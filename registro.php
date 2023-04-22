<?php
include_once "./src/db.php";
session_start();

$email = $_POST["email"];

function is_valid_email($str)
{
    $matches = null;
    return (1 === preg_match('/^[A-z0-9\\._-]+@[A-z0-9][A-z0-9-]*(\\.[A-z0-9_-]+)*\\.([A-z]{2,6})$/', $str, $matches));
}

if (is_valid_email($email) == 1) {

    $stmts = $dbh->prepare("SELECT COUNT(*) FROM cliente where cliente = ?");
    $stmts->execute([$email]);
    $count = $stmts->fetchColumn();
    if ($count == 0) {
        $stmt = $dbh->prepare("INSERT INTO cliente (idc, cliente) VALUES (:id, :email)");
        $stmt->execute(array(':id' => null, ':email' => $email));
    }

    $idc = $dbh->prepare("SELECT idc FROM cliente where cliente=:email");
    if ($idc->execute(array(':email' => $email))) {
        $resultado = $idc->fetch(PDO::FETCH_ASSOC);
        $clientes  = $dbh->prepare("SELECT count(*) FROM clientetema where ctidt = ? and ctidc = ?");
        $clientes->execute([$_SESSION['tema'], $resultado['idc']]);
        $numer = $clientes->fetchColumn();
        if ($numer > 0) {
            include_once "./heade.php";
            ?>
			<main class="pt-5 text-white bg-primary">
				<div class="text-center">
					<h2 class="mt-5 mb-5">BR<img src="img/logo2.png" alt="Logo" width="40px" height="40px">CKETS</h2>
				</div>
				<section class="col-md-6 offset-md-3 text-center">
					<h2>MUCHAS GRACIAS POR PARTICIPAR EN LA ENCUESTA.</h2>
					<h4>Este mail ya participo de la encuesta</h4>
				</section>

			</main>

			<?php
session_destroy();
        } else {
            $_SESSION["id"] = $resultado['idc'];
            header("Location: ./encuestarespuesta.php");
        }

    }
}

?>