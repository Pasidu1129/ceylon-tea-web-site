CEYLON NOIR - WEEK 06 E-BUSINESS SYSTEMS

TECHNOLOGY
PHP, MySQL, HTML, CSS, JavaScript, XAMPP

WEEK 06 FEATURES
1. User registration with email validation and password complexity rules.
2. Passwords are hashed using bcrypt (PHP PASSWORD_BCRYPT).
3. Generic login error prevents user enumeration.
4. Secure PHP session with HttpOnly, SameSite and conditional Secure cookie settings.
5. User profile dashboard with name, phone, shipping address and billing address.
6. Shipping and billing addresses are encrypted at rest with AES-256-CBC.
7. Secure password change with current-password re-verification.
8. Protected profile and checkout routes.
9. Logout destroys the session and clears the session cookie.
10. Guest cart remains in the PHP session when a user authenticates.
11. JSON API endpoints: POST /api/register.php, POST /api/login.php, GET/POST /api/profile.php.
12. Separate Admin role with full access to dashboard, products/stock, orders and user roles.
13. Normal users have store, cart, checkout and profile access; no admin dashboard access.

ADMIN LOGIN
Email/Username: admin@ceylonnoir.lk
Password: Admin@123

IMPORTANT: Change the administrator password after first setup.

DATABASE SETUP
1. Start Apache and MySQL in XAMPP.
2. Copy Ceylon_Tea_Website into C:\xampp\htdocs\
3. Open phpMyAdmin.
4. Import database.sql. It creates the ceylon_tea database and sample products.
5. Open http://localhost/Ceylon_Tea_Website/

WEEK 06 DOCUMENTATION COVERAGE
- Registration validation and feedback
- bcrypt password hashing
- Session management and cookie safety
- Login generic errors
- Protected routes and logout
- Profile and address management
- Password change with identity re-verification
- Admin/User access separation
- API endpoints
- Cart state persistence
