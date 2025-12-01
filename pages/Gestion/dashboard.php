<?php require('../../backend/account.php'); ?>
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
                    <div class="sidebar-subtitle">ProManage edition</div>
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

    <main class="dashboard-main">
        <section class="main-header card" id="dashboardContent" hidden>
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
            <div class="header-actions">
                <a class="btn btn-primary" id="editProjectLink" href="creationproj.php">Modifier ce projet</a>
                <a class="btn btn-ghost" href="projets.php">← Retour aux projets</a>
            </div>
        </section>

        <section class="panel-stack" id="dashboardPanels" hidden>
            <article class="panel" data-panel="overview" hidden>
                <div class="panel-header">
                    <h2>Vue d'ensemble</h2>
                    <p class="panel-subtitle">Synthèse des informations clés</p>
                </div>
                <div class="overview-grid" id="overviewStats"></div>
                <div class="notes-box" id="overviewNotes">Une description concise de votre projet apparaîtra ici.</div>
            </article>

            <article class="panel" data-panel="team" hidden>
                <div class="panel-header">
                    <h2>Équipe projet</h2>
                    <p class="panel-subtitle">Liste des membres et rôles</p>
                </div>
                <ul class="data-list" id="teamList"></ul>
            </article>

            <article class="panel" data-panel="tasks" hidden>
                <div class="panel-header">
                    <h2>Tâches</h2>
                    <p class="panel-subtitle">Avancement opérationnel</p>
                </div>
                <ul class="data-list" id="taskList"></ul>
            </article>

            <article class="panel" data-panel="timeline" hidden>
                <div class="panel-header">
                    <h2>Chronologie</h2>
                    <p class="panel-subtitle">Jalons et dates clés</p>
                </div>
                <ul class="data-list" id="timelineList"></ul>
            </article>

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

        <section class="card empty-state" id="dashboardEmpty">
            <h2>Bienvenue sur votre ProManage</h2>
            <p>Sélectionnez un projet depuis la liste ou créez-en un nouveau pour commencer.</p>
            <div class="empty-actions">
                <a class="primary-link" href="creationproj.php">Créer un projet</a>
                <a href="projets.php">Voir mes projets</a>
            </div>
        </section>
    </main>
</div>

