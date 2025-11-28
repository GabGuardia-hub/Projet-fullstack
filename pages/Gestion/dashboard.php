<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard projet • GuardiaProjets</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/projet.css">
    <style>
        :root {
            --pm-sidebar-width: 280px;
            --pm-primary: #2563eb;
            --pm-primary-dark: #1e40af;
            --pm-success: #10b981;
            --pm-warning: #f59e0b;
            --pm-text: #1f2937;
            --pm-muted: #6b7280;
            --pm-border: #e5e7eb;
            --pm-card: #ffffff;
            --pm-bg: #f3f4f6;
        }

        body.promanage-body {
            background: var(--pm-bg);
            color: var(--pm-text);
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            line-height: 1.6;
        }

        .promanage-dashboard {
            display: flex;
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(37,99,235,0.08), rgba(14,165,233,0.08));
        }

        .dashboard-sidebar {
            width: var(--pm-sidebar-width);
            background: var(--pm-card);
            border-right: 1px solid var(--pm-border);
            box-shadow: 2px 0 20px rgba(15,23,42,0.08);
            padding: 32px 24px 40px;
            display: flex;
            flex-direction: column;
            gap: 32px;
            position: sticky;
            top: 0;
            height: 100vh;
        }

        .sidebar-header { display: flex; flex-direction: column; gap: 8px; }
        .logo { display: flex; align-items: center; gap: 12px; font-weight: 700; color: var(--pm-primary); }
        .logo-icon { width: 40px; height: 40px; border-radius: 12px; background: var(--pm-primary); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 1rem; }
        .sidebar-subtitle { color: var(--pm-muted); font-size: 0.9rem; }

        .sidebar-nav { display: flex; flex-direction: column; gap: 16px; flex: 1; overflow-y: auto; }
        .nav-section-title { font-size: 0.75rem; text-transform: uppercase; letter-spacing: .08em; color: var(--pm-muted); }
        .nav-item { border: none; background: transparent; border-radius: 18px; padding: 14px 18px; display: flex; gap: 12px; align-items: flex-start; cursor: pointer; transition: .2s; }
        .nav-item small { display: block; color: var(--pm-muted); font-size: 0.8rem; }
        .nav-item.active { background: rgba(37,99,235,0.12); color: var(--pm-primary); box-shadow: inset 0 0 0 1px rgba(37,99,235,.2); }
        .nav-item:disabled { opacity: 0.45; cursor: not-allowed; }

        .sidebar-footer { margin-top: auto; display: flex; flex-direction: column; gap: 12px; }
        .sidebar-btn { display: inline-flex; justify-content: center; align-items: center; padding: 12px 18px; border-radius: 14px; border: 1px solid transparent; font-weight: 600; text-decoration: none; }
        .sidebar-btn.primary { background: linear-gradient(135deg, var(--pm-primary), var(--pm-primary-dark)); color: #fff; }
        .sidebar-btn.ghost { border-color: var(--pm-border); color: var(--pm-text); }

        .dashboard-main { flex: 1; padding: 48px clamp(24px, 5vw, 72px); }
        .card, .panel { background: var(--pm-card); border-radius: 28px; padding: clamp(24px, 4vw, 36px); box-shadow: 0 25px 45px rgba(15,23,42,0.08); }
        .main-header { display: flex; flex-direction: column; gap: 16px; margin-bottom: 32px; }
        .header-actions { display: flex; flex-wrap: wrap; gap: 12px; margin-top: 8px; }
        .header-meta { display: grid; grid-template-columns: repeat(auto-fit, minmax(160px, 1fr)); gap: 16px; }
        .status-pill { align-self: flex-start; padding: 6px 18px; border-radius: 999px; color: #fff; font-weight: 600; background: var(--pm-primary); }
        .status-pill[data-status*="term"] { background: linear-gradient(135deg, var(--pm-success), #059669); }
        .status-pill[data-status*="risq"] { background: linear-gradient(135deg, var(--pm-warning), #d97706); }

        .panel-stack { display: flex; flex-direction: column; gap: 24px; }
        .panel-stack [data-panel] { display: none; }
        .panel-stack [data-panel].active { display: block; }
        .panel-header { display: flex; flex-direction: column; gap: 4px; margin-bottom: 16px; }
        .panel-subtitle { color: var(--pm-muted); font-size: 0.95rem; }

        .overview-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px,1fr)); gap: 16px; margin-bottom: 16px; }
        .stat-card { padding: 16px; border-radius: 18px; background: rgba(37,99,235,0.08); }
        .stat-card p { margin-bottom: 4px; color: var(--pm-muted); }
        .stat-card strong { font-size: 1.4rem; }

        .data-list { list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 18px; }
        .data-item { display: flex; justify-content: space-between; gap: 16px; flex-wrap: wrap; border-bottom: 1px solid var(--pm-border); padding-bottom: 16px; }
        .data-item:last-child { border-bottom: none; padding-bottom: 0; }
        .data-item--empty { justify-content: center; color: var(--pm-muted); font-style: italic; border-bottom: none; }
        .status-badge { padding: 6px 12px; border-radius: 999px; background: rgba(37,99,235,0.12); color: var(--pm-primary); font-weight: 600; }
        .status-badge[data-status*="termin"] { background: rgba(15, 197, 136, 0.15); color: var(--pm-success); }
        .status-badge[data-status*="risq"] { background: rgba(245,158,11,0.2); color: var(--pm-warning); }
        .task-meta { display: flex; align-items: center; gap: 8px; }

        .inline-form { margin-top: 18px; display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 12px; }
        .inline-form input, .inline-form button, .chat-form textarea, .chat-form button { border-radius: 14px; border: 1px solid rgba(31,31,36,0.15); padding: 10px 14px; font-family: inherit; }
        .inline-form button, .chat-form button { border: none; background: linear-gradient(135deg, var(--pm-primary), var(--pm-primary-dark)); color: #fff; font-weight: 600; cursor: pointer; }

        .notes-box { border: 1px dashed rgba(31,31,36,0.12); border-radius: 20px; padding: 18px; background: rgba(15,23,42,0.03); }
        .chat-thread { display: flex; flex-direction: column; gap: 14px; }
        .chat-message { background: #fff; border-radius: 16px; padding: 14px 16px; border: 1px solid rgba(31,31,36,0.08); }
        .chat-message header { display: flex; justify-content: space-between; gap: 12px; margin-bottom: 6px; font-size: 0.9rem; color: var(--pm-muted); }
        .chat-form { margin-top: 18px; display: flex; flex-direction: column; gap: 10px; }
        .chat-form textarea { min-height: 90px; resize: vertical; }
        .chat-empty { text-align: center; color: var(--pm-muted); }

        .empty-state { text-align: center; padding: 60px 20px; }
        .empty-actions { margin-top: 16px; display: flex; gap: 12px; justify-content: center; flex-wrap: wrap; }
        .empty-actions a { padding: 12px 18px; border-radius: 12px; font-weight: 600; text-decoration: none; border: 1px solid rgba(37,99,235,0.2); color: var(--pm-primary); }
        .empty-actions .primary-link { background: linear-gradient(135deg, var(--pm-primary), var(--pm-primary-dark)); color: #fff; border-color: transparent; }

        @media (max-width: 1024px) {
            .promanage-dashboard { flex-direction: column; }
            .dashboard-sidebar { width: 100%; position: static; height: auto; }
        }
    </style>
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
