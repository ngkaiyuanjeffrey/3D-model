# Web-Based AR Shooter Game

AR Game Shooter is a PHP 8.3+ WebAR game using Three.js 0.160.0 and MindAR 1.2.5. It tracks a printed or second-screen image target, places a 3D enemy in the tracked scene, and supports waves, shooting, reload, score, HP, sound, target compilation, QR access, and local GLB management.

## Install on XAMPP

1. Copy the project into `htdocs/3D Model`.
2. Start Apache.
3. Open `http://localhost/3D%20Model/index.php`.
4. Upload a detailed target image and choose Compile after upload, or compile from the Compile page.
5. Open the game on a phone using the QR code. The phone and computer must be reachable on the same network; public phone camera access normally requires HTTPS.

## cPanel

Upload and extract the folder into the document root, use PHP 8.3+, ensure `assets/config`, `assets/models`, and `assets/targets` are writable by PHP, then use HTTPS. Set `publicBaseUrl` in the home page if automatic URL detection is not suitable.

## Models and target

Target uploads accept JPG, PNG, and WEBP up to 12 MB and are converted to `assets/targets/picture.jpg`. GLB uploads are checked for the `glTF` binary header and limited to 40 MB. Without a weapon GLB, the game uses its procedural fallback weapon logic and a procedural enemy so the gameplay loop remains testable.

## CDN dependencies

- Three.js 0.160.0 ES module from jsDelivr
- MindAR 1.2.5 production image tracker from jsDelivr
- Google Fonts for the interface
- QR Server API for the displayed QR image

Camera access requires a modern browser and a secure context. Chrome on Android is the recommended test platform. Safari support depends on device/browser WebAR compatibility.
