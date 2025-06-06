<?php

declare(strict_types=1);

session_start();

require_once "lib/Util.php";
require_once "lib/UserService.php";
require_once 'lib/FingerprintService.php';

$fingerprint = FingerprintService::getInstance();
$userService = new UserService();

if (!$fingerprint->isGuest()) {
    header("Location: index.php?referrer=account-aanmaken.php");
    return;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    Util::verifyPropertyExists($_POST, ["username", "password", "email"]);

    try {
        $userService->transformGuestToUser($_POST['username'], $_POST['password'], $_POST['email'], $fingerprint->getUser());

        if (isset($_GET['referrer'])) {
            header("Location: " . $_GET["referrer"] . "?referrer=account-aanmaken.php");
            return;
        }

        header("Location: index.php?referrer=account-aanmaken.php");
    } catch (Exception $e) {
        header("Location: account-aanmaken.php?flash=" . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/lib.css">
    <!-- <link rel="stylesheet" href="/css/account-aanmaken.css"> -->
    <title>Account aanmaken</title>
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
                <input type="email" name="email" placeholder="voorbeeld@email.com">
            </div>

            <div class="input-wrapper">
                <label for="username">Gebruikersnaam</label>
                <input type="text" name="username" placeholder="Gebruikersnaam">
            </div>

            <div class="input-wrapper">
                <label for="password">Wachtwoord</label>
                <input type="password" name="password" min="8" placeholder="Minstens 8 tekens">
            </div>

            <button type="submit">Aanmelden</button>
        </form>
        <p>Heb je al een account?</p>
        <a href="inloggen.php">Log in</a>
    </section>
</body>
</html>