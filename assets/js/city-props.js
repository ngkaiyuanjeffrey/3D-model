import * as THREE from 'https://cdn.jsdelivr.net/npm/three@0.160.0/build/three.module.js';
import {GLTFLoader} from 'https://cdn.jsdelivr.net/npm/three@0.160.0/examples/jsm/loaders/GLTFLoader.js';
import {MindARThree} from 'https://cdn.jsdelivr.net/npm/mind-ar@1.2.5/dist/mindar-image-three.prod.js';

const PROP_LAYOUT = [
    ['Street Light.glb', -.48, 0, -.2],
    ['Traffic Light.glb', .48, 0, -.25],
    ['Stop Sign.glb', -.32, 0, .18],
    ['Bench.glb', .3, 0, .2],
    ['Fire Hydrant.glb', -.12, 0, -.08],
    ['Traffic Cone.glb', .12, 0, -.08]
];

export class CityProps {
    constructor(parent) {
        this.parent = parent;
        this.loader = new GLTFLoader();
    }

    load() {
        for (const [file, x, y, z] of PROP_LAYOUT) {
            this.loader.load(`assets/models/city-props/${encodeURIComponent(file)}`, gltf => {
                const prop = gltf.scene;
                const bounds = new THREE.Box3().setFromObject(prop);
                const size = bounds.getSize(new THREE.Vector3());
                const largestSide = Math.max(size.x, size.y, size.z);
                if (!largestSide) return;
                prop.scale.setScalar(.24 / largestSide);
                prop.position.set(x, y, z);
                prop.traverse(object => {
                    if (object.isMesh) {
                        object.castShadow = true;
                        object.receiveShadow = true;
                    }
                });
                this.parent.add(prop);
            }, undefined, error => console.warn(`Could not load city prop ${file}`, error));
        }
    }
}

const originalAddAnchor = MindARThree.prototype.addAnchor;
MindARThree.prototype.addAnchor = function (...args) {
    const anchor = originalAddAnchor.apply(this, args);
    new CityProps(anchor.group).load();
    return anchor;
};