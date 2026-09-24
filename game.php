<?php
declare(strict_types=1);
require_once __DIR__ . '/api/site_lib.php';
$target = is_file(__DIR__ . '/assets/targets/targets.mind');
?><!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
    <meta name="theme-color" content="#050708">
    <title>Play | AR Game Shooter</title>
    <link rel="stylesheet" href="assets/css/game.css">
</head>
<body class="ar-game">
    <div id="ar-container"></div>
    <div id="weapon-container"></div>
    <div class="hud">
        <div class="hud-top">
            <div class="readout">
                <span>SCORE <b id="score">000</b></span>
                <span>WAVE <b id="wave">01</b></span>
                <span>HP <b id="hp">05</b></span>
            </div>
            <div id="lockStatus" class="lock">TARGET LOST</div>
        </div>
        <div id="crosshair" class="crosshair"></div>
    </div>
    <div class="touch-controls">
        <button id="reload" class="touch-button reload" type="button">RELOAD</button>
        <button id="fire" class="touch-button fire" type="button">FIRE</button>
    </div>
    <div id="gameMessage" class="game-message" <?= $target ? 'hidden' : '' ?>>
        <div>
            <h1><?= $target ? 'READY' : 'TARGET MISSING' ?></h1>
            <p id="messageText"><?= $target ? 'Tap FIRE or press SPACE to begin.' : 'Compile an image target before entering the arena.' ?></p>
            <a class="button button-primary" href="<?= $target ? 'javascript:void(0)' : 'index.php' ?>" id="messageAction"><?= $target ? 'ENTER AR' : 'Back to setup' ?></a>
        </div>
    </div>
    <script>window.AR_GAME_CONFIG={targetAvailable:<?= $target?'true':'false' ?>,targetSrc:'assets/targets/targets.mind?v=<?= asset_version('assets/targets/targets.mind') ?>'};</script>
    <script type="module" src="assets/js/game.js"></script>
</body>
</html>
