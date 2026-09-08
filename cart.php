<?php
require "config.php";

if (!isset($_SESSION["cart"])) $_SESSION["cart"] = [];

$action = $_GET["action"] ?? "";
$id = (int)($_GET["id"] ?? 0);

if ($action === "add" && $id > 0) {
    $addQty = max(1, (int)($_GET["qty"] ?? 1));
    $stmt = $conn->prepare("SELECT stock FROM products WHERE id=? LIMIT 1");
    $stmt->bind_param("i", $id); $stmt->execute();
    $product = $stmt->get_result()->fetch_assoc();
    if ($product && (int)$product["stock"] > 0) {
        $current = (int)($_SESSION["cart"][$id] ?? 0);
        $_SESSION["cart"][$id] = min($current + $addQty, (int)$product["stock"]);
    }
    header("Location: cart.php");
    exit;
}

if ($action === "remove" && $id > 0) {
    unset($_SESSION["cart"][$id]);
    header("Location: cart.php");
    exit;
}

if ($action === "clear") {
    $_SESSION["cart"] = [];
    header("Location: cart.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["update_cart"])) {
    foreach ($_POST["qty"] as $pid => $qty) {
        $qty = max(0, (int)$qty);
        if ($qty === 0) unset($_SESSION["cart"][(int)$pid]);
        else $_SESSION["cart"][(int)$pid] = $qty;
    }
    header("Location: cart.php");
    exit;
}

$pageTitle = "Shopping Cart | Ceylon Tea";
require "header.php";

$total = 0;
?>
<section class="page-banner">
    <h1>Shopping Cart</h1>
    <p>Review your selected tea products.</p>
</section>

<section class="section narrow">
<?php if (empty($_SESSION["cart"])): ?>
    <div class="empty-box">
        <h2>Your cart is empty</h2>
        <p>Add a tea product to get started.</p>
        <a class="btn" href="products.php">VIEW PRODUCTS</a>
    </div>
<?php else: ?>
<form method="post">
<table class="cart-table">
<thead><tr><th>Product</th><th>Price</th><th>Quantity</th><th>Subtotal</th><th></th></tr></thead>
<tbody>
<?php
$ids = array_keys($_SESSION["cart"]);
$placeholders = implode(",", array_fill(0, count($ids), "?"));
$types = str_repeat("i", count($ids));
$stmt = $conn->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
$stmt->bind_param($types, ...$ids);
$stmt->execute();
$res = $stmt->get_result();

while ($p = $res->fetch_assoc()):
    $qty = $_SESSION["cart"][$p["id"]];
    $subtotal = $p["price"] * $qty;
    $total += $subtotal;
?>
<tr>
<td><img class="cart-img" src="images/<?php echo htmlspecialchars($p['image']); ?>" alt=""><b><?php echo htmlspecialchars($p['name']); ?></b></td>
<td>Rs. <?php echo number_format($p["price"],2); ?></td>
<td><input class="qty" type="number" min="0" name="qty[<?php echo $p['id']; ?>]" value="<?php echo $qty; ?>"></td>
<td>Rs. <?php echo number_format($subtotal,2); ?></td>
<td><a href="cart.php?action=remove&id=<?php echo $p['id']; ?>">Remove</a></td>
</tr>
<?php endwhile; ?>
</tbody>
</table>
<div class="cart-summary">
    <strong>Total: Rs. <?php echo number_format($total,2); ?></strong>
    <div>
        <button class="outline-btn" type="submit" name="update_cart">UPDATE CART</button>
        <a class="btn" href="checkout.php">CHECKOUT</a>
        <a class="text-link" href="cart.php?action=clear">Clear Cart</a>
    </div>
</div>
</form>
<?php endif; ?>
</section>
<?php require "footer.php"; ?>
