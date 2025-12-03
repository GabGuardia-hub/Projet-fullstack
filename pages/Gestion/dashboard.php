<?php require_once'../../backend/account.php'; 
require_once'../../backend/env.php';
// Vérifier que l'id est présent et numérique
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) {
    die('Projet invalide.');
}
$projectId = (int)$_GET['id'];

$sprojetsql = "
    SELECT p.*
    FROM projets p
    JOIN membre_projets mp ON mp.projets_id = p.id
    WHERE p.id = :projet_id
      AND mp.user_id = :user_id
";
$projets = $bdd->prepare($sprojetsql);
$projets->execute([
    ':projet_id' => $projectId,
    ':user_id'   => $_SESSION['id']
]);
$projet = $projets->fetch(PDO::FETCH_ASSOC);

// Construire les événements de la chronologie (début + fin pour l'instant)
$events = [];

// Début du projet
if (!empty($projet['created_at'])) {
    $events[] = [
        'label'      => 'Début du projet',
        'event_date' => $projet['created_at'],
    ];
}

// Fin prévue
if (!empty($projet['fin_prevue'])) {
    $events[] = [
        'label'      => 'Fin prévue',
        'event_date' => $projet['fin_prevue'],
    ];
}

// Trier chronologiquement
usort($events, function ($a, $b) {
    return strcmp($a['event_date'], $b['event_date']);
});


$taskSql = "SELECT 
              t.id,
              t.title,
              t.description,
              t.status,
              t.date_limite,
              u.id   AS assignee_id,
              u.firstName,
              u.lastName
            FROM task t
            LEFT JOIN assign_to a ON a.id_task = t.id
            LEFT JOIN users u      ON u.id = a.id_member
            WHERE t.projets_id = :projet_id
            ORDER BY t.date_limite ASC, t.id DESC";
$taskStmt = $bdd->prepare($taskSql);
$taskStmt->execute([':projet_id' => $projectId]);
$tasks = $taskStmt->fetchAll(PDO::FETCH_ASSOC);



if (!$projet) {
    die('Projet introuvable ou non autorisé.');
}

/////////////////////////////////////////////////////////////////////////////////////////////

$userSql = "SELECT lastName, firstName FROM users WHERE id = :user_id";
$users = $bdd->prepare($userSql);
$users->execute([':user_id' => $projet['created_by']]);
$owner = $users->fetch(PDO::FETCH_ASSOC);

/////////////////////////////////////////////////////////////////////////////////////////////

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_member'])) {

    $email        = trim($_POST['member_email'] ?? '');
    $roleName     = trim($_POST['role_name'] ?? '');
    $permissionId = (int)($_POST['permission_id'] ?? 0);

    if ($email !== '' && $roleName !== '' && $permissionId > 0) {

        // 1) Trouver l'utilisateur par email
        $sql = "SELECT id FROM users WHERE email = :email";
        $stmt = $bdd->prepare($sql);
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $userId = (int)$user['id'];

            // On créer (ou récupère) le rôle avec la permission donnée
            $Rolesql = "SELECT id FROM role WHERE name = :name AND perimission_id = :perm_id";
            $Rolestmt = $bdd->prepare($Rolesql);
            $Rolestmt->execute([
                ':name'    => $roleName,
                ':perm_id' => $permissionId
            ]);
            $role = $Rolestmt->fetch(PDO::FETCH_ASSOC);

            if ($role) {
                $roleId = (int)$role['id'];
            } else {
                $RoleAddsql = "INSERT INTO role (name, description, perimission_id)
                        VALUES (:name, '', :perm_id)";
                $RoleAddstmt = $bdd->prepare($RoleAddsql);
                $RoleAddstmt->execute([
                    ':name'    => $roleName,
                    ':perm_id' => $permissionId
                ]);
                $roleId = (int)$bdd->lastInsertId();
            }

            // 3) Insérer dans membre_projets
            $membreProjetsql = "INSERT INTO membre_projets (projets_id, user_id, role_id, joined_at)
                    VALUES (:projets_id, :user_id, :role_id, CURDATE())";
            $MembreProjetsstmt = $bdd->prepare($membreProjetsql);
            $MembreProjetsstmt->execute([
                ':projets_id' => $projectId,
                ':user_id'    => $userId,
                ':role_id'    => $roleId
            ]);
        }
    }

    ///////////////////////////////////////////////////////////////////////////

    // On redirige pour éviter le repost du formulaire
    header('Location: dashboard.php?id=' . $projectId);
    exit;
}

