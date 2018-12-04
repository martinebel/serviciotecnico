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
                <div class="row">
                    <div class="col-md-6 col-md-offset-2 col-xs-12" style="text-align:center">
                        <h1>Que desea hacer?</h1>
                        
						<a href="abrirordenservicio.php" class="btn btn-default">Abrir Orden Servicio</a>
                        <a href="#" class="btn btn-default" onclick="showbuscarOrden();">Trabajar una Orden</a>
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

</body>

</html>