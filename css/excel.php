<?php
/**
 * PHPExcel
 *
 * Copyright (c) 2006 - 2015 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2015 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt    LGPL
 * @version    ##VERSION##, ##DATE##
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli') {
    die('This example should only be run from a Web Browser');
}

/** Include PHPExcel */
include_once "./src/db.php";
require_once dirname(__FILE__) . '/src/Classes/PHPExcel.php';
if (isset($_GET['tema'])) {
    $encuestas = $dbh->prepare("SELECT nombre,descripcion FROM tema where idt=?");
    $encuestas->execute([$_GET['tema']]);
    $tema = $encuestas->fetch(PDO::FETCH_ASSOC);

// Create new PHPExcel object
    $objPHPExcel = new PHPExcel();

// Set document properties
    $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");
    $clientes = $dbh->prepare("SELECT count(*) FROM clientetema where ctidt = ?");
    $clientes->execute([$_GET['tema']]);
    $numer = $clientes->fetchColumn();
// Add some data
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Tema')
        ->setCellValue('B1', 'Preguntas')
        ->setCellValue('C1', 'Contento')
        ->setCellValue('D1', 'Normal')
        ->setCellValue('E1', 'Descontento')
        ->setCellValue('G1', 'Total de participantes')
        ->setCellValue('G2', $numer);
    $fi     = 0;
    $encues = $dbh->prepare("SELECT  cliente.cliente as cliente
        FROM cliente
        RIGHT JOIN clientetema ON cliente.idc=clientetema.ctidc and clientetema.ctidt=?");
    $encues->execute([$_GET['tema']]);
    $resultt = $encues->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultt as $cliente) {
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('I' . $fi, $cliente['cliente']);
        $fi = 0;
    }

// Miscellaneous glyphs, UTF-8

    $fila    = 2;
    $feliz   = 0;
    $natural = 0;
    $molesto = 0;
    if (isset($_GET['tema'])) {
        $encuestas = $dbh->prepare("SELECT idp, pregunta,temap FROM pregunta where idt = ?");
        $encuestas->execute([$_GET['tema']]);
        $resul = $encuestas->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resul as $pregunta) {
            $encues = $dbh->prepare("SELECT respuesta FROM respuesta where idp = ?");
            $encues->execute([$pregunta['idp']]);
            $result = $encues->fetchAll(PDO::FETCH_ASSOC);
            foreach ($result as $respuesta) {
                if ($respuesta['respuesta'] == 1) {
                    $feliz++;
                } else if ($respuesta['respuesta'] == 2) {
                    $natural++;
                } else if ($respuesta['respuesta'] == 3) {
                    $molesto++;
                }

            }
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $fila, $pregunta['temap'])
                ->setCellValue('B' . $fila, $pregunta['pregunta'])
                ->setCellValue('C' . $fila, $feliz)
                ->setCellValue('D' . $fila, $natural)
                ->setCellValue('E' . $fila, $molesto);
            $feliz   = 0;
            $natural = 0;
            $molesto = 0;
            $fila++;
        }
    }

// Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle($tema['nombre']);

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
    $nombre = $tema['nombre'] . ".xlsx";
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename=' . $nombre);
//     header('Cache-Control: max-age=0');
    //     // If you're serving to IE 9, then the following may be needed
    //     header('Cache-Control: max-age=1');

// // If you're serving to IE over SSL, then the following may be needed
    //     header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    //     header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    //     header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    //     header ('Pragma: public'); // HTTP/1.0

    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
    $objWriter->save('php://output');
} else {
    header("Location: ./index.php");
}
exit;
