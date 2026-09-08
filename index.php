<?php
$pageTitle = "Ceylon Tea | Premium Tea Powder";
require "header.php";
?>
<section class="hero">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <p class="eyebrow">PREMIUM CEYLON</p>
        <h1>TEA POWDER</h1>
        <p>Experience the rich taste, natural aroma and exceptional quality of 100% Pure Ceylon Tea.</p>
        <a class="btn" href="products.php">SHOP NOW →</a>
    </div>
</section>

<section class="section">
    <div class="section-title">
        <h2>🍃 SHOP BY CATEGORY 🍃</h2>
        <p>Explore our premium tea collection</p>
    </div>
    <div class="categories">
        <?php
        $cats = [
            ["black-tea.jpg","BLACK TEA"],
            ["green-tea.jpg","GREEN TEA"],
            ["ginger-tea.jpg","GINGER TEA"],
            ["cinnamon-tea.jpg","CINNAMON TEA"],
            ["herbal-tea.jpg","HERBAL TEA"],
            ["premium-tea.jpg","PREMIUM TEA"]
        ];
        foreach ($cats as $c):
        ?>
        <a class="category-card" href="products.php?category=<?php echo urlencode($c[1]); ?>">
            <img src="images/<?php echo $c[0]; ?>" alt="<?php echo htmlspecialchars($c[1]); ?>">
            <h3><?php echo htmlspecialchars($c[1]); ?></h3>
        </a>
        <?php endforeach; ?>
    </div>
</section>

<section class="home-luxury-strip"><div><span class="gold-kicker">THE CEYLON NOIR EXPERIENCE</span><h2>Find Your Signature Cup</h2><p>Filter our collection by tea type, flavour and price to discover your next favourite.</p></div><a class="gold-btn" href="products.php">EXPLORE ALL TEAS →</a></section>

<section class="section">
    <div class="section-title">
        <h2>🍃 FEATURED PRODUCTS 🍃</h2>
        <p>Our popular premium tea powder products</p>
    </div>
    <div class="products">
        <?php
        $result = $conn->query("SELECT * FROM products WHERE featured=1 ORDER BY id LIMIT 4");
        while ($p = $result->fetch_assoc()):
        ?>
        <article class="product-card premium-card">
            <a class="product-image-link" href="product.php?id=<?php echo $p['id']; ?>"><img src="images/<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>"></a>
            <div class="product-info">
                <h3><?php echo htmlspecialchars($p['name']); ?></h3>
                <p><?php echo htmlspecialchars($p['description']); ?></p>
                <div class="product-bottom">
                    <strong>Rs. <?php echo number_format($p['price'], 2); ?></strong>
                    <a class="gold-btn mini" href="product.php?id=<?php echo $p['id']; ?>">VIEW DETAILS</a>
                </div>
            </div>
        </article>
        <?php endwhile; ?>
    </div>
</section>

<section class="why-us">
    <div class="section-title">
        <h2>WHY CHOOSE CEYLON TEA?</h2>
        <p>Quality and freshness in every cup</p>
    </div>
    <div class="features">
        <div class="feature"><span>🌱</span><h3>100% PURE & NATURAL</h3><p>Carefully selected quality tea leaves.</p></div>
        <div class="feature"><span>🎁</span><h3>FRESH & SAFE PACKAGING</h3><p>Packed to maintain freshness and aroma.</p></div>
        <div class="feature"><span>🚚</span><h3>FAST & RELIABLE DELIVERY</h3><p>Quick and safe doorstep delivery.</p></div>
        <div class="feature"><span>🔒</span><h3>SECURE SHOPPING</h3><p>A simple and secure shopping experience.</p></div>
    </div>
</section>
<?php require "footer.php"; ?>
