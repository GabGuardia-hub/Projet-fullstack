<?php require('../../backend/account.php'); ?>
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
        <header class="builder-header">
            <div>
                <p class="eyebrow">Assistant projet</p>
                <h1 id="builderTitle">Nouveau projet</h1>
                <p class="projects-subtitle">Définissez les informations clés, l'équipe, les tâches et les jalons de votre projet.</p>
            </div>
            <div class="builder-actions">
                <a class="btn btn-light" href="projets.php">← Retour à la liste</a>
                <a class="btn btn-ghost" id="dashboardShortcut" href="dashboard.php">Voir le dashboard</a>
            </div>
        </header>

        <form class="builder-form" id="projectBuilderForm">
            <section class="panel">
                <div class="panel-header">
                    <div>
                        <h2>Informations générales</h2>
                        <p class="panel-subtitle">Nom, responsable, dates et statut.</p>
                    </div>
                </div>
                <div class="panel-grid">
                    <div>
                        <label for="projectName">Nom du projet</label>
                        <input type="text" id="projectName" name="projectName" placeholder="Refonte du portail client" required>
                    </div>
                    <div>
                        <label for="projectOwner">Responsable</label>
                        <input type="text" id="projectOwner" name="projectOwner" placeholder="Equipe Produit" required>
                    </div>
                    <div>
                        <label for="projectStatus">Statut</label>
                        <select id="projectStatus" name="projectStatus" required>
                            <option value="En préparation">En préparation</option>
                            <option value="En cours" selected>En cours</option>
                            <option value="À risque">À risque</option>
                            <option value="Terminé">Terminé</option>
                        </select>
                    </div>
                    <div>
                        <label for="projectStart">Début</label>
                        <input type="date" id="projectStart" name="projectStart">
                    </div>
                    <div>
                        <label for="projectEnd">Fin prévisionnelle</label>
                        <input type="date" id="projectEnd" name="projectEnd">
                    </div>
                    <div>
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
                        <h2>Tâches principales</h2>
                        <p class="panel-subtitle">Découpez le travail et assignez les responsables.</p>
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
                <button class="btn btn-primary" type="submit">Enregistrer et ouvrir le dashboard</button>
                <a class="btn btn-ghost" href="projets.php">Annuler</a>
            </div>

            <div class="form-feedback" id="builderFeedback" hidden></div>
        </form>
    </main>

    <script>
        (function() {
            const storageKey = 'guardia.projects';
            const gradients = [
                'linear-gradient(160deg, #7c3aed, #4c1d95)',
                'linear-gradient(160deg, #0ea5e9, #2563eb)',
                'linear-gradient(160deg, #f97316, #ea580c)',
                'linear-gradient(160deg, #10b981, #059669)',
                'linear-gradient(160deg, #ec4899, #db2777)'
            ];

            const params = new URLSearchParams(window.location.search);
            const projectParam = params.get('project');
            const form = document.getElementById('projectBuilderForm');
            const teamRows = document.getElementById('teamRows');
            const taskRows = document.getElementById('taskRows');
            const timelineRows = document.getElementById('timelineRows');
            const driveRows = document.getElementById('driveRows');
            const feedback = document.getElementById('builderFeedback');
            const dashboardShortcut = document.getElementById('dashboardShortcut');

            let projects = loadProjects();
            let editingProject = null;

            if (projectParam) {
                editingProject = projects.find((proj) => proj.slug === projectParam || proj.id === projectParam) || null;
            }

            if (editingProject) {
                document.getElementById('builderTitle').textContent = `Modifier • ${editingProject.name}`;
                dashboardShortcut.href = `dashboard.php?project=${encodeURIComponent(editingProject.slug || editingProject.id)}`;
                hydrateForm(editingProject);
            } else {
                dashboardShortcut.setAttribute('aria-disabled', 'true');
                dashboardShortcut.classList.add('btn-disabled');
                addTeamRow();
                addTaskRow();
                addTimelineRow();
                addDriveRow();
            }

            document.getElementById('addTeamRow').addEventListener('click', () => addTeamRow());
            document.getElementById('addTaskRow').addEventListener('click', () => addTaskRow());
            document.getElementById('addTimelineRow').addEventListener('click', () => addTimelineRow());
            document.getElementById('addDriveRow').addEventListener('click', () => addDriveRow());

            form.addEventListener('submit', (event) => {
                event.preventDefault();

                const name = form.projectName.value.trim();
                const owner = form.projectOwner.value.trim();
                if (!name || !owner) {
                    showFeedback('Merci de renseigner au minimum un nom et un responsable.', true);
                    return;
                }

                const slug = ensureUniqueSlug(slugify(name), editingProject?.id);
                const projectPayload = {
                    id: editingProject?.id || (crypto.randomUUID ? crypto.randomUUID() : `proj-${Date.now()}`),
                    name,
                    owner,
                    status: form.projectStatus.value,
                    startDate: form.projectStart.value || null,
                    endDate: form.projectEnd.value || null,
                    description: form.projectDescription.value.trim(),
                    team: collectTeam(),
                    tasks: collectTasks(),
                    timeline: collectTimeline(),
                    drive: collectDrive(),
                    chatNotes: document.getElementById('chatNotes').value.trim(),
                    createdAt: editingProject?.createdAt || new Date().toISOString(),
                    color: editingProject?.color || gradients[projects.length % gradients.length],
                    slug
                };

                if (editingProject) {
                    projects = projects.map((proj) => (proj.id === editingProject.id ? projectPayload : proj));
                } else {
                    projects = [...projects, projectPayload];
                }

                saveProjects(projects);
                showFeedback('Projet enregistré. Redirection vers le dashboard...', false);

                setTimeout(() => {
                    window.location.href = `dashboard.php?project=${encodeURIComponent(slug)}`;
                }, 900);
            });

            function addTeamRow(data = {}) {
                const row = document.createElement('div');
                row.className = 'dynamic-row';
                row.innerHTML = `
                    <input type="text" class="team-name" placeholder="Nom complet">
                    <input type="text" class="team-role" placeholder="Rôle">
                    <input type="email" class="team-email" placeholder="Email professionnel">
                    <button type="button" class="remove-row" aria-label="Supprimer ce membre">×</button>
                `;
                row.querySelector('.remove-row').addEventListener('click', () => row.remove());
                row.querySelector('.team-name').value = data.name || '';
                row.querySelector('.team-role').value = data.role || '';
                row.querySelector('.team-email').value = data.email || '';
                teamRows.appendChild(row);
            }

            function addTaskRow(data = {}) {
                const row = document.createElement('div');
                row.className = 'dynamic-row';
                row.innerHTML = `
                    <input type="text" class="task-title" placeholder="Tâche">
                    <input type="text" class="task-owner" placeholder="Responsable">
                    <select class="task-status-field">
                        <option value="En cours">En cours</option>
                        <option value="À risque">À risque</option>
                        <option value="Terminé">Terminé</option>
                    </select>
                    <button type="button" class="remove-row" aria-label="Supprimer cette tâche">×</button>
                `;
                row.querySelector('.remove-row').addEventListener('click', () => row.remove());
                row.querySelector('.task-title').value = data.title || '';
                row.querySelector('.task-owner').value = data.owner || '';
                row.querySelector('.task-status-field').value = data.status || 'En cours';
                taskRows.appendChild(row);
            }

            function addTimelineRow(data = {}) {
                const row = document.createElement('div');
                row.className = 'dynamic-row';
                row.innerHTML = `
                    <input type="text" class="timeline-title" placeholder="Jalon / étape">
                    <input type="date" class="timeline-date-field">
                    <input type="text" class="timeline-note" placeholder="Note rapide">
                    <button type="button" class="remove-row" aria-label="Supprimer ce jalon">×</button>
                `;
                row.querySelector('.remove-row').addEventListener('click', () => row.remove());
                row.querySelector('.timeline-title').value = data.title || '';
                row.querySelector('.timeline-date-field').value = data.date || '';
                row.querySelector('.timeline-note').value = data.note || '';
                timelineRows.appendChild(row);
            }

            function addDriveRow(data = {}) {
                const row = document.createElement('div');
                row.className = 'dynamic-row';
                row.innerHTML = `
                    <input type="text" class="drive-title" placeholder="Nom du document">
                    <input type="url" class="drive-url" placeholder="https://...">
                    <button type="button" class="remove-row" aria-label="Supprimer ce document">×</button>
                `;
                row.querySelector('.remove-row').addEventListener('click', () => row.remove());
                row.querySelector('.drive-title').value = data.title || '';
                row.querySelector('.drive-url').value = data.url || '';
                driveRows.appendChild(row);
            }

            function collectTeam() {
                return [...teamRows.querySelectorAll('.dynamic-row')]
                    .map((row) => ({
                        name: row.querySelector('.team-name').value.trim(),
                        role: row.querySelector('.team-role').value.trim(),
                        email: row.querySelector('.team-email').value.trim()
                    }))
                    .filter((member) => member.name || member.role || member.email);
            }

            function collectTasks() {
                return [...taskRows.querySelectorAll('.dynamic-row')]
                    .map((row) => ({
                        title: row.querySelector('.task-title').value.trim(),
                        owner: row.querySelector('.task-owner').value.trim(),
                        status: row.querySelector('.task-status-field').value
                    }))
                    .filter((task) => task.title || task.owner);
            }

            function collectTimeline() {
                return [...timelineRows.querySelectorAll('.dynamic-row')]
                    .map((row) => ({
                        title: row.querySelector('.timeline-title').value.trim(),
                        date: row.querySelector('.timeline-date-field').value,
                        note: row.querySelector('.timeline-note').value.trim()
                    }))
                    .filter((milestone) => milestone.title || milestone.date || milestone.note);
            }

            function collectDrive() {
                return [...driveRows.querySelectorAll('.dynamic-row')]
                    .map((row) => ({
                        title: row.querySelector('.drive-title').value.trim(),
                        url: row.querySelector('.drive-url').value.trim()
                    }))
                    .filter((link) => link.title || link.url);
            }

            function hydrateForm(project) {
                form.projectName.value = project.name;
                form.projectOwner.value = project.owner || '';
                form.projectStatus.value = project.status || 'En cours';
                form.projectStart.value = project.startDate || '';
                form.projectEnd.value = project.endDate || '';
                form.projectDescription.value = project.description || '';
                document.getElementById('chatNotes').value = project.chatNotes || '';

                (project.team && project.team.length ? project.team : [{}]).forEach((member) => addTeamRow(member));
                (project.tasks && project.tasks.length ? project.tasks : [{}]).forEach((task) => addTaskRow(task));
                (project.timeline && project.timeline.length ? project.timeline : [{}]).forEach((milestone) => addTimelineRow(milestone));
                (project.drive && project.drive.length ? project.drive : [{}]).forEach((resource) => addDriveRow(resource));
            }

            function loadProjects() {
                try {
                    const stored = window.localStorage.getItem(storageKey);
                    if (stored) {
                        const parsed = JSON.parse(stored);
                        if (Array.isArray(parsed)) {
                            return parsed;
                        }
                    }
                } catch (error) {
                    console.warn('Impossible de lire les projets stockés', error);
                }
                return [];
            }

            function saveProjects(list) {
                try {
                    window.localStorage.setItem(storageKey, JSON.stringify(list));
                } catch (error) {
                    console.warn('Impossible de sauvegarder les projets', error);
                }
            }

            function slugify(value) {
                return value
                    .toLowerCase()
                    .normalize('NFD')
                    .replace(/[\u0300-\u036f]/g, '')
                    .replace(/[^a-z0-9]+/g, '-')
                    .replace(/(^-|-$)/g, '')
                    .slice(0, 60) || `projet-${Date.now()}`;
            }

            function ensureUniqueSlug(baseSlug, currentId) {
                let counter = 1;
                let candidate = baseSlug;
                const existingSlugs = new Set(
                    projects
                        .filter((proj) => proj.id !== currentId)
                        .map((proj) => proj.slug)
                );

                while (existingSlugs.has(candidate)) {
                    counter += 1;
                    candidate = `${baseSlug}-${counter}`;
                }
                return candidate;
            }

            function showFeedback(message, isError) {
                feedback.hidden = false;
                feedback.textContent = message;
                feedback.style.background = isError ? '#fee2e2' : '#ecfdf5';
                feedback.style.color = isError ? '#991b1b' : '#166534';
                feedback.style.borderColor = isError ? '#fecaca' : '#bbf7d0';
            }
        })();
    </script>

</body>
</html>
