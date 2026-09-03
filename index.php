<?php
$pageTitle = "Ceylon Tea | Premium Tea Powder";
require "header.php";
?>
<section class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <p class="eyebrow">100% PURE CEYLON TEA</p>
        <h1>The Art of a Perfect Cup</h1>
        <p>Discover carefully selected Ceylon tea powders with a rich aroma, refined flavour and the character of Sri Lanka.</p>
        <a class="btn" href="products.php">EXPLORE COLLECTION →</a>
    </div>
</section>

<section class="section">
    <div class="section-title"><h2>Shop by Category</h2><p>Find the tea that matches your taste.</p></div>
    <div class="categories">
        <?php
        $cats = [["black-tea.jpg","BLACK TEA"],["green-tea.jpg","GREEN TEA"],["ginger-tea.jpg","GINGER TEA"],["cinnamon-tea.jpg","CINNAMON TEA"],["herbal-tea.jpg","HERBAL TEA"],["premium-tea.jpg","PREMIUM TEA"]];
        foreach ($cats as $c):
        ?>
        <a class="category-card" href="products.php?category=<?php echo urlencode($c[1]); ?>">
            <img src="images/<?php echo $c[0]; ?>" alt="<?php echo htmlspecialchars($c[1]); ?>">
            <h3><?php echo htmlspecialchars($c[1]); ?></h3>
        </a>
        <?php endforeach; ?>
    </div>
</section>

<section class="section">
    <div class="section-title"><h2>Signature Collection</h2><p>Premium blends selected for everyday luxury.</p></div>
    <div class="products">
        <?php
        $result = $conn->query("SELECT * FROM products WHERE featured=1 ORDER BY id LIMIT 4");
        while ($p = $result->fetch_assoc()):
        ?>
        <article class="product-card">
            <img src="images/<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>">
            <div class="product-info">
                <span class="tag"><?php echo htmlspecialchars($p['category']); ?></span>
                <h3><?php echo htmlspecialchars($p['name']); ?></h3>
                <p><?php echo htmlspecialchars($p['description']); ?></p>
                <div class="product-bottom">
                    <strong>Rs. <?php echo number_format($p['price'], 2); ?></strong>
                    <a class="small-btn" href="cart.php?action=add&id=<?php echo $p['id']; ?>">ADD TO CART</a>
                </div>
            </div>
        </article>
        <?php endwhile; ?>
    </div>
</section>

<section class="why-us">
    <div class="section-title"><h2>Why Ceylon Tea?</h2><p>A refined shopping experience from leaf to doorstep.</p></div>
    <div class="features">
        <div class="feature"><span>✦</span><h3>PURE CEYLON QUALITY</h3><p>Selected tea products inspired by Sri Lanka's tea heritage.</p></div>
        <div class="feature"><span>◇</span><h3>FRESH PACKAGING</h3><p>Carefully packed to preserve aroma and flavour.</p></div>
        <div class="feature"><span>→</span><h3>RELIABLE DELIVERY</h3><p>Simple ordering and convenient doorstep delivery.</p></div>
        <div class="feature"><span>✓</span><h3>SECURE SHOPPING</h3><p>Protected accounts and a clear checkout experience.</p></div>
    </div>
</section>
<?php require "footer.php"; ?>
