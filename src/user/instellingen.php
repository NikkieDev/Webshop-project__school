<?php

declare(strict_types=1);
session_start();

require_once __DIR__ . "/../lib/FingerprintService.php";
require_once __DIR__ . "/../lib/SessionManager.php";
require_once __DIR__ . "/../lib/UserService.php";

function requiredBodyExists(array $body): bool
{
    foreach ($body as $field) { 
        if (!isset($_POST[$field])) {
            return false;
        }
    }

    return true;
}

function resetPassword(): void
{
    $passwordVerified = FingerprintService::getInstance()->verifyPassword($_POST['old-password']);
        
    if (!$passwordVerified) {
        header("Location: instellingen.php?error=Uw wachtwoord klopt niet.");
        exit;
    } else if ($_POST['new-password'] !== $_POST['new-password-confirm']) {
        header("Location: instellingen.php?error=De wachtwoorden moeten overeen komen.");
        exit;
    }

    UserService::getInstance()->setPassword($_POST['new-password']);
    return;
}

function resetMail()
{
    $passwordVerified = FingerprintService::getInstance()->verifyPassword($_POST['password']);

    if (!$passwordVerified) {
        header("Location: instellingen.php?error=Uw wachtwoord klopt niet.");
        exit;
    }

    UserService::getInstance()->setMail($_POST['new-mail']);
    return;
}

if ("POST" === $_SERVER["REQUEST_METHOD"]) {
    $requestType = '';

    if (!isset($_POST["request-type"])) {
        return;
    }

    $requestType = $_POST["request-type"];

    if ('password-reset' === $requestType && requiredBodyExists(['old-password', 'new-password', 'new-password-confirm'])) {
        resetPassword();
        header("Location: instellingen.php?msg=Uw wachtwoord is aangepast");
        exit;
    } else if ('mail-reset' === $requestType && requiredBodyExists(['password', 'new-mail'])) {
        resetMail();
        header("Location: instellingen.php?msg=Uw e-mail is aangepast");
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/lib.css">
    <link rel="stylesheet" href="/css/user/instellingen.css">
    <title>Instellingen</title>
</head>
<body>
    <?php include __DIR__ ."/../partials/header.php" ?>

    <section class="instellingen-wrapper">
        <div class="flash-wrapper">
            <?php if (isset($_GET['error'])) { ?>
                <div class="flash-card flash-warning"><span class="flash-content"><?= $_GET['error']; ?></span></div>
            <?php } else if (isset($_GET['msg'])) { ?>
                <div class="flash-card flash-success"><span class="flash-content"><?= $_GET['msg']; ?></span></div>
            <?php } ?>
        </div>


        <div class="instellingen-forms--wrapper">
            <div class="password-form--wrapper">
                <h3>Wachtwoord aanpassen</h3>
                <form method="POST" class="password-form form-wrapper">
                    <input type="hidden" name="request-type" value="password-reset">
                    <div class="input-wrapper">
                        <label for="old-password">Oud wachtwoord</label>
                        <input type="password" name="old-password" required>
                    </div>
                    <div class="input-wrapper">
                        <label for="new-password">Nieuw wachtwoord</label>
                        <input type="password" name="new-password" required>
                    </div>
                    <div class="input-wrapper">
                        <label for="new-password-confirm">Nieuw wachtwoord herhalen</label>
                        <input type="password" name="new-password-confirm" required>
                    </div>

                    <button type="submit">Vervangen</button>
                </form>
            </div>

            <div class="mail-form--wrapper">
                <h3>E-mail aanpassen</h3>
                <form method="POST" class="mail-form form-wrapper">
                    <input type="hidden" name="request-type" value="mail-reset">
                    <div class="input-wrapper">
                        <label for="password">Wachtwoord</label>
                        <input type="password" name="password" required>
                    </div>
                    <div class="input-wrapper">
                        <label for="new-mail">Nieuw e-mail adres</label>
                        <input type="email" name="new-mail" required>
                    </div>
    
                    <button type="submit">Vervangen</button>
                </form>
            </div>
        </div>
    </section>
</body>
</html>