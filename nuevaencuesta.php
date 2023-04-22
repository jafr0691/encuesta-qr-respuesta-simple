<?php
session_start();
include_once "./heade.php";
include_once "./left-panel.php";
$encuestas = $dbh->prepare("SELECT nombre FROM temaPregunta");
$encuestas->execute();
$resul = $encuestas->fetchAll(PDO::FETCH_ASSOC);
?>
<div class="content mt-3 text-white text-center">
	<div class="animated fadeIn">
		<div class="row">
			<form action="crearencuesta.php" method="post">
				<div class="row mb-5">

					<div class="col-md-6 col-sm-12">
						<h2 >NUEVA ENCUESTA</h2>
					</div>
					<div class="col-md-6 col-sm-12 pl-3 pr-3 form-group">
						<div class="col-sm-12 col-md-12 text-left"><label for="nombre" class=" form-control-label fa-lg">Nombre:</label>
							<input type="text" id="nombre" name="nombre" placeholder="Nombre de la encuesta" class="form-control" required></div>
						</div>
						<div class="offset-md-6 col-md-6 col-sm-12 pl-3 pr-3 form-group">
							<div class="col-sm-12 col-md-12 text-left"><label for="descri" class=" form-control-label fa-lg">Descripcion:</label><input type="text" id="descri" name="descri" placeholder="Descripcion de la encuesta" class="form-control" required></div>
						</div>
						<div class="offset-md-6 col-md-6 col-sm-12 pl-3 pr-3 form-group">
							<div class="col-sm-12 col-md-12 text-left"><label for="premio" class=" form-control-label fa-lg">Premio:</label><input type="text" id="premio" name="premio" placeholder="Premio de la encuesta" class="form-control" required></div>
						</div>
					</div>
					<div id="preguntas-list" class="col-md-12 col-sm-12 text-center">

						<div class="row pl-3 pr-3 form-group">
							<div class="col-md-4 col-sm-12 pl-3 pr-3 form-group text-left">
								<label for="prregunta" class="form-control-label mb-2 fa-lg">Tema: </label>
								<select name="temap[]" class="custom-select mb-2 text-left">
									<?php foreach ($resul as $temap) {
										echo '<option value="'.$temap['nombre'].'">'.$temap['nombre'].'</option>';
									}?>
								</select>
							</div>
							<div class="col-md-6 col-sm-12 pl-3 pr-3 form-group text-left">
								<label for="prregunta" class="form-control-label mb-2 text-left  fa-lg">Pregunta: </label>
								<input type="text"  placeholder="Ingrese la pregunta" class="mb-2 text-center form-control" name="pregunta[]" required>
							</div>
						</div>
						<div class="row pl-3 pr-3 form-group">
							<div class="col-md-4 col-sm-12 pl-3 pr-3 form-group text-left">
								<label for="prregunta" class="form-control-label mb-2 fa-lg">Tema: </label>
								<select name="temap[]" class="custom-select mb-2 text-left">
									<?php foreach ($resul as $temap) {
										echo '<option value="'.$temap['nombre'].'">'.$temap['nombre'].'</option>';
									}?>
								</select>
							</div>
							<div class="col-md-6 col-sm-12 pl-3 pr-3 form-group text-left">
								<label for="prregunta" class="form-control-label mb-2 text-left  fa-lg">Pregunta: </label>
								<input type="text"  placeholder="Ingrese la pregunta" class="mb-2 text-center form-control" name="pregunta[]" required>
							</div>
						</div>
					</div>
					<div class="col-md-6 offset-md-3 text-center mb-5">
						<input type="button" id="nueva" class="btn btn-secondary btn-md rounded" value="NUEVA PREGUNTA">
						<input type="submit" class="btn btn-success btn-md rounded" value="GUARDAR">
					</div>

				</form>
			</div>


		</div>
	</div><!-- .animated -->
</div><!-- .content -->


<script type="text/javascript">
	var preguntas = document.getElementById("preguntas-list");
	var nueva = document.getElementById("nueva");

	preguntas.addEventListener("click", function(e){
		if (e.target.name === "delet") {
			e.target.parentElement.remove();
		}else if(e.target.id === "delet"){
			e.target.parentElement.parentElement.remove();
		}
	});
	nueva.addEventListener("click", function(){

		const preguntalist = document.getElementById('preguntas-list');
		const element =  document.createElement('div');
		element.innerHTML = `
		<div class="row pl-3 pr-3 form-group">
		<div class="col-md-4 col-sm-12 pl-3 pr-3 form-group text-left">
		<label for="prregunta" class="form-control-label mb-2 fa-lg">Tema: </label>
		<select name="temap[]" class="custom-select mb-2 text-left">
		<?php foreach ($resul as $temap) {
			echo '<option value="'.$temap['nombre'].'">'.$temap['nombre'].'</option>';
		}?>
		</select>
		</div>
		<div class="col-md-6 col-sm-12 pl-3 pr-3 form-group text-left">
		<label for="prregunta" class="form-control-label mb-2 text-left  fa-lg">Pregunta: </label>
		<input type="text"  placeholder="Ingrese la pregunta" class="mb-2 text-center form-control" name="pregunta[]" required>
		</div>
		<a href="#" class="eliminar col-md-2 text-danger text-left my-auto inline" name="delet"><i id="delet" class="rounded-circle bg-secondary border-circle fa fa-trash-o fa-2x"></i></a>
		</div>
		`;
		preguntalist.appendChild(element);
	});
</script>
<?php
include_once "./footer.php";
?>