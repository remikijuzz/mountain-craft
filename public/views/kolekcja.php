<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mountain Craft | Sklep</title>
    <link rel="stylesheet" href="/public/css/mountaincraft.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
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
                    <li><a href="/dashboard">Twój Dziennik</a></li>
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
                <p style="color: var(--color-text-muted); max-w: 600px; margin: 1.5rem auto;">
                    Zbuduj swoją kolekcję. Precyzyjne modele topograficzne czekają na dodanie do Twojego ekwipunku. Nie musisz mieć konta, aby rozpocząć zakupy.
                </p>
            </div>

            <div class="journal-grid">
                <?php if (isset($products) && !empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <div class="journal-card">
                            <img src="<?= htmlspecialchars($product->getImageUrl()); ?>" alt="<?= htmlspecialchars($product->getName()); ?>">
                            
                            <div class="journal-card-content">
                                <h3 style="color: #E6E6E6; font-family: var(--font-heading); letter-spacing: 0.1em;">
                                    <?= htmlspecialchars($product->getName()); ?>
                                </h3>
                                <p style="color: var(--color-cta); font-family: var(--font-body); margin-top: 0.5rem;">
                                    <?= htmlspecialchars($product->getPrice()); ?> PLN
                                </p>
                                <p style="color: var(--color-text-muted); font-size: 0.8rem; margin-top: 0.5rem; margin-bottom: 1.5rem;">
                                    Skala: <?= htmlspecialchars($product->getScale()); ?>
                                </p>
                                
                                <form action="/cart/add" method="POST" style="width: 100%; margin-top: auto;">
                                    <input type="hidden" name="product_id" value="<?= $product->getId(); ?>">
                                    <button type="submit" class="btn primary" style="width: 100%; padding: 0.75rem; font-size: 0.8rem; letter-spacing: 0.1em; background: transparent; border: 1px solid var(--color-cta); color: var(--color-cta); cursor: pointer;">
                                        + DODAJ DO KOSZYKA
                                    </button>
                                </form>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p style="color: var(--color-text-muted); text-align: center; grid-column: 1 / -1;">
                        Brak produktów w bazie danych. Upewnij się, że plik init.sql zawiera dane testowe.
                    </p>
                <?php endif; ?>
            </div>

        </div>
    </section>
</body>
</html>