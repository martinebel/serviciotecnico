<?php
require("db.php");

$name=$_REQUEST["documento"];

  $resultado=array();


	$query="select * from vendedores where documento= '".$name."'";
 $stmt = sqlsrv_query( $conn, $query );
 while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {

   array_push($resultado,array(
     "codigo"=>$row["VendCodigo"],
     "nombre"=>mb_convert_encoding($row["VendNombre"], 'UTF-8', 'UTF-8')
   ));

     }

  echo json_encode($resultado);
  exit();

   ?>
