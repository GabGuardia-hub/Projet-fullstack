/* GAB ACCOUNT SCRIPT */
// ============= THEME MANAGEMENT =============
function toggleTheme() {
    const html = document.documentElement;
    const currentTheme = html.getAttribute('data-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
    
    html.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    
    // Animation du bouton
    const btn = document.getElementById('themeToggle');
    if (btn) {
        btn.style.transform = 'scale(0.9) rotate(180deg)';
        setTimeout(() => {
            btn.style.transform = 'scale(1) rotate(0deg)';
        }, 300);
    }
}

// Charger le thème sauvegardé au chargement de la page
document.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme') || 'light';
    document.documentElement.setAttribute('data-theme', savedTheme);
});

// ============= TAB NAVIGATION =============
function switchTab(tabId) {
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });
    document.querySelectorAll('.tab-button').forEach(button => {
        button.classList.remove('active');
    });
    
    document.getElementById(tabId).classList.add('active');
    document.querySelector(`[data-tab="${tabId}"]`).classList.add('active');
}

// ============= AVATAR UPLOAD =============
document.addEventListener('DOMContentLoaded', () => {
    const avatarInput = document.getElementById('avatarInput');
    const avatarDisplay = document.getElementById('avatarDisplay');
    
    if (avatarInput && avatarDisplay) {
        avatarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file && file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    avatarDisplay.src = e.target.result;
                    showNotification('Photo de profil mise à jour !', 'success');
                };
                reader.readAsDataURL(file);
            } else {
                showNotification('Veuillez sélectionner une image valide', 'error');
            }
        });
    }
});

// ============= FORM MANAGEMENT =============
function savePersonalInfo() {
    const firstName = document.getElementById('firstName').value;
    const lastName = document.getElementById('lastName').value;
    const email = document.getElementById('emailField').value;
    const phone = document.getElementById('phoneField').value;
    const birthdate = document.getElementById('birthdateField').value;
    const address = document.getElementById('addressField').value;
    const city = document.getElementById('cityField').value;
    const postal = document.getElementById('postalField').value;
    
    if (!firstName || !lastName || !email) {
        showNotification('Veuillez remplir tous les champs obligatoires', 'error');
        return;
    }
    
    if (!validateEmail(email)) {
        showNotification('Adresse email invalide', 'error');
        return;
    }
    
    const userData = {
        firstName,
        lastName,
        email,
        phone,
        birthdate,
        address,
        city,
        postal
    };
    
    console.log('Données à sauvegarder:', userData);
    
    document.getElementById('displayName').textContent = `${firstName} ${lastName}`;
    document.getElementById('displayEmail').textContent = email;
    
    showNotification('Informations mises à jour avec succès !', 'success');
}

function resetForm() {
    document.querySelectorAll('.info-form input').forEach(input => {
        input.value = '';
    });
    showNotification('Formulaire réinitialisé', 'info');
}

// ============= PASSWORD MANAGEMENT =============
function updatePassword() {
    const currentPass = document.getElementById('currentPassword').value;
    const newPass = document.getElementById('newPassword').value;
    const confirmPass = document.getElementById('confirmPassword').value;
    
    if (!currentPass || !newPass || !confirmPass) {
        showNotification('Veuillez remplir tous les champs', 'error');
        return;
    }
    
    if (newPass !== confirmPass) {
        showNotification('Les mots de passe ne correspondent pas', 'error');
        return;
    }
    
    if (newPass.length < 8) {
        showNotification('Le mot de passe doit contenir au moins 8 caractères', 'error');
        return;
    }
    
    if (!validatePassword(newPass)) {
        showNotification('Le mot de passe doit contenir des majuscules et des chiffres', 'error');
        return;
    }
    
    console.log('Changement de mot de passe');
    
    document.getElementById('currentPassword').value = '';
    document.getElementById('newPassword').value = '';
    document.getElementById('confirmPassword').value = '';
    
    showNotification('Mot de passe modifié avec succès !', 'success');
}

// ============= SESSION MANAGEMENT =============
function revokeSession(sessionId) {
    if (confirm('Voulez-vous vraiment révoquer cette session ?')) {
        console.log('Session révoquée:', sessionId);
        showNotification('Session révoquée avec succès', 'success');
    }
}

// ============= ACCOUNT MANAGEMENT =============
function deactivateAccount() {
    if (confirm('Êtes-vous sûr de vouloir désactiver votre compte ? Vous pourrez le réactiver plus tard.')) {
        console.log('Compte désactivé');
        showNotification('Compte désactivé', 'warning');
    }
}

function deleteAccount() {
    const confirmation = confirm('⚠️ ATTENTION : Cette action est irréversible !\n\nVoulez-vous vraiment supprimer définitivement votre compte ?');
    
    if (confirmation) {
        const verification = prompt('Pour confirmer, tapez "SUPPRIMER" en majuscules :');
        
        if (verification === 'SUPPRIMER') {
            console.log('Compte supprimé définitivement');
            showNotification('Compte supprimé. Redirection...', 'error');
            setTimeout(() => {
                window.location.href = 'logout.html';
            }, 2000);
        } else {
            showNotification('Suppression annulée', 'info');
        }
    }
}

// ============= UTILITY FUNCTIONS =============
function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

function validatePassword(password) {
    const hasUpperCase = /[A-Z]/.test(password);
    const hasNumber = /[0-9]/.test(password);
    return hasUpperCase && hasNumber;
}

function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification notification-${type}`;
    notification.textContent = message;
    
    notification.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        padding: 16px 24px;
        background: ${type === 'success' ? '#38a169' : type === 'error' ? '#e53e3e' : type === 'warning' ? '#d69e2e' : '#3182ce'};
        color: white;
        border-radius: 10px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
        z-index: 10000;
        font-weight: 600;
        animation: slideIn 0.3s ease;
    `;
    
    document.body.appendChild(notification);
    
    setTimeout(() => {
        notification.style.animation = 'slideOut 0.3s ease';
        setTimeout(() => {
            notification.remove();
        }, 300);
    }, 3000);
}

// Animations CSS pour les notifications
const style = document.createElement('style');
style.textContent = `
    @keyframes slideIn {
        from { transform: translateX(400px); opacity: 0; }
        to { transform: translateX(0); opacity: 1; }
    }
    @keyframes slideOut {
        from { transform: translateX(0); opacity: 1; }
        to { transform: translateX(400px); opacity: 0; }
    }
`;
document.head.appendChild(style);
/* FIN DU SCRIPT ACCOUNT GAB */