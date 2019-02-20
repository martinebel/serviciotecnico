<?php
//require 'db.php';
$idorden=$_REQUEST['id'];
$nombre=$_REQUEST['nombre'];
pclose(popen('start /b C:\\Sistema\\ZPLPrinter2.exe '.$idorden.' "'.$nombre.'"','r'));
//pclose(popen('start /b C:\\Sistema\\PublicacionesEspeciales.exe','r'));
echo "<script>window.close();</script>";
?>