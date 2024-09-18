<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Помощник в заполнении файла смены габаритки в Uzum Market</title>
    <link rel="stylesheet" href="resources/styles/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="resources/scripts/script.js" defer></script>
    <script src="resources/scripts/theme.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Помощник в заполнении файла смены габаритки в Uzum Market</h1>

        <div class="theme-toggle">
            <!-- Переключатель темы -->
            <i class="fa fa-sun" aria-hidden="true"></i>
            <input type="checkbox" id="theme-switcher">
            <label for="theme-switcher"></label>
            <i class="fa fa-moon" aria-hidden="true"></i>
        </div>

        <form id="data-form" action="process.php" method="post">
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>№</th>
                            <th>Штрих-код товара</th>
                            <th>Длина (см)</th>
                            <th>Ширина (см)</th>
                            <th>Высота (см)</th>
                            <th>Габаритная группа товара</th>
                            <th>Действие</th>
                        </tr>
                    </thead>
                    <tbody id="data">
                        <tr>
                            <td class="row-number">1</td>
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
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="button-group">
                <button type="button" onclick="addRow()">Добавить строку</button>
                <button type="button" class="clear-form" onclick="clearForm()">Очистить форму</button>
                <button type="button" class="remove-all" onclick="removeAllRows()">Удалить все строки</button>
            </div>

            <div class="file-options">
                <label for="file-prefix">Введите обозначение файла (необязательно):</label>
                <input type="text" id="file-prefix" name="file_prefix" placeholder="например: название магазина, ID товара и т.д">
                <span class="note">Если поле обозначения файла оставлено пустым, будет использована текущая дата.</span>
                
                <button type="submit" class="submit-btn">Скачать заполненный файл Excel</button>
            </div>
        </form>
    </div>
    
<!-- Вывод версии -->
<div class="version">Версия: <span id="version-number"></span></div>

</body>
</html>
