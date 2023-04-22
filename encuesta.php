<?php
session_start();
include_once "./heade.php";
if(isset($_GET["tema"])){
    $_SESSION["tema"]= $_GET['tema'];
}
if(isset($_SESSION["tema"])){
$stmts = $dbh->prepare("SELECT COUNT(*) FROM tema where idt = ?");
$stmtsl = $dbh->prepare("SELECT premio FROM tema where idt = ?");
    $stmtsl->execute([$_SESSION["tema"]]);
    $stmts->execute([$_SESSION["tema"]]);
    $resul = $stmtsl->fetch(PDO::FETCH_ASSOC);
    $count = $stmts->fetchColumn();
    if ($count >0) {
?>

<main class="pt-5 text-white bg-primary">
	<div class="text-center">
		<h2 class="mt-5 mb-5">BR<img src="img/logo2.png" alt="Logo" width="40px" height="40px">CKETS</h2>
	</div>
	<section class="col-md-6 offset-md-3 text-center">
		<h2><?php echo $resul['premio']; ?></h2>
		<a href="ingresar.php" class="btn btn-secondary btn-lg mt-5 rounded">INGRESAR</a>
	</section>

</main>
	<?php
	include_once "./footer.php";
}else{
session_destroy();
header("Location: http://www.google.com");
}
}else{
session_destroy();
header("Location: http://www.google.com");
}	?>

