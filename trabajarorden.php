<?php
require 'db.php';

if(isset($_REQUEST["action"]))
{
		$idorden=$_REQUEST['idorden'];
		$motivoespera=$_REQUEST['motivo'];
	if($_REQUEST["action"]=="entrarespera")
	{
		$sql = "update ordenservicio set estado='EN ESPERA' where idorden=".$idorden;
		$stmt = sqlsrv_query( $conn, $sql );
		$sql = "insert into bitacoraOrdenes (idorden,fecha,informe,idvendedor) values(".$idorden.",GETDATE(),'EN ESPERA: ".$motivoespera."',".$_SESSION['idusuario'].")";
		$stmt = sqlsrv_query( $conn, $sql );
	}
	else {
		$sql = "update ordenservicio set estado='TRABAJANDO' where idorden=".$idorden;
		$stmt = sqlsrv_query( $conn, $sql );
		$sql = "insert into bitacoraOrdenes (idorden,fecha,informe,idvendedor) values(".$idorden.",GETDATE(),'SALE DE ESPERA: ".$motivoespera."',".$_SESSION['idusuario'].")";
		$stmt = sqlsrv_query( $conn, $sql );
	}
header('Location: listaordenes.php?v=1&t=2');exit();
}


if (isset($_POST['motivocierre']))
{

	$idorden=$_POST['idorden'];
	//borrar detalle
	$sql = "delete from detalleoservicio where idorden=".$idorden;
$stmt = sqlsrv_query( $conn, $sql );
	$motivocierre=$_POST['motivocierre'];

	//guardar datos de la orden primero
	$sql = "update ordenservicio set estado='TRABAJANDO' where idorden=".$idorden;
$stmt = sqlsrv_query( $conn, $sql );
if(trim($motivocierre)!=""){
$sql = "insert into bitacoraOrdenes (idorden,fecha,informe,idvendedor) values(".$idorden.",GETDATE(),'".$motivocierre."',".$_SESSION['idusuario'].")";
$stmt = sqlsrv_query( $conn, $sql );
}
//header("Location: inicio.php");
}
//vamos con los productos
if (isset($_POST['procodigo']))
{

	$idorden=$_POST['idorden'];
	$total=$_POST['total'];
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


//insertar nuevos datos del detalle
$i=0;
foreach($codigoarray as $key)
{
$sql = "insert into detalleoservicio (idorden,idproducto,prodescripcion,cantidad,preciounitario,preciototal,esgarantia) values(".$idorden.",".$key.",'".$nombrearray[$i]."','".$cantarray[$i]."','".$precioarray[$i]."','".($precioarray[$i]*$cantarray[$i])."',0)";
$stmt = sqlsrv_query( $conn, $sql );
$i++;
}
}
if (isset($_POST['idorden'])){header('Location: listaordenes.php?v=1&t=2');exit();}
if (isset($_REQUEST['id'])){$idorden=$_REQUEST['id'];include 'vistas/trabajarorden.tpl.php';}

?>
