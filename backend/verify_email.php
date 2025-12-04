<?php
require 'env.php'; 

$token = $_GET['token'] ?? '';

if ($token === '') {
    die('Token manquant.');
}

$stmt = $pdo->prepare("SELECT id, is_verified FROM users WHERE token = :token LIMIT 1");
$stmt->execute([':token' => $token]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die('Lien invalide ou expiré.');
}

if ((int)$user['is_verified'] === 1) {
    die('Email déjà vérifié.');
}
$update = $pdo->prepare("UPDATE users SET is_verified = 1, token = NULL WHERE id = :id");
$update->execute([':id' => $user['id']]);

echo "Email vérifié, vous pouvez maintenant vous connecter.";
?>