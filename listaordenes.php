<?php
require 'db.php';
if(isset($_REQUEST['action']))
{
	//cerrar la orden
	$sql="update ordenservicio set estado='CERRADO',fechafin=GETDATE(),cerro=".$_SESSION['idusuario']." where idorden=".$_REQUEST['id'];
	  $stmt = sqlsrv_query( $conn, $sql );
	  header("Location: imprimirorden.php?id=".$_REQUEST['id']);
}

include 'vistas/listaordenes.tpl.php';
?>

