<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mountain Craft | Dziennik Dokonań</title>
    <link rel="stylesheet" href="/public/css/mountaincraft.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
</head>
<body>
    <header class="site-header">
        <div class="container">
            <div class="logo">MOUNTAIN CRAFT</div>
            <ul class="nav-links">
                <li><a href="/dashboard">Kolekcja</a></li>
                <li><a href="/logout" style="color: var(--color-cta);">Wyloguj się</a></li>
            </ul>
        </div>
    </header>

    <section class="section journal-section">
        <div class="container">
            
            <div class="journal-header">
                <span style="font-family: var(--font-body); font-size: 0.85rem; letter-spacing: 0.2em; color: var(--color-cta); text-transform: uppercase;">
                    Strefa Zamknięta
                </span>
                <h2 style="margin-top: 1rem; color: #E6E6E6;">Twój Dziennik Dokonań</h2>
                <p style="color: var(--color-text-muted); max-w: 600px; margin: 1.5rem auto;">
                    Puste miejsce na biurku to puste miejsce w historii. Spójrz na luki w swojej kolekcji. Neodymowe złącza czekają, by w końcu zamknąć pierścień majestatu.
                </p>
            </div>

            <div class="journal-grid">
                <?php if (isset($products) && !empty($products)): ?>
                    <?php foreach ($products as $product): ?>
                        <a href="/product?id=<?= $product->getId(); ?>" class="journal-card" style="display: block;">
                            <img src="<?= htmlspecialchars($product->getImageUrl()); ?>" alt="<?= htmlspecialchars($product->getName()); ?>">
                            
                            <div class="journal-card-content">
                                <h3 style="color: #E6E6E6; font-family: var(--font-heading); letter-spacing: 0.1em;">
                                    <?= htmlspecialchars($product->getName()); ?>
                                </h3>
                                <p style="color: var(--color-cta); font-family: var(--font-body); margin-top: 0.5rem;">
                                    <?= htmlspecialchars($product->getPrice()); ?> PLN
                                </p>
                                <p style="color: var(--color-text-muted); font-size: 0.8rem; margin-top: 0.5rem;">
                                    Skala: <?= htmlspecialchars($product->getScale()); ?>
                                </p>
                            </div>
                        </a>
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