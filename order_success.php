<?php
require "config.php";
if (!isLoggedIn()) { header("Location: login.php"); exit; }
$pageTitle = "Order Confirmed | Ceylon Tea";
require "header.php";
?>
<section class="form-section">
<div class="form-card success-box">
<h1>Order Placed Successfully 🎉</h1>
<p>Your order has been received.</p>
<p>Order Number: <strong>#<?php echo (int)($_GET["id"] ?? 0); ?></strong></p>
<a class="btn" href="products.php">CONTINUE SHOPPING</a>
</div>
</section>
<?php require "footer.php"; ?>