// === CHARGER LES MEMBRES EXISTANTS ===
$Equipesql = "SELECT u.id, u.firstName, u.lastName, u.email,
                     r.name AS role_name, p.name AS perm_name
        FROM membre_projets mp
        JOIN users u      ON u.id = mp.user_id
        JOIN role r       ON r.id = mp.role_id
        JOIN permissions p ON p.id = r.perimission_id
        WHERE mp.projets_id = :projet_id
        ORDER BY r.name, u.lastName";
$equipe = $bdd->prepare($Equipesql);
$equipe->execute([':projet_id' => $projectId]);
$membres = $equipe->fetchAll(PDO::FETCH_ASSOC);

// === CHARGER LES PERMISSIONS POUR LE SELECT ===
$Permissionsql = "SELECT id, name, description FROM permissions ORDER BY id";
$permStmt = $bdd->query($Permissionsql);
$permissions = $permStmt->fetchAll(PDO::FETCH_ASSOC);


if (!$projet) {
    die('Projet introuvable ou non autorisé.');
}

// Récupérer la permission de l'utilisateur sur ce projet
$permSql = "SELECT p.id AS perm_id, p.name AS perm_name
            FROM membre_projets mp
            JOIN role r        ON r.id = mp.role_id
            JOIN permissions p ON p.id = r.perimission_id
            WHERE mp.projets_id = :projet_id
              AND mp.user_id   = :user_id
            LIMIT 1";
$permStmt = $bdd->prepare($permSql);
$permStmt->execute([
    ':projet_id' => $projectId,
    ':user_id'   => $_SESSION['id']
]);
$currentPerm = $permStmt->fetch(PDO::FETCH_ASSOC);

// Seuls les users avec permission id 1 ou 2 peuvent gérer les tâches
$canManageTasks = $currentPerm && in_array((int)$currentPerm['perm_id'], [3, 2], true);


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_task'])) {

    if (!$canManageTasks) {
        die('Vous n’êtes pas autorisé à créer des tâches sur ce projet.');
    }

    $title       = trim($_POST['task_title'] ?? '');
    $description = trim($_POST['task_description'] ?? '');
    $deadline    = trim($_POST['task_deadline'] ?? '');
    $assigneeId  = (int)($_POST['task_assignee'] ?? 0);

    if ($title === '' || $description === '' || $deadline === '' || $assigneeId <= 0) {
        die('Tous les champs de la tâche doivent être remplis.');
    }

    // 1) Créer la tâche
    $sql = "INSERT INTO task (projets_id, title, description, status, created_by, date_limite)
            VALUES (:projets_id, :title, :description, :status, :created_by, :date_limite)";
    $stmt = $bdd->prepare($sql);
    $ok = $stmt->execute([
        ':projets_id'  => $projectId,
        ':title'       => $title,
        ':description' => $description,
        ':status'      => 'En cours',
        ':created_by'  => $_SESSION['id'],
        ':date_limite' => $deadline
    ]);

    if (!$ok) {
        var_dump($stmt->errorInfo());
        exit;
    }

    $taskId = (int)$bdd->lastInsertId();

    // 2) Assigner la tâche dans assign_to
    $assignSql = "INSERT INTO assign_to (id_task, id_member)
                  VALUES (:task_id, :member_id)";
    $assignStmt = $bdd->prepare($assignSql);
    $ok2 = $assignStmt->execute([
        ':task_id'   => $taskId,
        ':member_id' => $assigneeId
    ]);

    if (!$ok2) {
        var_dump($assignStmt->errorInfo());
        exit;
    }

    header('Location: dashboard.php?id=' . $projectId . '#tasks');
    exit;
}

