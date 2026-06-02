<header class="site-header" style="position: fixed; width: 100%; z-index: 100; background: rgba(10,10,10,0.9);">
        <div class="container">
            <div class="logo">MOUNTAINCRAFT</div>
            <ul class="nav-links">
                <li><a href="/kolekcja">Sklep (Kolekcja)</a></li>
                <li><a href="/cart">Koszyk</a></li>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li><a href="/logout" style="color: #c49a6c;">Wyloguj</a></li>
                <?php else: ?>
                    <li><a href="/login" style="color: #c49a6c;">Zaloguj się</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </header>