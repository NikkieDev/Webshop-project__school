<?php

declare(strict_types=1);

session_start();

require_once '../lib/FingerprintService.php';

$fingerprint = FingerprintService::getInstance();

if ($fingerprint->isGuest()) {
    header('Location: account-aanmaken.php');
}
