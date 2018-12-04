
<?php
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
			<form method="post" action="config.php">
                <div class="row">
                    <div class="col-md-6 col-md-offset-2 col-xs-12" style="text-align:center">
                       <div class="form-group">
    <label for="textoapertura">Pie de página para Ordenes Abiertas</label>
    <textarea type="text" name="textoapertura" rows="4" cols="50" class="form-control" id="textoapertura"><?php echo $pieAbierto;?></textarea>
  </div>
  <div class="form-group">
    <label for="textocierre1">Pie de página para Ordenes Cerradas (con costo)</label>
    <textarea type="text" name="textocierre1" rows="4" cols="50" class="form-control" id="textocierre1" ><?php echo $pieCerradoConCosto;?></textarea>
  </div>
  <div class="form-group">
    <label for="textocierre2">Pie de página para Ordenes Cerradas (sin costo)</label>
    <textarea type="text" name="textocierre2" rows="4" cols="50" class="form-control" id="textocierre2" ><?php echo $pieCerradoSinCosto;?></textarea>
  </div>
  
  <input type="submit" class="btn btn-success" value="Guardar">
                    </div>
                </div>
				</form>
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

</body>

</html>