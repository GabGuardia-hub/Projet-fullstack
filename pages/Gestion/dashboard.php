<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard projet • GuardiaProjets</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/projet.css">
</head>
<body>

    <?php include '../nav/nav.php'; ?>

    <main class="dashboard-page">
        <section class="dashboard-header" id="dashboardContent" hidden>
            <div>
                <p class="eyebrow">Dashboard projet</p>
                <h1 id="projectTitle"></h1>
                <p class="projects-subtitle" id="projectDescription"></p>
            </div>
            <span class="status-pill" id="projectStatusPill" data-status="">Statut</span>
            <div class="header-meta">
                <div>
                    <strong>Responsable</strong>
                    <p id="projectOwner">—</p>
                </div>
                <div>
                    <strong>Début</strong>
                    <p id="projectStart">—</p>
                </div>
                <div>
                    <strong>Fin prévue</strong>
                    <p id="projectEnd">—</p>
                </div>
            </div>
            <div class="builder-actions" style="margin-top: 12px;">
                <a class="btn btn-light" href="projets.php">← Retour aux projets</a>
                <a class="btn btn-ghost" id="editProjectLink" href="creationproj.php">Modifier ce projet</a>
            </div>
        </section>

        <section class="dashboard-grid" id="dashboardPanels" hidden>
            <article class="dashboard-card">
                <h2>Équipe</h2>
                <ul class="list-reset" id="teamList"></ul>
            </article>
            <article class="dashboard-card">
                <h2>Tâches</h2>
                <ul class="list-reset" id="taskList"></ul>
            </article>
            <article class="dashboard-card">
                <h2>Chronologie</h2>
                <ul class="list-reset" id="timelineList"></ul>
            </article>
            <article class="dashboard-card">
                <h2>Drive</h2>
                <ul class="list-reset" id="driveList"></ul>
            </article>
            <article class="dashboard-card" style="grid-column: 1 / -1;">
                <h2>Notes & chat</h2>
                <div class="chat-box" id="chatBox"></div>
            </article>
        </section>

        <section class="dashboard-empty" id="dashboardEmpty">
            <p>Aucun projet sélectionné. Créez-en un ou choisissez-le depuis la liste.</p>
            <div class="builder-actions" style="justify-content: center; margin-top: 16px;">
                <a class="btn btn-primary" href="creationproj.php">Créer un projet</a>
                <a class="btn btn-light" href="projets.php">Voir mes projets</a>
            </div>
        </section>
    </main>

    <script>
        (function() {
            const storageKey = 'guardia.projects';
            const params = new URLSearchParams(window.location.search);
            const projectSlug = params.get('project');

            const header = document.getElementById('dashboardContent');
            const panels = document.getElementById('dashboardPanels');
            const emptyState = document.getElementById('dashboardEmpty');
            const titleEl = document.getElementById('projectTitle');
            const descriptionEl = document.getElementById('projectDescription');
            const statusPill = document.getElementById('projectStatusPill');
            const ownerEl = document.getElementById('projectOwner');
            const startEl = document.getElementById('projectStart');
            const endEl = document.getElementById('projectEnd');
            const editLink = document.getElementById('editProjectLink');
            const teamList = document.getElementById('teamList');
            const taskList = document.getElementById('taskList');
            const timelineList = document.getElementById('timelineList');
            const driveList = document.getElementById('driveList');
            const chatBox = document.getElementById('chatBox');

            const project = findProject();
            if (!project) {
                emptyState.hidden = false;
                return;
            }

            emptyState.hidden = true;
            header.hidden = false;
            panels.hidden = false;

            titleEl.textContent = project.name;
            descriptionEl.textContent = project.description || 'Aucune description fournie.';
            statusPill.textContent = project.status || 'En cours';
            statusPill.dataset.status = (project.status || 'En cours').toLowerCase().replace(/\s+/g, '-');
            ownerEl.textContent = project.owner || '—';
            startEl.textContent = formatDate(project.startDate);
            endEl.textContent = formatDate(project.endDate);
            editLink.href = `creationproj.php?project=${encodeURIComponent(project.slug || project.id)}`;

            renderList(teamList, project.team, (member) => `
                <li class="team-item">
                    <div>
                        <strong>${escapeHtml(member.name || 'Membre')}</strong>
                        <div class="team-role">${escapeHtml(member.role || 'Rôle non défini')}</div>
                    </div>
                    <a href="mailto:${escapeAttr(member.email || '')}">${escapeHtml(member.email || '')}</a>
                </li>
            `, 'Aucun membre renseigné.');

            renderList(taskList, project.tasks, (task) => `
                <li class="task-item">
                    <strong>${escapeHtml(task.title || 'Tâche')}</strong>
                    <span class="task-status" data-status="${escapeAttr((task.status || 'En cours').toLowerCase())}">
                        ${escapeHtml(task.status || 'En cours')}
                    </span>
                </li>
            `, 'Aucune tâche pour le moment.');

            renderList(timelineList, project.timeline, (milestone) => `
                <li class="timeline-item">
                    <strong>${escapeHtml(milestone.title || 'Jalon')}</strong>
                    <span class="timeline-date">${formatDate(milestone.date)}</span>
                </li>
            `, 'Aucun jalon défini.');

            renderList(driveList, project.drive, (resource) => `
                <li class="drive-item">
                    <strong>${escapeHtml(resource.title || 'Document')}</strong>
                    <a href="${escapeAttr(resource.url || '#')}" target="_blank" rel="noopener">Ouvrir</a>
                </li>
            `, 'Aucun document partagé.');

            chatBox.textContent = project.chatNotes || 'Aucune note pour le moment.';

            function findProject() {
                if (!projectSlug) return null;
                try {
                    const stored = window.localStorage.getItem(storageKey);
                    if (!stored) return null;
                    const projects = JSON.parse(stored);
                    if (!Array.isArray(projects)) return null;
                    return projects.find((proj) => proj.slug === projectSlug || proj.id === projectSlug) || null;
                } catch (error) {
                    console.warn('Impossible de charger les projets', error);
                    return null;
                }
            }

            function renderList(container, data, templateFn, emptyMessage) {
                container.innerHTML = '';
                if (!data || !data.length) {
                    container.innerHTML = `<li class="timeline-item">${emptyMessage}</li>`;
                    return;
                }
                container.innerHTML = data.map(templateFn).join('');
            }

            function formatDate(date) {
                if (!date) return '—';
                try {
                    return new Intl.DateTimeFormat('fr-FR', { day: '2-digit', month: 'short', year: 'numeric' }).format(new Date(date));
                } catch (_) {
                    return date;
                }
            }

            function escapeHtml(value) {
                return (value || '')
                    .replace(/&/g, '&amp;')
                    .replace(/</g, '&lt;')
                    .replace(/>/g, '&gt;')
                    .replace(/"/g, '&quot;')
                    .replace(/'/g, '&#39;');
            }

            function escapeAttr(value) {
                return escapeHtml(value).replace(/\"/g, '&quot;');
            }
        })();
    </script>

</body>
</html>
