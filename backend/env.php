<?php
$envPath = __DIR__ . '/../.env'; // .env à la racine du projet

if (is_readable($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || $line[0] === '#') continue;

        [$name, $value] = array_map('trim', explode('=', $line, 2));
        putenv("$name=$value");
        $_ENV[$name] = $value;
    }
}

// Sécurité : valeurs par défaut si jamais manquantes
$host = $_ENV['DB_HOST'] ?? 'localhost';
$db   = $_ENV['DB_NAME'] ?? '';
$user = $_ENV['DB_USER'] ?? '';
$pass = $_ENV['DB_PASS'] ?? '';

try {
    $bdd = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
} catch (PDOException $e) {
    die('Erreur : ' . $e->getMessage());
}
?>