<?php

declare(strict_types= 1);

require_once __DIR__.'/../lib/FingerprintService.php';

$fingerprintService = FingerprintService::getInstance();

if (!$fingerprintService->isAdmin()) {
    http_response_code(401);
    header('Location: /');
    return;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/lib.css">
    <link rel="stylesheet" href="/css/admin.css">
    <title>Beheer portaal</title>
</head>
<body>
    <div class="admin-wrapper">
        <?php include_once './elements/_sidebar-nav.php' ?>
        <main class="admin-content">
            <!-- show possibly open orders, orders today, and a revenue counter. -->
        </main>
    </div>
</body>
</html>