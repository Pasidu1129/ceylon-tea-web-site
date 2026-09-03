<?php
require "config.php";
if (isLoggedIn()) { header("Location: index.php"); exit; }

$error = "";
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    $stmt = $conn->prepare("SELECT id,name,password FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user && password_verify($password, $user["password"])) {
        $_SESSION["user_id"] = $user["id"];
        $_SESSION["user_name"] = $user["name"];
        header("Location: index.php");
        exit;
    } else {
        $error = "Invalid email or password.";
    }
}
$pageTitle = "Login | Ceylon Tea";
require "header.php";
?>
<section class="form-section">
<div class="form-card">
<h1>Login</h1>
<?php if ($error): ?><div class="alert"><?php echo htmlspecialchars($error); ?></div><?php endif; ?>
<form method="post">
<label>Email</label><input type="email" name="email" required>
<label>Password</label><input type="password" name="password" required>
<button class="btn" type="submit">LOGIN</button>
</form>
<p>Don't have an account? <a href="register.php">Create one</a></p>
</div>
</section>
<?php require "footer.php"; ?>
