<?php
require 'db.php';
//require_once('email.php');
//16680
if(isset($_REQUEST['id'])){$idorden=$_REQUEST['id'];}
if (isset($_POST['motivocierre']))
{
	$idorden=$_POST['idorden'];
	$total=$_POST['total'];
	$motivocierre=$_POST['motivocierre'];
	//procodigo
	$items=$_POST['procodigo'];
	$codigoarray=array();
	foreach($items as $aux)
	{
		array_push($codigoarray,$aux);
	}
	
	//prodescripcion
	$nombres=$_POST['prodescripcion'];
	$nombrearray=array();
	foreach($nombres as $aux)
	{
		array_push($nombrearray,$aux);
	}
	
	//precios
	$precios=$_POST['pu'];
	$precioarray=array();
	foreach($precios as $aux)
	{
		array_push($precioarray,$aux);
	}
	
	//cantidad
	$cants=$_POST['cant'];
	$cantarray=array();
	foreach($cants as $aux)
	{
		array_push($cantarray,$aux);
	}

	//guardar datos de la orden primero
	$sql = "update ordenservicio set motivocierre='".$motivocierre."',total='".$total."',estado='CERRADA',fechafin=GETDATE(),cerro=".$_SESSION['idusuario']." where idorden=".$idorden;
$stmt = sqlsrv_query( $conn, $sql );
//borrar detalle
	$sql = "delete from detalleoservicio where idorden=".$idorden;
$stmt = sqlsrv_query( $conn, $sql );
//insertar nuevos datos del detalle
$i=0;
foreach($codigoarray as $key)
{
$sql = "insert into detalleoservicio (idorden,idproducto,prodescripcion,cantidad,preciounitario,preciototal,esgarantia) values(".$idorden.",".$key.",'".$nombrearray[$i]."','".$cantarray[$i]."','".$precioarray[$i]."','".($precioarray[$i]*$cantarray[$i])."',0)";
$stmt = sqlsrv_query( $conn, $sql );
$i++;
}

$sql = "select * from ordenservicio where idorden=".$idorden;

$stmt = sqlsrv_query( $conn, $sql );
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
	$esgarantia=$row["garantia"];
}

//si cerro en cero, traer producto por defecto
if(($total==0)&&($esgarantia==0))
{
	$sql = "select ProDescripcion,productolista.Importe  from productos inner join ProductoLista on productolista.IdProducto =productos.procodigo where ProCodigo=10220 and IdLista=1";

$stmt = sqlsrv_query( $conn, $sql );
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
	$prodescripcionCero=$row["ProDescripcion"];
	$proprecioCero=$row['Importe'];
}
$sql = "insert into detalleoservicio (idorden,idproducto,prodescripcion,cantidad,preciounitario,preciototal,esgarantia) values(".$idorden.",10220,'".$prodescripcionCero."','1','".$proprecioCero."','".$proprecioCero."',0)";
$stmt = sqlsrv_query( $conn, $sql );
$sql = "update ordenservicio set total='".$proprecioCero."' where idorden=".$idorden;
$stmt = sqlsrv_query( $conn, $sql );
}

//enviar mail
$razonsocial="";$email="";
$sql = "SELECT clientes.clirazonsocial,clientes.cliemail from ordenservicio inner join clientes on clientes.clicodigo=ordenservicio.idcliente where idorden=".$idorden;
echo $sql;
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
	$razonsocial=$row["clirazonsocial"];
	$email=$row['cliemail'];
}
///sendMail($email,$razonsocial,"Orden de Servicio ".$idorden,"<h3>Hola <strong>".$razonsocial."</strong></h3><p>Hemos finalizado la revision/reparacion de su equipo. Tiene un costo de $".$total."</p><p>Puede retirarlo por nuestro local de Santiago del Estero 414, de lunes a viernes de 09:00 a 13:00 y de 17:00 a 21:00, y sabados de 09:00 a 13:00.</p><p></p><p>RyR Computacion</p><p><a href='http://ryrcomputacion.com' target='_blank'>www.ryrcomputacion.com</a></p>");

header("Location: imprimirorden.php?id=".$idorden);	
}
include 'vistas/cerrarorden.tpl.php';
?>