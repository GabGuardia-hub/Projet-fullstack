<?php
require_once __DIR__ . '/account.php';
require_once __DIR__ . '/env.php';

header('Content-Type: application/json; charset=utf-8');

// 1) Vérifier l'id du projet
if (!isset($_GET['projet_id']) || !ctype_digit($_GET['projet_id'])) {
    http_response_code(400);
    echo json_encode(['error' => 'Projet invalide']);
    exit;
}
$projectId = (int)$_GET['projet_id'];

// 2) since_id optionnel
$sinceId = 0;
if (isset($_GET['since_id']) && ctype_digit($_GET['since_id'])) {
    $sinceId = (int)$_GET['since_id'];
}

// 3) Récupérer les messages du projet après since_id
$chatSql = "SELECT m.id, m.content, m.created_at,
                   u.firstName, u.lastName
            FROM messages m
            JOIN users u ON u.id = m.user_id
            WHERE m.projets_id = :projet_id
              AND m.id > :since_id
            ORDER BY m.created_at ASC";
$chatStmt = $bdd->prepare($chatSql);
$chatStmt->execute([
    ':projet_id' => $projectId,
    ':since_id'  => $sinceId
]);
$chatMessages = $chatStmt->fetchAll(PDO::FETCH_ASSOC);

// 4) Réponse JSON
echo json_encode(['messages' => $chatMessages]);
?>