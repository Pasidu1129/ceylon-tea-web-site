<?php
require "config.php";
requireLogin('checkout.php');

if(empty($_SESSION['pending_payhere_order'])){ header('Location: checkout.php'); exit; }
$pending=$_SESSION['pending_payhere_order'];

if(!payhereConfigured()){
    $pageTitle='PayHere Setup Required | Ceylon Tea';
    require 'header.php';
    ?>
    <section class="form-section"><div class="form-card" style="max-width:700px">
    <div class="gold-kicker">WEEK 07 · PAYHERE SANDBOX</div>
    <h1>PayHere Setup Required</h1>
    <div class="alert">Add your Sandbox Merchant ID and Merchant Secret in <code>config.php</code> before using PayHere.</div>
    <p class="muted">The project is already connected to the PayHere Sandbox checkout form and MD5 hash logic. Only your personal sandbox credentials are missing.</p>
    <ol><li>Open PayHere Sandbox → Integrations.</li><li>Add <strong>localhost</strong> as a Domain.</li><li>Copy your numeric Merchant ID and Merchant Secret.</li><li>Paste them into <code>config.php</code>.</li></ol>
    <a class="gold-btn" href="checkout.php">BACK TO CHECKOUT</a>
    </div></section>
    <?php require 'footer.php'; exit;
}

[$firstName,$lastName]=splitCustomerName($pending['customer_name']);
$orderId=(string)$pending['order_id'];
$amount=number_format((float)$pending['total'],2,'.','');
$currency='LKR';
$hash=payhereHash(PAYHERE_MERCHANT_ID,$orderId,$amount,$currency,PAYHERE_MERCHANT_SECRET);
$returnUrl=PAYHERE_BASE_URL.'/payhere_return.php?order_id='.urlencode($orderId);
$cancelUrl=PAYHERE_BASE_URL.'/payhere_cancel.php?order_id='.urlencode($orderId);
$items=implode(', ',$pending['items']);

$pageTitle='PayHere Sandbox | Ceylon Tea';
require 'header.php';
?>
<section class="form-section">
<div class="form-card" style="max-width:720px">
<div class="gold-kicker">WEEK 07 · PAYHERE SANDBOX</div>
<h1>Order Summary</h1>
<div style="padding:16px;background:#f7efdc;border:1px solid rgba(199,163,74,.35);border-radius:7px;margin-bottom:18px">
<p><strong>Order ID:</strong> #<?php echo e($orderId); ?></p>
<p><strong>Items:</strong> <?php echo e($items); ?></p>
<p><strong>Customer:</strong> <?php echo e($pending['customer_name']); ?></p>
<p><strong>City:</strong> <?php echo e($pending['city']); ?></p>
<p style="font-size:20px"><strong>Total: LKR <?php echo e($amount); ?></strong></p>
</div>
<p class="muted">Click Pay Now to continue to the PayHere Sandbox. The mandatory MD5 hash is generated on the server before the form is submitted.</p>
<form method="post" action="<?php echo e(PAYHERE_SANDBOX_URL); ?>">
<input type="hidden" name="merchant_id" value="<?php echo e(PAYHERE_MERCHANT_ID); ?>">
<input type="hidden" name="return_url" value="<?php echo e($returnUrl); ?>">
<input type="hidden" name="cancel_url" value="<?php echo e($cancelUrl); ?>">
<input type="hidden" name="notify_url" value="<?php echo e(PAYHERE_NOTIFY_URL); ?>">
<input type="hidden" name="first_name" value="<?php echo e($firstName); ?>">
<input type="hidden" name="last_name" value="<?php echo e($lastName); ?>">
<input type="hidden" name="email" value="<?php echo e($pending['email']); ?>">
<input type="hidden" name="phone" value="<?php echo e($pending['phone']); ?>">
<input type="hidden" name="address" value="<?php echo e($pending['address']); ?>">
<input type="hidden" name="city" value="<?php echo e($pending['city']); ?>">
<input type="hidden" name="country" value="Sri Lanka">
<input type="hidden" name="order_id" value="<?php echo e($orderId); ?>">
<input type="hidden" name="items" value="<?php echo e($items); ?>">
<input type="hidden" name="currency" value="LKR">
<input type="hidden" name="amount" value="<?php echo e($amount); ?>">
<input type="hidden" name="hash" value="<?php echo e($hash); ?>">
<button class="gold-btn full" type="submit">PAY NOW WITH PAYHERE SANDBOX</button>
</form>
<p style="font-size:12px;color:#766b59;margin-top:14px">Sandbox only. No real card details are stored by this website.</p>
</div>
</section>
<?php require 'footer.php'; ?>
