// Theme Settings with Session Storage
document.addEventListener('DOMContentLoaded', function() {
    // Load saved theme settings from session storage
    loadThemeSettings();

    // Theme Color Selection
    const themeColorItems = document.querySelectorAll('.choose-skin li');
    themeColorItems.forEach(item => {
        item.addEventListener('click', function() {
            const theme = this.getAttribute('data-theme');
            setThemeColor(theme);
        });
    });

    // Dark Mode Toggle
    const darkModeToggle = document.getElementById('theme-switch');
    if (darkModeToggle) {
        darkModeToggle.addEventListener('change', function() {
            toggleDarkMode(this.checked);
        });
    }

    // Monochrome Mode Toggle
    const monochromeToggle = document.getElementById('monochrome');
    if (monochromeToggle) {
        monochromeToggle.addEventListener('change', function() {
            toggleMonochromeMode(this.checked);
        });
    }
});

// Function to set theme color
function setThemeColor(theme) {
    // Remove active class from all theme items
    document.querySelectorAll('.choose-skin li').forEach(item => {
        item.classList.remove('active');
    });

    // Add active class to selected theme
    const selectedTheme = document.querySelector(`.choose-skin li[data-theme="${theme}"]`);
    if (selectedTheme) {
        selectedTheme.classList.add('active');
    }

    // Apply theme to document
    document.documentElement.setAttribute('data-theme', theme);

    // Get theme color from CSS variable
    const themeColorDiv = selectedTheme?.querySelector('div');
    if (themeColorDiv) {
        const themeColor = getComputedStyle(themeColorDiv).getPropertyValue('--mytask-theme-color').trim();
        document.documentElement.style.setProperty('--mytask-theme-color', themeColor);
    }

    // Save to session storage
    sessionStorage.setItem('theme-color', theme);

    console.log('Theme color changed to:', theme);
}

// Function to toggle dark mode
function toggleDarkMode(isDark) {
    if (isDark) {
        document.body.classList.add('dark-mode');
        document.documentElement.setAttribute('data-theme-mode', 'dark');
    } else {
        document.body.classList.remove('dark-mode');
        document.documentElement.removeAttribute('data-theme-mode');
    }

    // Save to session storage
    sessionStorage.setItem('dark-mode', isDark.toString());

    console.log('Dark mode:', isDark ? 'enabled' : 'disabled');
}

// Function to toggle monochrome mode
function toggleMonochromeMode(isMonochrome) {
    if (isMonochrome) {
        document.body.classList.add('monochrome-mode');
        document.documentElement.setAttribute('data-monochrome', 'true');
    } else {
        document.body.classList.remove('monochrome-mode');
        document.documentElement.removeAttribute('data-monochrome');
    }

    // Save to session storage
    sessionStorage.setItem('monochrome-mode', isMonochrome.toString());

    console.log('Monochrome mode:', isMonochrome ? 'enabled' : 'disabled');
}

// Function to load theme settings from session storage
function loadThemeSettings() {
    // Load theme color
    const savedThemeColor = sessionStorage.getItem('theme-color');
    if (savedThemeColor) {
        setThemeColor(savedThemeColor);
    } else {
        // Set default theme if no saved theme
        const defaultTheme = document.querySelector('.choose-skin li.active');
        if (defaultTheme) {
            const defaultThemeName = defaultTheme.getAttribute('data-theme');
            setThemeColor(defaultThemeName);
        }
    }

    // Load dark mode
    const savedDarkMode = sessionStorage.getItem('dark-mode');
    if (savedDarkMode === 'true') {
        const darkModeToggle = document.getElementById('theme-switch');
        if (darkModeToggle) {
            darkModeToggle.checked = true;
            toggleDarkMode(true);
        }
    }

    // Load monochrome mode
    const savedMonochromeMode = sessionStorage.getItem('monochrome-mode');
    if (savedMonochromeMode === 'true') {
        const monochromeToggle = document.getElementById('monochrome');
        if (monochromeToggle) {
            monochromeToggle.checked = true;
            toggleMonochromeMode(true);
        }
    }
}

// Function to reset theme settings
function resetThemeSettings() {
    sessionStorage.removeItem('theme-color');
    sessionStorage.removeItem('dark-mode');
    sessionStorage.removeItem('monochrome-mode');

    // Reset to default
    document.querySelector('.choose-skin li[data-theme="PurpleHeart"]')?.classList.add('active');
    document.getElementById('theme-switch').checked = false;
    document.getElementById('monochrome').checked = false;

    toggleDarkMode(false);
    toggleMonochromeMode(false);
    setThemeColor('PurpleHeart');

    console.log('Theme settings reset to default');
}

// Function to get current theme settings
function getCurrentThemeSettings() {
    return {
        themeColor: sessionStorage.getItem('theme-color'),
        darkMode: sessionStorage.getItem('dark-mode') === 'true',
        monochromeMode: sessionStorage.getItem('monochrome-mode') === 'true'
    };
}
