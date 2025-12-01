<?php require('../../backend/account.php'); 
$bdd = new PDO('mysql:host='.$host.';dbname='.$db.'; charset=utf8;', $user, $pass);
$errorMsg = "";
if (isset($_POST['envoie'])) {

    if(!empty($_POST['projectName']) AND !empty($_POST['projectDescription']) AND !empty($_POST['projectStatus']) AND !empty($_POST['projectStart']) AND !empty($_POST['projectEnd'])) {
        // Ici on récupere les données de l'insciption //
        $name = htmlspecialchars($_POST['projectName']);
        $description = htmlspecialchars($_POST['projectDescription']);
        $status = htmlspecialchars($_POST['projectStatus']);
        $created_at = htmlspecialchars($_POST['projectStart']);
        $updated_at = date('Y-m-d H:i:s');
        $fin_prevue = htmlspecialchars($_POST['projectEnd']);


        $created_by = $_SESSION['id'];

        //On insere les données dans la bdd //
        $insertProject = $bdd->prepare("INSERT INTO projets (name, description, status, created_by, created_at, updated_at, fin_prevue) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $insertProject->execute(array($name, $description, $status, $created_by, $created_at, $updated_at, $fin_prevue));

        header("Location: projets.php");
    }else {
            $errorMsg = "Tous les champs doivent être complétés !";
            header("Location: creationproj.php");
        }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer ou modifier un projet • GuardiaProjets</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/projet.css">
</head>
<body>

    <?php include '../nav/nav.php'; ?>

    <main class="project-builder">
        <header class="builder-header panel">
            <div>
                <p class="eyebrow">Assistant projet</p>
                <h1 id="builderTitle">Creation Projet</h1>
                <p class="projects-subtitle">Définissez les informations clés, l'équipe, les tâches et les jalons de votre projet.</p>
            </div>
            <!-- Message d'erreur -->
        <?php if (!empty($errorMsg)): ?>
            <div class="error-message">
                <?= htmlspecialchars($errorMsg) ?>
            </div>
        <?php endif; ?>

            <div class="builder-actions">
                <a class="btn btn-light" href="projets.php">← Retour à la liste</a>
                <a class="btn btn-ghost" id="dashboardShortcut" href="dashboard.php">Voir le dashboard</a>
            </div>
        </header>

        <form class="builder-form" id="projectBuilderForm" method="POST" autocomplete="off" >
            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2>Informations générales</h2>
                        <p class="panel-subtitle">Nom, responsable, dates et statut.</p>
                    </div>
                </div>
                <div class="panel-grid general-info-grid">
                    <div class="span-4">
                        <label for="projectName">Nom du projet</label>
                        <input type="text" id="projectName" name="projectName" placeholder="Intitulé du projet" required>
                    </div>
                    <div class="span-4">
                        <label for="projectStatus">Statut</label>
                        <select id="projectStatus" name="projectStatus" required>
                            <option value="En préparation">En préparation</option>
                            <option value="En cours" selected>En cours</option>
                            <option value="Terminé">Terminé</option>
                        </select>
                    </div>
                    <div class="span-6">
                        <label for="projectStart">Début</label>
                        <input type="date" id="projectStart" name="projectStart">
                    </div>
                    <div class="span-6">
                        <label for="projectEnd">Fin prévue</label>
                        <input type="date" id="projectEnd" name="projectEnd">
                    </div>
                    <div class="span-12 full-span">
                        <label for="projectDescription">Description</label>
                        <textarea id="projectDescription" name="projectDescription" placeholder="Objectifs, périmètre et attentes."></textarea>
                    </div>
                </div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2>Équipe projet</h2>
                        <p class="panel-subtitle">Invitez les personnes clés et leurs rôles.</p>
                    </div>
                    <button type="button" class="icon-button" id="addTeamRow">+ Ajouter</button>
                </div>
                <div class="dynamic-section" id="teamRows"></div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2>Tâches</h2>
                        <p class="panel-subtitle">Listez les actions clés et leurs dates limites.</p>
                    </div>
                    <button type="button" class="icon-button" id="addTaskRow">+ Ajouter</button>
                </div>
                <div class="dynamic-section" id="taskRows"></div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2>Chronologie & jalons</h2>
                        <p class="panel-subtitle">Suivez les étapes clés du projet.</p>
                    </div>
                    <button type="button" class="icon-button" id="addTimelineRow">+ Ajouter</button>
                </div>
                <div class="dynamic-section" id="timelineRows"></div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2>Drive & ressources</h2>
                        <p class="panel-subtitle">Centralisez les documents partagés.</p>
                    </div>
                    <button type="button" class="icon-button" id="addDriveRow">+ Ajouter</button>
                </div>
                <div class="dynamic-section" id="driveRows"></div>
            </section>

            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2>Notes & chat</h2>
                        <p class="panel-subtitle">Gardez une trace des décisions importantes.</p>
                    </div>
                </div>
                <textarea id="chatNotes" placeholder="Décisions, risques, points à trancher..."></textarea>
            </section>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary" name="envoie">Enregistrer et ouvrir le dashboard</button>
                <a class="btn btn-ghost" href="projets.php">Annuler</a>
            </div>

            <div class="form-feedback" id="builderFeedback" hidden></div>
        </form>
    </main>


</body>
</html>
