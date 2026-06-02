<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Mountain Craft | Kolekcja</title>
    <link rel="stylesheet" href="/public/css/mountaincraft.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="logo"><a href="/" style="color:white; text-decoration:none;">MOUNTAINCRAFT</a></div>
            <ul class="nav-links">
                <li><a href="/cart" style="color: var(--color-cta);">Przejdź do koszyka</a></li>
            </ul>
        </div>
    </header>

    <section class="section">
        <div class="container">
            <h2 style="text-align: center; margin-bottom: 3rem; font-family: var(--font-heading);">WYBIERZ MAKIETY DO KOSZYKA</h2>
            <div class="journal-grid">
                <?php foreach ($products as $product): ?>
                    <div class="journal-card">
                        <img src="<?= htmlspecialchars($product->getImageUrl()); ?>" alt="Góra">
                        <div class="journal-card-content">
                            <h3><?= htmlspecialchars($product->getName()); ?></h3>
                            <p><?= htmlspecialchars($product->getPrice()); ?> PLN</p>
                            
                            <form action="/cart/add" method="POST" style="margin-top: 1rem;">
                                <input type="hidden" name="product_id" value="<?= $product->getId(); ?>">
                                <button type="submit" class="btn primary" style="width: 100%; padding: 0.5rem; font-size: 0.8rem;">DODAJ DO KOSZYKA</button>
                            </form>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
</body>
</html>