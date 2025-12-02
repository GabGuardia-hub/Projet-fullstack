<?php
require('account.php');
require('env.php');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: projets.php');
    exit;
}

$projetId = isset($_POST['projet_id']) ? (int)$_POST['projet_id'] : 0;
$email    = trim($_POST['member_email'] ?? '');
$roleText = trim($_POST['member_role'] ?? '');

if ($projetId <= 0 || $email === '' || $roleText === '') {
    die('Données invalides.');
}

// Vérifier que le projet appartient bien à l'utilisateur connecté
$sql = "SELECT id FROM projets WHERE id = :id AND created_by = :user_id";
$stmt = $bdd->prepare($sql);
$stmt->execute([
    ':id'      => $projetId,
    ':user_id' => $_SESSION['id'],
]);
$projet = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$projet) {
    die('Projet introuvable ou non autorisé.');
}

// Trouver l'utilisateur par email
$sql = "SELECT id FROM users WHERE email = :email";
$stmt = $bdd->prepare($sql);
$stmt->execute([':email' => $email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
if (!$user) {
    die("Aucun utilisateur avec cet email.");
}
$userId = (int)$user['id'];

// Trouver (ou créer) le rôle
$sql = "SELECT id FROM role WHERE name = :name";
$stmt = $bdd->prepare($sql);
$stmt->execute([':name' => $roleText]);
$role = $stmt->fetch(PDO::FETCH_ASSOC);

if ($role) {
    $roleId = (int)$role['id'];
} else {
    $sql = "INSERT INTO role (name, description, perimission_id)
            VALUES (:name, '', 0)";
    $stmt = $bdd->prepare($sql);
    $stmt->execute([':name' => $roleText]);
    $roleId = (int)$bdd->lastInsertId();
}

// Insérer dans membre_projets (sans gérer les doublons avancés pour l’instant)
var_dump($projetId, $userId, $roleId);
exit;

$sql = "INSERT INTO membre_projets (projets_id, user_id, role_id, joined_at)
        VALUES (:projets_id, :user_id, :role_id, CURDATE())";
$stmt = $bdd->prepare($sql);
$stmt->execute([
    ':projets_id' => $projetId,
    ':user_id'    => $userId,
    ':role_id'    => $roleId,
]);

header('Location: ../pages/Gestion/dashboard.php?id=' . $projetId);
exit;
?>