<?php 
$pageTitle = "Ceylon Tea | Premium Tea Powder"; 
require "header.php"; 
?> 

<style>

/* =========================================================
   CEYLON NOIR — PREMIUM BLACK & GOLD HOME PAGE
   DATABASE / PHP LOGIC UNCHANGED
   ========================================================= */


/* =========================
   HERO SECTION
   ========================= */

.hero {
    position: relative;
    min-height: 680px;
    display: flex;
    align-items: center;
    overflow: hidden;

    background:
        radial-gradient(
            circle at 75% 45%,
            rgba(210, 170, 75, .12),
            transparent 30%
        ),
        linear-gradient(
            120deg,
            #030303 0%,
            #0a0a0a 50%,
            #050505 100%
        );

    border-bottom: 1px solid rgba(214,174,83,.2);
}

.hero-overlay {
    position: absolute;
    inset: 0;

    background:
        linear-gradient(
            90deg,
            rgba(0,0,0,.9) 0%,
            rgba(0,0,0,.65) 48%,
            rgba(0,0,0,.25) 100%
        );

    pointer-events: none;
}

.hero::before {
    content: "";
    position: absolute;

    width: 550px;
    height: 550px;

    right: -150px;
    top: -160px;

    border: 1px solid rgba(218,177,82,.12);
    border-radius: 50%;
}

.hero::after {
    content: "";
    position: absolute;

    width: 390px;
    height: 390px;

    right: -70px;
    top: -80px;

    border: 1px solid rgba(218,177,82,.07);
    border-radius: 50%;
}

.hero-content {
    position: relative;
    z-index: 2;

    max-width: 700px;
    padding: 100px 7%;
}

.eyebrow {
    margin: 0 0 18px;

    color: #d5ae58;

    font-size: 11px;
    font-weight: 800;
    letter-spacing: 4px;
}

.hero h1 {
    margin: 0 0 20px;

    color: #f1ede4;

    font-family: Georgia, serif;
    font-size: clamp(55px, 8vw, 100px);
    font-weight: 400;

    letter-spacing: 3px;
    line-height: .95;
}

.hero-content > p:not(.eyebrow) {
    max-width: 590px;

    margin: 0 0 32px;

    color: #aaa39a;

    font-size: 15px;
    line-height: 1.9;
}


/* =========================
   PREMIUM BUTTON
   ========================= */

