<?php
$pageTitle = "Tea Collection | Ceylon Noir";
require "header.php";

$category = trim($_GET['category'] ?? '');
$search = trim($_GET['search'] ?? '');
$sort = $_GET['sort'] ?? 'featured';
$min = $_GET['min'] ?? '';
$max = $_GET['max'] ?? '';

$where = [];
$params = [];
$types = '';

if ($category !== '') {
    $where[] = 'category=?';
    $params[] = $category;
    $types .= 's';
}

if ($search !== '') {
    $where[] = '(name LIKE ? OR description LIKE ? OR tasting_notes LIKE ?)';
    $like = "%$search%";
    $params[] = $like;
    $params[] = $like;
    $params[] = $like;
    $types .= 'sss';
}

if ($min !== '' && is_numeric($min)) {
    $where[] = 'price>=?';
    $params[] = (float)$min;
    $types .= 'd';
}

if ($max !== '' && is_numeric($max)) {
    $where[] = 'price<=?';
    $params[] = (float)$max;
    $types .= 'd';
}

$order = [
    'featured' => 'featured DESC, id DESC',
    'price_low' => 'price ASC',
    'price_high' => 'price DESC',
    'newest' => 'id DESC'
][$sort] ?? 'featured DESC, id DESC';

$sql = 'SELECT * FROM products' .
       ($where ? ' WHERE ' . implode(' AND ', $where) : '') .
       ' ORDER BY ' . $order;

$stmt = $conn->prepare($sql);

if ($params) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

$cats = $conn->query("SELECT DISTINCT category FROM products ORDER BY category");
?>

<style>

/* =========================================================
   CEYLON NOIR PREMIUM PRODUCTS PAGE
   UI / DESIGN ONLY
   DATABASE & PHP LOGIC UNCHANGED
   ========================================================= */

