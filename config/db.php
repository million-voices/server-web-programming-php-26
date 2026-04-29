<?php
try {
    // Create (or open) a local SQLite database file
    $pdo = new PDO("sqlite:database.sqlite");

    // Set error mode to exceptions
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
