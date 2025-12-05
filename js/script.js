/* GAB ACCOUNT SCRIPT */
// ============= THEME MANAGEMENT =============
// script.js - GitHub-style Account Settings

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