// Mise à jour du statut d'une tâche
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_task_status'])) {

    $taskId   = (int)($_POST['task_id'] ?? 0);
    $newStatus = trim($_POST['task_status'] ?? '');

    $allowed = ['En cours', 'Terminé', 'En retard'];
    if ($taskId <= 0 || !in_array($newStatus, $allowed, true)) {
        die('Données de statut invalides.');
    }

    // Sécurité : ne permettre la modif que si l'utilisateur est assigné à la tâche
    $checkSql = "SELECT a.id_member
                 FROM task t
                 JOIN assign_to a ON a.id_task = t.id
                 WHERE t.id = :task_id AND t.projets_id = :projet_id";
    $checkStmt = $bdd->prepare($checkSql);
    $checkStmt->execute([
        ':task_id'    => $taskId,
        ':projet_id'  => $projectId
    ]);
    $assign = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if (!$assign || (int)$assign['id_member'] !== (int)$_SESSION['id']) {
        die('Vous ne pouvez pas modifier cette tâche.');
    }

    $Timelinesql = "UPDATE task SET status = :status WHERE id = :id";
    $Timelinestmt = $bdd->prepare($Timelinesql);
    $Timelinestmt->execute([
        ':status' => $newStatus,
        ':id'     => $taskId
    ]);

    header('Location: dashboard.php?id=' . $projectId . '#tasks');
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard projet • GuardiaProjets</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/projet-dashboard.css">
    
</head>
<body class="promanage-body">

<?php include '../nav/nav.php'; ?>

