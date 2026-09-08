<?php

session_start();

$host = "localhost";
$user = "root";
$pass = "";
$db   = "ceylon_tea";

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");

function isLoggedIn() {
    return isset($_SESSION["user_id"]);
}

function cartCount() {
    return isset($_SESSION["cart"]) ? array_sum($_SESSION["cart"]) : 0;
}
?>