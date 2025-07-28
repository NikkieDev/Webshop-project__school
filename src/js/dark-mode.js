const darkModeToggleEl = document.querySelector('.dark-mode-toggle');

const darkMode = Cookies.getInstance().findCookie('dark-mode');

if ('true' === darkMode) {
    darkModeToggleEl.checked = 'true';
    document.body.classList.add('theme-dark');
} else {
    darkModeToggleEl.removeAttribute('checked');
}

darkModeToggleEl.addEventListener('change', event => {
    const checked = event.target.checked;

    Cookies.getInstance().addCookie('dark-mode', checked);
    document.body.classList.toggle('theme-dark');
});