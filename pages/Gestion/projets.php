<?php
require_once('../../backend/account.php');
require_once'../../backend/env.php';
// Récupérer tous les projets où l'utilisateur connecté est membre
$sql = "
    SELECT p.*
    FROM projets p
    JOIN membre_projets mp ON mp.projets_id = p.id
    WHERE mp.user_id = :user_id
    ORDER BY p.created_at DESC
";
$resultat = $bdd->prepare($sql);
$resultat->execute([':user_id' => $_SESSION['id']]);

if (!$resultat) {
    die("Erreur lors de la récupération des projets : " . $bdd->errorInfo()[2]);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes projets • GuardiaProjets</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/projet.css">
</head>
<body>

<?php include '../nav/nav.php'; ?>

<main class="projects-page">
    <section class="projects-header">
        <div>
            <p class="eyebrow">Planification</p>
            <h1>Centralisez tous vos projets.</h1>
            <p class="projects-subtitle">
                Retrouvez ici tous les projets auxquels vous appartenez (créés par vous ou non).
            </p>
        </div>
        <a class="btn btn-primary" href="creationproj.php">Nouveau projet</a>
    </section>

    <section class="projects-grid-section">
        <div class="section-heading">
            <div>
                <p class="eyebrow">Vue d'ensemble</p>
                <h2>Vos tableaux</h2>
            </div>
        </div>

        <section class="grid-projets">
            <?php
            $hasRows = false;
            while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
                $hasRows = true;
                echo '
                <a href="dashboard.php?id=' . (int)$row['id'] . '" class="card-projet">
                    <div class="card-projet-gradient"></div>
                    <div class="card-projet-content">
                        <h3 class="card-projet-titre">' . htmlspecialchars($row['name']) . '</h3>
                        <span class="card-projet-status card-projet-status--en-cours">'
                            . htmlspecialchars($row['status']) .
                        '</span>
                        <p class="card-projet-desc">' . htmlspecialchars($row['description']) . '</p>
                    </div>
                    <div class="card-projet-meta">
                        <span>Début : ' . htmlspecialchars($row['created_at']) . '</span>
                        <span>Dernière update : ' . htmlspecialchars($row['updated_at']) . '</span>
                        <span>Fin prévue : ' . htmlspecialchars($row['fin_prevue']) . '</span>
                    </div>
                </a>';
            }

            if (!$hasRows) {
                echo '<p class="muted">Vous n’êtes membre d’aucun projet pour le moment.</p>';
            }
            ?>
        </section>
    </section>
</main>

</body>
</html>
