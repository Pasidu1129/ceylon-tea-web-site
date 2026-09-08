<?php

require "config.php";

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $password = $_POST["password"] ?? "";
    $confirm = $_POST["confirm_password"] ?? "";

    if ($name === "" || $email === "" || $password === "") {

        $error = "Please fill in all fields.";

    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {

        $error = "Please enter a valid email address.";

    } elseif ($password !== $confirm) {

        $error = "Passwords do not match.";

    } elseif (strlen($password) < 8) {

        $error = "Password must be at least 8 characters.";

    } else {

        // Check whether email already exists
        $check = $conn->prepare(
            "SELECT id FROM users WHERE email = ?"
        );

        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {

            $error = "Email already exists.";

        } else {

            // Hash password
            $hash = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            $stmt = $conn->prepare(
                "INSERT INTO users (name, email, password)
                 VALUES (?, ?, ?)"
            );

            $stmt->bind_param(
                "sss",
                $name,
                $email,
                $hash
            );

            if ($stmt->execute()) {

                $success = "Registration successful. You can now login.";

            } else {

                $error = "Registration failed: " . $stmt->error;
            }

            $stmt->close();
        }

        $check->close();
    }
}

$pageTitle = "Register | Ceylon Tea";

require "header.php";
?>

<section class="form-section">

    <div class="form-card">

        <h1>Create Account</h1>

        <?php if ($error): ?>

            <div class="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>

        <?php endif; ?>


        <?php if ($success): ?>

            <div class="success">
                <?php echo htmlspecialchars($success); ?>
            </div>

        <?php endif; ?>


        <form method="post">

            <label>Full Name</label>

            <input
                type="text"
                name="name"
                required
            >


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
                minlength="8"
                required
            >


            <label>Confirm Password</label>

            <input
                type="password"
                name="confirm_password"
                minlength="8"
                required
            >


            <button
                class="btn"
                type="submit"
            >
                REGISTER
            </button>

        </form>

    </div>

</section>

<?php require "footer.php"; ?>