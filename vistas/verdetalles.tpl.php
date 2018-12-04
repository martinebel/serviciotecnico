<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Servicio Tecnico</title>
	<link href="css/jquery-ui.css" rel="stylesheet">
    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/custom.css" rel="stylesheet">


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
                    <div class="col-md-12 col-xs-12">
                      
					   <?php
					   $clicodigo="";
					   $sql = "select ordenservicio.*,clientes.clirazonsocial,clientes.clitelefono from ordenservicio inner join clientes on clientes.clicodigo=ordenservicio.idcliente where idorden=".$_REQUEST['id'];
$stmt = sqlsrv_query( $conn, $sql );
$motivocierre="";
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
	$clicodigo=$row['idcliente'];
      echo ' <div class="panel panel-default">
  <div class="panel-body">
  <p><strong>Cliente: </strong>'.$row['clirazonsocial'].'</p>
  <p><strong>Telefono: </strong>'.$row['clitelefono'].' </p>
  <p><strong>Ingreso: </strong>'.$row['motivoingreso'].' </p>
  <p id="barrita" ';
  switch($row['prioridad'])
    {
	  case "1": echo ' style="background:#f2dede;color:#a94442;padding: 5px;border: 1px solid;"><strong>Prioridad: </strong>ALTA';break;
	  case "2": echo ' style="background:#fcf8e3;color:#8a6d3b;padding: 5px;border: 1px solid;"><strong>Prioridad: </strong>MEDIA';break;
	  case "3": echo ' style="background:#dff0d8;color:#3c763d;padding: 5px;border: 1px solid;"><strong>Prioridad: </strong>BAJA';break;
  }



  echo '</p><p> <strong>Fecha Entrega: </strong>'.date_format($row['fechaaprox'],'d-m-Y').' </p>
  </div></div>';
$motivocierre=$row['motivocierre'];
	  }

sqlsrv_free_stmt( $stmt);

					   ?>
					  
                    </div>
					<div class="col-md-12">
					<ul class="nav nav-tabs">
					 <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Detalles</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Historial</a></li>
	</ul>
	 <div class="tab-content">
    <div role="tabpanel" class="tab-pane active" id="home">
					<div class="col-md-12">
					<br>
					<legend>Tareas Realizadas</legend>
					<div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
											
                                            <th style="width:20%">Fecha</th>
                                            <th style="width:20%">Vendedor</th>
                                            <th style="width:60%">Informe</th>
                                        </tr>
                                    </thead>
                                    <tbody id="grilla">
                                         <?php
					   $sql = "select bitacoraOrdenes.*,vendedores.vendnombre from bitacoraOrdenes inner join vendedores on vendedores.vendcodigo=bitacoraOrdenes.idvendedor where idorden=".$_REQUEST['id']." order by fecha desc";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      echo '<tr> 
	  <td>
	  <span>'.date_format($row['fecha'],'d-m-Y h:i:s').'</span></td> 
	  <td>
	  <span>'.$row['vendnombre'].'</span></td> 
	  <td>  <span>'.$row['informe'].'</span></td></tr>';

	  }

sqlsrv_free_stmt( $stmt);
					   ?>
                                    </tbody>
                                </table>
                            </div>

					</div>
					
					<div class="col-md-12">
					<legend>Productos</legend>
					<div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
											
                                            <th style="width:10%">Codigo</th>
                                            <th style="width:60%">Descripcion</th>
                                            <th style="width:20%">Precio</th>
                                        </tr>
                                    </thead>
                                    <tbody id="grilla">
                                         <?php
										 $total=0;
					   $sql = "select * from detalleoservicio where idorden=".$_REQUEST['id']."";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      echo '<tr> 
	  <td>
	  <span>'.$row['idproducto'].'</span></td> 
	  <td>
	  <span>'.$row['prodescripcion'].'</span></td> 
	  <td>  <span>'.$row['preciounitario'].'</span></td></tr>';
	  $total+=$row['preciounitario'];

	  }
echo '<tr><td></td><td>TOTAL</td><td>$'.$total.'</td></tr>';
sqlsrv_free_stmt( $stmt);
					   ?>
                                    </tbody>
                                </table>
                            </div>

					</div>
					</div>
					
					<div role="tabpanel" class="tab-pane" id="profile">
					<br>
					<div class="table-responsive table-bordered ">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
											
                                            <th style="width:5%">Orden</th>
                                            <th style="width:15%">F. Entrada</th>
                                            <th style="width:15%">F. Salida</th>
											 <th style="width:30%">Entrada</th>
											  <th style="width:30%">Salida</th>
											   <th style="width:5%"></th>
                                        </tr>
                                    </thead>
                                    <tbody>
					<?php
					 $sql = "select ordenservicio.*,clientes.clirazonsocial,clientes.clitelefono from ordenservicio inner join clientes on clientes.clicodigo=ordenservicio.idcliente where ordenservicio.idcliente=".$clicodigo." and (estado<>'TRABAJANDO' and estado<>'ABIERTO') order by idorden desc";
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      echo '<tr> 
	  <td>
	  <span>'.$row['idorden'].'</span></td> 
	 
	  <td>
	  <span>'.date_format($row['fechaingreso'],'d-m-Y h:i:s').'</span></td> 
	    <td>
	  <span>'.date_format($row['fechafin'],'d-m-Y h:i:s').'</span></td> 
	  <td>
	  <span>'.$row['motivoingreso'].'</span></td> 
	  <td>  <span>'.$row['motivocierre'].'</span></td>
	  <td>  <span><a href="imprimirorden.php?id='.$row['idorden'].'" class="btn btn-default" target="_blank">Imprimir</a></span></td>
	  </tr>';

	  }

sqlsrv_free_stmt( $stmt);
					?>
					 </tbody>
                                </table>
                            </div>
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

</body>
</html>