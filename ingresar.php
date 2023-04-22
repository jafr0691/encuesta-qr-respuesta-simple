<?php
session_start();
include_once "./heade.php";
if(isset($_SESSION["tema"])){
	$stmts = $dbh->prepare("SELECT COUNT(*) FROM tema where idt = ?");
	$stmts->execute([$_SESSION["tema"]]);
	$count = $stmts->fetchColumn();
	if ($count >0) {
		?>
		<form action="registro.php" method="post">
			<div class="container">
				<div class="row text-center pt-5 text-white bg-primary">
					<div class="col-md-12 text-center">
						<h2 class="mt-5 mb-5">BR<img src="img/logo2.png" alt="Logo" width="40px" height="40px">CKETS</h2>
					</div>
					<div class="col-md-12 text-center">
						<label for="prregunta" class="form-control-label text-center">
							<h4>INGRESA TU-EMAIL</h4>
						</label>
						<input type="email"  placeholder="Ingrese su Email" class="col-md-4 offset-md-4 text-center form-control" name="email" required>
					</div>
					<div class="col-md-12 text-center">
						<input type="submit" class="btn btn-secondary btn-lg mt-5 rounded" value="Siguiente">
					</div>

				</dir>
			</div>
		</form>
		<?php

		include_once "./footer.php";
	}else{
		session_destroy();
		unset($_SESSION['tema']);
		header("Location: http://www.google.com");
	}
}else{
	session_destroy();
	unset($_SESSION['tema']);
	header("Location: http://www.google.com");
}
?>
​​​​​
