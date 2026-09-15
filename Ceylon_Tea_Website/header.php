<?php require_once __DIR__.'/config.php'; ?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0"><title><?php echo e($pageTitle??'Ceylon Noir'); ?></title><link rel="stylesheet" href="css/style.css"></head><body>
<header class="site-header"><a class="brand" href="index.php"><span>✦ CEYLON NOIR</span><small>PURE CEYLON • PREMIUM TEA</small></a><nav>
<a href="index.php">Home</a><a href="products.php">Collection</a><a href="about.php">About</a><a href="contact.php">Contact</a>
<?php if(isLoggedIn()): ?><a href="profile.php">Hi, <?php echo e($_SESSION['user_name']??'User'); ?></a><?php if(isAdmin()): ?><a class="admin-nav" href="admin/index.php">Admin</a><?php endif; ?><a href="logout.php">Logout</a><?php else: ?><a href="login.php">Login</a><a href="register.php">Register</a><?php endif; ?><a class="cart-link" href="cart.php">🛒 Cart (<?php echo cartCount(); ?>)</a>
</nav></header><main>
