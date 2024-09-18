// Инициализация событий и восстановление темы после загрузки DOM
document.addEventListener('DOMContentLoaded', () => {
    initEventListeners();
    restoreTheme();
});

// Функция инициализации событий
function initEventListeners() {
    const themeSwitcher = document.querySelector('#theme-switcher');
    if (themeSwitcher) {
        themeSwitcher.addEventListener('change', handleThemeSwitch);
    }
}

// Функция обработки переключения темы
function handleThemeSwitch() {
    const isDarkMode = this.checked;
    setTheme(isDarkMode);
}

// Функция восстановления темы
function restoreTheme() {
    const savedTheme = localStorage.getItem('theme');
    const isDarkMode = savedTheme === 'dark' || savedTheme === null;
    setTheme(isDarkMode);
}

// Функция установки темы
function setTheme(isDarkMode) {
    document.body.classList.toggle('dark-mode', isDarkMode);
    localStorage.setItem('theme', isDarkMode ? 'dark' : 'light');
    const themeSwitcher = document.querySelector('#theme-switcher');
    if (themeSwitcher) {
        themeSwitcher.checked = isDarkMode;
    }
}
