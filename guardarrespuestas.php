<?php
include_once "./src/db.php";
session_start();
$t=$_SESSION['tema'];
header("refresh:10;url=http://localhost/encuesta.php?tema=$t");
$encuestas = $dbh->prepare("SELECT idp, pregunta FROM pregunta where idt=?");
$encuestas->execute([$_SESSION['tema']]);
$resultado = $encuestas->fetchAll(PDO::FETCH_ASSOC);
foreach ($resultado as $encuesta) {
	$stmt = $dbh->prepare("INSERT INTO respuesta (idr, respuesta, idp, idc) VALUES (:id, :respuesta, :idp, :idc)");
	$stmt->execute(array(':id' => null, ':respuesta' => $_POST[$encuesta['idp']], ':idp'=>$encuesta['idp'], ':idc'=>$_SESSION["id"]));
}
$stmt = $dbh->prepare("INSERT INTO clientetema (idct, ctidt, ctidc) VALUES (:id, :t, :c)");
$stmt->execute(array(':id' => null, ':t' => $_SESSION['tema'], ':c'=>$_SESSION['id']));
session_destroy();
unset($_SESSION['tema']);
unset($_SESSION['id']);
include_once "./heade.php";
?>
<main class="pt-5 text-white bg-primary">
	<div class="text-center animated fadeInDownShort">
		<h2 class="mt-5 mb-5">BR<img src="img/logo2.png" alt="Logo" width="40px" height="40px">CKETS</h2>
	</div>
	<section class="col-md-6 offset-md-3 text-center">
		<h2>MUCHAS GRACIAS POR PARTICIPAR EN LA ENCUESTA.</h2>
	</section>

</main>
