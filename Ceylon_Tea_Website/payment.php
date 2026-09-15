<?php
require "config.php";
if (!isLoggedIn()) { header("Location: login.php"); exit; }
if (empty($_SESSION["pending_checkout"])) { header("Location: checkout.php"); exit; }

$pending = $_SESSION["pending_checkout"];
$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $method = $_POST["method"] ?? "Online Payment";
    $reference = "PAY-" . strtoupper(bin2hex(random_bytes(4)));

    $stmt = $conn->prepare("INSERT INTO orders(user_id,total,address,phone,status,payment_method,payment_status,payment_reference) VALUES(?,?,?,?, 'Processing', ?, 'Paid', ?)");
    $status = "Processing";
    $stmt->bind_param("idssss", $_SESSION["user_id"], $pending["total"], $pending["address"], $pending["phone"], $method, $reference);
    if ($stmt->execute()) {
        $orderId = $conn->insert_id;
        $itemStmt = $conn->prepare("INSERT INTO order_items(order_id,product_id,quantity,unit_price) VALUES(?,?,?,?)");
        foreach ($pending["items"] as [$pid,$qty,$price]) {
            $itemStmt->bind_param("iiid", $orderId, $pid, $qty, $price);
            $itemStmt->execute();
        }
        $_SESSION["pending_checkout"] = [];
        $_SESSION["cart"] = [];
        header("Location: order_success.php?id=".$orderId);
        exit;
    }
    $error = "Payment could not be completed. Please try again.";
}
$pageTitle = "Online Payment | Ceylon Tea";
require "header.php";
?>
<section class="form-section">
<div class="form-card" style="max-width:620px">
<div class="gold-kicker">SECURE CHECKOUT</div>
<h1>Online Payment</h1>
<p style="color:#6b6255;margin-bottom:18px">Order total: <strong style="color:#806018">LKR <?php echo number_format($pending["total"],2); ?></strong></p>
<?php if ($error): ?><div class="alert"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
<div style="padding:14px;background:#f4ead3;border:1px solid rgba(199,163,74,.35);border-radius:7px;margin-bottom:18px;font-size:12px;color:#66583d">
<strong>Demo payment gateway for the university project.</strong><br>
This step demonstrates the online-payment flow without collecting or storing real card numbers. A production deployment can connect this step to a provider such as PayHere or another PCI-compliant gateway.
</div>
<form method="post">
<label>Payment Method</label>
<select name="method" style="width:100%;padding:11px;border:1px solid #ccc4b5;border-radius:5px;background:#fffdf8" required>
<option>Online Payment</option>
<option>Bank / Card Gateway</option>
</select>
<button class="gold-btn full" type="submit">CONFIRM ONLINE PAYMENT</button>
</form>
<a class="text-link gold-link" href="checkout.php">← Back to checkout</a>
</div>
</section>
<?php require "footer.php"; ?>
