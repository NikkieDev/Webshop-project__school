<?php

declare(strict_types= 1);

$activeTab = 'klanten';

require_once __DIR__ .'/../lib/repository/UserRepository.php';

$users = (new UserRepository())->getCustomersWithOrderAmount();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Klanten | Beheer portaal</title>
    <link rel="stylesheet" href="/css/lib.css">
    <link rel="stylesheet" href="/css/admin.css">
</head>
<body>
    <div class="admin-wrapper">
        <?php include_once './elements/_sidebar-nav.php' ?>
        <main class="admin-content">
            <table>
                <tr>
                    <th>Klant</th>
                    <th>Email</th>
                    <th>Gebruikersnaam</th>
                    <th>Registratiedatum</th>
                </tr>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?= $user['uuid'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['username'] ?></td>
                        <td><?= $user['createdAt'] ?></td>
                    </tr>
                <?php endforeach ?>
            </table>
        </main>
    </div>
</body>
</html>