.luxury-banner {
    position: relative;
    overflow: hidden;
    min-height: 330px;
    display: flex;
    align-items: center;
    padding: 70px 7%;
    background:
        radial-gradient(circle at 80% 30%, rgba(202, 159, 64, .13), transparent 32%),
        radial-gradient(circle at 15% 90%, rgba(202, 159, 64, .07), transparent 30%),
        linear-gradient(135deg, #050505, #0d0d0d 55%, #050505);
    border-bottom: 1px solid rgba(214, 174, 83, .22);
}

.luxury-banner::before {
    content: "";
    position: absolute;
    width: 360px;
    height: 360px;
    right: -100px;
    top: -160px;
    border: 1px solid rgba(218, 177, 82, .14);
    border-radius: 50%;
}

.luxury-banner::after {
    content: "";
    position: absolute;
    width: 250px;
    height: 250px;
    right: -40px;
    top: -100px;
    border: 1px solid rgba(218, 177, 82, .08);
    border-radius: 50%;
}

.luxury-banner > div {
    position: relative;
    z-index: 2;
    max-width: 760px;
}

.luxury-banner span {
    display: inline-block;
    margin-bottom: 16px;
    color: #d3ad59;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 3px;
}

.luxury-banner h1 {
    margin: 0 0 16px;
    color: #f4f0e7;
    font-size: clamp(38px, 5vw, 66px);
    font-weight: 500;
    line-height: 1.05;
    letter-spacing: -1px;
}

.luxury-banner h1 em {
    color: #d7b35e;
    font-family: Georgia, serif;
    font-weight: 400;
}

.luxury-banner p {
    max-width: 650px;
    margin: 0;
    color: #aaa39a;
    font-size: 15px;
    line-height: 1.8;
}


/* =========================================================
   CATALOG
   ========================================================= */

.catalog {
    background:
        radial-gradient(circle at 50% 0%, rgba(197, 155, 65, .035), transparent 35%),
        #080808;
    padding-top: 65px;
    padding-bottom: 80px;
}

.catalog-head {
    display: flex;
    align-items: end;
    justify-content: space-between;
    gap: 20px;
    margin-bottom: 32px;
}

.gold-kicker {
    display: inline-block;
    margin-bottom: 10px;
    color: #cda74f;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 2.5px;
}

.catalog-head h2 {
    margin: 0;
    color: #f0ece3;
    font-size: 34px;
    font-weight: 500;
    letter-spacing: -.5px;
}

.result-count {
    color: #948b7d;
    font-size: 12px;
    letter-spacing: 1px;
}


/* =========================================================
   FILTER PANEL
   ========================================================= */

.filter-panel {
    display: grid;
    grid-template-columns: 2fr 1.2fr 1fr 1fr 1.25fr auto auto;
    gap: 12px;
    align-items: end;

    padding: 22px;
    margin-bottom: 25px;

    background:
        linear-gradient(145deg, rgba(255,255,255,.035), rgba(255,255,255,.012)),
        #0b0b0b;

    border: 1px solid rgba(205, 165, 76, .18);
    border-radius: 6px;

    box-shadow:
        0 15px 40px rgba(0,0,0,.35),
        inset 0 1px 0 rgba(255,255,255,.025);
}

.filter-panel label {
    display: block;
    margin-bottom: 8px;
    color: #9e9587;
    font-size: 9px;
    font-weight: 700;
    letter-spacing: 1.5px;
    text-transform: uppercase;
}

.filter-panel input,
.filter-panel select {
    width: 100%;
    height: 46px;
    padding: 0 13px;

    color: #ddd5c6;
    background: #070707;

    border: 1px solid rgba(180, 150, 91, .22);
    border-radius: 4px;

    outline: none;
    font-family: inherit;
    font-size: 12px;

    transition: .3s ease;
}

.filter-panel input::placeholder {
    color: #666057;
}

.filter-panel input:focus,
.filter-panel select:focus {
    border-color: rgba(218, 178, 86, .7);
    box-shadow: 0 0 0 3px rgba(214, 174, 83, .06);
}

.filter-panel select option {
    background: #111;
    color: #ddd;
}


/* =========================================================
   PREMIUM GOLD BUTTONS
   ========================================================= */

.gold-btn,
.outline-btn {
    position: relative;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    min-height: 46px;
    padding: 0 23px;

    border-radius: 4px;

    font-family: inherit;
    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1.7px;

    text-decoration: none;
    cursor: pointer;

    transition:
        transform .3s ease,
        box-shadow .3s ease,
        background .3s ease,
        color .3s ease,
        border-color .3s ease;

    overflow: hidden;
}


/* GOLD PRIMARY */

.gold-btn {
    color: #090909;

    background:
        linear-gradient(
            135deg,
            #a97922 0%,
            #d5aa4e 25%,
            #f0d27e 48%,
            #d1a544 70%,
            #9c6d1c 100%
        );

    border: 1px solid #d5ab50;

    box-shadow:
        0 6px 20px rgba(0,0,0,.3),
        inset 0 1px 0 rgba(255,255,255,.35);
}

.gold-btn::before {
    content: "";

    position: absolute;
    top: 0;
    left: -120%;

    width: 70%;
    height: 100%;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(255,255,255,.4),
            transparent
        );

    transform: skewX(-20deg);

    transition: left .6s ease;
}

.gold-btn:hover::before {
    left: 150%;
}

.gold-btn:hover {
    color: #000;
    transform: translateY(-3px);

    box-shadow:
        0 10px 28px rgba(203, 161, 69, .25),
        0 0 20px rgba(203, 161, 69, .12),
        inset 0 1px 0 rgba(255,255,255,.5);
}


/* OUTLINE BUTTON */

.outline-btn {
    color: #d7b45d;
    background: rgba(0,0,0,.55);

    border: 1px solid rgba(213, 174, 82, .55);

    box-shadow:
        inset 0 0 0 1px rgba(255,255,255,.015),
        0 5px 16px rgba(0,0,0,.25);
}

