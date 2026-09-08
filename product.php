<?php
require "config.php";
$id = (int)($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM products WHERE id=? LIMIT 1");
$stmt->bind_param("i", $id);
$stmt->execute();
$p = $stmt->get_result()->fetch_assoc();
if (!$p) { header("Location: products.php"); exit; }
$pageTitle = $p['name'] . " | Ceylon Tea";
require "header.php";
$details = [
  'Origin' => 'Sri Lanka — Ceylon Tea',
  'Weight' => '250 g',
  'Tea Type' => $p['category'],
  'Best For' => 'Daily tea, gifting & relaxing moments'
];
?>
<section class="product-detail-wrap">
  <div class="product-detail">
    <div class="detail-image"><img src="images/<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>"></div>
    <div class="detail-content">
      <span class="eyebrow"><?php echo htmlspecialchars($p['category']); ?></span>
      <h1><?php echo htmlspecialchars($p['name']); ?></h1>
      <p class="detail-description"><?php echo htmlspecialchars($p['description']); ?></p>
      <div class="detail-price">Rs. <?php echo number_format($p['price'],2); ?></div>
      <div class="stock-line">● <?php echo ((int)$p['stock'] > 0 ? 'In Stock' : 'Out of Stock'); ?></div>
      <?php if ((int)$p['stock'] > 0): ?>
      <form class="buy-form" method="get" action="cart.php">
        <input type="hidden" name="action" value="add">
        <input type="hidden" name="id" value="<?php echo $p['id']; ?>">
        <label>Quantity</label>
        <div class="buy-row"><input type="number" name="qty" value="1" min="1" max="<?php echo (int)$p['stock']; ?>"><button class="gold-btn" type="submit">ADD TO BAG</button></div>
      </form>
      <?php else: ?><button class="gold-btn disabled" disabled>OUT OF STOCK</button><?php endif; ?>
      <div class="details-grid">
        <?php foreach($details as $k=>$v): ?><div><span><?php echo $k; ?></span><strong><?php echo $v; ?></strong></div><?php endforeach; ?>
      </div>
    </div>
  </div>
</section>
<section class="section detail-extra">
  <div class="detail-panel"><h2>Tasting Notes</h2><p><?php echo htmlspecialchars($p['tasting_notes'] ?? 'A smooth aroma, balanced character and a satisfying finish.'); ?></p></div>
  <div class="detail-panel"><h2>Brewing Guide</h2><p>Use 1–2 teaspoons per cup. Add hot water and steep for 3–5 minutes. Adjust strength to your preference.</p></div>
</section>
<?php require "footer.php"; ?>
