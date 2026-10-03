<?php
require 'config.php';
requireLogin();
$orderId=(int)($_GET['order_id'] ?? 0);
$uid=(int)$_SESSION['user_id'];
if($orderId>0){
    $q=$conn->prepare("UPDATE orders SET status='Cancelled', payment_status='Cancelled' WHERE id=? AND user_id=? AND payment_status='Pending'");
    $q->bind_param('ii',$orderId,$uid); $q->execute();
}
unset($_SESSION['pending_payhere_order']);
$pageTitle='Payment Cancelled | Ceylon Tea'; require 'header.php';
?>
<section class="form-section"><div class="form-card">
<div class="gold-kicker">PAYHERE SANDBOX</div><h1>Payment Cancelled</h1>
<p>Your PayHere sandbox payment was cancelled. The order has not been marked as paid.</p>
<a class="gold-btn" href="products.php">CONTINUE SHOPPING</a>
</div></section>
<?php require 'footer.php'; ?>
