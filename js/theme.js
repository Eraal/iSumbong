// Global Theme Management System for iReport
class ThemeManager {
    constructor() {
        this.currentTheme = 'light';
        this.initialized = false;
        this.init();
    }

    init() {
        // Load theme on page load
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', () => {
                this.loadTheme();
                this.initialized = true;
            });
        } else {
            // DOM is already loaded
            this.loadTheme();
            this.initialized = true;
        }
    }

    // Get current theme from localStorage or PHP session
    getCurrentTheme() {
        // Check PHP session first if available
        const sessionTheme = document.querySelector('meta[name="session-theme"]');
        if (sessionTheme) {
            const theme = sessionTheme.getAttribute('content');
            this.currentTheme = theme;
            return theme;
        }
        
        // Fallback to localStorage
        const savedTheme = localStorage.getItem('theme') || 'light';
        this.currentTheme = savedTheme;
        return savedTheme;
    }

    // Apply theme to the page
    applyTheme(theme) {
        const body = document.body;
        
        // Remove both classes first to avoid conflicts
        body.classList.remove('dark-theme', 'light-theme');
        
        if (theme === 'dark') {
            body.classList.add('dark-theme');
            this.currentTheme = 'dark';
        } else {
            this.currentTheme = 'light';
        }
        
        // Update theme icon in navigation
        this.updateThemeIcon(theme);
        
        // Store in localStorage
        localStorage.setItem('theme', theme);
        
        // Send to server to store in session
        this.saveThemeToSession(theme);
        
        // Update session meta tag
        this.updateSessionMeta(theme);
        
        console.log('Theme applied:', theme);
    }

    // Update session meta tag
    updateSessionMeta(theme) {
        const sessionMeta = document.querySelector('meta[name="session-theme"]');
        if (sessionMeta) {
            sessionMeta.setAttribute('content', theme);
        }
    }

    // Update theme icon in navigation
    updateThemeIcon(theme) {
        const themeIcon = document.getElementById('themeIcon');
        if (themeIcon) {
            if (theme === 'dark') {
                themeIcon.className = 'fas fa-sun'; // Sun icon for dark theme (switch to light)
                themeIcon.title = 'Switch to Light Theme';
            } else {
                themeIcon.className = 'fas fa-moon'; // Moon icon for light theme (switch to dark)
                themeIcon.title = 'Switch to Dark Theme';
            }
        }
    }

    // Load and apply the saved theme
    loadTheme() {
        const theme = this.getCurrentTheme();
        this.applyTheme(theme);
        
        // Update theme selector if it exists
        const themeSelect = document.getElementById('themeSelect');
        if (themeSelect) {
            themeSelect.value = theme;
        }
    }

    // Save theme to PHP session via AJAX
    saveThemeToSession(theme) {
        const currentPath = window.location.pathname;
        
        fetch(currentPath, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'save_theme=1&theme=' + encodeURIComponent(theme)
        })
        .then(response => {
            if (response.ok) {
                return response.json();
            }
            throw new Error('Network response was not ok');
        })
        .then(data => {
            console.log('Theme saved to session:', data);
        })
        .catch(error => {
            console.log('Theme save error:', error);
            // Try alternative save method
            this.saveThemeAlternative(theme);
        });
    }

    // Alternative save method if main save fails
    saveThemeAlternative(theme) {
        // Try saving to a dedicated theme endpoint if available
        fetch('/ireport/includes/save_theme.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'theme=' + encodeURIComponent(theme)
        })
        .catch(error => {
            console.log('Alternative theme save also failed:', error);
        });
    }

    // Change theme (called from settings or theme toggles)
    changeTheme(theme) {
        if (theme !== this.currentTheme) {
            this.applyTheme(theme);
            this.showThemeNotification('Theme changed to: ' + theme.charAt(0).toUpperCase() + theme.slice(1));
        }
    }

    // Show theme change notification
    showThemeNotification(message) {
        // Remove existing notifications
        const existingNotifications = document.querySelectorAll('.theme-notification');
        existingNotifications.forEach(notification => {
            notification.remove();
        });

        // Create notification element
        const notification = document.createElement('div');
        notification.className = 'alert alert-success alert-dismissible fade show theme-notification';
        notification.style.cssText = `
            position: fixed;
            top: 100px;
            right: 20px;
            z-index: 9999;
            min-width: 300px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        `;
        notification.innerHTML = `
            <i class="fas fa-palette mr-2"></i>${message}
            <button type="button" class="close" onclick="this.parentElement.remove()" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        `;
        
        // Add to page
        document.body.appendChild(notification);
        
        // Auto remove after 3 seconds
        setTimeout(() => {
            if (notification.parentNode) {
                notification.remove();
            }
        }, 3000);
    }

    // Toggle between light and dark theme
    toggleTheme() {
        const newTheme = this.currentTheme === 'dark' ? 'light' : 'dark';
        console.log('Toggling from', this.currentTheme, 'to', newTheme);
        this.changeTheme(newTheme);
        return newTheme;
    }

    // Check if theme manager is ready
    isReady() {
        return this.initialized;
    }
}

// Initialize global theme manager with error handling
try {
    window.themeManager = new ThemeManager();
} catch (error) {
    console.error('Failed to initialize theme manager:', error);
    // Fallback initialization
    setTimeout(() => {
        try {
            window.themeManager = new ThemeManager();
        } catch (e) {
            console.error('Fallback theme manager initialization failed:', e);
        }
    }, 500);
}

// Global function to change theme (can be called from anywhere)
function changeTheme(theme) {
    if (window.themeManager && window.themeManager.isReady()) {
        window.themeManager.changeTheme(theme);
    } else {
        console.log('Theme manager not ready, retrying...');
        setTimeout(() => {
            if (window.themeManager) {
                window.themeManager.changeTheme(theme);
            }
        }, 100);
    }
}

// Global function to toggle theme (can be called from anywhere)
function toggleTheme() {
    if (window.themeManager && window.themeManager.isReady()) {
        return window.themeManager.toggleTheme();
    } else {
        console.log('Theme manager not ready, retrying...');
        setTimeout(() => {
            if (window.themeManager) {
                window.themeManager.toggleTheme();
            }
        }, 100);
        return null;
    }
}
