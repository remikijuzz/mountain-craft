<?php
    if (session_status() === PHP_SESSION_NONE) session_start();
    $cartMsg = $_SESSION['cart_message'] ?? null;
    unset($_SESSION['cart_message']);
?>
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Mountain Craft | Sklep</title>
    <link rel="stylesheet" href="/public/css/mountaincraft.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="logo"><a href="/" style="color:white; text-decoration:none;">MOUNTAINCRAFT</a></div>
            <ul class="nav-links">
                <li><a href="/kolekcja">Sklep (Kolekcja)</a></li>
                <li><a href="/cart">Koszyk</a></li>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li><a href="/logout" style="color: var(--color-cta);">Wyloguj się</a></li>
                <?php else: ?>
                    <li><a href="/login" style="color: var(--color-cta);">Zaloguj się</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </header>

    <section class="section journal-section">
        <div class="container">
            
            <div class="journal-header">
                <span style="font-family: var(--font-body); font-size: 0.85rem; letter-spacing: 0.2em; color: var(--color-cta); text-transform: uppercase;">
                    Otwarta Ekspedycja
                </span>
                <h2 style="margin-top: 1rem; color: #E6E6E6;">Wybierz Makiety do Koszyka</h2>
            </div>

            <?php if ($cartMsg): ?>
                <div style="background: rgba(76, 175, 80, 0.1); border: 1px solid #4CAF50; color: #4CAF50; padding: 1rem; text-align: center; margin-bottom: 2rem;">
                    <?= htmlspecialchars($cartMsg) ?>
                </div>
            <?php endif; ?>

            <div class="journal-grid">
                <?php if (isset($products) && !empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="journal-card">
                            <img src="<?= htmlspecialchars($product->getImageUrl()); ?>" alt="<?= htmlspecialchars($product->getName()); ?>">
                            <div class="journal-card-content">
                                <h3 style="color: #E6E6E6; font-family: var(--font-heading); letter-spacing: 0.1em;"><?= htmlspecialchars($product->getName()); ?></h3>
                                <p style="color: var(--color-cta); font-family: var(--font-body); margin-top: 0.5rem;"><?= htmlspecialchars($product->getPrice()); ?> PLN</p>
                                <p style="color: var(--color-text-muted); font-size: 0.8rem; margin: 1.5rem 0;">Skala: <?= htmlspecialchars($product->getScale()); ?></p>
                                <form action="/cart/add" method="POST" style="width: 100%; margin-top: auto;">
                                    <input type="hidden" name="product_id" value="<?= $product->getId(); ?>">
                                    <button type="submit" class="btn primary" style="width: 100%; padding: 0.75rem; font-size: 0.8rem; letter-spacing: 0.1em; background: transparent; border: 1px solid var(--color-cta); color: var(--color-cta); cursor: pointer;">
                                        + DODAJ DO KOSZYKA
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>
</body>
</html>