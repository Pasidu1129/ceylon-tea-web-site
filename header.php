<?php require_once "config.php"; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : "Ceylon Tea"; ?></title>
<link rel="stylesheet" href="css/style.css">
</head>
<body>
<header class="site-header">
    <a class="brand" href="index.php">
        <span>🍃 CEYLON TEA</span>
        <small>PURE CEYLON. PURE TASTE.</small>
    </a>
    <nav>
        <a href="index.php">Home</a>
        <a href="products.php">Products</a>
        <a href="about.php">About Us</a>
        <a href="contact.php">Contact Us</a>
        <?php if (isLoggedIn()): ?>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="login.php">Login</a>
        <?php endif; ?>
        <a class="cart-link" href="cart.php">🛒 Cart (<?php echo cartCount(); ?>)</a>
    </nav>
</header>
<main>
