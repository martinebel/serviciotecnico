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

    <div id="wrapper" class="toggled">

       <?php include 'sidebar.php';?>

        <!-- Page Content -->
        <div id="page-content-wrapper">
		
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <legend>Lista de Ordenes</legend>
						<form action="listaordenes.php" method="GET" id="formulario">
						<div class="col-md-4">
                        <span>Ver </span>
						<select name="v"  class="form-control" style="width:300px">
						<option value="0" <?php if($_REQUEST['v']=="0"){echo 'selected';}?>>Ordenes Cerradas</option>
						<option value="1" <?php if($_REQUEST['v']=="1"){echo 'selected';}?>>Ordenes Abiertas</option>
						</select>
						</div>
						<div class="col-md-6">
						<input type="checkbox" name="fechas" id="fechas" value="1" <?php if(isset($_REQUEST['fechas'])){ echo 'checked';}?>>Filtro de Fechas<br>
						 <span>Desde </span>
						<input type="text" name="desde" <?php if(isset($_REQUEST['fechas'])){ echo 'required="required"';}?> id="desde" value="<?php if(isset($_REQUEST['fechas'])){ echo $_REQUEST['desde'];}?>">
						
						 <span>Hasta </span>
						<input type="text" name="hasta" <?php if(isset($_REQUEST['fechas'])){ echo 'required="required"';}?> id="hasta" value="<?php if(isset($_REQUEST['fechas'])){ echo $_REQUEST['hasta'];}?>">
						</select>
						</div>
						<div class="col-md-2">
						
						<input type="submit" class="btn btn-primary" value="Filtrar">
						</div>
						</form>
                    </div>
					<p>&nbsp;</p>
					<hr>
					<div class="col-md-12">
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
		<th>Acciones</th>
		<th>Prioridad</th>
		
		
		<th style="display:none">Prioridad</th>
      </tr>
    </thead>
	<tbody>
    <?php
	//hacer la consulta
	$filtro="";
	
	if(isset($_REQUEST['fechas'])){
		
		$filtro=" and (fechaingreso>='".$_REQUEST['desde']." 00:00:00' and fechaingreso<='".$_REQUEST['hasta']." 23:59:59')";
		
	}
	if($_REQUEST['v']=="0") //todas
	{
		$sql="select top 200 ordenservicio.*,clientes.clirazonsocial from ordenservicio inner join clientes on clientes.clicodigo=ordenservicio.idcliente where (estado='CERRADA' or estado='FACTURADO') ".$filtro." order by idorden desc ";
	}
	
	if($_REQUEST['v']=="1") //abiertas
	{
		$sql="select ordenservicio.*,clientes.clirazonsocial from ordenservicio inner join clientes on clientes.clicodigo=ordenservicio.idcliente where (estado='ABIERTO' or estado='TRABAJANDO') ".$filtro." order by idorden desc";
	}
	//echo $sql;
	  $stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}	  
while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
   switch($row['prioridad'])
 {
 case "1": echo '<tr style="background:#f2dede;color:#a94442">';break;
 case "2": echo '<tr style="background:#fcf8e3;color:#8a6d3b">';break;
 case "3": echo '<tr style="background:#dff0d8;color:#3c763d">';break;
 }
  
  echo '
  <td>'.$row['idorden'].'</td>
  <td>'.substr($row['clirazonsocial'],0,25).'</td>
  <td>'.date_format($row['fechaingreso'],'d-m-Y').'</td>
  <td>'.$row['tipo'].'</td>
  <td>';
if(($row['estado']=="CERRADA")||($row['estado']=="FACTURADO"))
{
	echo date_format($row['fechafin'],'d-m-Y');
}
else
{
	echo '--';
}
//FECHA APROX
echo '</td>';
if(($row['estado']=="CERRADA")||($row['estado']=="FACTURADO"))
{
	echo '<td>'.date_format($row['fechaaprox'],'d-m-Y').'</td>';
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
}
  
  echo '<td>'.$row['estado'].'</td>
 ';
  

  echo '<td><div class="btn-group">
  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
    Acciones <span class="caret"></span>
  </button>
  <ul class="dropdown-menu">';
  if(($row['estado']=="CERRADA")||($row['estado']=="FACTURADO"))
{
	echo ' ';
}
else
{
echo ' <li><a href="cerrarorden.php?id='.$row['idorden'].'" title="Cerrar Orden">Cerrar Orden</a></li><li><a href="trabajarorden.php?id='.$row['idorden'].'" title="Trabajar">Trabajar Orden</a></li><li role="separator" class="divider"></li>';

}



 echo '
    <li><a href="imprimirorden.php?id='.$row['idorden'].'">Imprimir Orden</a></li>
    <li><a target="_blank" href="etiquetas.php?id='.$row['idorden'].'&nombre='.$row['clirazonsocial'].'">Imprimir Etiquetas</a></li>
	<li role="separator" class="divider"></li>
	<li><a href="verdetalles.php?id='.$row['idorden'].'" title="Ver Detalles">Ver Detalles</a></li>
  </ul>
</div> </td> 
 <td>';
  switch($row['prioridad'])
 {
 case "1": echo "ALTA";break;
 case "2": echo "MEDIA";break;
 case "3": echo "BAJA";break;
 }
 echo '</td><td style="display:none">'.$row['prioridad'].'</td></tr>';
}

	?>
	</tbody>
  </table>
</div>
					</div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
<script src="js/custom.js"></script>
 <script src="js/jquery-ui.min.js"></script>
	    <!-- DataTables JavaScript -->
    <script src="datatables/js/jquery.dataTables.min.js"></script>
    <script src="datatables-plugins/dataTables.bootstrap.min.js"></script>
    <script src="datatables-responsive/dataTables.responsive.js"></script>
	
<script>
$(function() {
    $('#filtro').change(function() {
       $("#formulario").submit();
    });
});

  $(document).ready(function() {
        $('#dataTables-example').DataTable({
            responsive: true,
			order: [[ 9, 'asc' ], [ 0, 'desc' ]]
        });
    });
	
	$( function() {
    $( "#desde" ).datepicker( {dateFormat: 'yy-mm-dd' } );
	$( "#hasta" ).datepicker( {dateFormat: 'yy-mm-dd' } );
  } );
  
  
   $('#fechas').on('change', function() { 
        if($(this).is(":checked")) {
           
            $("#desde").attr("required", "required");
			 $("#hasta").attr("required", "required");
        }
		else
		{
			  $("#desde").removeAttr("required");
			    $("#hasta").removeAttr("required");
		}
   });
   
    $(".pendiente").effect("pulsate", { times:3 }, 2000);
</script>

</body>

</html>
