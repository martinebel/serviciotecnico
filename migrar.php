<?php
require 'db.php';
 $sql = "select  OrdenServicioOLD.*,equipos.numeroserie,equipos.tipo,equipos.idcliente from OrdenServicioOLD inner join equipos on equipos.idequipo = OrdenServicioOLD.idequipo where estado='ABIERTO'";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
	 $sql2 = "INSERT INTO OrdenServicio
           ([idorden],[idcliente]
           ,[fechaingreso]
           ,[motivoingreso]
           ,[tipo]
           ,[marca]
           ,[serie]
           ,[prioridad]
           ,[hacerbackup]
           ,[cargador]
           ,[recibio]
           ,[fechafin]
           ,[motivocierre]
           ,[cerro]
           ,[total]
           ,[estado]
           ,[fechaaprox])
     VALUES
           (".$row["idorden"].",".$row["idcliente"]."
           ,'".date_format($row["fechaingreso"],'Y-m-d')."'
           ,'".$row["motivoingreso"]."'
           ,'".$row["tipo"]."'
           ,''
           ,'".$row["numeroserie"]."'
           ,'3'
           ,'".$row["hacerbackup"]."'
           ,'".$row["cargador"]."'
           ,'".$row["recibio"]."'
           ,NULL
           ,'".$row["estadocierre"]."'
           ,'".$row["cerro"]."'
           ,'".$row["total"]."'
           ,'ABIERTA'
           ,'".calcular_fecha()."');";
$stmt2 = sqlsrv_query( $conn, $sql2 );
echo $sql2;
}

function calcular_fecha()
{
	$fechaaprox = new DateTime();
$fechaaprox->modify('+3 day');
	 $weekday = date_format($fechaaprox, 'l');
$normalized_weekday = strtolower($weekday);
if ($normalized_weekday == "saturday") {
   $fechaaprox->modify('+2 day');
}
if ($normalized_weekday == "sunday") {
   $fechaaprox->modify('+1 day');
}
return date_format($fechaaprox,'Y-m-d');
}
?>