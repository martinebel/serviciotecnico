<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Servicio Tecnico</title> 
 <!-- Bootstrap Core CSS -->
    <link href="css/printer.css" rel="stylesheet">
</head>
<body>
<?php
$Sdireccion="";$Stelefono="";
$sql = "SELECT * from sucursales where idsucursal=".$idSucursal;
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
	//datos sucursal
	$Sdireccion=$row['direccion'].', '.$row['localidad'].', '.$row['Provincia'];
	$Stelefono=$row['Telefono'];
}



//obtener texto de pie de pagina
$sql = "SELECT * from turnero";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
	//datos sucursal
	$pieAbierto=$row['pieservicio'];
	$pieCerradoConCosto=$row['textocierre1'];
	$pieCerradoSinCosto=$row['textocierre2'];
}
?>
<a id="btn1" href="inicio.php">Ir al Inicio</a>
<a id="btn2" href="#" onclick="impresion();">Imprimir</a>
<div class="book">
<div class="page">
<div class="subpage">
<div style="height:138mm;border: 1px solid;position:relative;">
<div class="row" style="height:20%;overflow:hidden;padding-top:5px">
<div class="col-md-2">
<img src="img/logo.png" style="width:70px;">
</div>
<div class="col-md-6">
<p><strong>RYR COMPUTACION</strong></p>
<p style="font-size:10px"><?php echo $Sdireccion;?></p>
<p style="font-size:10px"><?php echo $Stelefono;?></p>
<?php
if($idSucursal=="1")
{
	echo '<p style="font-size:10px">WhatsApp 362-4661814</p>';
}
?>
<p style="font-size:10px">www.ryrcomputacion.com</p>
</div>
<?php
$sql = "SELECT ordenservicio.*,clientes.clirazonsocial,clientes.clitelefono,clientes.clidireccion,clientes.cliprovincia,clientes.clilocalidad,clientes.cliemail,a1.vendnombre vrecibio,a2.vendnombre vcerro from ordenservicio  inner join clientes on clientes.clicodigo=ordenservicio.idcliente inner join vendedores a1 on a1.vendcodigo=ordenservicio.recibio left join vendedores a2 on a2.vendcodigo=ordenservicio.cerro  where idorden=".$_REQUEST['id'];
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
	//encabezado
	echo '<div class="col-md-4">
	<p><strong>ORDEN DE SERVICIO '.$_REQUEST['id'].'</strong></p>';
	 if($row['estado']=="ABIERTO" || $row['estado']=="TRABAJANDO"){
	echo '<p>INGRESO: '.date_format($row['fechaingreso'],'d-m-Y').'</p>
	<p>F. DE ENTREGA: '.date_format($row['fechaaprox'],'d-m-Y').'</p>
	<p>RECIBIO: '.$row['vrecibio'].'</p>';
	 }else
	{
		echo '<p>INGRESO: '.date_format($row['fechaingreso'],'d-m-Y').'</p>
	<p>FINALIZADO: '.date_format($row['fechafin'],'d-m-Y').'</p>
	<p>CERRO: '.$row['vcerro'].'</p>';
	}
	echo '</div></div><div class="row" style="height:15%;overflow:hidden">';
	 echo '<div class="col-md-7"><p class="titulo">CLIENTE</p><p class="contenido">'.$row['idcliente'].'-'.$row['clirazonsocial'].'</p></div>';
	 echo '<div class="col-md-5"><p class="titulo">TELEFONO</p><p class="contenido">'.$row['clitelefono'].'</p></div>';
	  echo '<div class="col-md-7"><p class="titulo">DIRECCION</p><p class="contenido">'.$row['clidireccion'].' ' .$row['clilocalidad'].' '.$row['cliprovincia'].'</p></div>';
	 echo '<div class="col-md-5"><p class="titulo">EMAIL</p><p class="contenido">'.$row['cliemail'].'</p></div></div>';
	

	
	 if($row['estado']=="ABIERTO" || $row['estado']=="TRABAJANDO"){
		 	
    echo '<div class="row" style="height:38%;overflow:hidden">';
	 echo '<div class="col-md-3"><p class="titulo">EQUIPO</p><p class="contenido">'.$row['marca'].'</p></div>';
echo '<div class="col-md-3"><p class="titulo">SERIE</p><p class="contenido">'.$row['serie'].'</p></div>';
	 echo '<div class="col-md-2"><p class="titulo">TIPO</p><p class="contenido">'.$row['tipo'].'</p></div>';
	 echo '<div class="col-md-2"><p class="titulo">BACKUP</p><p class="contenido">'.($row['hacerbackup']=="1"?'SI':'NO').'</p></div>';
	 echo '<div class="col-md-2"><p class="titulo">CARGADOR</p><p class="contenido">'.($row['cargador']=="1"?'SI':'NO').'</p></div>';
	 echo '<div class="col-md-12"><p class="titulo">DECLARACION DEL CLIENTE</p><p class="contenido">'.$row['motivoingreso'].'</p></div></div>';
echo '<div class="row" style="height:34%;overflow:hidden;margin-top:10px;"><div class="col-md-12" >
<small style="font-size:7px;display:flex;text-align: justify;">
'.$pieAbierto.'</small></div>';
	  echo '<div style="    position: absolute;
    bottom: 0px;
    display: block;
    width: 100%;"><div class="col-md-3"><p class="titulo">FIRMA CLIENTE</p><p class="contenido"><br><br></p></div>';
  echo '<div class="col-md-6"><p style="text-align:center"><br>COPIA CLIENTE<br>Orden de Recepcion</p></div>';
 echo '<div class="col-md-3"><p class="titulo">FIRMA TECNICO</p><p class="contenido"><br><br></p></div></div></div>';
	 }
	 else
	 {
		  echo '<div class="row" style="height:65%;overflow:hidden;">';  
	 echo '<div class="col-md-12" style="height:54%"><p class="titulo">TRABAJO REALIZADO</p><p class="contenido">'.$row['motivocierre'].'</p>';

 ?> <table class="table" style="font-size:10px;width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width:10%;text-align:left;">Cod.</th>
                                            <th style="width:69%;text-align:left;">Descripcion</th>
                                            <th style="width:20%;text-align:right;">P.U.</th>
                                        </tr>
                                    </thead>
                                    <tbody id="grilla">
                                         <?php
										 $contador=0;
										 $total=0;
					   $sql2 = "select * from detalleoservicio where idorden=".$_REQUEST['id'];
$stmt2 = sqlsrv_query( $conn, $sql2 );
if( $stmt2 === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
      echo '<tr>
	 
	  <td style="text-align:left;">
	  <span>'.$row2['idproducto'].'</span></td> 
	  <td style="text-align:left;">
	  <span>'.$row2['prodescripcion'].'</span></td> 
	  <td style="text-align:right;"> <span>'.$row2['preciounitario'].'</span></td> </tr>';
	  }

sqlsrv_free_stmt( $stmt2);
					   ?>
                                    </tbody>
                                </table>
								</div>
								<hr>
								<?php
								echo '<div class="col-md-12" style="text-align:right"><p><strong>TOTAL $'.$row['total'].'</strong></p></div>';
								echo '<div class="row" style="height: 23%;overflow: hidden;    position: relative;"><div class="col-md-12" style="    position: absolute;
    bottom: 3px;">
<small style="font-size:7px;display:flex;text-align: justify;">'.($row["total"]>0?$pieCerradoConCosto:$pieCerradoSinCosto).'</small></div></div>';
		 echo '<div class="row" style="    position: absolute;
    bottom: 0px;
    display: block;
    width: 100%;"><div class="col-md-3"><p class="titulo">FIRMA CLIENTE</p><p class="contenido"><br><br></p></div>';
  echo '<div class="col-md-6"><p style="text-align:center"><br>COPIA CLIENTE<br>Orden de Cierre</p></div>';
 echo '<div class="col-md-3"><p class="titulo">FIRMA TECNICO</p><p class="contenido"><br><br></p></div></div></div>'; 
	 }

}

