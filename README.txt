CEYLON TEA E-COMMERCE WEBSITE
============================

Technology:
- PHP
- MySQL
- HTML/CSS
- XAMPP

FEATURES
--------
1. Home page
2. Product listing and category filtering
3. Product images
4. Session-based shopping cart
5. User registration and login
6. Checkout and order creation
7. MySQL database
8. About Us and Contact Us pages
9. Responsive design

HOW TO RUN WITH XAMPP
---------------------
1. Install/start XAMPP.
2. Start Apache and MySQL.
3. Copy the whole "Ceylon_Tea_Website" folder into:
   C:\xampp\htdocs\

4. Open phpMyAdmin:
   http://localhost/phpmyadmin

5. Import "database.sql".
   The SQL creates the "ceylon_tea" database and tables and inserts sample products.

6. Make sure config.php contains:
   host = localhost
   user = root
   password = (empty by default)
   database = ceylon_tea

7. Open:
   http://localhost/Ceylon_Tea_Website/

IMPORTANT
---------
- The project is configured for the normal XAMPP MySQL root account with an empty password.
- If your MySQL root account has a password, change $pass in config.php.
- This is a student/project-ready local setup. For real public deployment, use HTTPS,
  environment variables/secrets, stronger validation, CSRF protection, secure cookies,
  and a production database account.

PROJECT PAGES
-------------
index.php       Home
products.php    Products
cart.php        Shopping cart
login.php       Login
register.php    Registration
checkout.php    Checkout
about.php       About Us
contact.php     Contact Us
logout.php      Logout
database.sql    MySQL database


PUBLIC DEPLOYMENT (WHEN YOU ARE READY)
---------------------------------------
For a PHP + MySQL website, use a hosting provider that supports PHP and MySQL. Upload the project files, create a MySQL database, import database.sql, and update config.php with the hosting database credentials. Then open the domain assigned by your host.

The current project uses localhost/root/empty-password settings for XAMPP, so do not upload those credentials unchanged to public hosting.

ADVANCED PRODUCT DETAILS
- Product cards now open product.php?id=PRODUCT_ID.
- Product pages show image, price, stock, origin, weight, tea type, tasting notes and brewing guide.
- database.sql includes stock and tasting_notes fields.
- If you already imported an older database, run:
  ALTER TABLE products ADD stock INT NOT NULL DEFAULT 50;
  ALTER TABLE products ADD tasting_notes TEXT;