.outline-btn:hover {
    color: #080808;

    background:
        linear-gradient(
            135deg,
            #ae7d24,
            #e6c56d,
            #b98528
        );

    border-color: #dfb75a;

    transform: translateY(-3px);

    box-shadow:
        0 9px 25px rgba(210, 170, 76, .22),
        0 0 17px rgba(210, 170, 76, .1);
}


/* SMALL GOLD BUTTON */

.gold-btn.mini {
    min-height: 42px;
    padding: 0 17px;
    font-size: 9px;
}


/* CLEAR */

.clear-filter {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    min-height: 46px;
    padding: 0 17px;

    color: #9d927f;
    background: rgba(255,255,255,.015);

    border: 1px solid rgba(170,145,95,.22);
    border-radius: 4px;

    font-size: 9px;
    font-weight: 700;
    letter-spacing: 1.5px;

    text-decoration: none;

    transition: .3s ease;
}

.clear-filter:hover {
    color: #e0bd66;
    background: rgba(210,170,75,.06);
    border-color: rgba(210,170,75,.55);
}


/* =========================================================
   CATEGORY PILLS
   ========================================================= */

.category-pills {
    display: flex;
    gap: 9px;
    flex-wrap: wrap;
    margin-bottom: 35px;
}

.pill {
    display: inline-flex;
    align-items: center;
    justify-content: center;

    min-height: 36px;
    padding: 0 17px;

    color: #918879;
    background: #0b0b0b;

    border: 1px solid rgba(180,150,90,.18);
    border-radius: 30px;

    font-size: 9px;
    font-weight: 700;
    letter-spacing: 1.2px;

    text-decoration: none;

    transition: .3s ease;
}

.pill:hover {
    color: #dcb968;
    border-color: rgba(216,174,82,.55);
    background: rgba(213,173,80,.05);
    transform: translateY(-2px);
}

.pill.active {
    color: #0a0a0a;

    background:
        linear-gradient(
            135deg,
            #b58227,
            #e1bd61,
            #bd8c31
        );

    border-color: #d5ad52;

    box-shadow:
        0 5px 18px rgba(206,165,72,.15);
}


/* =========================================================
   PRODUCTS GRID
   ========================================================= */

.premium-products {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 25px;
}


/* =========================================================
   PRODUCT CARD
   ========================================================= */

.premium-card {
    position: relative;
    overflow: hidden;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,.035),
            rgba(255,255,255,.008)
        ),
        #0b0b0b;

    border: 1px solid rgba(205,165,76,.15);
    border-radius: 7px;

    box-shadow:
        0 14px 35px rgba(0,0,0,.35);

    transition:
        transform .4s ease,
        border-color .4s ease,
        box-shadow .4s ease;
}

.premium-card:hover {
    transform: translateY(-8px);

    border-color: rgba(214,174,83,.42);

    box-shadow:
        0 22px 48px rgba(0,0,0,.5),
        0 0 24px rgba(205,165,76,.055);
}


/* =========================================================
   PRODUCT IMAGE
   ========================================================= */

.product-image-link {
    position: relative;
    display: block;

    height: 310px;
    overflow: hidden;

    background:
        radial-gradient(
            circle at center,
            rgba(208,169,76,.08),
            transparent 65%
        ),
        #060606;
}

.product-image-link img {
    width: 100%;
    height: 100%;

    object-fit: cover;

    display: block;

    transition:
        transform .7s cubic-bezier(.2,.7,.2,1),
        filter .5s ease;
}

.premium-card:hover .product-image-link img {
    transform: scale(1.06);
    filter: brightness(.72);
}


/* IMAGE DARK OVERLAY */

.product-image-link::after {
    content: "";

    position: absolute;
    inset: 0;

    background:
        linear-gradient(
            to top,
            rgba(0,0,0,.75),
            transparent 45%
        );

    pointer-events: none;
}


/* QUICK VIEW */

