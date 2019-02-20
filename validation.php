<?php
require 'db.php';
$sql = "SELECT * from vendedores where VendCodigo=".$_POST['usuario'];

$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {

if($row['VendClave']==$_POST['password'])
{

 $_SESSION['idusuario'] = $row['VendCodigo'];
$_SESSION['nombreusuario'] = $row['VendNombre'];
$_SESSION['tipousuario'] = $row['usuario'];
header('Location: listaordenes.php?v=1&t=2');
}
else
{
	header('Location: index.php?e=1&u='.$_POST['usuario']);
}
}

sqlsrv_free_stmt( $stmt);
?>