<?php

declare(strict_types=1);

session_start();

if ('POST' === $_SERVER['REQUEST_METHOD']) {
    require_once "lib/repository/ContactRepository.php";

    $contactRepository = new ContactRepository();

    if (!isset($_POST["body"]) || !isset($_POST["email"])) {
        header("Location: /contact.php");
        exit;
    }

    $contactRepository->create($_POST['email'], $_POST['body']);
    header("Location: /");
    exit;
}

require_once "lib/SessionManager.php";
require_once "lib/FingerprintService.php";

$email = "";
$isGuest = FingerprintService::getInstance()->isGuest();

if (!$isGuest) {
    $email = SessionManager::getInstance()->getData('email');
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contacteer ons</title>
    <link rel="stylesheet" href="/css/lib.css">
    <link rel="stylesheet" href="/css/contact.css">
</head>
<body>
    <?php include_once 'partials/header.php'; ?>

    <section class="contact-wrapper">
        <h3>Contact met ons opnemen? Dat kan!</h3>
        <form method="POST">
            <div class="input-wrapper">
                <label for="email">E-mail</label>
                <input type="email" name="email" value="<?= $email ?>" required>
            </div>

            <div class="input-wrapper">
                <label for="body">Wat wil je ons vragen?</label>
                <textarea name="body"></textarea>
            </div>

            <button type="submit">Verstuur</button>
        </form>
    </section>
</body>
</html>