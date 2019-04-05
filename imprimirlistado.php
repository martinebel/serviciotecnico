<?php
require 'db.php';

?>
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
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/custom.css" rel="stylesheet">
	 <link href="css/jquery-ui.css" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>
<body>
  <?php
  if($_REQUEST['v']=="0") //cerradas
  {
    echo '<h3>Listado de Ordenes CERRADAS</h3>';
  }
  else {
      echo '<h3>Listado de Ordenes ABIERTAS</h3>';
  }


    if(isset($_REQUEST['fechas'])){

    echo "<small>Filtrado desde ".$_REQUEST['desde']." hasta ".$_REQUEST['hasta']."</small>";

  }
  echo '<hr>';
   ?>
  <div class="table-responsive ">
<table class="table table-striped" id="dataTables-example">
<thead>
<tr>
  <th>#</th>
  <th>Cliente</th>
  <th>Entrada</th>
  <th>Tipo</th>
  <th>Salida</th>
  <th>Estimado</th>
<th>Estado</th>
</tr>
</thead>
<tbody>
  <?php
//hacer la consulta
$filtro="";


if($_REQUEST['v']=="0") //cerradas
{
  $filtro=" (estado='CERRADA' or estado='FACTURADO') ";
}

if($_REQUEST['v']=="1") //abiertas
{
  $filtro=" (estado='ABIERTO' or estado='TRABAJANDO') ";
}

  if(isset($_REQUEST['fechas'])){

  $filtro.=" and (fechaingreso>='".$_REQUEST['desde']." 00:00:00' and fechaingreso<='".$_REQUEST['hasta']." 23:59:59')";

}

switch($_REQUEST['t'])
{
  case '0': $filtro.=" and (tipo='CPU' or tipo='NOTE') "; break;
  case '1': $filtro.=" and (tipo<>'CPU' and tipo<>'NOTE') "; break;
}

$sql="select top 200 ordenservicio.*,clientes.clirazonsocial from ordenservicio inner join clientes on clientes.clicodigo=ordenservicio.idcliente where ".$filtro." order by idorden desc";
//echo $sql;
  $stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
  die( print_r( sqlsrv_errors(), true) );
}
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {

echo '<tr>
<td>'.$row['idorden'].'</td>
<td>'.substr($row['clirazonsocial'],0,25).'</td>
<td>'.date_format($row['fechaingreso'],'d-m-Y').'</td>
<td>'.$row['tipo'].'</td>
<td>';
if(($row['estado']=="CERRADA")||($row['estado']=="FACTURADO"))
{
echo date_format($row['fechafin'],'d-m-Y');
}else
{
echo '--';
}
//FECHA APROX
echo '</td>';
if(($row['estado']=="CERRADA")||($row['estado']=="FACTURADO"))
{
echo '<td>'.date_format($row['fechaaprox'],'d-m-Y').'</td>';
//ESTADO
if($row["total"]==0){echo '<td class="pendiente" style="background:#a94442;color:#ffffff">'.$row['estado'].'</td>';}
else{echo '<td>'.$row['estado'].'</td>';}
}
else
{
$date1=date_create(date('d-m-Y'));
$date2=date_create(date_format($row['fechaaprox'],'d-m-Y'));
$diff=date_diff($date1,$date2);
if(($diff->format('%R%a')==-1)||($diff->format('%a')==0))
{
echo '<td class="pendiente" style="background:#a94442;color:#ffffff">'.date_format($row['fechaaprox'],'d-m-Y').'</td>';
}
else{
echo '<td>'.date_format($row['fechaaprox'],'d-m-Y').'</td>';

}
echo '<td>'.$row['estado'].'</td>';
}






echo '</tr>';
}

?>
</tbody>
</table>
</div>
</body>
<script src="js/jquery.min.js"></script>
<script>

window.print();


</script>

</html>
