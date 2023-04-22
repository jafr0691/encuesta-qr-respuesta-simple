<?php
include_once "./src/db.php";
if (isset($_GET['tema'])) {

    $encuepr = $dbh->prepare("SELECT idp FROM pregunta where idt = ?");
    $encuepr->execute([$_GET['tema']]);
    $resultpr = $encuepr->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultpr as $respuesta) {
    	$deletr = $dbh->prepare("DELETE FROM respuesta where idp=:idp");
    	$deletr->execute([':idp' => $respuesta['idp']]);
    }

    $deletp = $dbh->prepare("DELETE FROM pregunta where idt=:idt");
    $deletp->execute([':idt' => $_GET['tema']]);



    $encuect = $dbh->prepare("SELECT ctidc FROM clientetema where ctidt = ?");
    $encuect->execute([$_GET['tema']]);
    $resultct = $encuect->fetchAll(PDO::FETCH_ASSOC);
    foreach ($resultct as $respuestact) {
    	$clientes = $dbh->prepare("SELECT count(*) FROM clientetema where ctidc = ?");
		$clientes->execute([$respuestact['ctidc']]);
		$numer = $clientes->fetchColumn();
		if($numer<=1){
			$delec = $dbh->prepare("DELETE FROM cliente where idc=:idc");
    		$delec->execute([':idc' => $respuestact['ctidc']]);
		}
    }

    $deletct = $dbh->prepare("DELETE FROM clientetema where ctidt=:idct");
    $deletct->execute([':idct' => $_GET['tema']]);

    $delett = $dbh->prepare("DELETE FROM tema where idt=:idt");
    $delett->execute([':idt' => $_GET['tema']]);

    echo "Eliminado todo el tema ".$_GET['tema'];

} else {
    header("Location: ./index.php");
}
