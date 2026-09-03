<?php
require "config.php";
$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm = $_POST["confirm_password"] ?? "";

    if ($password !== $confirm) {
        $error = "Passwords do not match.";
    } elseif (strlen($password) < 8) {
        $error = "Password must be at least 8 characters.";
    } else {
        $hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users(name,email,password) VALUES(?,?,?)");
        $stmt->bind_param("sss", $name, $email, $hash);
        if ($stmt->execute()) {
            $success = "Registration successful. You can now login.";
        } else {
            $error = $conn->errno == 1062 ? "Email already exists." : "Registration failed.";
        }
    }
}
$pageTitle = "Register | Ceylon Tea";
require "header.php";
?>
<section class="form-section">
<div class="form-card">
<h1>Create Account</h1>
<?php if ($error): ?><div class="alert"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
<?php if ($success): ?><div class="success"><?php echo htmlspecialchars($success); ?></div><?php endif; ?>
<form method="post">
<label>Full Name</label><input type="text" name="name" required>
<label>Email</label><input type="email" name="email" required>
<label>Password</label><input type="password" name="password" minlength="8" required>
<label>Confirm Password</label><input type="password" name="confirm_password" minlength="8" required>
<button class="btn" type="submit">REGISTER</button>
</form>
</div>
</section>
<?php require "footer.php"; ?>
