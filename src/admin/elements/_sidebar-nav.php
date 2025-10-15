<aside class="side-nav">
    <h3 class="side-nav--welcome__message">Welkom admin</h3>
    <div class="side-nav-items">
        <a href="/admin/bestellingen.php" class="side-nav--item <?= $activeTab === 'bestellingen' ? 'active' : '' ?>">Bestellingen</a>
        <a href="/admin/klanten.php" class="side-nav--item <?= $activeTab === 'klanten' ? 'active' : '' ?>">Klanten</a>
        <a href="/admin/artikelen.php" class="side-nav--item <?= $activeTab === 'assortiment' ? 'active' : '' ?>">Assortiment</a>
        <a href="/admin/voorraad.php" class="side-nav--item <?= $activeTab === 'voorraad' ? 'active' : '' ?>">Voorraad</a>
        <a href="/ajax/logout.php" class="side-nav--item <?= $activeTab === 'uitloggen' ? 'active' : '' ?>">Uitloggen</a>
    </div>
</aside>