<?php
require 'db.php';
//require_once('email.php');

if (isset($_POST['action']))
{
	echo "Se esta guardando la orden. Por favor no actualice esta pagina ni use los botones para ir hacia atras. Puede demorar algunos segundos, por favor, espere.";
	$idcliente=$_POST['idcliente'];
	$telefono=$_POST['telefono'];
	$email=$_POST['email'];
	$motivoingreso=$_POST['motivoingreso'];
	$tipo=$_POST['tipo'];
	$marca=$_POST['marca'];
	$serie=$_POST['serie'];
	$prioridad=$_POST['prioridad'];
	$fecha=date('Y-m-d h:i:s');
	if(isset($_POST['backup']))
	{$backup="1";}else{$backup="0";}
	//calcular fecha aprox
	$fechaaprox = new DateTime();
	if($prioridad=="1"){$fechaaprox->modify('+1 day');}
	if($prioridad=="2"){$fechaaprox->modify('+2 day');}
	if($prioridad=="3"){$fechaaprox->modify('+3 day');}
	 $weekday = date_format($fechaaprox, 'l');
$normalized_weekday = strtolower($weekday);
if ($normalized_weekday == "saturday") {
   $fechaaprox->modify('+2 day');
}
if ($normalized_weekday == "sunday") {
   $fechaaprox->modify('+1 day');
}

if(isset($_POST['cargador']))
	{$cargador="1";}else{$cargador="0";}

if(isset($_POST['garantia']))
	{$garantia="1";}else{$garantia="0";}

//re-guardar los datos del cliente
$sql="update clientes set clitelefono='".$telefono."',cliemail='".$email."' where clicodigo=".$idcliente;
sqlsrv_query($conn, $sql); 


	//guardar orden de servicio
$sql = "insert into ordenservicio (idcliente,fechaingreso,motivoingreso,tipo,marca,serie,prioridad,hacerbackup,cargador,recibio,fechafin,motivocierre,cerro,total,estado,fechaaprox,garantia) 
		VALUES (".$idcliente.",GETDATE(),'".$motivoingreso."','".$tipo."','".$marca."','".$serie."','".$prioridad."',".$backup.",".$cargador.",".$_SESSION['idusuario'].",NULL,'',NULL,0,'ABIERTO','".date_format($fechaaprox, 'Y-m-d')."',".$garantia."); SELECT SCOPE_IDENTITY()";
$resource=sqlsrv_query($conn, $sql, $arrParams); 
if( $resource === false) {
    die( print_r( sqlsrv_errors(), true) );
}
else{
	
sqlsrv_next_result($resource); 
sqlsrv_fetch($resource); 
$idorden=sqlsrv_get_field($resource, 0);
$razonsocial="";
$sql = "SELECT * from clientes where clicodigo=".$idcliente;
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
	$razonsocial=$row["CliRazonSocial"];
}
//enviar mail

//sendMail($email,$razonsocial,"Orden de Servicio ".$idorden,"<h3>Hola <strong>".$razonsocial."</strong></h3><p>Hemos recibido su equipo con la <strong>Orden de Servicio n°".$idorden.". </strong></p><p>Nuestro servicio técnico se comunicará con usted tan pronto como sea posible.</p><p></p><p>RyR Computacion</p><p><a href='http://ryrcomputacion.com' target='_blank'>www.ryrcomputacion.com</a></p>");
//imprimir etiquetas y luego ir a la impresion de la orden
//$output = exec('C:\\Sistema\\ZPLPrinter.exe '.$idorden.' "'.$razonsocial.'"'); 
pclose(popen('start /b C:\\Sistema\\ZPLPrinter2.exe '.$idorden.' "'.$razonsocial.'"','r'));

	header("Location: imprimirorden.php?id=".$idorden);
}
}
include 'vistas/abrirordenservicio.tpl.php';
?>