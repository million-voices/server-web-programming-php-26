<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
} ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My PHP Site</title>
    <style>
        body { font-family: sans-serif; line-height: 1.6; padding: 20px; }
        nav { border-bottom: 1px solid #ccc; padding-bottom: 10px; }
    </style>
</head>
<body>
    <nav>
        <a href="/">Home</a> |
        <a href="/about">About</a> |
<?php if (!isset($_SESSION["user_id"])) {
    // User is not logged in
    echo "<a href=\"/login\">Login</a> |";
} else {
    echo "<a href=\"/logout\">Logout</a> |";
} ?>
        <a href="/weather">Weather</a> |
    </nav>
    <main>
