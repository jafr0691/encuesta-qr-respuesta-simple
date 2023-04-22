<?php
session_start();
include_once "./heade.php";
if (isset($_GET['tema'])) {
    $encuestas = $dbh->prepare("SELECT nombre,descripcion,premio FROM tema where idt=?");
    $encuestas->execute([$_GET['tema']]);
    $tema = $encuestas->fetch(PDO::FETCH_ASSOC);
}
include_once "./left-panel.php";
$felizt   = 0;
$naturalt = 0;
$molestot = 0;
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
                $felizt++;
            } else if ($respuesta['respuesta'] == 2) {
                $naturalt++;
            } else if ($respuesta['respuesta'] == 3) {
                $molestot++;
            }

        }
    }
}
$clientes = $dbh->prepare("SELECT count(*) FROM clientetema where ctidt = ?");
$clientes->execute([$_GET['tema']]);
$numer = $clientes->fetchColumn();
?>

<div class="content mt-3">
	<div class="animated fadeIn">
		<div class="row">

			<div class="col-md-12">
				<div class="card">
					<div class="card-header">
						<div class="row">
							<div class="col-sm-12 col-md-6 mb-3"><h2 class="left">Encuestas <a href="./excel.php?tema=<?php echo $_GET['tema']; ?>" class="btn btn-primary btn-sm rounded" target="_black">Excel <i class="fa fa-download"></i></a></h2></div>

							<div class="col-sm-12 col-md-6"><a href="nuevaencuesta.php" class="btn btn-primary btn-lg float-right rounded">Nueva Encuesta <i class="fa fa-file-text-o"></i></a></div>

						</div>
					</div>
					<div class="card-body">
						<table id="bootstrap-data-table-export" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
									<td colspan="5">
										<?php echo "Nombre de Encuesta: <strong>" . $tema['nombre'] . "</strong>"; ?>
									</td>
								</tr>
								<tr>
									<td colspan="5">
										<?php echo "Descripcion: <strong>" . $tema['descripcion'] . "</strong>"; ?>
									</td>
								</tr>
								<tr>
									<td colspan="5">
										<?php echo "Premio: <strong>" . $tema['premio'] . "</strong>"; ?>
									</td>
								</tr>
								<tr>
									<td colspan="5">
										<?php echo "Clientes que participaron: <strong>" . $numer . "</strong>";?>
									</td>
								</tr>
								<tr>
									<th style="width: 35%">Tema:</th>
									<th style="width: 35%">Preguntas:</th>
									<th style="width: 10%">
										<img src="img/feliz.png" width="40px" title="Contento" alt="Contento">
										<span class="badge-success badge badge-left"><?php echo $felizt; ?></span>
									</th>
									<th style="width: 10%">
										<img src="img/natural.png" width="40px" title="Normal" alt="Normal">
										<span class='badge-warning badge badge-left'><?php echo $naturalt; ?></span>
									</th>
									<th style="width: 15%">
										<img src="img/molesto.png" width="41px" title="Descontento" alt="Descontento">
										<span class='badge-danger badge badge-left'><?php echo $molestot; ?></span>
									</th>
								</tr>
									</thead>
									<tbody>
										<?php
$feliz   = 0;
$natural = 0;
$molesto = 0;
if (isset($_GET['tema'])) {
    $encuestas = $dbh->prepare("SELECT idp, pregunta,temap FROM pregunta where idt = ?");
    $encuestas->execute([$_GET['tema']]);
    $resul = $encuestas->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resul as $pregunta) {
        echo "<tr class=''><td>{$pregunta['temap']}</td>";
        echo "<td>{$pregunta['pregunta']}</td>";
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
            //style='width:15%'

        }
        echo "<td>";
        if ($feliz > 0) {
            echo "<span class='badge-success badge badge-right rounded-circle fa-lg'>{$feliz}</span>";
        } else {
            echo "<span class='badge-secondary badge badge-right rounded-circle fa-lg'>{$feliz}</span></td>";
        }

        echo "<td>";
        if ($natural > 0) {
            echo "<span class='badge-warning badge badge-right rounded-circle fa-lg'>{$natural}</span>";
        } else {
            echo "<span class='badge-secondary badge badge-right rounded-circle fa-lg'>{$natural}</span></td>";
        }

        echo "<td>";
        if ($molesto > 0) {
            echo "<span class='badge-danger badge badge-right rounded-circle fa-lg'>{$molesto}</span>";
        } else {
            echo "<span class='badge-secondary badge badge-right rounded-circle fa-lg'>{$molesto}</span>";
        }

        echo "</td></tr>";
        $feliz   = 0;
        $natural = 0;
        $molesto = 0;
    }
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

		<?php
include_once "./footer.php";
?>