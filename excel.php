<?php

error_reporting(E_ALL);
ini_set('display_errors', true);
ini_set('display_startup_errors', true);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli') {
    die('This example should only be run from a Web Browser');
}

/** Include PHPExcel */
include_once "./src/db.php";
require_once dirname(__FILE__) . '/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

if (isset($_GET['tema'])) {
    $encuestas = $dbh->prepare("SELECT nombre,descripcion,premio FROM tema where idt=?");
    $encuestas->execute([$_GET['tema']]);
    $tema = $encuestas->fetch(PDO::FETCH_ASSOC);

// Create new PHPExcel object
    $spreadsheet = new Spreadsheet();
$objWorksheet = $spreadsheet->getActiveSheet();
// Set document properties
    $spreadsheet->getProperties()->setCreator("Jesus Farias")
        ->setLastModifiedBy("Jesus Farias Dev")
        ->setTitle("Centro medico odontologico Brackets")
        ->setSubject("Brackets")
        ->setDescription("Encuesta de un centro medico odontologico.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Bracktes Encuesta");
    $clientes = $dbh->prepare("SELECT count(*) FROM clientetema where ctidt = ?");
    $clientes->execute([$_GET['tema']]);
    $numer = $clientes->fetchColumn();
// Add some data
    $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1', 'Tema')
        ->setCellValue('B1', 'Preguntas')
        ->setCellValue('C1', 'Contento')
        ->setCellValue('D1', 'Normal')
        ->setCellValue('E1', 'Descontento')
        ->setCellValue('G1', 'Total de participantes')
        ->setCellValue('G2', $numer)
        ->setCellValue('J1', 'Participantes:');
    $fi     = 2;
    $encues = $dbh->prepare("SELECT  cliente.cliente as cliente
        FROM cliente
        RIGHT JOIN clientetema ON cliente.idc=clientetema.ctidc and clientetema.ctidt=?");
    $encues->execute([$_GET['tema']]);
    $resultt = $encues->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultt as $cliente) {
        $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('J' . $fi, $cliente['cliente']);
        $fi++;
    }

// Miscellaneous glyphs, UTF-8
    $f       = 0;
    $n       = 0;
    $m       = 0;
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
            $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('A' . $fila, $pregunta['temap'])
                ->setCellValue('B' . $fila, $pregunta['pregunta'])
                ->setCellValue('C' . $fila, $feliz)
                ->setCellValue('D' . $fila, $natural)
                ->setCellValue('E' . $fila, $molesto);
            $f       = $feliz + $f;
            $n       = $natural + $n;
            $m       = $molesto + $m;
            $feliz   = 0;
            $natural = 0;
            $molesto = 0;
            $fila++;
        }
    }
    $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('G5', 'Total')
                ->setCellValue('G6', 'Natural')
                ->setCellValue('G7', 'Descontento')
                ->setCellValue('G8', 'Contento')
                ->setCellValue('H6', $n)
                ->setCellValue('H7', $m)
                ->setCellValue('H8', $f)
                ->setCellValue('N2', 'Nombre')
                ->setCellValue('N3', 'descripcion')
                ->setCellValue('N4', 'Premio:')
                ->setCellValue('O2', $tema['nombre'])
                ->setCellValue('O3', $tema['descripcion'])
                ->setCellValue('O4', $tema['premio']);

    $spreadsheet->getActiveSheet()
    ->setTitle('Encuesta Brackets');

    $writer = new Xlsx($spreadsheet);
    $nombre = $tema['nombre'] . ".xlsx";
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename='.$nombre );
    $writer->save('php://output');

} else {
    header("Location: ./index.php");
}
exit;
