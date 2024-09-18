<?php
require 'vendor/autoload.php'; // Подключите автозагрузчик Composer

use PhpOffice\PhpSpreadsheet\IOFactory;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $shk = $_POST['shk']; // Поле ШК
    $length = $_POST['length'];
    $width = $_POST['width'];
    $height = $_POST['height'];
    $group = $_POST['group'];

    // Получаем префикс для названия файла (если есть)
    $filePrefix = isset($_POST['file_prefix']) ? $_POST['file_prefix'] : '';

    // Формируем имя файла
    $filePrefix = trim($filePrefix);
    if ($filePrefix === '') {
        $filePrefix = date('d.m.Y'); // Текущая дата, если префикс пустой
    }
    $fileName = $filePrefix . ' - Изменение габаритов.xlsx';

    // Загружаем шаблон Excel
    $spreadsheet = IOFactory::load(__DIR__ . '/template/template.xlsx');
    $sheet = $spreadsheet->getActiveSheet();

    // Начинаем заполнять с 2-й строки (если первая строка — заголовки)
    $startRow = 2;

    // Заполняем данные
    foreach ($shk as $index => $value) {
        $sheet->setCellValue('A' . $startRow, $value);         // Заполняем ШК
        $sheet->setCellValue('B' . $startRow, $length[$index]); // Длина
        $sheet->setCellValue('C' . $startRow, $width[$index]);  // Ширина
        $sheet->setCellValue('D' . $startRow, $height[$index]); // Высота
        $sheet->setCellValue('E' . $startRow, $group[$index]);  // Группа
        $startRow++;
    }

    // Сохраняем заполненный файл в папке temp
    $filePath = __DIR__ . '/template/temp/' . $fileName;
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save($filePath);

    // Отправляем файл пользователю
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $fileName . '"');
    header('Cache-Control: max-age=0');
    readfile($filePath);

    // Удаляем временный файл после скачивания
    unlink($filePath);
    exit();
}
?>