.btn,
.gold-btn,
.outline-btn {
    position: relative;

    display: inline-flex;
    align-items: center;
    justify-content: center;

    min-height: 48px;
    padding: 0 25px;

    border-radius: 4px;

    font-family: inherit;

    font-size: 10px;
    font-weight: 800;
    letter-spacing: 1.8px;

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


/* GOLD BUTTON */

.btn,
.gold-btn {
    color: #090909;

    background:
        linear-gradient(
            135deg,
            #a87520 0%,
            #d4a94c 25%,
            #f0d27c 50%,
            #d0a442 72%,
            #996b1c 100%
        );

    border: 1px solid #d8ae52;

    box-shadow:
        0 7px 22px rgba(0,0,0,.35),
        inset 0 1px 0 rgba(255,255,255,.38);
}

.btn::before,
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

.btn:hover::before,
.gold-btn:hover::before {
    left: 150%;
}

.btn:hover,
.gold-btn:hover {
    color: #000;

    transform: translateY(-3px);

    box-shadow:
        0 11px 30px rgba(210,169,75,.25),
        0 0 20px rgba(210,169,75,.12),
        inset 0 1px 0 rgba(255,255,255,.5);
}


/* =========================
   COMMON SECTION
   ========================= */

.section {
    position: relative;

    padding: 85px 7%;

    background:
        radial-gradient(
            circle at 50% 0%,
            rgba(202,160,69,.035),
            transparent 35%
        ),
        #080808;
}

.section-title {
    text-align: center;

    margin-bottom: 45px;
}

.section-title h2 {
    margin: 0 0 12px;

    color: #eee9df;

    font-family: Georgia, serif;
    font-size: 32px;
    font-weight: 400;

    letter-spacing: 1px;
}

.section-title p {
    margin: 0;

    color: #89837a;

    font-size: 13px;
    letter-spacing: .5px;
}

.section-title h2::after {
    content: "";

    display: block;

    width: 55px;
    height: 1px;

    margin: 18px auto 0;

    background:
        linear-gradient(
            90deg,
            transparent,
            #d2ad57,
            transparent
        );
}


/* =========================
   CATEGORIES
   ========================= */

.categories {
    display: grid;

    grid-template-columns:
        repeat(3, minmax(0, 1fr));

    gap: 22px;

    max-width: 1250px;
    margin: auto;
}

.category-card {
    position: relative;

    display: block;

    height: 280px;

    overflow: hidden;

    background: #0b0b0b;

    border: 1px solid rgba(205,165,76,.16);
    border-radius: 6px;

    text-decoration: none;

    box-shadow:
        0 12px 30px rgba(0,0,0,.3);

    transition:
        transform .4s ease,
        border-color .4s ease,
        box-shadow .4s ease;
}

.category-card::after {
    content: "";

    position: absolute;
    inset: 0;

    background:
        linear-gradient(
            to top,
            rgba(0,0,0,.9),
            rgba(0,0,0,.1) 65%
        );
}

.category-card img {
    width: 100%;
    height: 100%;

    object-fit: cover;

    display: block;

    opacity: .78;

    transition:
        transform .7s ease,
        opacity .5s ease,
        filter .5s ease;
}

.category-card h3 {
    position: absolute;

    left: 25px;
    bottom: 22px;

    z-index: 3;

    margin: 0;

    color: #f0dfb0;

    font-size: 13px;
    font-weight: 700;

    letter-spacing: 2px;
}

.category-card:hover {
    transform: translateY(-7px);

    border-color: rgba(216,174,82,.48);

    box-shadow:
        0 20px 40px rgba(0,0,0,.5),
        0 0 22px rgba(210,169,75,.06);
}

.category-card:hover img {
    transform: scale(1.07);

    opacity: .9;

    filter: brightness(.72);
}


/* =========================
   LUXURY STRIP
   ========================= */

.home-luxury-strip {
    position: relative;

    display: flex;

    align-items: center;
    justify-content: space-between;

    gap: 40px;

    padding: 65px 7%;

    background:
        radial-gradient(
            circle at 80% 50%,
            rgba(210,170,75,.11),
            transparent 35%
        ),
        linear-gradient(
            135deg,
            #050505,
            #101010,
            #060606
        );

    border-top: 1px solid rgba(212,173,79,.16);
    border-bottom: 1px solid rgba(212,173,79,.16);
}

.home-luxury-strip::before {
    content: "";

    position: absolute;

    left: 7%;
    right: 7%;
    top: 15px;

    height: 1px;

    background:
        linear-gradient(
            90deg,
            transparent,
            rgba(213,174,82,.16),
            transparent
        );
}

.home-luxury-strip > div {
    max-width: 650px;
}

.gold-kicker {
    display: inline-block;

    margin-bottom: 10px;

    color: #cba64d;

    font-size: 10px;
    font-weight: 800;
    letter-spacing: 2.5px;
}

.home-luxury-strip h2 {
    margin: 0 0 12px;

    color: #eee8dd;

    font-family: Georgia, serif;
    font-size: 36px;
    font-weight: 400;
}

.home-luxury-strip p {
    margin: 0;

    color: #908a81;

    font-size: 13px;
    line-height: 1.7;
}


/* =========================
   FEATURED PRODUCTS
   ========================= */

.products {
    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: 22px;

    max-width: 1350px;
    margin: auto;
}

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
        0 13px 32px rgba(0,0,0,.35);

    transition:
        transform .4s ease,
        border-color .4s ease,
        box-shadow .4s ease;
}

.premium-card:hover {
    transform: translateY(-8px);

    border-color: rgba(215,174,83,.42);

    box-shadow:
        0 22px 45px rgba(0,0,0,.5),
        0 0 22px rgba(207,166,73,.05);
}


/* PRODUCT IMAGE */

.product-image-link {
    position: relative;

    display: block;

    height: 280px;

    overflow: hidden;

    background: #060606;
}

.product-image-link::after {
    content: "";

    position: absolute;
    inset: 0;

    background:
        linear-gradient(
            to top,
            rgba(0,0,0,.65),
            transparent 55%
        );

    pointer-events: none;
}

.product-image-link img {
    width: 100%;
    height: 100%;

    object-fit: cover;

    display: block;

    transition:
        transform .7s ease,
        filter .5s ease;
}

