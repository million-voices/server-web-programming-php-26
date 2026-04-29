<?php
session_start();
require_once APP_ROOT . "/config/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"] ?? "";
    $password = $_POST["password"] ?? "";

    $stmt = $pdo->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user["password"])) {
        // Regenerate session ID for security (prevents session fixation)
        session_regenerate_id();

        $_SESSION["user_id"] = $user["id"];
        $_SESSION["username"] = $username;

        header("Location: /");
        exit();
    } else {
        echo "<p style='color:red'>Invalid username or password.</p>";
    }
}

require_once APP_ROOT . "/templates/header.php";
?>

<form method="POST">
    <input type="text" name="username" placeholder="Username" required>
    <input type="password" name="password" placeholder="Password" required>
    <button type="submit">Login</button>
</form>

<h1>Login</h1>

<?php require_once APP_ROOT . "/templates/footer.php";
?>
