<?php

declare(strict_types=1);

session_start();

require_once 'lib/Util.php';
require_once 'lib/FingerprintService.php';

$fingerprint = FingerprintService::getInstance();

if (!$fingerprint->isGuest()) {
    header("Location: index.php?referrer=account-aanmaken.php");
    return;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Util::verifyPropertyExists($_POST, ['email', 'password']);

    try {
        $fingerprint->login($_POST["email"], $_POST["password"]);

        if (isset($_GET['referrer'])) {
            header("Location: " . $_GET["referrer"] . "?referrer=inloggen.php");
            return;
        }

        header("Location: index.php?referrer=inloggen.php");
    } catch (Exception $e) {
        header("Location: inloggen.php?flash=" . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/lib.css">
    <title>Inloggen</title>
</head>
<body>
    <?php if (isset($_GET['flash'])) { ?>
        <section>
            <div class="flash-card flash-warning">
                <span class="flash-content"><?php echo $_GET['flash']; ?></span>
            </div>
        </section>
    <?php } ?>
    <section class="form-wrapper">
        <form method="post">
            <div class="input-wrapper">
                <label for="email">E-mail</label>
                <input type="email" name="email">
            </div>

            <div class="input-wrapper">
                <label for="password">Wachtwoord</label>
                <input type="password" name="password" min="8">
            </div>

            <button type="submit">Inloggen</button>
        </form>
        <p>Heb je nog geen account?</p>
        <a href="account-aanmaken.php">Registreren</a>
    </section>
</body>
</html>