.premium-card:hover .product-image-link img {
    transform: scale(1.06);

    filter: brightness(.72);
}


/* PRODUCT INFO */

.product-info {
    padding: 21px;
}

.product-info h3 {
    margin: 0 0 9px;

    color: #eee9df;

    font-family: Georgia, serif;
    font-size: 20px;
    font-weight: 400;
}

.product-info p {
    min-height: 43px;

    margin: 0 0 17px;

    color: #8c867e;

    font-size: 11px;
    line-height: 1.65;
}

.product-bottom {
    padding-top: 15px;

    border-top: 1px solid rgba(255,255,255,.06);
}

.product-bottom strong {
    color: #d9b45b;

    font-family: Georgia, serif;
    font-size: 19px;
    font-weight: 400;
}


/* =========================
   CARD ACTIONS
   ========================= */

.card-actions {
    display: flex;

    align-items: center;

    gap: 8px;

    margin-top: 18px;
}

.card-actions form {
    margin: 0;
}

.gold-btn.mini {
    min-height: 40px;

    padding: 0 14px;

    font-size: 8px;
}

.outline-btn {
    min-height: 40px;

    padding: 0 14px;

    color: #d6b15b;

    background: rgba(0,0,0,.55);

    border: 1px solid rgba(213,174,82,.55);

    box-shadow:
        inset 0 0 0 1px rgba(255,255,255,.01),
        0 4px 14px rgba(0,0,0,.25);
}

.outline-btn:hover {
    color: #080808;

    background:
        linear-gradient(
            135deg,
            #ae7d24,
            #e5c46c,
            #b98528
        );

    border-color: #dfb75a;

    transform: translateY(-3px);

    box-shadow:
        0 8px 22px rgba(210,170,76,.2);
}

.add-cart-mini {
    min-width: 125px;
}

.outline-btn:disabled {
    color: #66615a;

    background: rgba(255,255,255,.018);

    border-color: rgba(255,255,255,.08);

    cursor: not-allowed;

    opacity: .6;

    box-shadow: none;
}

.outline-btn:disabled:hover {
    color: #66615a;

    background: rgba(255,255,255,.018);

    border-color: rgba(255,255,255,.08);

    transform: none;
}


/* =========================
   WHY US
   ========================= */

.why-us {
    position: relative;

    padding: 90px 7%;

    background:
        radial-gradient(
            circle at center,
            rgba(204,163,72,.045),
            transparent 40%
        ),
        #050505;

    border-top: 1px solid rgba(213,174,82,.1);
}

.features {
    display: grid;

    grid-template-columns:
        repeat(4, minmax(0, 1fr));

    gap: 18px;

    max-width: 1200px;

    margin: auto;
}

.feature {
    padding: 35px 22px;

    text-align: center;

    background:
        linear-gradient(
            145deg,
            rgba(255,255,255,.028),
            rgba(255,255,255,.008)
        );

    border: 1px solid rgba(205,165,76,.13);
    border-radius: 6px;

    transition:
        transform .35s ease,
        border-color .35s ease,
        background .35s ease;
}

.feature:hover {
    transform: translateY(-6px);

    border-color: rgba(215,174,83,.38);

    background:
        linear-gradient(
            145deg,
            rgba(210,170,75,.055),
            rgba(255,255,255,.008)
        );
}

.feature span {
    display: block;

    margin-bottom: 18px;

    font-size: 31px;

    filter: grayscale(.2);
}

.feature h3 {
    margin: 0 0 10px;

    color: #d9bc76;

    font-size: 11px;
    font-weight: 800;

    letter-spacing: 1.4px;
}

.feature p {
    margin: 0;

    color: #858078;

    font-size: 11px;
    line-height: 1.7;
}


/* =========================
   RESPONSIVE
   ========================= */

