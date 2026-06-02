<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mountain Craft | Inżynieria Wykuta w Skale</title>
    <link rel="stylesheet" href="/public/css/mountaincraft.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        body { margin: 0; overflow-x: hidden; background-color: #0a0a0a; }
        .hero-section { display: flex; height: 100vh; width: 100vw; }
        .hero-content { flex: 1; padding: 10% 8%; display: flex; flex-direction: column; justify-content: center; z-index: 2;}
        .hero-image { flex: 1; background-image: url('https://images.unsplash.com/photo-1628772689123-4d0fa27b0dd6?q=80&w=1920'); background-size: cover; background-position: center; filter: grayscale(100%) contrast(120%); border-left: 2px solid #1a1a1a; box-shadow: -20px 0 50px rgba(0,0,0,0.8); }
        .hero-subtitle { color: #c49a6c; font-size: 0.8rem; letter-spacing: 0.2em; text-transform: uppercase; margin-bottom: 1rem; }
        .hero-title { font-family: 'Cinzel', serif; font-size: 4rem; line-height: 1.1; color: #ffffff; margin-bottom: 2rem; }
        .hero-text { color: #888; font-size: 1rem; line-height: 1.6; max-width: 400px; margin-bottom: 3rem; }
    </style>
</head>
<body>
    <header class="site-header" style="position: fixed; width: 100%; z-index: 100; background: rgba(10,10,10,0.9);">
        <div class="container">
            <div class="logo">MOUNTAINCRAFT</div>
            <ul class="nav-links">
                <li><a href="/kolekcja">Kolekcja</a></li>
                <li><a href="/dashboard">Dziennik</a></li>
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li><a href="/logout" style="color: #c49a6c;">Wyloguj</a></li>
                <?php else: ?>
                    <li><a href="/login">Logowanie</a></li>
                <?php endif; ?>
                <li><a href="/cart">Koszyk</a></li>
            </ul>
        </div>
    </header>

    <div class="hero-section">
        <div class="hero-content">
            <div class="hero-subtitle">Mountaincraft | Ekstremalne Skalowanie</div>
            <h1 class="hero-title">INŻYNIERIA<br>WYKUTA<br>W SKALE.</h1>
            <p class="hero-text">Twój trójwymiarowy dziennik dokonań. Makiety górskie łączone magnesami neodymowymi, bazujące na precyzyjnych danych LiDAR 1m. Trofeum dla tych, którzy nie uznają kompromisów.</p>
            
            <a href="/login" class="btn primary" style="width: fit-content; text-decoration: none; display: inline-block;">
                ROZPOCZNIJ KOLEKCJĘ >
            </a>
        </div>
        <div class="hero-image"></div>
    </div>
</body>
</html>