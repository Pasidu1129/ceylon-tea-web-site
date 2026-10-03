CEYLON NOIR - WEEK 07 PAYHERE SANDBOX VERSION
================================================

This version includes Week 07 Payment Gateway Integration requirements:
- Customer name, email, phone and city
- Shipping and billing checkout form
- Order item summary and LKR total
- PayHere Sandbox form POST
- Mandatory server-side MD5 hash
- Pay Now button
- Return and cancel pages
- PayHere notification endpoint with md5sig verification
- Payment/order status storage
- Cash on Delivery remains available
- Existing Week 06 authentication, profile, admin and cart features retained

IMPORTANT PAYHERE SETUP
-----------------------
1. Open your PayHere Sandbox account.
2. Go to Integrations.
3. Add localhost as the Domain for the local lab.
4. Copy your Sandbox Merchant ID and Merchant Secret.
5. Open config.php and replace:
   YOUR_SANDBOX_MERCHANT_ID
   YOUR_SANDBOX_MERCHANT_SECRET
6. Set PAYHERE_BASE_URL to the exact XAMPP URL used for the project.
7. Set PAYHERE_NOTIFY_URL to a publicly reachable HTTPS URL for payhere_notify.php.

Example local URL:
http://localhost/Ceylon_Tea_Website/

PAYHERE HASH
------------
The project generates the mandatory hash on the PHP server:
UPPERCASE(MD5(merchant_id + order_id + amount + currency + UPPERCASE(MD5(merchant_secret))))
The amount is formatted to exactly two decimals and currency is LKR.

NOTIFICATION LIMITATION ON LOCALHOST
------------------------------------
PayHere documentation states that notify_url must be publicly accessible and payment notifications cannot be tested directly on localhost. Therefore:
- the checkout/redirect/hash flow can be demonstrated locally through the Sandbox;
- final server-to-server payment status updates require a public URL for payhere_notify.php.
Do not mark a payment as paid based only on the browser return page.

WEEK 07 TEST FLOW
-----------------
1. Start Apache and MySQL in XAMPP.
2. Import database.sql into phpMyAdmin.
3. Register/login to the website.
4. Add tea products to the cart.
5. Open Checkout.
6. Enter phone, shipping address, city and billing address.
7. Select PayHere Sandbox - Online Payment.
8. Click Pay Now.
9. Confirm that the browser is sent to sandbox.payhere.lk/pay/checkout.
10. Use the test credentials supplied in the Week 07 lecture note.
11. Verify the return page and, when a public notify endpoint is available, verify that the database payment_status is updated from the verified callback.

SECURITY
--------
- Card numbers/CVV are not collected or stored by this website.
- Merchant Secret is kept in PHP server-side config and is never sent as a form field.
- The checkout hash is generated server-side.
- notify_url verifies PayHere's md5sig before updating an order.
- The order amount is checked against the stored order total before status update.
- User ID is validated before inserting an order to avoid the previous foreign-key session error.

ADMIN LOGIN
-----------
Email: admin@ceylonnoir.lk
Password: Admin@123

This is a university sandbox project. Use PayHere Sandbox only for testing.
