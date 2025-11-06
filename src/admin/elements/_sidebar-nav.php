<aside class="side-nav">
    <h3 class="side-nav--welcome__message">Welkom Beheerder</h3>
    <div class="side-nav-items">
        <a href="/admin/bestellingen.php" class="side-nav--item <?= $activeTab === 'bestellingen' ? 'active' : '' ?>">Bestellingen</a>
        <a href="/admin/klanten.php" class="side-nav--item <?= $activeTab === 'klanten' ? 'active' : '' ?>">Klanten</a>
        <a href="/admin/voorraad.php" class="side-nav--item <?= $activeTab === 'voorraad' ? 'active' : '' ?>">Voorraad</a>
        <a href="/" class="side-nav--item">Terug naar shop</a>
        <a href="/ajax/logout.php" class="side-nav--item">Uitloggen</a>
    </div>
</aside>