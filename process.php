<?php
require 'vendor/autoload.php'; // Подключите автозагрузчик Composer

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Exception as SpreadsheetException;

// Обработчик POST-запроса
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Получаем данные из формы
        $shk = isset($_POST['shk']) ? $_POST['shk'] : [];
        $length = isset($_POST['length']) ? $_POST['length'] : [];
        $width = isset($_POST['width']) ? $_POST['width'] : [];
        $height = isset($_POST['height']) ? $_POST['height'] : [];
        $group = isset($_POST['group']) ? $_POST['group'] : [];

        // Проверка данных
        if (empty($shk) || empty($length) || empty($width) || empty($height) || empty($group)) {
            throw new Exception('Некоторые поля формы пусты.');
        }

        // Получаем префикс для названия файла (если есть)
        $filePrefix = isset($_POST['file_prefix']) ? trim($_POST['file_prefix']) : '';
        if ($filePrefix === '') {
            $filePrefix = date('d.m.Y'); // Текущая дата, если префикс пустой
        }
        $fileName = $filePrefix . ' - Изменение габаритов.xlsx';

        // Загружаем шаблон Excel
        $templatePath = __DIR__ . '/template/template.xlsx';
        if (!file_exists($templatePath)) {
            throw new Exception('Шаблон не найден.');
        }

        $spreadsheet = IOFactory::load($templatePath);
        $sheet = $spreadsheet->getActiveSheet();

        // Начинаем заполнять с 2-й строки (если первая строка — заголовки)
        $startRow = 2;

        // Заполняем данные
        foreach ($shk as $index => $value) {
            $sheet->setCellValue('A' . $startRow, htmlspecialchars($value));         // Заполняем ШК
            $sheet->setCellValue('B' . $startRow, htmlspecialchars($length[$index])); // Длина
            $sheet->setCellValue('C' . $startRow, htmlspecialchars($width[$index]));  // Ширина
            $sheet->setCellValue('D' . $startRow, htmlspecialchars($height[$index])); // Высота
            $sheet->setCellValue('E' . $startRow, htmlspecialchars($group[$index]));  // Группа
            $startRow++;
        }

        // Сохраняем заполненный файл в папке temp
        $tempDir = __DIR__ . '/template/temp/';
        if (!is_dir($tempDir) && !mkdir($tempDir, 0755, true)) {
            throw new Exception('Не удалось создать директорию для временных файлов.');
        }

        $filePath = $tempDir . $fileName;
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save($filePath);

        // Отправляем файл пользователю
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . basename($fileName) . '"');
        header('Cache-Control: max-age=0');
        readfile($filePath);

        // Удаляем временный файл после скачивания
        unlink($filePath);
    } catch (SpreadsheetException $e) {
        // Обработка ошибок от библиотеки PhpSpreadsheet
        echo 'Ошибка при обработке файла Excel: ', $e->getMessage();
    } catch (Exception $e) {
        // Обработка общих ошибок
        echo 'Ошибка: ', $e->getMessage();
    } finally {
        // Освобождение ресурсов
        flush();
        exit();
    }
}
?>
