<?php
if(isset($_REQUEST['idorden'])){
$output = exec('C:\\Sistema\\ZPLPrinter.exe '.$_REQUEST['idorden'].' "'.$_REQUEST['nombre'].'"'); 
}
echo "USO: printer.php?idorden=IDORDEN&nombre=NOMBRECLIENTE";
?>