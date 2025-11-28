<?php require('../../backend/account.php'); ?>
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
                </div>
            </div>
            <div id="projectsGrid" class="projects-grid" aria-live="polite"></div>
        </section>
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

            const defaultProjects = [];

            const projectsGrid = document.getElementById('projectsGrid');

            let projects = loadProjects();

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
                return defaultProjects;
            }

            function formatDate(iso) {
                try {
                    return new Intl.DateTimeFormat('fr-FR', { day: '2-digit', month: 'short' }).format(new Date(iso));
                } catch (_) {
                    return '—';
                }
            }

            function createProjectCard(project, index) {
                const card = document.createElement('a');
                card.className = 'project-card';

                card.style.background = project.color || gradients[index % gradients.length];
                card.href = `dashboard.php?project=${encodeURIComponent(project.slug || project.id)}`;
                card.setAttribute('aria-label', `Ouvrir le tableau du projet ${project.name}`);

                const meta = document.createElement('div');
                meta.className = 'project-card__meta';
                meta.innerHTML = `<span>${project.status}</span><span>${formatDate(project.createdAt)}</span>`;

                const title = document.createElement('h3');
                title.textContent = project.name;

                const owner = document.createElement('p');
                owner.className = 'project-card__owner';
                owner.textContent = project.owner;

                card.append(meta, title, owner);
                return card;
            }

            function renderProjects() {
                projectsGrid.innerHTML = '';
                projects
                    .slice()
                    .sort((a, b) => new Date(b.createdAt) - new Date(a.createdAt))
                    .forEach((project, index) => {
                        projectsGrid.appendChild(createProjectCard(project, index));
                    });
            }

            renderProjects();
        })();
    </script>

</body>
</html>