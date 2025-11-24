<?php require('../../backend/account.php'); ?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Paramètres du Compte</title>
    <link rel="stylesheet" href="../../css/style.css">
    <link rel="stylesheet" href="../../css/account.css">
</head>
<body>
    <!-- Theme Toggle Button (Top Right) -->
    <button class="theme-toggle-btn" id="themeToggle" onclick="toggleTheme()" aria-label="Toggle theme">
        <svg class="theme-icon sun-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <circle cx="12" cy="12" r="5"/>
            <line x1="12" y1="1" x2="12" y2="3"/>
            <line x1="12" y1="21" x2="12" y2="23"/>
            <line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/>
            <line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/>
            <line x1="1" y1="12" x2="3" y2="12"/>
            <line x1="21" y1="12" x2="23" y2="12"/>
            <line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/>
            <line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
        </svg>
        <svg class="theme-icon moon-icon" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor">
            <path d="M21 12.79A9 9 0 1 1 11.21 3 7 7 0 0 0 21 12.79z"/>
        </svg>
    </button>

    <div class="settings-container">
        <!-- Sidebar Navigation -->
        <aside class="settings-sidebar">
            <nav class="settings-nav">
                <div class="nav-section">
                    <h3 class="nav-section-title">Compte</h3>
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a href="#profile" class="nav-link" onclick="showSection('profile')">
                                <svg class="nav-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                    <circle cx="12" cy="7" r="4"/>
                                </svg>
                                Profil public
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#account.php" class="nav-link active" onclick="showSection('account')">
                                <svg class="nav-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <circle cx="12" cy="12" r="3"/>
                                    <path d="M12 1v6m0 6v6m8.66-13.66l-4.24 4.24m-4.84 4.84l-4.24 4.24M23 12h-6m-6 0H1m17.66 8.66l-4.24-4.24m-4.84-4.84l-4.24-4.24"/>
                                </svg>
                                Compte
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#appearance" class="nav-link" onclick="showSection('appearance')">
                                <svg class="nav-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M12 2.69l5.66 5.66a8 8 0 1 1-11.31 0z"/>
                                </svg>
                                Apparence
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#notifications" class="nav-link" onclick="showSection('notifications')">
                                <svg class="nav-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/>
                                    <path d="M13.73 21a2 2 0 0 1-3.46 0"/>
                                </svg>
                                Notifications
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="nav-section">
                    <h3 class="nav-section-title">Accès</h3>
                    <ul class="nav-list">
                        <li class="nav-item">
                            <a href="#emails" class="nav-link" onclick="showSection('emails')">
                                <svg class="nav-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                                    <polyline points="22,6 12,13 2,6"/>
                                </svg>
                                Emails
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#security" class="nav-link" onclick="showSection('security')">
                                <svg class="nav-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                                    <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
                                </svg>
                                Sécurité
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#sessions" class="nav-link" onclick="showSection('sessions')">
                                <svg class="nav-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                                    <line x1="8" y1="21" x2="16" y2="21"/>
                                    <line x1="12" y1="17" x2="12" y2="21"/>
                                </svg>
                                Sessions
                            </a>
                        </li> 
                        <li class="nav-item">
                            <a href="../../backend/logout.php" class="nav-link logout" style="color:#e53935;" onclick="return confirm('Êtes-vous sûr de vouloir vous déconnecter ?');">
                                <svg class="nav-icon" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                                    <line x1="8" y1="21" x2="16" y2="21"/>
                                    <line x1="12" y1="17" x2="12" y2="21"/>
                                </svg>
                                Deconnexion
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </aside>

        <!-- Main Content Area -->
        <main class="settings-main">
            <!-- Profile Section -->
            <section id="profile" class="content-section" style="display: none;">
                <div class="content-header">
                    <h1>Profil public</h1>
                    <p class="content-description">Les informations suivantes peuvent être visibles par tous les utilisateurs.</p>
                </div>

                <div class="settings-group">
                    <div class="form-group">
                        <label class="form-label">Photo de profil</label>
                        <div class="avatar-upload-container">
                            <img src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80'%3E%3Crect fill='%236e40c9' width='80' height='80' rx='40'/%3E%3Ctext x='50%25' y='50%25' font-size='32' fill='white' text-anchor='middle' dy='.3em'%3EU%3C/text%3E%3C/svg%3E" alt="Avatar" id="profileAvatar" class="avatar-preview">
                            <div class="avatar-actions">
                                <button class="btn-secondary btn-sm" onclick="document.getElementById('avatarUpload').click()">
                                    Changer
                                </button>
                                <input type="file" id="avatarUpload" accept="image/*" hidden>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="username">Nom d'utilisateur</label>
                        <input type="text" id="username" class="form-input" value="utilisateur" placeholder="Votre nom d'utilisateur">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="bio">Bio</label>
                        <textarea id="bio" class="form-textarea" rows="4" placeholder="Parlez-nous de vous..."></textarea>
                        <small class="form-hint">Une brève description de vous-même</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="website">Site web</label>
                        <input type="url" id="website" class="form-input" placeholder="https://example.com">
                    </div>

                    <div class="form-actions">
                        <button class="btn-primary" onclick="saveProfile()">Mettre à jour le profil</button>
                    </div>
                </div>
            </section>

            <!-- Account Section -->
            <section id="account" class="content-section active">
                <div class="content-header">
                    <h1>Compte</h1>
                    <p class="content-description">Gérez vos paramètres de compte et vos informations personnelles.</p>
                </div>

                <div class="settings-group">
                    <h2 class="group-title">Informations personnelles</h2>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="firstName">Prénom</label>
                            <input type="text" id="firstName" class="form-input" placeholder="Jean">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="lastName">Nom</label>
                            <input type="text" id="lastName" class="form-input" placeholder="Dupont">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="accountEmail">Adresse email</label>
                        <input type="email" id="accountEmail" class="form-input" placeholder="jean.dupont@email.com">
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label class="form-label" for="phone">Téléphone</label>
                            <input type="tel" id="phone" class="form-input" placeholder="+33 6 00 00 00 00">
                        </div>
                        <div class="form-group">
                            <label class="form-label" for="birthdate">Date de naissance</label>
                            <input type="date" id="birthdate" class="form-input">
                        </div>
                    </div>

                    <div class="form-actions">
                        <button class="btn-primary" onclick="saveAccount()">Enregistrer</button>
                        <button class="btn-secondary" onclick="resetAccountForm()">Annuler</button>
                    </div>
                </div>

                <div class="settings-group danger-zone">
                    <h2 class="group-title">Zone de danger</h2>
                    <div class="danger-item">
                        <div class="danger-info">
                            <h3>Supprimer ce compte</h3>
                            <p>Une fois supprimé, il n'y a pas de retour en arrière. Veuillez en être certain.</p>
                        </div>
                        <button class="btn-danger" onclick="deleteAccount()">Supprimer le compte</button>
                    </div>
                </div>
            </section>

            <!-- Appearance Section -->
            <section id="appearance" class="content-section" style="display: none;">
                <div class="content-header">
                    <h1>Apparence</h1>
                    <p class="content-description">Personnalisez l'apparence de l'interface selon vos préférences.</p>
                </div>

                <div class="settings-group">
                    <h2 class="group-title">Mode du thème</h2>
                    <p class="group-description">Choisissez comment vous souhaitez que l'interface apparaisse.</p>
                    
                    <div class="theme-options">
                        <label class="theme-option">
                            <input type="radio" name="theme" value="light" onchange="setTheme('light')">
                            <div class="theme-card">
                                <div class="theme-preview light-preview">
                                    <div class="preview-header"></div>
                                    <div class="preview-sidebar"></div>
                                    <div class="preview-content"></div>
                                </div>
                                <div class="theme-info">
                                    <strong>Clair</strong>
                                    <p>Interface claire</p>
                                </div>
                            </div>
                        </label>

                        <label class="theme-option">
                            <input type="radio" name="theme" value="dark" onchange="setTheme('dark')">
                            <div class="theme-card">
                                <div class="theme-preview dark-preview">
                                    <div class="preview-header"></div>
                                    <div class="preview-sidebar"></div>
                                    <div class="preview-content"></div>
                                </div>
                                <div class="theme-info">
                                    <strong>Sombre</strong>
                                    <p>Interface sombre</p>
                                </div>
                            </div>
                        </label>

                        <label class="theme-option">
                            <input type="radio" name="theme" value="auto" onchange="setTheme('auto')">
                            <div class="theme-card">
                                <div class="theme-preview auto-preview">
                                    <div class="preview-split">
                                        <div class="preview-half light-half"></div>
                                        <div class="preview-half dark-half"></div>
                                    </div>
                                </div>
                                <div class="theme-info">
                                    <strong>Auto</strong>
                                    <p>Suit le système</p>
                                </div>
                            </div>
                        </label>
                    </div>
                </div>
            </section>

            <!-- Notifications Section -->
            <section id="notifications" class="content-section" style="display: none;">
                <div class="content-header">
                    <h1>Notifications</h1>
                    <p class="content-description">Gérez vos préférences de notification.</p>
                </div>

                <div class="settings-group">
                    <h2 class="group-title">Notifications par email</h2>
                    
                    <div class="notification-item">
                        <div class="notification-info">
                            <strong>Mises à jour du compte</strong>
                            <p>Recevez des emails concernant votre compte</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>

                    <div class="notification-item">
                        <div class="notification-info">
                            <strong>Alertes de sécurité</strong>
                            <p>Notifications importantes sur la sécurité</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" checked>
                            <span class="toggle-slider"></span>
                        </label>
                    </div>

                    <div class="notification-item">
                        <div class="notification-info">
                            <strong>Newsletter</strong>
                            <p>Recevez notre newsletter mensuelle</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>
            </section>

            <!-- Emails Section -->
            <section id="emails" class="content-section" style="display: none;">
                <div class="content-header">
                    <h1>Adresses email</h1>
                    <p class="content-description">Gérez vos adresses email associées à ce compte.</p>
                </div>

                <div class="settings-group">
                    <div class="email-list">
                        <div class="email-item">
                            <div class="email-info">
                                <strong>user@example.com</strong>
                                <div class="email-badges">
                                    <span class="badge badge-primary">Principal</span>
                                    <span class="badge badge-success">Vérifié</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <button class="btn-secondary" onclick="addEmail()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                            <line x1="12" y1="5" x2="12" y2="19"/>
                            <line x1="5" y1="12" x2="19" y2="12"/>
                        </svg>
                        Ajouter une adresse email
                    </button>
                </div>
            </section>

            <!-- Security Section -->
            <section id="security" class="content-section" style="display: none;">
                <div class="content-header">
                    <h1>Sécurité</h1>
                    <p class="content-description">Protégez votre compte avec des mesures de sécurité avancées.</p>
                </div>

                <div class="settings-group">
                    <h2 class="group-title">Modifier le mot de passe</h2>
                    
                    <div class="form-group">
                        <label class="form-label" for="oldPassword">Mot de passe actuel</label>
                        <input type="password" id="oldPassword" class="form-input" placeholder="••••••••">
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="newPassword">Nouveau mot de passe</label>
                        <input type="password" id="newPassword" class="form-input" placeholder="••••••••">
                        <small class="form-hint">Minimum 8 caractères avec majuscules et chiffres</small>
                    </div>

                    <div class="form-group">
                        <label class="form-label" for="confirmPassword">Confirmer le mot de passe</label>
                        <input type="password" id="confirmPassword" class="form-input" placeholder="••••••••">
                    </div>

                    <div class="form-actions">
                        <button class="btn-primary" onclick="updatePassword()">Modifier le mot de passe</button>
                    </div>
                </div>

                <div class="settings-group">
                    <h2 class="group-title">Authentification à deux facteurs</h2>
                    <div class="security-item">
                        <div class="security-info">
                            <strong>Activer 2FA</strong>
                            <p>Ajoutez une couche de sécurité supplémentaire</p>
                        </div>
                        <label class="toggle-switch">
                            <input type="checkbox" id="enable2FA">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>
                </div>
            </section>

            <!-- Sessions Section -->
            <section id="sessions" class="content-section" style="display: none;">
                <div class="content-header">
                    <h1>Sessions</h1>
                    <p class="content-description">Gérez vos sessions actives sur différents appareils.</p>
                </div>

                <div class="settings-group">
                    <div class="session-list">
                        <div class="session-item">
                            <div class="session-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <rect x="2" y="3" width="20" height="14" rx="2" ry="2"/>
                                    <line x1="8" y1="21" x2="16" y2="21"/>
                                    <line x1="12" y1="17" x2="12" y2="21"/>
                                </svg>
                            </div>
                            <div class="session-details">
                                <strong>Chrome sur Windows</strong>
                                <p>Paris, France • Actuelle</p>
                            </div>
                            <span class="badge badge-success">Active</span>
                        </div>

                        <div class="session-item">
                            <div class="session-icon">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                                    <rect x="5" y="2" width="14" height="20" rx="2" ry="2"/>
                                    <line x1="12" y1="18" x2="12.01" y2="18"/>
                                </svg>
                            </div>
                            <div class="session-details">
                                <strong>Safari sur iPhone</strong>
                                <p>Lyon, France • Il y a 2 jours</p>
                            </div>
                            <button class="btn-danger-text" onclick="revokeSession(2)">Révoquer</button>
                        </div>
                    </div>
                </div>
            </section>
        </main>
    </div>

    <script src="../../js/script.js"></script>
</body>
</html>
