<?php
session_start();
include_once "./heade.php";
if(isset($_GET["tema"])){
    $_SESSION["tema"]= $_GET['tema'];
}
if(isset($_SESSION["tema"])){
$stmtsl = $dbh->prepare("SELECT premio FROM tema where idt = ?");
$stmtsl->execute([$_SESSION["tema"]]);
$resul = $stmtsl->fetch(PDO::FETCH_ASSOC);

$stmts = $dbh->prepare("SELECT COUNT(*) FROM tema where idt = ?");
    $stmts->execute([$_SESSION["tema"]]);
    $count = $stmts->fetchColumn();
    if ($count >0) {
?>
	<main class="pt-5 text-white bg-primary">
		<div class="text-center mb-5">
			<h2 class="">BR<img src="img/logo2.png" alt="Logo" width="40px" height="40px">CKETS</h2>
		</div>
		<form action="guardarrespuestas.php" method="post" class="">
			<?php
				$encuestas = $dbh->prepare("SELECT idp, pregunta,temap FROM pregunta where idt=?");
					$encuestas->execute([$_SESSION['tema']]);
					    $resultado = $encuestas->fetchAll(PDO::FETCH_ASSOC);
					foreach ($resultado as $encuesta) {
			?>
		<div class="list-pregunt text-center">
			<div class="col-md-12 text-center pb-2'">
				<h2><?php echo $encuesta['temap']; ?></h2>
			</div>

				<div class="col-md-12 text-center">
				<div id="cont"></div>
				<?php

					echo "<div class='text-center container animated fadeInRight'>
							<div class=' mb-5 text-center'>
								<h4>{$encuesta['pregunta']}</h4>
							</div>
							<div class='col-sm-12 col-md-12 d-flex justify-content-center form-check-inline'>
						        <div class='form-check'>
						        	<img src='img/feliz.png' id='uno{$encuesta['idp']}' width='55px' height='55px'>
						            <div class='checkbox'>
						                <label for='uno{$encuesta['idp']}' class='form-check-label'>
						                    <span id='checkuno{$encuesta['idp']}'></span><input type='radio' id='uno{$encuesta['idp']}' name='{$encuesta['idp']}' value='1' class='form-check-input uno{$encuesta['idp']}'> Contento
						                </label>
						            </div>
						        </div>

						        <div class='form-check'>
						        	<img src='img/natural.png' id='dos{$encuesta['idp']}' width='55px' height='55px'>
						            <div class='checkbox'>
						                <label for='dos{$encuesta['idp']}' class='form-check-label '>
						                    <span id='checkdos{$encuesta['idp']}'></span><input type='radio' id='dos{$encuesta['idp']}' name='{$encuesta['idp']}' value='2' class='form-check-input dos{$encuesta['idp']}' checked> Normal
						                </label>
						            </div>
						        </div>
						        <div class='form-check'>
						        	<img src='img/molesto.png' id='tre{$encuesta['idp']}' width='55px' height='55px'>
						            <div class='checkbox'>
						                <label for='tre{$encuesta['idp']}' class='form-check-label '>
						                    <span id='checktre{$encuesta['idp']}'></span><input type='radio' id='tres{$encuesta['idp']}' name='{$encuesta['idp']}' value='3' class='form-check-input tre{$encuesta['idp']}'> Descontento
						                </label>
						            </div>
						        </div>
						    </div>
						    <div class='col col-md-12  text-center pt-5'>
							    <input type='button' id='atras' class='btn btn-secondary btn-lg rounded' value='Atras'>
								<input type='button' id='siguiente' class='btn btn-success btn-lg rounded' value='Siguiente'>
							</div>
						</div>";


					?>
				</div>

		</div>
	<?php } ?>
	<div id="final" style="display: none;" class="text-center mt-5 animated bounceIn">
						<h2>FELICITACIONES</h2>
						<h2><?php echo $resul['premio']; ?></h2>
						<div class='col col-md-12  text-center pt-5'>
							<input type='button' id='regresar' class='btn btn-secondary btn-lg rounded' value='Regresar'>
							<input type='submit' id='guardar' class='btn btn-success btn-lg rounded' value='FINALIZAR'>
						</div>
					</div>
	</form>
	</main>
		<script type="text/javascript">
		function inicio(){
		for (var i = 0; i <= document.querySelectorAll('.list-pregunt').length-1; i++) {
			document.querySelectorAll('.list-pregunt')[i].setAttribute("id", i);
			document.querySelectorAll('.list-pregunt')[i].style.display='none';
		 	if (i==0) {
		 		document.querySelectorAll('.list-pregunt')[i].style.display='block';
		 		document.querySelectorAll("#atras")[i].setAttribute("disabled", "disabled");
		 		document.querySelectorAll("#siguiente")[i].addEventListener("click",siguiente);

		 	}else if(i==(document.querySelectorAll('.list-pregunt').length-1)){
		 		document.querySelectorAll('.list-pregunt')[i].style.display='none';
		 		document.querySelectorAll("#atras")[i].addEventListener("click",atras);
		 		document.querySelectorAll("#siguiente")[i].addEventListener("click",ultimo);
		 	}else{
		 		document.querySelectorAll('.list-pregunt')[i].style.display='none';
		 		document.querySelectorAll("#atras")[i].addEventListener("click",atras);
		 		document.querySelectorAll("#siguiente")[i].addEventListener("click",siguiente);
		 	}
		 	document.querySelectorAll(".list-pregunt")[i].addEventListener("click",select);
			document.querySelectorAll('#cont')[i].innerHTML = (i+1)+" de "+document.querySelectorAll('.list-pregunt').length;

		 }

		 document.getElementById("final").style.display="none";
}
inicio();
document.getElementById("regresar").addEventListener("click",inicio);

		function select(e){
			if (document.querySelector("."+e.target.id+"[type=radio]")) {
				document.querySelector("."+e.target.id+"[type=radio]").click();
			}
		 };

		 function siguiente(e){
		 	console.log(e.target.parentElement.parentElement.parentElement.parentElement);
		 	e.target.parentElement.parentElement.parentElement.parentElement.style.display="none";
		 	var id = e.target.parentElement.parentElement.parentElement.parentElement.id;
		 	var sigui = parseInt(id) +1;

		 	document.querySelectorAll(".list-pregunt")[sigui].style.display="block";
		 	document.querySelector('#cont').innerHTML = (sigui+1)+" de "+document.querySelectorAll('.list-pregunt').length;
		 };
		 function ultimo(e){
		 	e.target.parentElement.parentElement.parentElement.parentElement.style.display="none";
		 	document.getElementById("final").style.display="block";
		 	document.querySelector('#cont').innerHTML = "<i class='fa fa-check fa-5x'></i>";
		 }
		 function atras(e){
		 	e.target.parentElement.parentElement.parentElement.parentElement.style.display="none";
		 	var id = e.target.parentElement.parentElement.parentElement.parentElement.id;
		 	var sigui = parseInt(id) -1;
		 	document.querySelectorAll(".list-pregunt")[sigui].style.display="block";
		 	document.querySelector('#cont').innerHTML = (sigui+1)+" de "+document.querySelectorAll('.list-pregunt').length;
		 };
		</script>

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