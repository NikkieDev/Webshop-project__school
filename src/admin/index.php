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
        <aside class="side-nav">
            <h3 class="side-nav--welcome__message">Welkom admin</h3>
            <div class="side-nav-items">
                <a href="/admin/bestellingen.php" class="side-nav--item">Bestellingen</a>
                <a href="/admin/klanten.php" class="side-nav--item">Klanten</a>
                <a href="/admin/artikelen.php" class="side-nav--item">Assortiment</a>
                <a href="/admin/voorraad.php" class="side-nav--item">Voorraad</a>
                <a href="/ajax/logout.php" class="side-nav--item">Uitloggen</a>
            </div>
        </aside>
        <main class="admin-content">
            <!-- show possibly open orders, orders today, and a revenue counter. -->
        </main>
    </div>
</body>
</html>