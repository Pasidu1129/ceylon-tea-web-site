<?php
$pageTitle = "Products | Ceylon Tea";
require "header.php";

$category = $_GET["category"] ?? "";
if ($category !== "") {
    $stmt = $conn->prepare("SELECT * FROM products WHERE category=? ORDER BY id DESC");
    $stmt->bind_param("s", $category);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $result = $conn->query("SELECT * FROM products ORDER BY id DESC");
}
?>
<section class="page-banner">
    <h1>Our Tea Products</h1>
    <p>Choose your favourite Ceylon tea.</p>
</section>
<section class="section">
    <div class="products">
        <?php while ($p = $result->fetch_assoc()): ?>
        <article class="product-card">
            <a class="product-image-link" href="product.php?id=<?php echo $p['id']; ?>"><img src="images/<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>"></a>
            <div class="product-info">
                <span class="tag"><?php echo htmlspecialchars($p['category']); ?></span>
                <h3><a href="product.php?id=<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['name']); ?></a></h3>
                <p><?php echo htmlspecialchars($p['description']); ?></p>
                <div class="product-bottom">
                    <strong>Rs. <?php echo number_format($p['price'], 2); ?></strong>
                    <a class="small-btn" href="product.php?id=<?php echo $p['id']; ?>">VIEW DETAILS</a>
                </div>
            </div>
        </article>
        <?php endwhile; ?>
    </div>
</section>
<?php require "footer.php"; ?>
