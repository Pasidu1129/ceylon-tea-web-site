<?php

require "config.php";

if (isLoggedIn()) {
    header("Location: index.php");
    exit;
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($email === "" || $password === "") {

        $error = "Please enter your email and password.";

    } else {

        $stmt = $conn->prepare(
            "SELECT id, name, password
             FROM users
             WHERE email = ?
             LIMIT 1"
        );

        $stmt->bind_param("s", $email);
        $stmt->execute();

        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user["password"])) {

            session_regenerate_id(true);

            $_SESSION["user_id"] = $user["id"];
            $_SESSION["user_name"] = $user["name"];

            header("Location: index.php");
            exit;

        } else {

            $error = "Invalid email or password.";
        }

        $stmt->close();
    }
}

$pageTitle = "Login | Ceylon Tea";

require "header.php";
?>

<section class="form-section">

    <div class="form-card">

        <h1>Login</h1>


        <?php if ($error): ?>

            <div class="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>


        <form method="post">

            <label>Email</label>

            <input
                type="email"
                name="email"
                required
            >


            <label>Password</label>

            <input
                type="password"
                name="password"
                required
            >


            <button
                class="btn"
                type="submit"
            >
                LOGIN
            </button>

        </form>


        <p>
            Don't have an account?
            <a href="register.php">Create one</a>
        </p>

    </div>

</section>

<?php require "footer.php"; ?>