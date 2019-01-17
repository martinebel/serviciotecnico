<?php
	if ( ! session_id() ) @ session_start();
$serverName = "localhost"; //serverName\instanceName
$connectionInfo = array( "Database"=>"pruebaryr", "UID"=>"ryr", "PWD"=>"password");
$conn = sqlsrv_connect( $serverName, $connectionInfo);

if( $conn ) {
    // echo "Conexión establecida.<br />";
}else{
     echo "Conexión no se pudo establecer.<br />";
     die( print_r( sqlsrv_errors(), true));
}
$idSucursal="";
$nombreSucursal="";
$sql = "SELECT * from sucursales where activa=1";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      $idSucursal= $row['IdSucursal'];
	  $nombreSucursal=$row['Nombre'];
}

sqlsrv_free_stmt( $stmt);
?>