<script>
(function () {
    const storageKey = 'guardia.projects';
    const params = new URLSearchParams(window.location.search);
    const projectSlug = params.get('project');

    const header = document.getElementById('dashboardContent');
    const panelsWrapper = document.getElementById('dashboardPanels');
    const emptyState = document.getElementById('dashboardEmpty');
    const titleEl = document.getElementById('projectTitle');
    const descriptionEl = document.getElementById('projectDescription');
    const statusPill = document.getElementById('projectStatusPill');
    const ownerEl = document.getElementById('projectOwner');
    const startEl = document.getElementById('projectStart');
    const endEl = document.getElementById('projectEnd');
    const editLink = document.getElementById('editProjectLink');
    const overviewStats = document.getElementById('overviewStats');
    const overviewNotes = document.getElementById('overviewNotes');
    const teamList = document.getElementById('teamList');
    const taskList = document.getElementById('taskList');
    const timelineList = document.getElementById('timelineList');
    const driveList = document.getElementById('driveList');
    const chatThread = document.getElementById('chatThread');
    const navButtons = document.querySelectorAll('[data-panel-target]');
    const panelSections = document.querySelectorAll('[data-panel]');
    const driveForm = document.getElementById('driveForm');
    const chatForm = document.getElementById('chatForm');
    const driveTitleInput = document.getElementById('driveTitle');
    const driveUrlInput = document.getElementById('driveUrl');
    const driveTypeInput = document.getElementById('driveType');
    const chatInput = document.getElementById('chatInput');

    toggleNavigation(false);

    navButtons.forEach((button) => {
        button.addEventListener('click', () => {
            if (button.disabled) return;
            showPanel(button.dataset.panelTarget);
        });
    });

    const project = findProject();
    if (!project) {
        emptyState.hidden = false;
        return;
    }

    emptyState.hidden = true;
    header.hidden = false;
    panelsWrapper.hidden = false;
    toggleNavigation(true);

    titleEl.textContent = project.name;
    const description = project.description || 'Aucune description fournie.';
    descriptionEl.textContent = description;
    overviewNotes.textContent = description;
    statusPill.textContent = project.status || 'En cours';
    statusPill.dataset.status = (project.status || 'En cours').toLowerCase().replace(/\s+/g, '-');
    ownerEl.textContent = project.owner || '—';
    startEl.textContent = formatDate(project.startDate);
    endEl.textContent = formatDate(project.endDate);
    editLink.href = `creationproj.php?project=${encodeURIComponent(project.slug || project.id || '')}`;

    updateOverviewStats(project);

    renderList(teamList, project.team, (member) => `
        <li class="data-item">
            <div>
                <strong>${escapeHtml(member.name || 'Membre')}</strong>
                <div class="muted">${escapeHtml(member.role || 'Rôle non défini')}</div>
            </div>
            <a href="mailto:${escapeAttr(member.email || '')}">${escapeHtml(member.email || '')}</a>
        </li>
    `, 'Aucun membre renseigné.');

    renderList(taskList, project.tasks, (task) => {
        const status = (task.status || 'En cours').toLowerCase();
        const deadline = task?.deadline || task?.dueDate;
        const deadlineLabel = deadline ? formatDate(deadline) : '—';
        return `
            <li class="data-item data-item--task">
                <div>
                    <strong>${escapeHtml(task.title || 'Tâche')}</strong>
                    <div class="muted">Date limite : ${escapeHtml(deadlineLabel)}</div>
                </div>
                <div class="task-meta">
                    <span class="status-badge" data-status="${escapeAttr(status)}">${escapeHtml(task.status || 'En cours')}</span>
                </div>
            </li>
        `;
    }, 'Aucune tâche pour le moment.');

    renderList(timelineList, project.timeline, (milestone) => `
        <li class="data-item">
            <div>
                <strong>${escapeHtml(milestone.title || 'Jalon')}</strong>
                <div class="muted">${escapeHtml(milestone.description || '')}</div>
            </div>
            <span class="muted">${formatDate(milestone.date)}</span>
        </li>
    `, 'Aucun jalon défini.');

    const baseDrive = project.drive || [];
    let dynamicDrive = loadDynamic('drive');
    let dynamicChat = loadDynamic('chat');

    renderDriveItems([...baseDrive, ...dynamicDrive]);

    const initialChat = project.chatNotes
        ? [{ author: project.owner || 'Chef de projet', content: project.chatNotes, timestamp: project.updatedAt || project.endDate || project.startDate }]
        : [];
    renderChatMessages([...initialChat, ...dynamicChat]);

    showPanel('overview');

    if (driveForm) {
        driveForm.addEventListener('submit', (event) => {
            event.preventDefault();
            const title = driveTitleInput.value.trim();
            const url = driveUrlInput.value.trim();
            const type = driveTypeInput.value.trim();
            if (!title || !url) return;
            const newResource = {
                title,
                url,
                type: type || 'Lien partagé',
                id: crypto.randomUUID ? crypto.randomUUID() : Date.now().toString()
            };
            dynamicDrive = [...dynamicDrive, newResource];
            saveDynamic('drive', dynamicDrive);
            renderDriveItems([...baseDrive, ...dynamicDrive]);
            driveForm.reset();
        });
    }

    if (chatForm) {
        chatForm.addEventListener('submit', (event) => {
            event.preventDefault();
            const message = chatInput.value.trim();
            if (!message) return;
            const newMessage = {
                author: 'Vous',
                content: message,
                timestamp: new Date().toISOString()
            };
            dynamicChat = [...dynamicChat, newMessage];
            saveDynamic('chat', dynamicChat);
            renderChatMessages([...initialChat, ...dynamicChat]);
            chatForm.reset();
        });
    }

    function toggleNavigation(enabled) {
        navButtons.forEach((button) => {
            button.disabled = !enabled;
            if (!enabled) button.classList.remove('active');
        });
        if (!enabled) {
            panelSections.forEach((section) => {
                section.hidden = true;
                section.classList.remove('active');
            });
        }
    }

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
            container.innerHTML = `<li class="data-item data-item--empty">${emptyMessage}</li>`;
            return;
        }
        container.innerHTML = data.map(templateFn).join('');
    }

    function renderDriveItems(items) {
        renderList(driveList, items, (resource) => `
            <li class="data-item">
                <div>
                    <strong>${escapeHtml(resource.title || 'Document')}</strong>
                    <div class="muted">${escapeHtml(resource.type || 'Ressource')}</div>
                </div>
                <a href="${escapeAttr(resource.url || '#')}" target="_blank" rel="noopener">Ouvrir</a>
            </li>
        `, 'Aucun document partagé.');
    }

    function loadDynamic(section) {
        try {
            const raw = window.localStorage.getItem(dynamicKey(section));
            if (!raw) return [];
            const parsed = JSON.parse(raw);
            return Array.isArray(parsed) ? parsed : [];
        } catch (_) {
            return [];
        }
    }

    function saveDynamic(section, data) {
        try {
            window.localStorage.setItem(dynamicKey(section), JSON.stringify(data));
        } catch (_) {
            /* ignore */
        }
    }

    function dynamicKey(section) {
        return `guardia.dashboard.${projectSlug}.${section}`;
    }

    function formatDate(date) {
        if (!date) return '—';
        try {
            return new Intl.DateTimeFormat('fr-FR', { day: '2-digit', month: 'short', year: 'numeric' }).format(new Date(date));
        } catch (_) {
            return date;
        }
    }

    function formatDateTime(date) {
        if (!date) return '';
        try {
            return new Intl.DateTimeFormat('fr-FR', { day: '2-digit', month: 'short', hour: '2-digit', minute: '2-digit' }).format(new Date(date));
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

    function getNextMilestone(timeline) {
        if (!timeline || !timeline.length) return '—';
        try {
            const withDates = timeline.filter((item) => item.date).sort((a, b) => new Date(a.date) - new Date(b.date));
            const upcoming = withDates.find((item) => new Date(item.date) >= new Date());
            const target = upcoming || withDates[0] || timeline[0];
            const label = target.title || 'Jalon';
            return target.date ? `${label} • ${formatDate(target.date)}` : label;
        } catch (_) {
            return timeline[0].title || 'Jalon';
        }
    }

    function updateOverviewStats(project) {
        const teamCount = (project.team || []).length;
        const taskCount = (project.tasks || []).length;
        const nextMilestone = getNextMilestone(project.timeline);
        const period = `${formatDate(project.startDate)} → ${formatDate(project.endDate)}`;
        const stats = [
            { label: 'Membres', value: teamCount },
            { label: 'Tâches', value: taskCount },
            { label: 'Prochain jalon', value: nextMilestone },
            { label: 'Période', value: period }
        ];
        overviewStats.innerHTML = stats.map((stat) => `
            <div class="stat-card">
                <p>${stat.label}</p>
                <strong>${stat.value}</strong>
            </div>
        `).join('');
    }

    function renderChatMessages(messages) {
        chatThread.innerHTML = '';
        if (!messages || !messages.length) {
            chatThread.innerHTML = '<p class="chat-empty">Aucun message pour le moment.</p>';
            return;
        }
        chatThread.innerHTML = messages.map((msg) => `
            <div class="chat-message">
                <header>
                    <strong>${escapeHtml(msg.author || 'Anonyme')}</strong>
                    <time>${formatDateTime(msg.timestamp)}</time>
                </header>
                <p>${escapeHtml(msg.content || '')}</p>
            </div>
        `).join('');
    }

    function showPanel(target) {
        panelSections.forEach((section) => {
            const isMatch = section.dataset.panel === target;
            section.hidden = !isMatch;
            section.classList.toggle('active', isMatch);
        });
        navButtons.forEach((button) => {
            button.classList.toggle('active', button.dataset.panelTarget === target);
        });
    }
})();
</script>

</body>
</html>