<div class="promanage-dashboard">
    <aside class="dashboard-sidebar">
        <div class="sidebar-header">
            <div class="logo">
                <span class="logo-icon">GP</span>
                <div>
                    <span>GuardiaProjets</span>
                    <small>Dashboard</small>
                </div>
            </div>
        </div>
        <nav class="sidebar-nav">
            <div>
                <p class="nav-section-title">Navigation</p>
                <button class="nav-item active" type="button" data-panel-target="overview">
                    <span class="nav-icon">🏠</span>
                    <div>
                        <strong>Vue d'ensemble</strong>
                        <small>Résumé du projet</small>
                    </div>
                </button>
                <button class="nav-item" type="button" data-panel-target="team">
                    <span class="nav-icon">👥</span>
                    <div>
                        <strong>Équipe</strong>
                        <small>Rôles & contacts</small>
                    </div>
                </button>
                <button class="nav-item" type="button" data-panel-target="tasks">
                    <span class="nav-icon">✅</span>
                    <div>
                        <strong>Tâches</strong>
                        <small>Suivi opérationnel</small>
                    </div>
                </button>
                <button class="nav-item" type="button" data-panel-target="timeline">
                    <span class="nav-icon">🗓️</span>
                    <div>
                        <strong>Chronologie</strong>
                        <small>Jalons clés</small>
                    </div>
                </button>
                <button class="nav-item" type="button" data-panel-target="drive">
                    <span class="nav-icon">📁</span>
                    <div>
                        <strong>Drive</strong>
                        <small>Documents partagés</small>
                    </div>
                </button>
                <button class="nav-item" type="button" data-panel-target="notes">
                    <span class="nav-icon">💬</span>
                    <div>
                        <strong>Notes & chat</strong>
                        <small>Historique rapide</small>
                    </div>
                </button>
            </div>
        </nav>
        <div class="sidebar-footer">
            <a class="sidebar-btn primary" href="creationproj.php">+ Nouveau projet</a>
            <a class="sidebar-btn ghost" href="projets.php">← Mes projets</a>
        </div>
    </aside>



    <!-- Lukas modifie ici -->

    <main class="dashboard-main">

        <section class="main-header card" id="dashboardContent">
            <div>
                <p class="eyebrow">Dashboard du projet : <?php echo htmlspecialchars($projet['name']); ?></p>
                <h1 id="projectTitle"></h1>
                <p class="projects-subtitle" id="projectDescription"></p>
            </div>
            <span class="status-pill" id="projectStatusPill" data-status="<?php echo $projet['status']; ?>">
                <?php echo htmlspecialchars($projet['status']); ?>
            </span>
            <div class="header-meta">
                <div>
                    <strong>Responsable</strong>
                    <p id="projectOwner">
                        <?php echo htmlspecialchars($owner['lastName'].' '.$owner['firstName']); ?>
                    </p>
                </div>
                <div>
                    <strong>Début</strong>
                    <p id="projectStart">
                        <?php echo htmlspecialchars($projet['created_at']); ?>
                    </p>
                </div>
                <div>
                    <strong>Fin prévue</strong>
                    <p id="projectEnd">
                        <?php echo htmlspecialchars($projet['fin_prevue']); ?>
                    </p>
                </div>
            </div>
            <div class="header-actions">
                <a class="btn btn-primary" id="editProjectLink" href="creationproj.php">Modifier ce projet</a>
                <a class="btn btn-ghost" href="projets.php">← Retour aux projets</a>
            </div>
        </section>
            <!-- OVERVIEW -->
            <article class="panel" data-panel="overview" >
                <div class="panel-header">
                    <h2>Description du projet</h2>
                    <p class="panel-subtitle">Résumé du projet</p>
                </div>
                <div class="overview-grid" id="overviewStats"></div>
                <div class="notes-box" id="overviewNotes">
                    <?php echo htmlspecialchars($projet['description']); ?>
                </div>
            </article>

            <!-- TEAM -->
            <article class="panel" data-panel="team" hidden>
                <div class="panel-header">
                    <h2>Équipe projet</h2>
                    <p class="panel-subtitle">Liste des membres et rôles</p>
                </div>

                <ul class="data-list">
                    <?php if (!$membres): ?>
                        <li class="data-item--empty">
                            Aucun membre pour ce projet pour l’instant.
                        </li>
                    <?php else: ?>
                        <?php foreach ($membres as $membre): ?>
                            <li class="data-item">
                                <div>
                                    <strong>
                                        <?= htmlspecialchars($membre['firstName'].' '.$membre['lastName']) ?>
                                    </strong>
                                    <div class="muted">
                                        <?= htmlspecialchars($membre['email']) ?>
                                    </div>
                                </div>
                                <span class="status-badge">
                                    <?= htmlspecialchars($membre['role_name']) ?>
                                    (<?= htmlspecialchars($membre['perm_name']) ?>)
                                </span>
                            </li>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </ul>

                <form class="inline-form" method="POST" action="" style="margin-top: 20px;">
                    <input type="hidden" name="add_member" value="1">
                    <input type="hidden" name="projet_id" value="<?= (int)$projectId ?>">

                    <input type="email" name="member_email" placeholder="Email du membre" required>
                    <input type="text" name="role_name" placeholder="Nom du rôle (ex: Responsable)" required>

                    <select name="permission_id" required>
                        <option value="" disabled selected>Permission…</option>
                        <?php foreach ($permissions as $perm): ?>
                            <option value="<?= (int)$perm['id'] ?>">
                                <?= htmlspecialchars($perm['name']) ?> (<?= htmlspecialchars($perm['description']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>

                    <button type="submit">Ajouter un membre</button>
                </form>
            </article>

            <!-- TASKS -->
            <article class="panel" data-panel="tasks" hidden>
                <div class="panel-header">
                    <h2>Tâches</h2>
                    <p class="panel-subtitle">Avancement opérationnel</p>
                </div>

                <ul class="data-list" id="taskList">
                    <?php
                    $userId = (int)$_SESSION['id'];
                    $hasTasksForUser = false;

                    foreach ($tasks as $task) {
                        if ((int)$task['assignee_id'] !== $userId) {
                            continue;
                        }
                        $hasTasksForUser = true;
                        ?>
                        <li class="data-item">
                            <div>
                                <strong><?= htmlspecialchars($task['title']) ?></strong>
                                <p class="muted">
                                    <?= htmlspecialchars($task['description']) ?>
                                </p>
                            </div>

                            <div class="task-meta">
                                <span>Échéance : <?= htmlspecialchars($task['date_limite']) ?></span>

                                <form method="POST" style="margin:0;">
                                    <input type="hidden" name="update_task_status" value="1">
                                    <input type="hidden" name="task_id" value="<?= (int)$task['id'] ?>">

                                    <select name="task_status" onchange="this.form.submit()">
                                        <option value="En cours"   <?= $task['status']==='En cours'   ? 'selected' : '' ?>>En cours</option>
                                        <option value="Terminé"    <?= $task['status']==='Terminé'    ? 'selected' : '' ?>>Fini</option>
                                        <option value="En retard"  <?= $task['status']==='En retard'  ? 'selected' : '' ?>>En retard</option>
                                    </select>
                                </form>
                            </div>
                        </li>
                        <?php
                    }

                    if (!$hasTasksForUser): ?>
                        <li class="data-item--empty">
                            Vous n’avez aucune tâche attribuée pour ce projet.
                        </li>
                    <?php endif; ?>
                </ul>



                <?php if ($canManageTasks): ?>
                    <form class="inline-form" method="POST" style="margin-top: 18px;">
                        <input type="hidden" name="add_task" value="1">

                        <input type="text" name="task_title" placeholder="Titre de la tâche" required>
                        <input type="text" name="task_description" placeholder="Description rapide" required>
                        <input type="date" name="task_deadline" required>
                        <select name="task_assignee" required>
                        <option value="" disabled selected>Assigner à…</option>
                        <?php foreach ($membres as $membre): ?>
                            <option value="<?= (int)$membre['id'] ?>">
                                <?= htmlspecialchars($membre['firstName'].' '.$membre['lastName']) ?>
                                (<?= htmlspecialchars($membre['role_name']) ?>)
                            </option>
                        <?php endforeach; ?>
            </select>

                        <button type="submit">Ajouter une tâche</button>
                    </form>
                <?php else: ?>
                    <p class="muted" style="margin-top:12px;">
                        Seuls les membres avec la permission 1 ou 2 peuvent créer des tâches.
                    </p>
                <?php endif; ?>
            </article>

            <!-- TIMELINE -->
            <article class="panel" data-panel="timeline" hidden>
                <div class="panel-header">
                    <h2>Chronologie</h2>
                    <p class="panel-subtitle">Jalons et dates clés</p>
                </div>

                <?php if (!$events): ?>
                    <p class="muted">Aucune date clé n’a encore été définie pour ce projet.</p>
                <?php else: ?>
                    <div class="timeline-wrapper">
                        <div class="timeline-line"></div>
                        <div class="timeline-events">
                            <?php foreach ($events as $event): ?>
                                <div class="timeline-item">
                                    <span class="timeline-dot"></span>
                                    <span class="timeline-date">
                                        <?= htmlspecialchars($event['event_date']) ?>
                                    </span>
                                    <span class="timeline-label">
                                        <?= htmlspecialchars($event['label']) ?>
                                    </span>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                <?php endif; ?>
            </article>



            <!-- DRIVE -->
            <article class="panel" data-panel="drive" hidden>
                <div class="panel-header">
                    <h2>Drive & ressources</h2>
                    <p class="panel-subtitle">Documents partagés</p>
                </div>
                <ul class="data-list" id="driveList"></ul>
                <form class="inline-form" id="driveForm">
                    <input type="text" id="driveTitle" placeholder="Titre du document" required>
                    <input type="url" id="driveUrl" placeholder="Lien (https://...)" required>
                    <input type="text" id="driveType" placeholder="Type (PDF, Note, etc.)">
                    <button type="submit">Ajouter au drive</button>
                </form>
                <small class="muted">Les éléments ajoutés sont sauvegardés localement pour ce projet.</small>
            </article>

            <!-- NOTES -->
            <article class="panel" data-panel="notes" hidden>
                <div class="panel-header">
                    <h2>Notes & chat</h2>
                    <p class="panel-subtitle">Synthèse des derniers échanges</p>
                </div>
                <div class="notes-box">
                    <div class="chat-thread" id="chatThread"></div>
                    <form class="chat-form" id="chatForm">
                        <textarea id="chatInput" placeholder="Écrire un message..." required></textarea>
                        <button type="submit">Envoyer</button>
                    </form>
                    <small class="muted">Les messages sont enregistrés dans votre navigateur.</small>
                </div>
            </article>
        </section>

    </main>
</div>


<script>
(function(){
    const navButtons = document.querySelectorAll('[data-panel-target]');
    const panelSections = document.querySelectorAll('[data-panel]');

    function showPanel(target) {
        panelSections.forEach(section => {
            const active = section.dataset.panel === target;
            section.hidden = !active;
            section.classList.toggle('active', active);
        });
        navButtons.forEach(btn => btn.classList.toggle('active', btn.dataset.panelTarget === target));
    }

    navButtons.forEach(btn => {
        btn.addEventListener('click', () => {
            if (btn.disabled) return;
            showPanel(btn.dataset.panelTarget);
            // mettre à jour le hash pour le lien direct
            try { history.replaceState(null, '', '#' + btn.dataset.panelTarget); } catch (e) { location.hash = btn.dataset.panelTarget; }
        });
    });

    // initial : depuis le hash, le bouton déjà actif ou le premier
    const fromHash = location.hash ? location.hash.substring(1) : null;
    const activeBtn = Array.from(navButtons).find(b => b.classList.contains('active'));
    const initial = fromHash || (activeBtn && activeBtn.dataset.panelTarget) || (navButtons[0] && navButtons[0].dataset.panelTarget);
    if (initial) showPanel(initial);
})();
</script>

</body>
</html>