.quick-view {
    position: absolute;

    left: 50%;
    bottom: 20px;

    z-index: 4;

    min-width: 132px;

    padding: 12px 18px;

    color: #090909;

    background:
        linear-gradient(
            135deg,
            #b27f25,
            #e5c16a,
            #bd8d32
        );

    border: 1px solid #e0b75a;
    border-radius: 3px;

    font-size: 9px;
    font-weight: 800;
    letter-spacing: 1.7px;

    text-align: center;
    text-decoration: none;

    opacity: 0;

    transform: translate(-50%, 18px);

    transition:
        opacity .35s ease,
        transform .35s ease;

    box-shadow:
        0 8px 25px rgba(0,0,0,.45);
}

.product-image-link:hover .quick-view {
    opacity: 1;
    transform: translate(-50%, 0);
}


/* =========================================================
   PRODUCT INFORMATION
   ========================================================= */

.product-info {
    padding: 23px;
}

.card-meta {
    display: flex;
    align-items: center;
    justify-content: space-between;

    gap: 10px;
    margin-bottom: 13px;
}

.tag {
    color: #b99a59;

    font-size: 9px;
    font-weight: 700;
    letter-spacing: 1.4px;
    text-transform: uppercase;
}

.featured-label {
    color: #d7b25c;

    font-size: 8px;
    font-weight: 800;
    letter-spacing: 1.3px;

    padding: 5px 8px;

    border: 1px solid rgba(211,174,83,.3);
    background: rgba(211,174,83,.045);
    border-radius: 2px;
}

.product-info h3 {
    margin: 0 0 10px;
}

.product-info h3 a {
    color: #eee9df;

    font-family: Georgia, serif;
    font-size: 23px;
    font-weight: 400;

    text-decoration: none;

    transition: .3s ease;
}

.product-info h3 a:hover {
    color: #d9b65f;
}

.product-info p {
    min-height: 48px;
    margin: 0 0 18px;

    color: #8f897f;

    font-size: 12px;
    line-height: 1.65;
}


/* =========================================================
   PRICE
   ========================================================= */

.product-bottom {
    display: flex;
    align-items: center;

    padding-top: 17px;

    border-top: 1px solid rgba(255,255,255,.06);
}

.product-bottom strong {
    color: #dcb65d;

    font-family: Georgia, serif;
    font-size: 20px;
    font-weight: 400;

    letter-spacing: .3px;
}


/* =========================================================
   CARD ACTIONS
   ========================================================= */

.card-actions {
    display: flex;
    align-items: center;

    gap: 9px;

    margin-top: 20px;
}

.card-actions form {
    margin: 0;
}

.card-actions .add-cart-mini {
    min-width: 145px;
}


/* =========================================================
   OUT OF STOCK
   ========================================================= */

.outline-btn:disabled {
    color: #66615a;

    background: rgba(255,255,255,.018);

    border-color: rgba(255,255,255,.09);

    cursor: not-allowed;
    opacity: .65;

    box-shadow: none;
}

.outline-btn:disabled:hover {
    color: #66615a;

    background: rgba(255,255,255,.018);

    border-color: rgba(255,255,255,.09);

    transform: none;
}


/* =========================================================
   NO RESULTS
   ========================================================= */

.no-results {
    grid-column: 1 / -1;

    padding: 80px 30px;

    text-align: center;

    background:
        radial-gradient(
            circle at center,
            rgba(207,166,73,.06),
            transparent 55%
        ),
        #0b0b0b;

    border: 1px solid rgba(205,165,76,.16);
    border-radius: 7px;
}

.no-results h3 {
    margin: 0 0 10px;

    color: #e8e2d6;

    font-family: Georgia, serif;
    font-size: 26px;
    font-weight: 400;
}

.no-results p {
    margin: 0 0 25px;

    color: #8f897f;
    font-size: 13px;
}


/* =========================================================
   RESPONSIVE
   ========================================================= */

