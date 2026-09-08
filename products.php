<?php
$pageTitle = "Tea Collection | Ceylon Noir";
require "header.php";

$category = trim($_GET['category'] ?? '');
$search = trim($_GET['search'] ?? '');
$sort = $_GET['sort'] ?? 'featured';
$min = $_GET['min'] ?? '';
$max = $_GET['max'] ?? '';

$where=[]; $params=[]; $types='';
if($category!==''){ $where[]='category=?'; $params[]=$category; $types.='s'; }
if($search!==''){ $where[]='(name LIKE ? OR description LIKE ? OR tasting_notes LIKE ?)'; $like="%$search%"; $params[]=$like;$params[]=$like;$params[]=$like;$types.='sss'; }
if($min!=='' && is_numeric($min)){ $where[]='price>=?'; $params[]=(float)$min; $types.='d'; }
if($max!=='' && is_numeric($max)){ $where[]='price<=?'; $params[]=(float)$max; $types.='d'; }
$order=['featured'=>'featured DESC, id DESC','price_low'=>'price ASC','price_high'=>'price DESC','newest'=>'id DESC'][$sort] ?? 'featured DESC, id DESC';
$sql='SELECT * FROM products'.($where?' WHERE '.implode(' AND ',$where):'').' ORDER BY '.$order;
$stmt=$conn->prepare($sql); if($params){$stmt->bind_param($types,...$params);} $stmt->execute(); $result=$stmt->get_result();
$cats=$conn->query("SELECT DISTINCT category FROM products ORDER BY category");
?>
<section class="luxury-banner"><div><span>THE CEYLON NOIR COLLECTION</span><h1>Curated Tea, <em>Elevated.</em></h1><p>Explore single-origin classics, aromatic infusions and signature blends crafted for memorable cups.</p></div></section>
<section class="catalog section">
  <div class="catalog-head"><div><span class="gold-kicker">SHOP THE COLLECTION</span><h2>Premium Tea Selection</h2></div><span class="result-count"><?php echo $result->num_rows; ?> teas</span></div>
  <form class="filter-panel" method="get">
    <div class="filter-search"><label>Search</label><input type="search" name="search" value="<?php echo htmlspecialchars($search); ?>" placeholder="Search tea, flavour or notes..."></div>
    <div><label>Category</label><select name="category"><option value="">All Categories</option><?php while($c=$cats->fetch_assoc()): ?><option value="<?php echo htmlspecialchars($c['category']); ?>" <?php echo $category===$c['category']?'selected':''; ?>><?php echo htmlspecialchars($c['category']); ?></option><?php endwhile; ?></select></div>
    <div><label>Min Price</label><input type="number" name="min" min="0" value="<?php echo htmlspecialchars($min); ?>" placeholder="Rs."></div>
    <div><label>Max Price</label><input type="number" name="max" min="0" value="<?php echo htmlspecialchars($max); ?>" placeholder="Rs."></div>
    <div><label>Sort By</label><select name="sort"><option value="featured" <?php echo $sort==='featured'?'selected':''; ?>>Featured</option><option value="newest" <?php echo $sort==='newest'?'selected':''; ?>>Newest</option><option value="price_low" <?php echo $sort==='price_low'?'selected':''; ?>>Price: Low to High</option><option value="price_high" <?php echo $sort==='price_high'?'selected':''; ?>>Price: High to Low</option></select></div>
    <button class="gold-btn filter-btn">APPLY FILTER</button><a class="clear-filter" href="products.php">Clear</a>
  </form>
  <div class="category-pills"><a class="pill <?php echo $category===''?'active':''; ?>" href="products.php">All</a><?php $cats->data_seek(0); while($c=$cats->fetch_assoc()): ?><a class="pill <?php echo $category===$c['category']?'active':''; ?>" href="products.php?category=<?php echo urlencode($c['category']); ?>"><?php echo htmlspecialchars($c['category']); ?></a><?php endwhile; ?></div>
  <div class="products premium-products">
  <?php if($result->num_rows): while($p=$result->fetch_assoc()): ?>
    <article class="product-card premium-card">
      <a class="product-image-link" href="product.php?id=<?php echo $p['id']; ?>"><img src="images/<?php echo htmlspecialchars($p['image']); ?>" alt="<?php echo htmlspecialchars($p['name']); ?>"><span class="quick-view">VIEW DETAILS</span></a>
      <div class="product-info"><div class="card-meta"><span class="tag"><?php echo htmlspecialchars($p['category']); ?></span><?php if($p['featured']): ?><span class="featured-label">SIGNATURE</span><?php endif; ?></div><h3><a href="product.php?id=<?php echo $p['id']; ?>"><?php echo htmlspecialchars($p['name']); ?></a></h3><p><?php echo htmlspecialchars($p['description']); ?></p><div class="product-bottom"><strong>Rs. <?php echo number_format($p['price'],2); ?></strong><a class="gold-btn mini" href="product.php?id=<?php echo $p['id']; ?>">EXPLORE</a></div></div>
    </article>
  <?php endwhile; else: ?><div class="no-results"><h3>No tea matched your filters.</h3><p>Try another category, search term or price range.</p><a class="gold-btn" href="products.php">VIEW ALL TEAS</a></div><?php endif; ?>
  </div>
</section>
<?php require "footer.php"; ?>
