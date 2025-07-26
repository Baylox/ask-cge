// Listen for the Turbo load event to initialize theme settings
document.addEventListener('turbo:load', () => {
    const html = document.documentElement;
    // Retrieve the saved theme from localStorage, default to 'dark' if not set
    const savedTheme = localStorage.getItem('theme');
    const theme = savedTheme ?? 'dark'; 
    html.setAttribute('data-theme', theme);

    /**
     * Represents the theme toggle button element in the DOM.
     * Used to switch between light and dark themes.
     * @type {HTMLElement|null}
     */
    const toggle = document.querySelector('.theme-toggle');
    if (toggle) {
        // Set the toggle state based on the current theme
        toggle.checked = theme === 'light'; 

        // Listen for changes on the toggle to switch themes
        toggle.addEventListener('change', () => {
            const newTheme = toggle.checked ? 'light' : 'dark'; 
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
    }
});

