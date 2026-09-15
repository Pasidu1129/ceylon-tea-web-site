-- ============================================
-- CEYLON TEA DATABASE
-- FULL RESET + CREATE + INSERT
-- ============================================

-- Remove old database completely
DROP DATABASE IF EXISTS ceylon_tea;

-- Create fresh database
CREATE DATABASE ceylon_tea
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE ceylon_tea;


-- ============================================
-- USERS TABLE
-- ============================================

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('user','admin') NOT NULL DEFAULT 'user',
    phone VARCHAR(30) DEFAULT NULL,
    shipping_address TEXT DEFAULT NULL,
    billing_address TEXT DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


INSERT INTO users (name,email,password,role) VALUES ('Site Administrator','admin@ceylonnoir.lk', '$2y$12$W7Ozzrbn7kcfEg8E5VhuYOSbXgcEEuB2XAEAdm8G1SkbrQWJloBzu', 'admin');

-- ============================================
-- PRODUCTS TABLE
-- ============================================

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    category VARCHAR(80) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(150) NOT NULL,
    featured TINYINT(1) DEFAULT 0,
    stock INT NOT NULL DEFAULT 50,
    tasting_notes TEXT,
    weight VARCHAR(30) DEFAULT '250 g',
    origin VARCHAR(120) DEFAULT 'Sri Lanka — Ceylon Tea',
    brewing_guide TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;


-- ============================================
-- ORDERS TABLE
-- ============================================

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    address TEXT NOT NULL,
    phone VARCHAR(30) NOT NULL,
    status VARCHAR(30) DEFAULT 'Pending',
    payment_method VARCHAR(40) DEFAULT 'Cash on Delivery',
    payment_status VARCHAR(30) DEFAULT 'Pending',
    payment_reference VARCHAR(100) DEFAULT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_orders_user
        FOREIGN KEY (user_id)
        REFERENCES users(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE
) ENGINE=InnoDB;


-- ============================================
-- ORDER ITEMS TABLE
-- ============================================

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,

    CONSTRAINT fk_order_items_order
        FOREIGN KEY (order_id)
        REFERENCES orders(id)
        ON DELETE CASCADE
        ON UPDATE CASCADE,

    CONSTRAINT fk_order_items_product
        FOREIGN KEY (product_id)
        REFERENCES products(id)
        ON DELETE RESTRICT
        ON UPDATE CASCADE
) ENGINE=InnoDB;


-- ============================================
-- INSERT PRODUCTS
-- ============================================

INSERT INTO products
(
    name,
    category,
    description,
    price,
    image,
    featured,
    stock,
    tasting_notes,
    weight,
    origin,
    brewing_guide
)
VALUES

(
    'Royal Ceylon Black',
    'BLACK TEA',
    'A bold, full-bodied black tea powder with the classic depth of high-grown Ceylon tea.',
    890.00,
    'product-black.jpg',
    1,
    60,
    'Malty depth, warm aroma and a clean, brisk finish.',
    '250 g',
    'Nuwara Eliya, Sri Lanka',
    'Use 1–2 tsp per cup. Brew with hot water for 3–5 minutes. Add milk or enjoy black.'
),

(
    'Emerald Green Tea',
    'GREEN TEA',
    'A fresh and refined green tea with a clean character and delicate natural aroma.',
    980.00,
    'product-green.jpg',
    1,
    48,
    'Fresh grassy notes, gentle sweetness and a clean finish.',
    '200 g',
    'Kandy, Sri Lanka',
    'Use 1 tsp per cup. Brew with hot water for 2–3 minutes; avoid boiling water for a softer cup.'
),

(
    'Golden Ginger Infusion',
    'GINGER TEA',
    'A warming tea blend with a bright ginger aroma, created for comforting everyday moments.',
    920.00,
    'product-ginger.jpg',
    1,
    45,
    'Warm ginger spice, citrus-like brightness and a smooth finish.',
    '250 g',
    'Sri Lanka',
    'Use 1–2 tsp per cup and steep 4–5 minutes. Enjoy plain or with a little honey.'
),

(
    'Ceylon Cinnamon Reserve',
    'CINNAMON TEA',
    'A fragrant cinnamon-forward blend balancing natural spice with smooth Ceylon tea.',
    960.00,
    'product-cinnamon.jpg',
    1,
    42,
    'Sweet cinnamon spice, soft tea depth and a lingering aromatic finish.',
    '250 g',
    'Central Highlands, Sri Lanka',
    'Use 1–2 tsp per cup. Steep 3–5 minutes and serve warm.'
),

(
    'Serene Herbal Blend',
    'HERBAL TEA',
    'A caffeine-free inspired herbal blend with a light, refreshing character.',
    880.00,
    'herbal-tea.jpg',
    0,
    35,
    'Soft herbal aroma, mellow body and refreshing finish.',
    '200 g',
    'Sri Lanka',
    'Use 1–2 tsp per cup. Steep 5 minutes and adjust strength to taste.'
),

(
    'Noir Signature Ceylon',
    'PREMIUM TEA',
    'Our signature premium Ceylon tea powder selected for aroma, balance and an elegant cup.',
    1290.00,
    'premium-tea.jpg',
    1,
    28,
    'Layered aroma, balanced richness and a refined Ceylon finish.',
    '250 g',
    'Nuwara Eliya, Sri Lanka',
    'Use 1 tsp per cup. Brew 3–4 minutes for a balanced premium cup.'
),

(
    'Highland Breakfast Tea',
    'BLACK TEA',
    'A dependable breakfast blend with rich colour and a lively finish.',
    940.00,
    'black-tea.jpg',
    0,
    55,
    'Bright briskness, rich body and a classic breakfast character.',
    '500 g',
    'Dimbula, Sri Lanka',
    'Use 2 tsp for a strong pot. Brew 4 minutes and serve with or without milk.'
),

(
    'Jasmine Green Reserve',
    'GREEN TEA',
    'A delicate green tea profile paired with a floral-inspired jasmine aroma.',
    1090.00,
    'green-tea.jpg',
    0,
    32,
    'Floral aroma, fresh green character and a delicate finish.',
    '200 g',
    'Central Sri Lanka',
    'Use 1 tsp per cup. Brew 2–3 minutes with hot, not boiling, water.'
),

(
    'Spiced Ginger Gold',
    'GINGER TEA',
    'A richer ginger tea profile for customers who enjoy a stronger warming spice note.',
    990.00,
    'ginger-tea.jpg',
    0,
    38,
    'Pronounced ginger warmth, rounded sweetness and a long finish.',
    '250 g',
    'Sri Lanka',
    'Use 1–2 tsp per cup. Steep 4–5 minutes.'
),

(
    'Cinnamon Noir Blend',
    'CINNAMON TEA',
    'A premium dark tea and cinnamon combination with an elegant aromatic profile.',
    1040.00,
    'cinnamon-tea.jpg',
    0,
    30,
    'Deep tea body, sweet spice and a smooth lingering aroma.',
    '250 g',
    'Uva, Sri Lanka',
    'Use 1–2 tsp per cup. Brew 3–5 minutes and serve hot.'
);


-- ============================================
-- CHECK DATA
-- ============================================

SELECT * FROM users;

SELECT * FROM products;

SELECT * FROM orders;

SELECT * FROM order_items;