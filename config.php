<?php
require 'db.php';
if(isset($_POST['textoapertura']))
{
	$sql="update turnero set pieservicio='".$_POST['textoapertura']."',textocierre1='".$_POST['textocierre1']."',textocierre2='".$_POST['textocierre2']."'";
	$stmt = sqlsrv_query( $conn, $sql );
	echo '<div class="alert alert-success" role="alert">
  <strong>El contenido se ha guardado.</strong>
</div>';
}
include 'vistas/config.tpl.php';
?>