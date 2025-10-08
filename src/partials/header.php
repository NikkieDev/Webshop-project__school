<?php
require_once __DIR__. "/../lib/SessionManager.php";
require_once __DIR__."/../lib/FingerprintService.php";

$fingerprint = FingerprintService::getInstance();
$session = SessionManager::getInstance();

?>
<section class="header-wrapper">
    <?php if ($session->get('username')) { ?>
        <h3>Welcome, <?= $session->get('username') ?></h3>
    <?php } ?>
    <nav>
        <div class="nav-item--wrapper">
            <a class="nav-item" href="/">Home</a>
            <a class="nav-item" href="/winkelwagen.php?referrer=index.php">Winkelwagen</a>
            <?php if (!$fingerprint->isGuest()) { ?>
                <a class="nav-item" href="/user/bestellingen.php?referrer=index.php">Bestellingen</a>
                <a class="nav-item" href="/user/instellingen.php?referrer=index.php">Instellingen</a>
            <?php } ?>
            <a class="nav-item" href="/contact.php">Contact</a>
            <?php if ($fingerprint->isAdmin()) { ?>
                <a href="/admin" class="nav-item">Portaal</a>
            <?php } ?>
        </div>
        <div class="fixed-right">
            <?php if ($fingerprint->isGuest()) { ?>
                <a class="nav-item" href="/account-aanmaken.php?referrer=index.php">Aanmelden</a>
                <a class="nav-item" href="/inloggen.php?referrer=index.php">Inloggen</a>
            <?php } else { ?>
                <a class="nav-item" href="/ajax/logout.php?referrer=index.php">Uitloggen</a>
            <?php } ?>
        </div>
    </nav>
</section>