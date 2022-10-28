<?php

namespace App\Service;

class FormExportService
{
    private const FONT_NAME = 'timesnewroman';

    public function exportToPdf(string $pageOrientation, string $title, string $html): string
    {
        $pdf = new \TCPDF(
            $pageOrientation,
            PDF_UNIT,
            PDF_PAGE_FORMAT,
            true,
            'UTF-8',
            false
        );

        // Настройка свойств документа
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetTitle($title);

        // Настройка шрифтов
        $pdf->setHeaderFont([self::FONT_NAME, '', PDF_FONT_SIZE_MAIN]);
        $pdf->setFooterFont([self::FONT_NAME, '', PDF_FONT_SIZE_DATA]);

        // Отступы и колонтитулы
//        $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
        $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
        $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);

        $pdf->SetAutoPageBreak(true, PDF_MARGIN_BOTTOM);
        $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

        $pdf->SetFont(self::FONT_NAME, '', 12);

        // Настройки для импорта из HTML
        $pdf->setCellPadding(1);
        $pdf->setCellHeightRatio(1.25);
        $pdf->setHtmlVSpace([
            'p' => [['h' => 1, 'n' => 1], ['h' => 1, 'n' => 1]],
        ]);

        // Добавляем начальную страницу
        $pdf->AddPage();

        $pdf->writeHTML($html, true, false, false, false, '');

        // Создаем файл во временной директории и удаляем его по завершению скрипта
        $file = tempnam(sys_get_temp_dir(), '');
        register_shutdown_function(static function (string $file) {
            @unlink($file);
        }, $file);

        $pdf->Output($file, 'F');

        return $file;
    }
}
