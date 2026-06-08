<script src="/mkFashion/public/js/main.js" defer></script>
<link rel="stylesheet" href="/mkFashion/public/css/style.css">
<header>
    <nav>
        <a href="/mkFashion/public/">🏠 Accueil</a>
        <a href="/mkFashion/public/cart/index">🛒 Panier</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <span>👤 <?= $_SESSION['user_name'] ?></span>
            <a href="/mkFashion/public/auth/logout">Déconnexion</a>
        <?php else: ?>
            <a href="/mkFashion/public/auth/loginForm">Connexion</a>
            <a href="/mkFashion/public/auth/registerForm">Inscription</a>
        <?php endif; ?>
    </nav>
</header>