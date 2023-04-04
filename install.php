<?php
$provider = 1;
$items = [
    'fred',
    'ace',
    'login',
];

// Подключаем
define('MODX_API_MODE', true);
require_once './../index.php';
require_once './packages.class.php';

$modx = new modX();

// Включаем обработку ошибок
$modx->getService('error', 'error.modError');
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');

$modx->initialize('mgr');

$packages = new Packages($modx);

foreach ($items as $item) {
    $new = $packages->find($item, $provider);

    if ($packages->exist($item)) {
        continue;
    }
    echo $item;
    $signature = $packages->download($new, $provider);

    if ($signature) {
        $packages->install($signature);
    }
}