<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Mountain Craft | Twój Koszyk</title>
    <link rel="stylesheet" href="/public/css/mountaincraft.css">
    <style>
        .cart-item { display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid #333; padding: 1rem 0; color: white;}
    </style>
</head>
<body>
    <header class="site-header">
    <div class="container">
        <div class="logo"><a href="/" style="color:white; text-decoration:none;">MOUNTAINCRAFT</a></div>
        <ul class="nav-links">
            <li><a href="/kolekcja">Sklep (Kolekcja)</a></li>
            <li><a href="/cart">Koszyk</a></li>
            
            <?php if(isset($_SESSION['user_id'])): ?>
                <li><a href="/dashboard">Twój Dziennik</a></li>
                <li><a href="/logout" style="color: var(--color-cta);">Wyloguj się</a></li>
            <?php else: ?>
                <li><a href="/login" style="color: var(--color-cta);">Zaloguj się</a></li>
            <?php endif; ?>
        </ul>
    </div>
</header>

    <section class="section">
        <div class="container" style="max-width: 600px; background: rgba(17,17,17,0.9); padding: 2rem; border: 1px solid #333;">
            <h2 style="color: #E6E6E6; margin-bottom: 2rem;">TWÓJ KOSZYK</h2>
            
            <?php if (empty($products)): ?>
                <p style="color: gray;">Twój koszyk jest pusty. <a href="/kolekcja" style="color: #c49a6c;">Wróć do sklepu</a>.</p>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <div class="cart-item">
                        <span><?= htmlspecialchars($product->getName()); ?></span>
                        <span style="color: #c49a6c;"><?= htmlspecialchars($product->getPrice()); ?> PLN</span>
                    </div>
                <?php endforeach; ?>
                
                <div style="margin-top: 2rem; text-align: right; color: white; font-size: 1.2rem;">
                    SUMA: <strong style="color: #c49a6c;"><?= number_format($total, 2); ?> PLN</strong>
                </div>

                <div style="margin-top: 3rem; display: flex; flex-direction: column; gap: 1rem;">
                    <?php if ($isLoggedIn): ?>
                        <form action="/checkout" method="POST">
                            <button type="submit" class="btn primary" style="width: 100%;">KUPUJ JAKO ZALOGOWANY</button>
                        </form>
                    <?php else: ?>
                        <form action="/checkout" method="POST">
                            <button type="submit" class="btn primary" style="width: 100%; background: transparent; border: 1px solid #c49a6c;">KUPUJ JAKO GOŚĆ</button>
                        </form>
                        <p style="text-align: center; color: gray; font-size: 0.9rem;">
                            Masz konto? <a href="/login" style="color: #c49a6c;">Zaloguj się, aby zapisać historię</a>
                        </p>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
</body>
</html>