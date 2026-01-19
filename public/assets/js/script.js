// Toggle Dark Mode
function toggleTheme() {
    const html = document.documentElement;
    const currentTheme = html.getAttribute('data-bs-theme');
    const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

    html.setAttribute('data-bs-theme', newTheme);
    localStorage.setItem('theme', newTheme);
    updateIcons(newTheme);
}

function updateIcons(theme) {
    const iconSun = document.getElementById('icon-sun');
    const iconMoon = document.getElementById('icon-moon');

    if (theme === 'dark') {
        iconSun.classList.remove('d-none');
        iconMoon.classList.add('d-none');
    } else {
        iconSun.classList.add('d-none');
        iconMoon.classList.remove('d-none');
    }
}

// Set Theme saat load
const savedTheme = localStorage.getItem('theme') || 'light';
document.documentElement.setAttribute('data-bs-theme', savedTheme);
document.addEventListener('DOMContentLoaded', () => updateIcons(savedTheme));