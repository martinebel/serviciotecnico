<?php

require("db.php");

//busqueda ajax de cliente
if(isset($_REQUEST['term'])) {
$name=$_REQUEST["term"];

$html="";
  $return = array();
    $json = "[";
    $first = true;


if(isset($_REQUEST['tipo']))
{


	$query="SELECT top 50 productos.*,productolista.importe from productos inner join productolista on productolista.idproducto=productos.procodigo where idlista=1 and probaja=0 and procodigo= ".$name."";
 $stmt = sqlsrv_query( $conn, $query );
if( $stmt === false) {
   $query="SELECT top 50 productos.*,productolista.importe from productos inner join productolista on productolista.idproducto=productos.procodigo where idlista=1 and probaja=0 and prodescripcion like '".$name."%' order by prodescripcion asc";
 $stmt = sqlsrv_query( $conn, $query );
 while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {



      if(!$first){
            $json .=  ",";
        }else{
            $first = false;
        }

          $json .= '{"id":"'.$row['ProCodigo'].'","label":"['.$row['ProCodigo'].'] '.str_replace('"','',$row['ProDescripcion']).'","value":"'.str_replace('"','',$row['ProDescripcion']).'","precio":"'.str_replace('"','',$row['importe']).'"}';

     }
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {



      if(!$first){
            $json .=  ",";
        }else{
            $first = false;
        }

         $json .= '{"id":"'.$row['ProCodigo'].'","label":"['.$row['ProCodigo'].'] '.str_replace('"','',$row['ProDescripcion']).'","value":"'.str_replace('"','',$row['ProDescripcion']).'","precio":"'.str_replace('"','',$row['importe']).'"}';

     }
	     $json .= "]";

    echo $json;
	exit();
}




$query="SELECT top 10 * from clientes where clirazonsocial like '%".utf8_decode(trim($name))."%'";

 $stmt = sqlsrv_query( $conn, $query );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {



      if(!$first){
            $json .=  ",";
        }else{
            $first = false;
        }

        $json .= '{"id":"'.$row['CliCodigo'].'","label":"['.$row['CliCodigo'].'] '.utf8_encode(trim($row['CliRazonSocial'])).'","value":"['.$row['CliCodigo'].'] '.utf8_encode(trim($row['CliRazonSocial'])).'"}';

     }


    $json .= "]";
header('Content-Type: application/json; charset=utf-8');
    echo $json;

}

if(isset($_REQUEST['factura']))
{
  $html="";
  $return = array();
    $json = "[";
    $first = true;
  $query="SELECT * from ventas where facid='".$_REQUEST['numero']."' and clicodigo=".$_REQUEST['idcliente'];
  //echo $query;
 $stmt = sqlsrv_query( $conn, $query );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
$rows = sqlsrv_has_rows( $stmt );
if($rows===true)
{
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {



      if(!$first){
            $json .=  ",";
        }else{
            $first = false;
        }

        $json .= '{"msg":"OK"}';

     }
   }
   else
   {
    if(!$first){
            $json .=  ",";
        }else{
            $first = false;
        }

        $json .= '{"msg":"ERROR"}';
   }


    $json .= "]";

    echo $json;
    exit();
}


//consulta de datos de cliente
if(isset($_REQUEST['codigo'])) {
	$html="";
  $return = array();
    $json = "[";
    $first = true;

$query="SELECT * from clientes where clicodigo=".$_REQUEST['codigo']."";
  $stmt = sqlsrv_query( $conn, $query );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}


	$output_array = array();
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
    $output_array[] = array( 'telefono' => $row['CliTelefono'], 'email' => $row['CliEmail'] );
}

echo json_encode( $output_array );
}

if(isset($_REQUEST['nuevo'])) {
		$output_array = array();
	//obtner el siguiente codigo de cliente
$idcliente	=0;
$query="SELECT max(clicodigo) as 'maximo' from clientes";
  $stmt = sqlsrv_query( $conn, $query );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   $idcliente=$row["maximo"];
}
//incrementar en 1
$idcliente++;
//guardar el nuevo cliente
$query="INSERT INTO Clientes
           ([CliCodigo]
           ,[CliRazonSocial]
           ,[CliTipoDoc]
           ,[CliNumDoc]
           ,[IvaCodigo]
           ,[CliDireccion]
           ,[CliLocalidad]
           ,[CliProvincia]
           ,[CliCPostal]
           ,[CliTelefono]
           ,[CliEmail]
           ,[CliEstado]
           ,[CliObservaciones]
           ,[CliFechaAlta]
           ,[CliMontoDisponible]
           ,[CliTipoCliente]
           ,[CliActualiza]
           ,[CliCtaDias]
           ,[VendCodigo]
           ,[cli_recargas]
           ,[cli_recargas_toner])
     VALUES
           (".$idcliente."
           ,'".strtoupper(utf8_decode(trim($_REQUEST['nombre'])))."'
           ,'".$_REQUEST['tipodoc']."'
           ,'".$_REQUEST['numdoc']."'
           ,".$_REQUEST['clitipo']."
           ,'".$_REQUEST['direccion']."'
           ,'".$_REQUEST['localidad']."'
           ,'".$_REQUEST['provincia']."'
           ,' '
           ,'".$_REQUEST['telefono']."'
           ,'".$_REQUEST['email']."'
           ,1
           ,' '
           ,'".date('Y-m-d h:i:s')."'
           ,0
           ,'MINORISTAS'
           ,1
           ,0
           ,1
           ,0
           ,0)";
		   //echo $query;
  $stmt = sqlsrv_query( $conn, $query );
//insertar en la tabla de listas de precio
$query="insert into clientelista (clicodigo,idlista) values (".$idcliente.",1)";
  $stmt = sqlsrv_query( $conn, $query );
  $query="insert into clientelista (clicodigo,idlista) values (".$idcliente.",12)";
  $stmt = sqlsrv_query( $conn, $query );
  //$query="insert into clientelista (clicodigo,idlista) values (".$idcliente.",8)";
  //$stmt = sqlsrv_query( $conn, $query );
  //devolver los datos en AJAX
   $output_array[] = array( 'codigo' => $idcliente, 'telefono' => $_REQUEST['telefono'], 'email' => $_REQUEST['email'], 'nombre' => $_REQUEST['nombre'] );
   echo json_encode( $output_array );
}


if(isset($_REQUEST['buscarorden'])) {
		$output_array = array();
	//obtner el siguiente codigo de cliente
$idorden	=0;
$query="SELECT * from ordenservicio where idorden=".$_REQUEST['buscarorden']." and (estado='ABIERTO' or estado='TRABAJANDO')";
  $stmt = sqlsrv_query( $conn, $query );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   $idorden=$row["idorden"];
}
 $output_array[] = array( 'codigo' => $idorden );
   echo json_encode( $output_array );
}


?>