?>
<br>

</div>
<!--COPIA TECNICO-->
<div style="height:138mm;border: 1px solid;position:relative;">
<div class="row" style="height:20%;overflow:hidden;padding-top:5px">
<div class="col-md-2">
<img src="img/logo.png" style="width:70px;">
</div>
<div class="col-md-6">
<p><strong>RYR COMPUTACION</strong></p>
<p style="font-size:10px"><?php echo $Sdireccion;?></p>
<p style="font-size:10px"><?php echo $Stelefono;?></p>
<p style="font-size:10px">www.ryrcomputacion.com</p>
</div>
<?php
$sql = "SELECT ordenservicio.*,clientes.clirazonsocial,clientes.clitelefono,clientes.clidireccion,clientes.cliprovincia,clientes.clilocalidad,clientes.cliemail,a1.vendnombre vrecibio,a2.vendnombre vcerro from ordenservicio  inner join clientes on clientes.clicodigo=ordenservicio.idcliente inner join vendedores a1 on a1.vendcodigo=ordenservicio.recibio left join vendedores a2 on a2.vendcodigo=ordenservicio.cerro  where idorden=".$_REQUEST['id'];
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
	//encabezado
	echo '<div class="col-md-4">
	<p><strong>ORDEN DE SERVICIO '.$_REQUEST['id'].'</strong></p>';
	 if($row['estado']=="ABIERTO" || $row['estado']=="TRABAJANDO"){
	echo '<p>INGRESO: '.date_format($row['fechaingreso'],'d-m-Y').'</p>
	<p>F. DE ENTREGA: '.date_format($row['fechaaprox'],'d-m-Y').'</p>
	<p>RECIBIO: '.$row['vrecibio'].'</p>';
	 }else
	{
		echo '<p>INGRESO: '.date_format($row['fechaingreso'],'d-m-Y').'</p>
	<p>FINALIZADO: '.date_format($row['fechafin'],'d-m-Y').'</p>
	<p>CERRO: '.$row['vcerro'].'</p>';
	}
	echo '</div></div><div class="row" style="height:20%;overflow:hidden">';
	 echo '<div class="col-md-7"><p class="titulo">CLIENTE</p><p class="contenido">'.$row['idcliente'].'-'.$row['clirazonsocial'].'</p></div>';
	 echo '<div class="col-md-5"><p class="titulo">TELEFONO</p><p class="contenido">'.$row['clitelefono'].'</p></div>';
	  echo '<div class="col-md-7"><p class="titulo">DIRECCION</p><p class="contenido">'.$row['clidireccion'].' ' .$row['clilocalidad'].' '.$row['cliprovincia'].'</p></div>';
	 echo '<div class="col-md-5"><p class="titulo">EMAIL</p><p class="contenido">'.$row['cliemail'].'</p></div></div>';
	
	
    
	
	 if($row['estado']=="ABIERTO" || $row['estado']=="TRABAJANDO"){
		 echo '<div class="row" style="height:26%;overflow:hidden">';
	 echo '<div class="col-md-3"><p class="titulo">EQUIPO</p><p class="contenido">'.$row['marca'].'</p></div>';
echo '<div class="col-md-3"><p class="titulo">SERIE</p><p class="contenido">'.$row['serie'].'</p></div>';
	 echo '<div class="col-md-2"><p class="titulo">TIPO</p><p class="contenido">'.$row['tipo'].'</p></div>';
	 echo '<div class="col-md-2"><p class="titulo">BACKUP</p><p class="contenido">'.($row['hacerbackup']=="1"?'SI':'NO').'</p></div>';
	 echo '<div class="col-md-2"><p class="titulo">CARGADOR</p><p class="contenido">'.($row['cargador']=="1"?'SI':'NO').'</p></div>';
	 echo '<div class="col-md-12"><p class="titulo">DECLARACION DEL CLIENTE</p><p class="contenido">'.$row['motivoingreso'].'</p></div></div>';
echo '<div class="row" style="height:17%;overflow:hidden;margin-top:10px">';
	  echo '<div style="    position: absolute;
    bottom: 0px;
    display: block;
    width: 100%;"><div class="col-md-3"><p class="titulo">FIRMA CLIENTE</p><p class="contenido"><br><br></p></div>';
  echo '<div class="col-md-6"><p style="text-align:center"><br>COPIA TECNICO<br>Orden de Recepcion</p></div>';
 echo '<div class="col-md-3"><p class="titulo">FIRMA TECNICO</p><p class="contenido"><br><br></p></div></div></div>';
	 }
	 else
	 {
		   echo '<div class="row" style="height:60%;overflow:hidden">';
	 echo '<div class="col-md-12"><p class="titulo">TRABAJO REALIZADO</p><p class="contenido">'.$row['motivocierre'].'</p>';

 ?><table class="table" style="font-size:10px;width:100%">
                                    <thead>
                                        <tr>
                                            <th style="width:10%;text-align:left;">Cod.</th>
                                            <th style="width:69%;text-align:left;">Descripcion</th>
                                            <th style="width:20%;text-align:right;">P.U.</th>
                                        </tr>
                                    </thead>
                                    <tbody id="grilla">
                                         <?php
										 $contador=0;
										 $total=0;
					   $sql2 = "select * from detalleoservicio where idorden=".$_REQUEST['id'];
$stmt2 = sqlsrv_query( $conn, $sql2 );
if( $stmt2 === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row2 = sqlsrv_fetch_array( $stmt2, SQLSRV_FETCH_ASSOC) ) {
      echo '<tr>
	 
	  <td style="text-align:left;">
	  <span>'.$row2['idproducto'].'</span></td> 
	  <td style="text-align:left;">
	  <span>'.$row2['prodescripcion'].'</span></td> 
	  <td style="text-align:right;"> <span>'.$row2['preciounitario'].'</span></td> </tr>';
	  }

sqlsrv_free_stmt( $stmt2);
					   ?>
                                    </tbody>
                                </table>
								</div>
								<hr>
								<?php
								echo '<div class="col-md-12" style="text-align:right"><p><strong>TOTAL $'.$row['total'].'</strong></p></div>';
		 echo '<div style="    position: absolute;
    bottom: 0px;
    display: block;
    width: 100%;"><div class="col-md-3"><p class="titulo">FIRMA CLIENTE</p><p class="contenido"><br><br></p></div>';
  echo '<div class="col-md-6"><p style="text-align:center"><br>COPIA TECNICO<br>Orden de Cierre</p></div>';
 echo '<div class="col-md-3"><p class="titulo">FIRMA TECNICO</p><p class="contenido"><br><br></p></div></div></div>'; 
	 }

}

?>
</div>
</div>
</div>

</div>
</div>
</div>
<!-- jQuery -->
    <script src="js/jquery.min.js"></script>
<script>
function impresion()
{
	
	$("#btn1").css("display","none");
	$("#btn2").css("display","none");
	 window.print();
	 	$("#btn1").css("display","inline");
	$("#btn2").css("display","inline");
	 
}
</script>

</body>
</html>
