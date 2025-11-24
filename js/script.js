/* GAB ACCOUNT SCRIPT */
// ============= THEME MANAGEMENT =============
// script.js - GitHub-style Account Settings

// ============= THEME MANAGEMENT =============
function toggleTheme() {
    const html = document.documentElement;
    const currentTheme = html.getAttribute('data-theme') || 'light';
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    
    setTheme(newTheme);
}

function setTheme(theme) {
    const html = document.documentElement;
    
    if (theme === 'auto') {
        const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
        html.setAttribute('data-theme', prefersDark ? 'dark' : 'light');
    } else {
        html.setAttribute('data-theme', theme);
    }
    
    localStorage.setItem('theme', theme);
    
    // Update radio buttons
    const themeRadios = document.querySelectorAll('input[name="theme"]');
    themeRadios.forEach(radio => {
        radio.checked = radio.value === theme;
    });
}

// Load saved theme on page load
document.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme') || 'light';
    setTheme(savedTheme);
    
    // Listen for system theme changes if auto is selected
    if (savedTheme === 'auto') {
        window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (e) => {
            if (localStorage.getItem('theme') === 'auto') {
                document.documentElement.setAttribute('data-theme', e.matches ? 'dark' : 'light');
            }
        });
    }
});

// ============= NAVIGATION =============
function showSection(sectionId) {
    // Hide all sections
    document.querySelectorAll('.content-section').forEach(section => {
        section.classList.remove('active');
        section.style.display = 'none';
    });
    
    // Remove active class from all nav links
    document.querySelectorAll('.nav-link').forEach(link => {
        link.classList.remove('active');
    });
    
    // Show selected section
    const targetSection = document.getElementById(sectionId);
    if (targetSection) {
        targetSection.classList.add('active');
        targetSection.style.display = 'block';
    }
    
    // Add active class to clicked nav link
    const activeLink = document.querySelector(`.nav-link[href="#${sectionId}"]`);
    if (activeLink) {
        activeLink.classList.add('active');
    }
    
    // Update URL without page reload
    history.pushState(null, '', `#${sectionId}`);
    
    // Prevent default link behavior
    event?.preventDefault();
}

// Handle back/forward browser navigation
window.addEventListener('popstate', () => {
    const hash = window.location.hash.replace('#', '') || 'account';
    showSection(hash);
});

// Load correct section on page load based on URL hash
document.addEventListener('DOMContentLoaded', () => {
    const hash = window.location.hash.replace('#', '') || 'account';
    showSection(hash);
});

// ============= AVATAR UPLOAD =============
document.addEventListener('DOMContentLoaded', () => {
    const avatarUpload = document.getElementById('avatarUpload');
    const profileAvatar = document.getElementById('profileAvatar');
    
    if (avatarUpload && profileAvatar) {
        avatarUpload.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    profileAvatar.src = e.target.result;
                    showNotification('Photo de profil mise à jour', 'success');
                };
                reader.readAsDataURL(file);
            } else {
                showNotification('Veuillez sélectionner une image valide', 'error');
            }
        });
    }
});

// ============= FORM HANDLERS =============
function saveProfile() {
    const username = document.getElementById('username')?.value;
    const bio = document.getElementById('bio')?.value;
    const website = document.getElementById('website')?.value;
    
    if (!username) {
        showNotification('Le nom d\'utilisateur est requis', 'error');
        return;
    }
    
    console.log('Profile data:', { username, bio, website });
    showNotification('Profil mis à jour avec succès', 'success');
}

function saveAccount() {
    const firstName = document.getElementById('firstName')?.value;
    const lastName = document.getElementById('lastName')?.value;
    const email = document.getElementById('accountEmail')?.value;
    
    if (!firstName || !lastName || !email) {
        showNotification('Veuillez remplir tous les champs obligatoires', 'error');
        return;
    }
    
    if (!validateEmail(email)) {
        showNotification('Adresse email invalide', 'error');
        return;
    }
    
    console.log('Account data:', { firstName, lastName, email });
    showNotification('Informations du compte enregistrées', 'success');
}

