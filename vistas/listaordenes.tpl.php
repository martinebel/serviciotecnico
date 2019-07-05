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
 <?php include 'sidebar.php';?>

    <div id="wrapper" class="">


        <!-- Page Content -->
        <div id="page-content-wrapper">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12" style="background-color: #e3e3e3;">
                        <legend>Lista de Ordenes</legend>
						<form action="listaordenes.php" method="GET" id="formulario">
						<div class="col-md-2">
                        <span>Ordenes </span>
						<select name="v"  class="form-control" >
						<option value="0" <?php if($_REQUEST['v']=="0"){echo 'selected';}?>>Cerradas</option>
						<option value="1" <?php if($_REQUEST['v']=="1"){echo 'selected';}?>>Abiertas</option>
						</select>
						</div>
            <div class="col-md-2">
                        <span>Tipo </span>
            <select name="t"  class="form-control">
            <option value="0" <?php if($_REQUEST['t']=="0"){echo 'selected';}?>>CPU y Note</option>
            <option value="1" <?php if($_REQUEST['t']=="1"){echo 'selected';}?>>Comp. y otros</option>
            <option value="2" <?php if($_REQUEST['t']=="2"){echo 'selected';}?>>Todos</option>
            </select>
            </div>
						<div class="col-md-4">
						<input type="checkbox" name="fechas" id="fechas" value="1" <?php if(isset($_REQUEST['fechas'])){ echo 'checked';}?>>Filtro de Fechas<br>
						 <span>Desde </span>
						<input type="text" class="form-control" style="width:30%;display:inline-block;" name="desde" <?php if(isset($_REQUEST['fechas'])){ echo 'required="required"';}?> id="desde" value="<?php if(isset($_REQUEST['fechas'])){ echo $_REQUEST['desde'];}?>">

						 <span>Hasta </span>
						<input type="text" class="form-control" style="width:30%;display:inline-block;"  name="hasta" <?php if(isset($_REQUEST['fechas'])){ echo 'required="required"';}?> id="hasta" value="<?php if(isset($_REQUEST['fechas'])){ echo $_REQUEST['hasta'];}?>">
						</select>
						</div>
						<div class="col-md-2">
						<br>
						<input type="submit" class="btn btn-primary" value="Filtrar">
						</div>
            <div class="col-md-2">
            <br>
            <?php
            if($_SESSION['tipousuario']=="1")
            {
                echo '<a href="imprimirlistado.php?v='.$_REQUEST['v'].'&t='.$_REQUEST['t'].(isset($_REQUEST['fechas'])?'&fechas='.$_REQUEST['fechas'].'&desde='.$_REQUEST['desde'].'&hasta='.$_REQUEST['hasta']:'').'" target="_blank" class="btn btn-default" >Imprimir Listado</a>';
            }
            ?>
            </div>
						</form>
            <p>&nbsp;</p>
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


	if($_REQUEST['v']=="0") //cerradas
	{
		$filtro=" (estado='CERRADA' or estado='FACTURADO') ";
	}

	if($_REQUEST['v']=="1") //abiertas
	{
		$filtro=" (estado='ABIERTO' or estado='TRABAJANDO' or estado='EN ESPERA') ";
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

        if(getParameterByName("q"))
        {
          $('#dataTables-example').DataTable().search(getParameterByName("q")).draw();
        }
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


    function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
    results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}
</script>

</body>

</html>
