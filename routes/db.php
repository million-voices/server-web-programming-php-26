<?php
// Use __DIR__ to go up one level and into templates
require_once APP_ROOT . "/templates/header.php";
require_once APP_ROOT . "/config/db.php";
?>

<h1>Creating a Database</h1>

<?php
// Create a table
$pdo->exec("CREATE TABLE IF NOT EXISTS users (
    id INTEGER PRIMARY KEY,
    username TEXT UNIQUE NOT NULL,
    password TEXT NOT NULL
)");

// Insert using a prepared statement
$username = "admin";
$password = password_hash("123456", PASSWORD_DEFAULT);
$stmt = $pdo->prepare("INSERT OR IGNORE INTO users (username, password) VALUES (:user, :pass)");
$stmt->execute([
    "user" => $username,
    "pass" => $password,
]);
?>

<h2>Existing users</h2>
<?php
// Read records from the table
$stmt = $pdo->query("SELECT id, username FROM users");
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

foreach ($results as $row) {
    echo "<p>" . $row["id"] . ":" . $row["username"] . "</p>";
}
?>

<?php require_once APP_ROOT . "/templates/footer.php";
?>
