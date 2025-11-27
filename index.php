<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GuardiaProjets • Plateforme collaborative</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <div class="top-nav">
            <div class="logo">Guardia<span>Projets</span></div>
            <div class="header-actions">
                <a class="btn btn-ghost" href="pages/Gestion/projets.php">Mes projets</a>
                <a class="btn btn-ghost" href="pages/support/Aide.php">Aide</a>
                <a class="btn btn-ghost" href="pages/support/Contact.php">Contact</a>
                <a class="btn btn-ghost" href="pages/Authentification/login.php">Se connecter</a>
                <a class="btn btn-gradient" href="pages/Gestion/account.php">Mon compte</a>
            </div>
        </div>
    </header>

    <main>
        <section class="hero">
            <div class="hero-copy">
                <p class="eyebrow">Nouveau • Plateforme unifiée</p>
                <h1>Couverture totale de vos projets avec GuardiaProjets.</h1>
                <p>Orchestrez vos équipes, vos tâches et vos opérations dans un espace élégant inspiré des meilleures pratiques .</p>
                <div class="hero-actions">
                    <button class="btn btn-primary">Créer un compte</button>
                </div>
            </div>
            <div class="hero-cards">
                <button class="category-card" style="background: linear-gradient(160deg, #7c3aed, #4c1d95);">
                    <strong>Projets & tâches</strong>
                    <span>Suivez chaque jalon en temps réel.</span>
                </button>
                <button class="category-card" style="background: linear-gradient(160deg, #0ea5e9, #2563eb);">
                    <strong>Informatique & assistance</strong>
                    <span>Centralisez incidents et déploiements.</span>
                </button>
                <button class="category-card" style="background: linear-gradient(160deg, #f97316, #ea580c);">
                    <strong>Opérations</strong>
                    <span>Industrialisez vos processus critiques.</span>
                </button>
                <button class="category-card" style="background: linear-gradient(160deg, #ec4899, #db2777);">
                    <strong>Création & design</strong>
                    <span>Coordonnez briefs et validations.</span>
                </button>
            </div>
        </section>

        <section class="workflow-section">
            <div class="workflow-preview">
                <div class="preview-pill">Vue dynamique</div>
                <img id="workflowImage" src="https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=900&q=80" alt="Aperçu workflow">
            </div>
            <div class="workflow-selector">
                <h2>Que souhaitez-vous gérer ?</h2>
                <p class="workflow-description" id="workflowDescription">
                    Sélectionnez un type de flux pour visualiser un exemple de tableau GuardiaProjets.
                </p>
                <div class="workflow-grid" id="workflowGrid">
                    <button class="workflow-option active" data-workflow="projets">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="3" width="7" height="7" rx="1.5"/>
                            <rect x="14" y="3" width="7" height="7" rx="1.5"/>
                            <rect x="14" y="14" width="7" height="7" rx="1.5"/>
                            <rect x="3" y="14" width="7" height="7" rx="1.5"/>
                        </svg>
                        Projets
                    </button>
                    <button class="workflow-option" data-workflow="taches">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M9 11l3 3L22 4"/>
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                        </svg>
                        Tâches
                    </button>
                    <button class="workflow-option" data-workflow="design">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 19l-7 3 3-7L19 4a2.828 2.828 0 0 1 4 4L12 19z"/>
                            <path d="M18 8l3 3"/>
                        </svg>
                        Design
                    </button>
                    <button class="workflow-option" data-workflow="logiciels">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="3" y="4" width="18" height="16" rx="2"/>
                            <path d="M7 20v-4h10v4"/>
                        </svg>
                        Logiciels
                    </button>
                    <button class="workflow-option" data-workflow="informatique">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="3"/>
                            <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09a1.65 1.65 0 0 0-1-1.51 1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 1 1-2.83-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09a1.65 1.65 0 0 0 1.51-1 1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 1 1 2.83-2.83l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 1 1 2.83 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9c0 .69.28 1.35.77 1.84.49.49 1.15.77 1.83.77H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/>
                        </svg>
                        Informatique
                    </button>
                    <button class="workflow-option" data-workflow="operations">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            <polyline points="23 4 23 10 17 10"/>
                            <polyline points="1 20 1 14 7 14"/>
                            <path d="M3.51 9a9 9 0 0 1 14.13-3.36L23 10"/>
                            <path d="M20.49 15a9 9 0 0 1-14.13 3.36L1 14"/>
                        </svg>
                        Opérations
                    </button>
                </div>
                <div class="hero-actions" style="margin-top: 32px;">
                    <button class="btn btn-primary">Commencer →</button>
                    <button class="btn btn-ghost">Voir les modèles</button>
                </div>
            </div>
        </section>

        <div class="trust-logos">
            Adopté par les équipes ambitieuses
            <ul>
                <li>Uber</li>
                <li>Welcome to the Jungle</li>
                <li>Carrefour</li>
                <li>Renault</li>
                <li>Engie</li>
                <li>Leboncoin</li>
            </ul>
        </div>
    </main>

    <script>
        const workflows = {
            projets: {
                description: "Planifiez les jalons clés, attribuez les responsables et visualisez vos progrès en un coup d'œil.",
                image: "https://images.unsplash.com/photo-1557804506-669a67965ba0?auto=format&fit=crop&w=900&q=80"
            },
            taches: {
                description: "Construisez des listes de tâches ultra-visuelles avec statuts, priorités et échéances synchronisées.",
                image: "https://images.unsplash.com/photo-1521737604893-d14cc237f11d?auto=format&fit=crop&w=900&q=80"
            },
            design: {
                description: "Centralisez les briefs créatifs, retours clients et validations d'équipes design.",
                image: "https://images.unsplash.com/photo-1529333166437-7750a6dd5a70?auto=format&fit=crop&w=900&q=80"
            },
            logiciels: {
                description: "Synchronisez vos roadmaps produit, releases et pipelines d'intégration continue.",
                image: "https://images.unsplash.com/photo-1504384308090-c894fdcc538d?auto=format&fit=crop&w=900&q=80"
            },
            informatique: {
                description: "Priorisez tickets d'assistance, incidents critiques et opérations d'infrastructure.",
                image: "https://images.unsplash.com/photo-1525182008055-f88b95ff7980?auto=format&fit=crop&w=900&q=80"
            },
            operations: {
                description: "Harmonisez vos processus opérations, finances et logistique dans un tableau unique.",
                image: "https://images.unsplash.com/photo-1489515217757-5fd1be406fef?auto=format&fit=crop&w=900&q=80"
            }
        };

        const workflowImage = document.getElementById('workflowImage');
        const workflowDescription = document.getElementById('workflowDescription');
        const workflowGrid = document.getElementById('workflowGrid');

        workflowGrid.addEventListener('click', (event) => {
            const button = event.target.closest('.workflow-option');
            if (!button) return;

            const key = button.dataset.workflow;
            const config = workflows[key];
            if (!config) return;

            workflowGrid.querySelectorAll('.workflow-option').forEach((opt) => opt.classList.remove('active'));
            button.classList.add('active');

            workflowImage.src = config.image;
            workflowImage.alt = `Aperçu ${key}`;
            workflowDescription.textContent = config.description;
        });
    </script>
</body>
</html>