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

        $stmt = $conn->prepare("INSERT INTO orders(user_id,total,address,phone,status) VALUES(?,?,?,?, 'Pending')");
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
<button class="btn" type="submit">PLACE ORDER</button>
</form>
</div>
</section>
<?php require "footer.php"; ?>
