<?php
$activeTab = 'voorraad';

require_once __DIR__ .'/../lib/render/loadProducts.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vooraad | Beheer portaal</title>
    <link rel="stylesheet" href="/css/lib.css">
    <link rel="stylesheet" href="/css/admin.css">
    <script src="/js/stock.js" defer></script>
</head>
<body>
    <div class="admin-wrapper">
        <?php include_once './elements/_sidebar-nav.php' ?>
        <main class="admin-content">
            <table>
                <tr>
                    <th>Artikel ID</th>
                    <th>Artikel titel</th>
                    <th>Artikel prijs</th>
                    <th>Artikel voorraad</th>
                </tr>
                <?php foreach ($products as $product): ?>
                    <?php $productUuid = $product['uuid']; ?>
                    <tr>
                        <td><?= $productUuid ?></td>
                        <td><?= $product['title'] ?></td>
                        <td><?= $product['price'] ?></td>
                        <td><input min="0" onchange="setStock('<?= $productUuid ?>')" data-product="<?= $productUuid ?>" type="number" value="<?= $product['stock'] ?>"></td>
                    </tr>
                <?php endforeach ?>
            </table>
        </main>
    </div>
</body>
</html>