@media (max-width: 1100px) {

    .products {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

    .features {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }

    .categories {
        grid-template-columns:
            repeat(2, minmax(0, 1fr));
    }
}


@media (max-width: 760px) {

    .hero {
        min-height: 570px;
    }

    .hero-content {
        padding: 80px 7%;
    }

    .hero h1 {
        font-size: 58px;
    }

    .section {
        padding: 65px 6%;
    }

    .categories {
        grid-template-columns: 1fr;
    }

    .category-card {
        height: 250px;
    }

    .home-luxury-strip {
        flex-direction: column;

        align-items: flex-start;

        padding: 55px 7%;
    }

    .home-luxury-strip h2 {
        font-size: 30px;
    }

    .products {
        grid-template-columns: 1fr;
    }

    .features {
        grid-template-columns: 1fr;
    }
}


@media (max-width: 480px) {

    .hero h1 {
        font-size: 48px;
        letter-spacing: 1px;
    }

    .hero-content > p:not(.eyebrow) {
        font-size: 13px;
    }

    .section-title h2 {
        font-size: 27px;
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
     HERO
     ========================================================= -->

<section class="hero">

    <div class="hero-overlay"></div>

    <div class="hero-content">

        <p class="eyebrow">
            PREMIUM CEYLON
        </p>

        <h1>
            TEA POWDER
        </h1>

        <p>
            Experience the rich taste, natural aroma and exceptional
            quality of 100% Pure Ceylon Tea.
        </p>

        <a class="btn" href="products.php">
            SHOP NOW →
        </a>

    </div>

</section>


<!-- =========================================================
     SHOP BY CATEGORY
     ========================================================= -->

<section class="section">

    <div class="section-title">

        <h2>
            🍃 SHOP BY CATEGORY 🍃
        </h2>

        <p>
            Explore our premium tea collection
        </p>

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

        <a
            class="category-card"
            href="products.php?category=<?php echo urlencode($c[1]); ?>"
        >

            <img
                src="images/<?php echo $c[0]; ?>"
                alt="<?php echo htmlspecialchars($c[1]); ?>"
            >

            <h3>
                <?php echo htmlspecialchars($c[1]); ?>
            </h3>

        </a>

        <?php endforeach; ?>

    </div>

</section>


<!-- =========================================================
     LUXURY STRIP
     ========================================================= -->

<section class="home-luxury-strip">

    <div>

        <span class="gold-kicker">
            THE CEYLON NOIR EXPERIENCE
        </span>

        <h2>
            Find Your Signature Cup
        </h2>

        <p>
            Filter our collection by tea type, flavour and price
            to discover your next favourite.
        </p>

    </div>

    <a
        class="gold-btn"
        href="products.php"
    >
        EXPLORE ALL TEAS →
    </a>

</section>


<!-- =========================================================
     FEATURED PRODUCTS
     ========================================================= -->

<section class="section">

    <div class="section-title">

        <h2>
            🍃 FEATURED PRODUCTS 🍃
        </h2>

        <p>
            Our popular premium tea powder products
        </p>

    </div>


    <div class="products">

        <?php 

        $result = $conn->query(
            "SELECT * FROM products WHERE featured=1 ORDER BY id LIMIT 4"
        ); 

        while ($p = $result->fetch_assoc()): 

        ?>

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

            </a>


            <!-- PRODUCT INFO -->

            <div class="product-info">

                <h3>
                    <?php echo htmlspecialchars($p['name']); ?>
                </h3>

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

                    <a
                        class="gold-btn mini"
                        href="product.php?id=<?php echo $p['id']; ?>"
                    >
                        VIEW DETAILS
                    </a>


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

    </div>

</section>


<!-- =========================================================
     WHY CHOOSE US
     ========================================================= -->

<section class="why-us">

    <div class="section-title">

        <h2>
            WHY CHOOSE CEYLON TEA?
        </h2>

        <p>
            Quality and freshness in every cup
        </p>

    </div>


    <div class="features">


        <div class="feature">

            <span>🌱</span>

            <h3>
                100% PURE & NATURAL
            </h3>

            <p>
                Carefully selected quality tea leaves.
            </p>

        </div>


        <div class="feature">

            <span>🎁</span>

            <h3>
                FRESH & SAFE PACKAGING
            </h3>

            <p>
                Packed to maintain freshness and aroma.
            </p>

        </div>


        <div class="feature">

            <span>🚚</span>

            <h3>
                FAST & RELIABLE DELIVERY
            </h3>

            <p>
                Quick and safe doorstep delivery.
            </p>

        </div>


        <div class="feature">

            <span>🔒</span>

            <h3>
                SECURE SHOPPING
            </h3>

            <p>
                A simple and secure shopping experience.
            </p>

        </div>


    </div>

</section>


<?php require "footer.php"; ?>