function resetAccountForm() {
    document.querySelectorAll('#account input').forEach(input => {
        if (input.type !== 'button' && input.type !== 'submit') {
            input.value = '';
        }
    });
    showNotification('Formulaire réinitialisé', 'info');
}

function updatePassword() {
    const oldPassword = document.getElementById('oldPassword')?.value;
    const newPassword = document.getElementById('newPassword')?.value;
    const confirmPassword = document.getElementById('confirmPassword')?.value;
    
    if (!oldPassword || !newPassword || !confirmPassword) {
        showNotification('Veuillez remplir tous les champs', 'error');
        return;
    }
    
    if (newPassword !== confirmPassword) {
        showNotification('Les mots de passe ne correspondent pas', 'error');
        return;
    }
    
    if (newPassword.length < 8) {
        showNotification('Le mot de passe doit contenir au moins 8 caractères', 'error');
        return;
    }
    
    if (!validatePassword(newPassword)) {
        showNotification('Le mot de passe doit contenir des majuscules et des chiffres', 'error');
        return;
    }
    
    console.log('Password changed');
    document.getElementById('oldPassword').value = '';
    document.getElementById('newPassword').value = '';
    document.getElementById('confirmPassword').value = '';
    
    showNotification('Mot de passe modifié avec succès', 'success');
}

// ============= SESSION MANAGEMENT =============
function revokeSession(sessionId) {
    if (confirm('Voulez-vous vraiment révoquer cette session ?')) {
        console.log('Session revoked:', sessionId);
        showNotification('Session révoquée', 'success');
    }
}

// ============= ACCOUNT ACTIONS =============
function addEmail() {
    const email = prompt('Entrez une nouvelle adresse email :');
    if (email && validateEmail(email)) {
        console.log('Adding email:', email);
        showNotification('Email ajouté avec succès', 'success');
    } else if (email) {
        showNotification('Adresse email invalide', 'error');
    }
}

function deleteAccount() {
    const confirmation = confirm(
        '⚠️ ATTENTION : Cette action est irréversible !\n\n' +
        'Voulez-vous vraiment supprimer définitivement votre compte ?'
    );
    
    if (confirmation) {
        const verification = prompt('Pour confirmer, tapez "SUPPRIMER" en majuscules :');
        
        if (verification === 'SUPPRIMER') {
            console.log('Account deleted');
            showNotification('Compte supprimé. Redirection...', 'error');
            setTimeout(() => {
                window.location.href = '../pages/login.html';
            }, 2000);
        } else {
            showNotification('Suppression annulée', 'info');
        }
    }
}

// ============= VALIDATION FUNCTIONS =============
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validatePassword(password) {
    const hasUpperCase = /[A-Z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    return hasUpperCase && hasNumber;
}

// ============= NOTIFICATION SYSTEM =============
function showNotification(message, type = 'info') {
    // Remove existing notifications
    document.querySelectorAll('.toast-notification').forEach(n => n.remove());
    
    const notification = document.createElement('div');
    notification.className = `toast-notification toast-${type}`;
    
    const colors = {
        success: 'var(--color-success-emphasis)',
        error: 'var(--color-danger-emphasis)',
        warning: 'var(--color-attention-emphasis)',
        info: 'var(--color-accent-emphasis)'
    };
    
    notification.style.cssText = `
        position: fixed;
        top: 80px;
        right: 16px;
        padding: 12px 16px;
        background-color: ${colors[type] || colors.info};
        color: white;
        border-radius: 6px;
        box-shadow: var(--shadow-lg);
        z-index: 1000;
        font-size: 14px;
        font-weight: 500;
        max-width: 400px;
        animation: slideInRight 0.3s ease;
    `;
    
    notification.textContent = message;
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOutRight 0.3s ease';
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// Add notification animations
const style = document.createElement('style');
style.textContent = `
    @keyframes slideInRight {
        from {
            transform: translateX(400px);
            opacity: 0;
        }
        to {
            transform: translateX(0);
            opacity: 1;
        }
    }
    
    @keyframes slideOutRight {
        from {
            transform: translateX(0);
            opacity: 1;
        }
        to {
            transform: translateX(400px);
            opacity: 0;
        }
    }
`;
document.head.appendChild(style);

/* FIN DU SCRIPT ACCOUNT GAB */