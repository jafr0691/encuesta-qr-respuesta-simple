<?php
session_start();
include_once "./src/db.php";

$nombre = ucwords($_POST["nombre"]);
$descri = ucwords($_POST["descri"]);

$dia= date('d');
$hora= date('G');
$mes = date('n');
$year = date('Y');


$fecha = $dia."/".$mes."/".$year;
$stmt = $dbh->prepare("INSERT INTO tema (idt, nombre, descripcion, premio, fecha) VALUES (:id, :nombre, :descri, :premio, :fecha)");
$stmt->execute(array(':id' => null, ':nombre' => $nombre, ':descri' => $descri, ':premio' => $_POST['premio'],':fecha' => $fecha));


$idt = $dbh->prepare("SELECT idt FROM tema where nombre=:nombre");
if ($idt->execute(array(':nombre' => $nombre))) {
    $resultado = $idt->fetch(PDO::FETCH_ASSOC);
    $tema = $resultado['idt'];
}
$i=0;
foreach ($_POST['pregunta'] as $pre) {
	$stmt = $dbh->prepare("INSERT INTO pregunta (idp, pregunta,temap, idt) VALUES (:id, :pre,:temap, :idt)");
	$stmt->execute(array(':id' => null, ':pre' => $pre, ':temap' => $_POST['temap'][$i],':idt' => $tema));
	$i++;
}


header("Location: ./index.php");


 ?>