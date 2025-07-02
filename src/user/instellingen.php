<?php

declare(strict_types=1);
session_start();

require_once __DIR__ . "/../lib/FingerprintService.php";
require_once __DIR__ . "/../lib/SessionManager.php";

$fingerprint = FingerprintService::getInstance();
$session = SessionManager::getInstance();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/lib.css">
    <title>Instellingen</title>
</head>
<body>
    <?php include __DIR__ ."/../partials/header.php" ?>
    <section class="instellingen-wrapper">
        <!-- reset password -->
        <!-- reset email -->
        <!-- delete account -->
    </section>
</body>
</html>