<?php
session_start();
include_once "./src/db.php";

$nombre = $_POST["nombre"];
$descri = $_POST["descri"];
$tema = $_POST["tema"];
$premio = $_POST["premio"];
$dia= date('d');
$hora= date('G');
$mes= date('n');
$year = date('Y');


$fecha = $dia."/".$mes."/".$year;
$audiodb = $dbh->prepare("UPDATE tema SET nombre=:nombre, descripcion=:descri, premio=:pre,fecha=:fecha where idt=:id");
$audiodb->execute(array(':id' => $tema, ':nombre' => ucwords($nombre), ':descri' => $descri, ':pre' => $premio, ':fecha' => $fecha));

$preguntas = $dbh->prepare("SELECT idp FROM pregunta where idt=?");
$preguntas->execute([$tema]);
$resultado = $preguntas->fetchAll(PDO::FETCH_ASSOC);
$i=0;
foreach ($resultado as $idp) {
	if ($_POST['pregunta'][$i]) {
	$pregunta = $dbh->prepare("UPDATE pregunta SET pregunta=:pre, temap=:temap where idp=:id");
	$pregunta->execute(array(':id' => $idp['idp'], ':pre' => ucwords($_POST['pregunta'][$i]),':temap' => $_POST['temap'][$i]));
	}else{
		$deletp = $dbh->prepare("DELETE FROM pregunta where idp=:id");
    	$deletp->execute([':id' => $idp['idp']]);
	}
	$i++;
}

if (isset($_POST['pregunta'][$i])) {
	for ($ii=$i; $ii < count($_POST['pregunta']); $ii++) {
		$stmt = $dbh->prepare("INSERT INTO pregunta (idp, pregunta,temap, idt) VALUES (:id, :pre,:temap, :idt)");
		$stmt->execute(array(':id' => null, ':pre' => ucwords($_POST['pregunta'][$ii]),':temap' => $_POST['temap'][$ii], ':idt' => $tema));
	}
}


header("Location: ./index.php");


 ?>