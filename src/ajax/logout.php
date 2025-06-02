<?php

declare(strict_types=1);
session_start();

require_once "../lib/FingerprintService.php";

$fpService = FingerprintService::getInstance();

http_response_code(400);

if (!$fpService->isGuest()) {
    $fpService->logout();
    http_response_code(200);
}

header("Location: ../index.php?referrer=logout.php");
return;