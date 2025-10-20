<?php
if (isset($_SERVER['HTTP_ACCEPT']) && strpos($_SERVER['HTTP_ACCEPT'], 'text/html') === false) {
    return;
}

require_once __DIR__ . '/GoogleTranslateWrapper.php';
require_once __DIR__ . '/TranslatePage.php';
$config = require __DIR__ . '/config.php';

$targetLang = $_GET['lang'] ?? null;
$pageTranslator = new TranslatePage($targetLang);
$pageTranslator->start();
$GLOBALS['pageTranslator'] = $pageTranslator;
