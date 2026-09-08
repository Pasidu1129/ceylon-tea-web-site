CREATE DATABASE IF NOT EXISTS ceylon_tea
CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

USE ceylon_tea;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    category VARCHAR(80) NOT NULL,
    description TEXT,
    price DECIMAL(10,2) NOT NULL,
    image VARCHAR(150) NOT NULL,
    featured TINYINT(1) DEFAULT 0,
    stock INT NOT NULL DEFAULT 50,
    tasting_notes TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    address TEXT NOT NULL,
    phone VARCHAR(30) NOT NULL,
    status VARCHAR(30) DEFAULT 'Pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO products (name, category, description, price, image, featured, stock, tasting_notes) VALUES
('Premium Black Tea','BLACK TEA','Strong flavour and rich aroma for a perfect tea experience.',850.00,'product-black.jpg',1,50,'Bold aroma with a rich, smooth character and classic Ceylon finish.'),
('Green Tea Powder','GREEN TEA','Refreshing green tea made from natural tea leaves.',950.00,'product-green.jpg',1,45,'Fresh, light and naturally refreshing with a clean finish.'),
('Ginger Tea Powder','GINGER TEA','Aromatic tea with natural ginger flavour.',900.00,'product-ginger.jpg',1,40,'Warm ginger aroma with a bright and comforting finish.'),
('Cinnamon Tea Powder','CINNAMON TEA','Smooth and tasty cinnamon tea with a delightful flavour.',920.00,'product-cinnamon.jpg',1,35,'Sweet spice notes with a warm cinnamon aroma.'),
('Herbal Tea','HERBAL TEA','A refreshing herbal tea blend.',880.00,'herbal-tea.jpg',0,30,'Gentle herbal aroma with a clean, refreshing character.'),
('Premium Ceylon Tea','PREMIUM TEA','Selected premium Ceylon tea powder.',1200.00,'premium-tea.jpg',0,25,'Elegant aroma and balanced depth from selected Ceylon tea leaves.');
