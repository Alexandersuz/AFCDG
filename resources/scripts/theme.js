// Инициализация событий и восстановление темы после загрузки DOM
document.addEventListener('DOMContentLoaded', () => {
    initEventListeners(); // Инициализация событий

    // Восстановление темы из локального хранилища
    restoreTheme();
});

// Функция инициализации событий
function initEventListeners() {
    const themeSwitcher = document.getElementById('theme-switcher');
    if (themeSwitcher) {
        themeSwitcher.addEventListener('change', handleThemeSwitch);
    }
}

// Функция обработки переключения темы
function handleThemeSwitch() {
    const isDarkMode = this.checked;
    document.body.classList.toggle('dark-mode', isDarkMode);
    localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
}

// Функция восстановления темы
function restoreTheme() {
    const savedTheme = localStorage.getItem('theme');
    const isDarkMode = savedTheme === 'dark';
    document.body.classList.toggle('dark-mode', isDarkMode);
    const themeSwitcher = document.getElementById('theme-switcher');
    if (themeSwitcher) {
        themeSwitcher.checked = isDarkMode;
    }
}
