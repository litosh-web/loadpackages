<?php
$provider = 1;
$items = [
    'login',
//    'fred',
//    'ace',
//    'ajaxform',
//    'FormIt',
//    'Fred Ace Integration',
//    'Fred TinyMCE RTE',
//    'migx',
];

// Подключаем
define('MODX_API_MODE', true);
require_once dirname(__DIR__) . '/index.php';
require_once dirname(__DIR__) . '/packages/packages.class.php';

$modx = new modX();
$modx->initialize('web');

// Включаем обработку ошибок
$modx->getService('error', 'error.modError');
$modx->setLogLevel(modX::LOG_LEVEL_INFO);
$modx->setLogTarget(XPDO_CLI_MODE ? 'ECHO' : 'HTML');

$packages = new Packages($modx);

foreach ($items as $item) {

    $pkg = $packages->exist($item);

    if (!$pkg) {
        $new = $packages->find($item, $provider);
        $packages->download($new, $provider);
        $pkg = $packages->exist($item);
    }

    if ($pkg['signature'] && !$pkg['installed']) {
        $res = $packages->install($pkg['signature']);


    }
}