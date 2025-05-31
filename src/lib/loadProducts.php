<?php

declare(strict_types=1);

require_once 'db.php';

$dbManager = new Db();

$products = $dbManager->getProducts();
$dbManager->close();
?>
