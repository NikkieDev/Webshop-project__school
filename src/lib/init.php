<?php

declare(strict_types=1);

session_start();

require_once "FingerprintService.php";
require_once "SessionManager.php";
require_once "CookieManager.php";

$fingerprint = FingerprintService::getInstance();
$session = new SessionManager();
$cookieManager = new CookieManager();

?>