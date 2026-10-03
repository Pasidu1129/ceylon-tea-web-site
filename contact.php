<?php
$pageTitle = "Contact Us | Ceylon Tea";
require "header.php";
?>
<section class="page-banner"><h1>Contact Us</h1><p>We would love to hear from you.</p></section>
<section class="section contact-grid">
<div><h2>Get in Touch</h2><p>✉ info@ceylontea.com</p><p>☎ +94 77 123 4567</p><p>📍 Matara, Sri Lanka</p></div>
<div class="form-card">
<form method="post" action="#">
<label>Name</label><input type="text" required>
<label>Email</label><input type="email" required>
<label>Message</label><textarea rows="5" required></textarea>
<button class="btn" type="submit">SEND MESSAGE</button>
</form>
</div>
</section>
<?php require "footer.php"; ?>
