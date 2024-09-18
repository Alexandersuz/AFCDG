// Задайте актуальную версию проекта
const CURRENT_VERSION = '0.0.05'; 

// Обновление версии на странице после загрузки DOM
document.addEventListener('DOMContentLoaded', () => {
    const versionElement = document.getElementById('version-number');
    if (versionElement) {
        versionElement.textContent = CURRENT_VERSION;
    } else {
        console.error('Элемент с id "version-number" не найден.');
    }
});

// Функция добавления новой строки
function addRow() {
    const table = document.getElementById('data');
    const newRow = document.createElement('tr');
    const rowCount = table.rows.length + 1; // Учитываем, что строка будет добавлена, поэтому +1

    newRow.innerHTML = `
        <td class="row-number">${rowCount}</td>
        <td><input type="text" name="shk[]" placeholder="Введите штрих-код товара" maxlength="13" required oninput="validateNumber(this)"></td>
        <td><input type="text" name="length[]" placeholder="Введите длину (см)" required oninput="validateNumber(this)"></td>
        <td><input type="text" name="width[]" placeholder="Введите ширину (см)" required oninput="validateNumber(this)"></td>
        <td><input type="text" name="height[]" placeholder="Введите высоту (см)" required oninput="validateNumber(this)"></td>
        <td>
            <select name="group[]" required>
                <option value="МГТ">МГТ (Мелкогабарит)</option>
                <option value="СГТ">СГТ (Среднегабарит)</option>
                <option value="КГТ">КГТ (Крупногабарит)</option>
            </select>
        </td>
        <td><button type="button" onclick="removeRow(this)">Удалить</button></td>
    `;

    table.appendChild(newRow);
    updateRowNumbers(); // Обновляем номера строк после добавления
}

// Функция удаления строки
function removeRow(button) {
    const row = button.closest('tr'); // Используем closest для поиска родительского элемента tr
    const table = document.getElementById('data');

    // Убедимся, что первая строка не может быть удалена
    if (table.rows.length <= 1) {
        alert('Первая строка не может быть удалена.');
        return;
    }

    row.remove();
    updateRowNumbers(); // Обновляем номера строк после удаления
}

// Функция обновления номеров строк
function updateRowNumbers() {
    const table = document.getElementById('data');
    Array.from(table.rows).forEach((row, index) => {
        row.cells[0].textContent = index + 1; // Обновляем номер строки, начиная с 1
    });
}

// Функция очистки формы
function clearForm() {
    document.querySelectorAll('#data tr').forEach(row => {
        row.querySelectorAll('input').forEach(input => input.value = '');
        row.querySelector('select').selectedIndex = 0; // Сбрасываем выбор в select
    });
}

// Функция удаления всех строк кроме первой
function removeAllRows() {
    const table = document.getElementById('data');
    while (table.rows.length > 1) {
        table.deleteRow(1); // Удаляем все строки кроме первой
    }
    updateRowNumbers(); // Обновляем номера строк после удаления всех строк
}

// Функция валидации ввода чисел
function validateNumber(input) {
    input.value = input.value.replace(/[^0-9]/g, ''); // Удаляем все нечисловые символы
}
