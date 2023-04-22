<?php
session_start();
include_once "./heade.php";
include_once "./left-panel.php";
?>


<div class="content mt-3">
	<div class="animated fadeIn">
		<div class="row">

			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col-sm-12 col-md-6 mb-3"><h2 class="left">Encuestas</h2></div>

							<div class="col-sm-12 col-md-6"><a href="nuevaencuesta.php" class="btn btn-primary btn-lg float-right rounded">Nueva Encuesta <i class="fa fa-file-text-o"></i></a></div>

						</div>
					</div>
					<div class="card-body">
						<table id="bootstrap-data-table-export" class="table table-striped table-bordered table-responsive">
							<thead>
								<tr>
									<th style='width:70%'>Nombre</th>
									<th style='width:5%'>Fecha</th>
									<th style='width:5%'>Ver</th>
									<th style='width:5%'>QR</th>
									<th style='width:5%'>Url</th>
									<th style='width:5%'>Editar</th>
									<th style='width:5%'>Eliminar</th>
								</tr>
							</thead>
							<tbody>
								<?php
								$encuestas = $dbh->prepare("SELECT * FROM tema");
								$encuestas->execute();
								$resultado = $encuestas->fetchAll(PDO::FETCH_ASSOC);
								foreach ($resultado as $encuesta) {
									echo "<tr id='list-encuestas'>
									<td>{$encuesta['nombre']}</td>
									<td>{$encuesta['fecha']}</td>
									<td>";
									$clientes = $dbh->prepare("SELECT count(*) FROM clientetema where ctidt = ?");
									$clientes->execute([$encuesta['idt']]);
									$numer = $clientes->fetchColumn();
									echo "<a href='ver.php?tema={$encuesta['idt']}'>
										<i class='fa fa-search fa-lg text-primary'></i><span class='badge badge-light'>{$numer}</span></a>
									</td>
									<td>
										<i data-id='{$encuesta['idt']}' data-name='{$encuesta['nombre']}' class='fa fa-qrcode fa-lg btn' id='qr' data-toggle='modal' data-target='#myModal'></i>
									</td>
									<td>
									<a href='encuesta.php?tema={$encuesta['idt']}' target='_blank'><i class='fa fa-share-square-o fa-lg btn text-primary'></i></a>
									</td>
									<td>";
									if($numer==0){
										echo "<a href='editarencuesta.php?tema={$encuesta['idt']}' title='Editar'><i class='text-success fa fa-edit fa-lg btn'></i></a>";
									}else{
										echo "<i class='fa fa-edit fa-lg ml-2 pl-1 text-secondary'></i>";
									}

									echo "</td>
									<td>
									<i data-name='{$encuesta['nombre']}' class='text-danger fa fa-trash-o fa-lg btn delet' data-id='{$encuesta['idt']}' id='delet{$encuesta['idt']}' title='Eliminar' data-toggle='modal' data-target='#myModal'></i></a>
									</td>
									</tr>";
								}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>


		</div>
	</div><!-- .animated -->
</div><!-- .content -->
  <!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
        <div class="modal-header">

          <h4 class="modal-title" id="titlemsj"></h4>
        </div>
        <div class="modal-body text-center" id="imp1">
          <p id="mensaje"></p>
        </div>
        <div class="modal-footer">
        	<button type="button" class="close mr-5" data-dismiss="modal">Cerrar</button>
          	<div id="btnmodal"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<dir id="resultqr">

</dir>
	<script>
		for (var i = 0; i <= document.querySelectorAll('#list-encuestas').length-1; i++) {
			document.querySelectorAll(".delet")[i].addEventListener("click",msjdelet);
			document.querySelectorAll("#qr")[i].addEventListener("click",codigo);
		}


		function codigo(e){
			var tema = e.target.getAttribute('data-id');
			var url = document.location.origin+"/encuesta.php?tema="+tema;
			var xhttp = new XMLHttpRequest();
			  xhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			    	var tema = e.target.getAttribute('data-id');
			    	var nombre = e.target.getAttribute('data-name');
			    	document.getElementById('titlemsj').innerHTML = nombre;
			      document.getElementById('mensaje').innerHTML = '<img src="'+this.responseText+'">';
			      document.getElementById('btnmodal').innerHTML = '<a href="'+this.responseText+'" class="btn btn-primary mr-1 ml-1 mr-5 rounded" download="'+nombre+'.jpg">Descargar <i class="fa fa-floppy-o"></i></a><button type="button" class="btn btn-secondary float-right rounded" id="btnqr" data-dismiss="modal" data-id="'+tema+'">Imprimir <i class="fa fa-print"></i></button>';
			      document.getElementById('btnqr').addEventListener("click", imprim1);
			    }
			  };
			  xhttp.open("GET", "./qr.php?urlqr="+url, true);
			  xhttp.send();
		}


		function imprim1(){

			var printContents = document.getElementById('imp1').innerHTML;
	        w = window.open();
	        w.document.write(printContents);
	        w.document.close(); // necessary for IE >= 10
	        w.focus(); // necessary for IE >= 10
			w.print();
			w.close();
	        return true;
    	}

		function msjdelet(e){
			var nombre = e.target.getAttribute('data-name');
			var tema = e.target.getAttribute('data-id');
			document.getElementById('titlemsj').innerHTML = nombre;
			document.getElementById('mensaje').innerHTML = 'Desea eliminar la encuesta?';
			document.getElementById('btnmodal').innerHTML = '<button type="button" class="btn btn-default rounded" id="btndelet" data-dismiss="modal" data-id="'+tema+'">Eliminar <i class="text-danger fa fa-trash-o"></i></button>';
			document.getElementById('btndelet').addEventListener("click", delet);

		}

		function delet(e){
			var id = document.getElementById('btndelet').getAttribute('data-id');
			var xhttp = new XMLHttpRequest();
			  xhttp.onreadystatechange = function() {
			    if (this.readyState == 4 && this.status == 200) {
			      document.getElementById('delet'+id).parentElement.parentElement.remove();
			    }
			  };
			  xhttp.open("GET", "./deletencuesta.php?tema="+id, true);
			  xhttp.send();
		}

	</script>

<?php
include_once "./footer.php";
?>
</html>