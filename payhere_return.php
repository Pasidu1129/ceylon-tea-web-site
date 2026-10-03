<?php
require 'config.php';
requireLogin();
$orderId=(int)($_GET['order_id'] ?? 0);
$q=$conn->prepare('SELECT id,total,status,payment_status,payment_method FROM orders WHERE id=? AND user_id=? LIMIT 1');
$uid=(int)$_SESSION['user_id'];
$q->bind_param('ii',$orderId,$uid); $q->execute(); $order=$q->get_result()->fetch_assoc();
unset($_SESSION['pending_payhere_order']);
$_SESSION['cart']=[];
$pageTitle='Payment Return | Ceylon Tea'; require 'header.php';
?>
<section class="form-section"><div class="form-card success-box">
<div class="gold-kicker">PAYHERE RETURN</div>
<h1>Payment Redirect Completed</h1>
<?php if($order): ?>
<p>Order Number: <strong>#<?php echo e($order['id']); ?></strong></p>
<p>Payment Status: <strong><?php echo e($order['payment_status']); ?></strong></p>
<p>Order Status: <strong><?php echo e($order['status']); ?></strong></p>
<p class="muted">PayHere sends the final payment status to the server notification URL. If this page still shows Pending, refresh after the notification is processed.</p>
<a class="btn" href="order_success.php?id=<?php echo (int)$order['id']; ?>">VIEW ORDER</a>
<?php else: ?><p>The order could not be found.</p><?php endif; ?>
</div></section>
<?php require 'footer.php'; ?>
