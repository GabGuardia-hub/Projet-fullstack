<?php require('../../backend/account.php'); 
$bdd = new PDO('mysql:host=localhost;dbname=Projets_full_stack;charset=utf8;', 'root', 'root');
// Ici, on a créer les fonctions pour afficher les projets de l'utilisateur connecté //
$sql = "SELECT * FROM projets WHERE created_by = " . $_SESSION['id'];
$nom = "SELECT lastName, firstName FROM users WHERE id = " . $_SESSION['id'];
$resultat = $bdd->query($sql);
$nom_resultat = $bdd->query($nom);

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
                <p class="projects-subtitle">Créez un projet, affectez un responsable et accédez à son tableau en un clic.</p>
            </div>
            <a class="btn btn-primary" href="creationproj.php">Nouveau projet</a>
        </section>

        <section class="projects-grid-section">
            <div class="section-heading">
                <div>
                    <p class="eyebrow">Vue d'ensemble</p>
                    <h2>Vos tableaux</h2>

                    <!-- Ici pour afficher tous les projets du mecse -->

                    


                </div>
            </div>

            <?php 
            while ($row = $resultat->fetch(PDO::FETCH_ASSOC)) {
                echo '<a href="/Projets-full-stack/pages/Gestion/dashboard.php?id='.$row['id'].'" class="card-projet">
                    <div class="card-projet-gradient"></div>
                    <div class="card-projet-content">
                        <h3 class="card-projet-titre">'.htmlspecialchars($row['name']).'</h3>
                        <p class="card-projet-desc">'.htmlspecialchars($row['description']).'</p>
                    </div>

                    <div class="card-projet-meta">
                        <span>Début : '.htmlspecialchars($row['created_at']).'</span>
                        <span>Dernière update : '.htmlspecialchars($row['updated_at']).'</span>
                        <span>Fin prévue : '.htmlspecialchars($row['fin_prevue']).'</span>
                    </div>
                </a>';
                
            }
            
            
            
            ?>
        </section>
    </main>

    
</body>
</html>