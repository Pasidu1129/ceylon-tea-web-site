<?php
$pageTitle = "Products | Ceylon Tea";
require "header.php";
$category = trim($_GET["category"] ?? "");
if ($category !== "") {
    $stmt = $conn->prepare("SELECT * FROM products WHERE category=? ORDER BY id DESC");
    $stmt->bind_param("s", $category); $stmt->execute(); $result = $stmt->get_result();
} else { $result = $conn->query("SELECT * FROM products ORDER BY id DESC"); }
$categories = $conn->query("SELECT DISTINCT category FROM products ORDER BY category");
?>
<section class="page-banner"><h1>Our Tea Collection</h1><p>Premium Ceylon tea powders, selected for every tea moment.</p></section>
<section class="section">
    <div class="filter-bar">
        <a href="products.php">ALL</a>
        <?php while($c=$categories->fetch_assoc()): ?><a href="products.php?category=<?php echo urlencode($c['category']); ?>"><?php echo htmlspecialchars($c['category']); ?></a><?php endwhile; ?>
    </div>
    <div class="products">
        <?php if ($result->num_rows): while ($p = $result->fetch_assoc()): ?>
        <article class="product-card">
            <img src="images/<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
            <div class="product-info">
                <span class="tag"><?php echo htmlspecialchars($p['category']); ?></span>
                <h3><?php echo htmlspecialchars($p['name']); ?></h3>
                <p><?php echo htmlspecialchars($p['description']); ?></p>
                <div class="product-bottom"><strong>Rs. <?php echo number_format($p['price'],2); ?></strong><a class="small-btn" href="cart.php?action=add&id=<?php echo $p['id']; ?>">ADD TO CART</a></div>
            </div>
        </article>
        <?php endwhile; else: ?><p class="muted">No products found in this category.</p><?php endif; ?>
    </div>
</section>
<?php require "footer.php"; ?>
