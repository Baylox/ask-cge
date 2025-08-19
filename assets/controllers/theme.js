// Init with Turbo (SPA-friendly)
document.addEventListener('turbo:load', () => {
    const html = document.documentElement;
    const KEY = 'theme';

    // Initial choice: storage > OS
    const stored = localStorage.getItem(KEY);
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const initial = stored ?? (prefersDark ? 'dark' : 'light');
    applyTheme(initial);

    // All toggles (checkbox OR button)
    const toggles = document.querySelectorAll('.theme-toggle');
    syncToggles(initial);

    toggles.forEach(el => {
        const evt = el instanceof HTMLInputElement ? 'change' : 'click';
        el.addEventListener(evt, () => {
            const next = currentTheme() === 'dark' ? 'light' : 'dark';
            applyTheme(next);
            syncToggles(next);
            localStorage.setItem(KEY, next);
            document.dispatchEvent(new CustomEvent('theme:change', { detail: { theme: next } }));
        });
    });

    // Helpers
    function applyTheme(theme) {
        html.setAttribute('data-theme', theme);          // DaisyUI
        html.classList.toggle('dark', theme === 'dark'); // Tailwind dark:
    }
    function currentTheme() {
        return html.getAttribute('data-theme') || 'light';
    }
    function syncToggles(theme) {
        toggles.forEach(el => {
            if (el instanceof HTMLInputElement) el.checked = (theme === 'light'); // chosen direction
            el.setAttribute('aria-pressed', theme === 'dark' ? 'true' : 'false');
        });
    }
});

