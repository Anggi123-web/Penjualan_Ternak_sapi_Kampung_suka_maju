/**
 * SIPETER Kampung Suka Maju — Universal Theme Manager
 * Supports: Mode Siang (Light) & Mode Malam (Dark)
 * Persisted in localStorage with system preference fallback
 */
(function () {
    const STORAGE_KEY = 'sipeter-theme';

    // 1. Get initial preferred theme
    function getPreferredTheme() {
        const stored = localStorage.getItem(STORAGE_KEY);
        if (stored === 'light' || stored === 'dark') {
            return stored;
        }
        // Fallback to system preference
        return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
    }

    // 2. Apply theme immediately to document element to prevent FOUC
    const initialTheme = getPreferredTheme();
    document.documentElement.setAttribute('data-theme', initialTheme);

    // 3. Update all toggle button elements in DOM
    function updateToggleButtons(theme) {
        const buttons = document.querySelectorAll('.sipeter-theme-toggle-btn, [data-theme-toggle]');
        buttons.forEach(btn => {
            const isDark = theme === 'dark';
            btn.setAttribute('aria-pressed', isDark ? 'true' : 'false');
            btn.setAttribute('title', isDark ? 'Beralih ke Mode Siang' : 'Beralih ke Mode Malam');

            // Update text label if present
            const label = btn.querySelector('.theme-label');
            if (label) {
                label.textContent = isDark ? 'Mode Siang' : 'Mode Malam';
            }

            // Update icon if present
            const icon = btn.querySelector('.theme-icon');
            if (icon) {
                if (isDark) {
                    icon.className = 'theme-icon bi bi-sun-fill';
                } else {
                    icon.className = 'theme-icon bi bi-moon-stars-fill';
                }
            }

            // Update switch indicator slider if pill style
            const indicator = btn.querySelector('.theme-switch-indicator');
            if (indicator) {
                if (isDark) {
                    indicator.classList.add('active-dark');
                } else {
                    indicator.classList.remove('active-dark');
                }
            }
        });
    }

    // Update all logo images for light/dark contrast
    function updateLogos(theme) {
        const isDark = theme === 'dark';
        const logoImgs = document.querySelectorAll('img[src*="sipeter_logo"]');
        logoImgs.forEach(img => {
            const currentSrc = img.getAttribute('src');
            if (!currentSrc) return;
            if (isDark) {
                if (currentSrc.includes('sipeter_logo.png')) {
                    img.setAttribute('src', currentSrc.replace('sipeter_logo.png', 'sipeter_logo_dark.png'));
                }
            } else {
                if (currentSrc.includes('sipeter_logo_dark.png')) {
                    img.setAttribute('src', currentSrc.replace('sipeter_logo_dark.png', 'sipeter_logo.png'));
                }
            }
        });
    }

    // 4. Set theme
    function setTheme(theme, save = true) {
        const targetTheme = (theme === 'dark') ? 'dark' : 'light';
        document.documentElement.setAttribute('data-theme', targetTheme);
        if (save) {
            localStorage.setItem(STORAGE_KEY, targetTheme);
        }
        updateToggleButtons(targetTheme);
        updateLogos(targetTheme);

        // Dispatch custom event for custom components (like maps or charts)
        window.dispatchEvent(new CustomEvent('sipeterThemeChanged', {
            detail: { theme: targetTheme }
        }));
    }

    // 5. Toggle theme
    function toggleTheme() {
        const current = document.documentElement.getAttribute('data-theme') || getPreferredTheme();
        const nextTheme = current === 'dark' ? 'light' : 'dark';
        setTheme(nextTheme, true);
    }

    // Expose to global window
    window.sipeterTheme = {
        get: () => document.documentElement.getAttribute('data-theme') || getPreferredTheme(),
        set: setTheme,
        toggle: toggleTheme
    };
    window.toggleTheme = toggleTheme;

    // 6. Listen to system preference changes if user hasn't explicitly set localStorage
    try {
        const mediaQuery = window.matchMedia('(prefers-color-scheme: dark)');
        mediaQuery.addEventListener('change', (e) => {
            if (!localStorage.getItem(STORAGE_KEY)) {
                setTheme(e.matches ? 'dark' : 'light', false);
            }
        });
    } catch (err) {
        // Fallback for older browsers
    }

    // 7. On DOM ready, bind click listeners and update buttons
    function initThemeUI() {
        const currentTheme = document.documentElement.getAttribute('data-theme') || getPreferredTheme();
        updateToggleButtons(currentTheme);
        updateLogos(currentTheme);

        // Event delegation for any theme toggle button
        document.addEventListener('click', function (e) {
            const toggleBtn = e.target.closest('.sipeter-theme-toggle-btn:not(.sipeter-back-btn), [data-theme-toggle]');
            if (toggleBtn) {
                // If it is a real navigation link, do not prevent default or toggle theme
                const href = toggleBtn.getAttribute('href');
                if (href && !href.startsWith('#') && !href.startsWith('javascript:')) {
                    return;
                }
                e.preventDefault();
                toggleTheme();
            }
        });
    }

    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initThemeUI);
    } else {
        initThemeUI();
    }
})();