@media (max-width: 1200px) {

    .filter-panel {
        grid-template-columns: repeat(3, 1fr);
    }

    .filter-search {
        grid-column: span 3;
    }

    .premium-products {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}


@media (max-width: 760px) {

    .luxury-banner {
        min-height: 280px;
        padding: 55px 6%;
    }

    .catalog {
        padding-top: 45px;
    }

    .catalog-head {
        align-items: flex-start;
        flex-direction: column;
    }

    .catalog-head h2 {
        font-size: 29px;
    }

    .filter-panel {
        grid-template-columns: 1fr;
        padding: 17px;
    }

    .filter-search {
        grid-column: auto;
    }

    .filter-btn,
    .clear-filter {
        width: 100%;
    }

    .premium-products {
        grid-template-columns: 1fr;
    }

    .product-image-link {
        height: 330px;
    }
}


@media (max-width: 480px) {

    .luxury-banner h1 {
        font-size: 38px;
    }

    .luxury-banner p {
        font-size: 13px;
    }

    .category-pills {
        gap: 7px;
    }

    .pill {
        padding: 0 13px;
    }

    .product-info {
        padding: 19px;
    }

    .product-info h3 a {
        font-size: 21px;
    }

    .card-actions {
        flex-direction: column;
        align-items: stretch;
    }

    .card-actions .gold-btn,
    .card-actions .outline-btn,
    .card-actions form {
        width: 100%;
    }

    .card-actions form .outline-btn {
        width: 100%;
    }
}

</style>


<!-- =========================================================
     LUXURY BANNER
     ========================================================= -->

<section class="luxury-banner">
    <div>

        <span>THE CEYLON NOIR COLLECTION</span>

        <h1>
            Curated Tea,
            <em>Elevated.</em>
        </h1>

        <p>
            Explore single-origin classics, aromatic infusions and
            signature blends crafted for memorable cups.
        </p>

    </div>
</section>


<!-- =========================================================
     PRODUCT CATALOG
     ========================================================= -->

<section class="catalog section">

    <div class="catalog-head">

        <div>

            <span class="gold-kicker">
                SHOP THE COLLECTION
            </span>

            <h2>
                Premium Tea Selection
            </h2>

        </div>

        <span class="result-count">
            <?php echo $result->num_rows; ?> teas
        </span>

    </div>


    <!-- =====================================================
         FILTER
         ===================================================== -->

    <form class="filter-panel" method="get">

        <div class="filter-search">

            <label>Search</label>

            <input
                type="search"
                name="search"
                value="<?php echo htmlspecialchars($search); ?>"
                placeholder="Search tea, flavour or notes..."
            >

        </div>


        <div>

            <label>Category</label>

            <select name="category">

                <option value="">
                    All Categories
                </option>

                <?php while($c = $cats->fetch_assoc()): ?>

                    <option
                        value="<?php echo htmlspecialchars($c['category']); ?>"
                        <?php echo $category === $c['category'] ? 'selected' : ''; ?>
                    >
                        <?php echo htmlspecialchars($c['category']); ?>
                    </option>

                <?php endwhile; ?>

            </select>

        </div>


        <div>

            <label>Min Price</label>

            <input
                type="number"
                name="min"
                min="0"
                value="<?php echo htmlspecialchars($min); ?>"
                placeholder="Rs."
            >

        </div>


        <div>

            <label>Max Price</label>

            <input
                type="number"
                name="max"
                min="0"
                value="<?php echo htmlspecialchars($max); ?>"
                placeholder="Rs."
            >

        </div>


        <div>

            <label>Sort By</label>

            <select name="sort">

                <option
                    value="featured"
                    <?php echo $sort === 'featured' ? 'selected' : ''; ?>
                >
                    Featured
                </option>

                <option
                    value="newest"
                    <?php echo $sort === 'newest' ? 'selected' : ''; ?>
                >
                    Newest
                </option>

                <option
                    value="price_low"
                    <?php echo $sort === 'price_low' ? 'selected' : ''; ?>
                >
                    Price: Low to High
                </option>

                <option
                    value="price_high"
                    <?php echo $sort === 'price_high' ? 'selected' : ''; ?>
                >
                    Price: High to Low
                </option>

            </select>

        </div>


        <button
            type="submit"
            class="gold-btn filter-btn"
        >
            APPLY FILTER
        </button>


        <a
            class="clear-filter"
            href="products.php"
        >
            CLEAR
        </a>

    </form>


    <!-- =====================================================
         CATEGORY PILLS
         ===================================================== -->

    <div class="category-pills">

        <a
            class="pill <?php echo $category === '' ? 'active' : ''; ?>"
            href="products.php"
        >
            All
        </a>

        <?php

        $cats->data_seek(0);

        while($c = $cats->fetch_assoc()):

        ?>

            <a
                class="pill <?php echo $category === $c['category'] ? 'active' : ''; ?>"
                href="products.php?category=<?php echo urlencode($c['category']); ?>"
            >
                <?php echo htmlspecialchars($c['category']); ?>
            </a>

        <?php endwhile; ?>

    </div>


    <!-- =====================================================
         PRODUCTS
         ===================================================== -->

    <div class="products premium-products">

        <?php if($result->num_rows): ?>

            <?php while($p = $result->fetch_assoc()): ?>

                <article class="product-card premium-card">


                    <!-- PRODUCT IMAGE -->

                    <a
                        class="product-image-link"
                        href="product.php?id=<?php echo $p['id']; ?>"
                    >

                        <img
                            src="images/<?php echo htmlspecialchars($p['image']); ?>"
                            alt="<?php echo htmlspecialchars($p['name']); ?>"
                        >

                        <span class="quick-view">
                            VIEW DETAILS
                        </span>

                    </a>


                    <!-- PRODUCT INFO -->

                    <div class="product-info">


                        <!-- META -->

                        <div class="card-meta">

                            <span class="tag">
                                <?php echo htmlspecialchars($p['category']); ?>
                            </span>


                            <?php if($p['featured']): ?>

                                <span class="featured-label">
                                    SIGNATURE
                                </span>

                            <?php endif; ?>

                        </div>


                        <!-- NAME -->

                        <h3>

                            <a
                                href="product.php?id=<?php echo $p['id']; ?>"
                            >
                                <?php echo htmlspecialchars($p['name']); ?>
                            </a>

                        </h3>


                        <!-- DESCRIPTION -->

                        <p>
                            <?php echo htmlspecialchars($p['description']); ?>
                        </p>


                        <!-- PRICE -->

                        <div class="product-bottom">

                            <strong>
                                Rs.
                                <?php echo number_format($p['price'], 2); ?>
                            </strong>

                        </div>


                        <!-- ACTIONS -->

                        <div class="card-actions">


                            <!-- VIEW DETAILS -->

                            <a
                                class="gold-btn mini"
                                href="product.php?id=<?php echo $p['id']; ?>"
                            >
                                VIEW DETAILS
                            </a>


                            <!-- ADD TO CART -->

                            <?php if((int)$p['stock'] > 0): ?>

                                <form
                                    method="get"
                                    action="cart.php"
                                >

                                    <input
                                        type="hidden"
                                        name="action"
                                        value="add"
                                    >

                                    <input
                                        type="hidden"
                                        name="id"
                                        value="<?php echo $p['id']; ?>"
                                    >

                                    <input
                                        type="hidden"
                                        name="qty"
                                        value="1"
                                    >

                                    <button
                                        class="outline-btn add-cart-mini"
                                        type="submit"
                                    >
                                        ADD TO CART
                                    </button>

                                </form>


                            <?php else: ?>

                                <button
                                    class="outline-btn add-cart-mini"
                                    disabled
                                >
                                    OUT OF STOCK
                                </button>

                            <?php endif; ?>


                        </div>

                    </div>

                </article>

            <?php endwhile; ?>


        <?php else: ?>


            <!-- NO RESULTS -->

            <div class="no-results">

                <h3>
                    No tea matched your filters.
                </h3>

                <p>
                    Try another category, search term or price range.
                </p>

                <a
                    class="gold-btn"
                    href="products.php"
                >
                    VIEW ALL TEAS
                </a>

            </div>


        <?php endif; ?>

    </div>

</section>


<?php require "footer.php"; ?>