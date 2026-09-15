<?php
require "config.php";

if (!isLoggedIn()) {
    header("Location: login.php");
    exit;
}
if (empty($_SESSION["cart"])) {
    header("Location: cart.php");
    exit;
}

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $address = trim($_POST["address"] ?? "");
    $phone = trim($_POST["phone"] ?? "");
    $paymentMethod = $_POST["payment_method"] ?? "Cash on Delivery";

    if ($address === "" || $phone === "") {
        $error = "Please fill in all fields.";
    } else {
        $total = 0;
        $items = [];

        foreach ($_SESSION["cart"] as $pid => $qty) {
            $pid = (int)$pid;
            $qty = (int)$qty;
            $stmt = $conn->prepare("SELECT id,name,price FROM products WHERE id=?");
            $stmt->bind_param("i", $pid);
            $stmt->execute();
            $p = $stmt->get_result()->fetch_assoc();
            if ($p) {
                $subtotal = $p["price"] * $qty;
                $total += $subtotal;
                $items[] = [$p["id"], $qty, $p["price"]];
            }
        }

        if ($paymentMethod === "Online Payment") {
            $_SESSION["pending_checkout"] = [
                "address" => $address,
                "phone" => $phone,
                "total" => $total,
                "items" => $items
            ];
            header("Location: payment.php");
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO orders(user_id,total,address,phone,status,payment_method,payment_status) VALUES(?,?,?,?, 'Pending', 'Cash on Delivery', 'Pending')");
        $stmt->bind_param("idss", $_SESSION["user_id"], $total, $address, $phone);
        if ($stmt->execute()) {
            $orderId = $conn->insert_id;
            $itemStmt = $conn->prepare("INSERT INTO order_items(order_id,product_id,quantity,unit_price) VALUES(?,?,?,?)");
            foreach ($items as [$pid,$qty,$price]) {
                $itemStmt->bind_param("iiid", $orderId, $pid, $qty, $price);
                $itemStmt->execute();
            }
            $_SESSION["cart"] = [];
            header("Location: order_success.php?id=".$orderId);
            exit;
        } else {
            $error = "Could not place the order.";
        }
    }
}

$pageTitle = "Checkout | Ceylon Tea";
require "header.php";
?>
<section class="form-section">
<div class="form-card">
<h1>Checkout</h1>
<?php if ($error): ?><div class="alert"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
<form method="post">
<label>Delivery Address</label>
<textarea name="address" rows="4" required></textarea>
<label>Phone Number</label>
<input type="tel" name="phone" required>
<label>Payment Method</label>
<select name="payment_method" id="payment_method" style="width:100%;padding:11px;border:1px solid #ccc4b5;border-radius:5px;font-size:14px;background:#fffdf8">
<option value="Cash on Delivery">Cash on Delivery</option>
<option value="Online Payment">Online Payment — Card / Bank</option>
</select>
<div class="payment-note" style="margin-top:12px;padding:12px;border:1px solid rgba(199,163,74,.35);background:#f7efdc;border-radius:6px;font-size:12px;color:#6b5a38">Online payment will continue to the secure payment step. Card details are not stored in the website database.</div>
<button class="btn" type="submit">CONTINUE TO PAYMENT / PLACE ORDER</button>
</form>
</div>
</section>
<?php require "footer.php"; ?>
