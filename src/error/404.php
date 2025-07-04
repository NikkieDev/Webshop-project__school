<?php

declare(strict_types=1);

$returnPage = '/';

if (isset($_GET['return'])) {
    $returnPage = $_GET['return'];
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/errors.css">
    <link rel="stylesheet" href="/css/lib.css">
    <title>Foutmelding</title>
</head>
<body>
    <section class="error-wrapper">
        <img class="error-image" src="/assets/error-icon.svg">
        <p class="error-message">De pagina die u zoekt, bestaat niet!</p>
        <a href="<?= $returnPage ?>" class="btn">Terug</a>
    </section>
</body>
</html>