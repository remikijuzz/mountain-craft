<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Mountain Craft | Logowanie</title>
    <link rel="stylesheet" href="/public/css/mountaincraft.css">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700&family=Inter:wght@300;400;600&display=swap" rel="stylesheet">
    <style>
        .auth-container { min-height: 100vh; display: flex; align-items: center; justify-content: center; position: relative; }
        .auth-box { background-color: rgba(17, 17, 17, 0.9); border: 1px solid var(--color-border); padding: 3rem; width: 100%; max-width: 450px; z-index: 10; }
        .auth-form { display: flex; flex-direction: column; gap: 1.5rem; margin-top: 2rem; }
        .form-group input { width: 100%; background: transparent; border: none; border-bottom: 1px solid var(--color-border); color: var(--color-text); padding: 0.75rem 0; outline: none; transition: 0.3s; }
        .form-group input:focus { border-bottom-color: var(--color-cta); }
        .messages { color: #ff4444; font-size: 0.9rem; margin-bottom: 1rem; text-align: center; }
        .success-message { background: rgba(76, 175, 80, 0.1); border: 1px solid #4CAF50; color: #4CAF50; padding: 1rem; text-align: center; margin-bottom: 1rem; font-size: 0.9rem;}
    </style>
</head>
<body>
    <div class="auth-container">
        <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?q=80&w=1920" alt="Góry w tle" class="hero-bg">
        
        <div class="auth-box">
            <h1 style="font-size: 2rem; text-align: center; margin-bottom: 0;">Mountain Craft</h1>
            <p style="text-align: center; color: gray; font-size: 0.9rem; margin-bottom: 2rem;">Ekskluzywne makiety szczytów</p>
            
            <?php if (isset($success) && $success): ?>
                <div class="success-message">
                    <?= htmlspecialchars($success) ?>
                </div>
            <?php endif; ?>

            <div class="messages">
                <?php
                    if (isset($messages)) {
                        foreach ($messages as $message) echo htmlspecialchars($message) . "<br>";
                    }
                ?>
            </div>

            <form class="auth-form" action="login" method="POST">
                <div class="form-group"><input type="email" name="email" placeholder="Adres E-mail" required></div>
                <div class="form-group"><input type="password" name="password" placeholder="Hasło" required></div>
                <button type="submit" class="btn primary" style="width: 100%; margin-top: 1rem;">Zaloguj się</button>
            </form>
            
            <div style="text-align: center; margin-top: 2rem;">
                <p style="color: gray; font-size: 0.9rem;">
                    Nowy odkrywca? <a href="/register" style="color: var(--color-cta); border-bottom: 1px solid var(--color-cta);">Rozpocznij wyprawę</a>
                </p>
            </div>
        </div>
    </div>
</body>
</html>