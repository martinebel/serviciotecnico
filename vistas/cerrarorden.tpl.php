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
					   $sql = "select ordenservicio.*,clientes.clirazonsocial,clientes.clitelefono from ordenservicio inner join clientes on clientes.clicodigo=ordenservicio.idcliente where idorden=".$idorden;
$stmt = sqlsrv_query( $conn, $sql );
$motivocierre="";
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      echo ' <div class="panel panel-default">
  <div class="panel-body">
  <p><strong>Cliente: </strong>'.$row['clirazonsocial'].'</p>
  <p><strong>Telefono: </strong>'.$row['clitelefono'].' </p>
  <p><strong>Ingreso: </strong>'.$row['motivoingreso'].' </p>
   <p';
  switch($row['prioridad'])
    {
	  case "1": echo ' style="background:#f2dede;color:#a94442;padding: 5px;border: 1px solid;"><strong>Prioridad: </strong>ALTA';break;
	  case "2": echo ' style="background:#fcf8e3;color:#8a6d3b;padding: 5px;border: 1px solid;"><strong>Prioridad: </strong>MEDIA';break;
	  case "3": echo ' style="background:#dff0d8;color:#3c763d;padding: 5px;border: 1px solid;"><strong>Prioridad: </strong>BAJA';break;
  }



  echo '</p><p> <strong>Fecha Entrega: </strong>'.date_format($row['fechaaprox'],'d-m-Y').' </p></div></div>';
$motivocierre=$row['motivocierre'];
	  }

sqlsrv_free_stmt( $stmt);
					   ?>
					  
                    </div>
					<form action="cerrarorden.php" method="post">
				
					
						<div class="col-md-12">
					<div class="form-group">
					<label for="producto">Agregar Productos</label>
					<input type="text" class="form-control" id="producto">
					</div>
					<div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>
											<th style="width:5%"></th>
                                            <th style="width:10%">Cod.</th>
                                            <th style="width:54%">Descripcion</th>
                                            <th style="width:20%">P.U.</th>
                                        </tr>
                                    </thead>
                                    <tbody id="grilla">
                                         <?php
										 $contador=0;
										 $total=0;
					   $sql = "select * from detalleoservicio where idorden=".$_REQUEST['id'];
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      echo '<tr id="fila'.$contador.'">
	  <td><a href="#" onclick="eliminarFila('.$contador.');" class="btn btn-primary">
	  <span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td> 
	  <td><input type="hidden" name="procodigo[]" class="form-control" value="'.$row['idproducto'].'" readonly>
	  <span>'.$row['idproducto'].'</span></td> 
	  <td><input type="hidden" name="prodescripcion[]" class="form-control" value="'.$row['prodescripcion'].'" readonly>
	  <span>'.$row['prodescripcion'].'</span></td> 
	  <td><input type="text" name="pu[]" class="form-control pu" value="'.$row['preciounitario'].'"></td></tr>';
$contador++;
$total+=$row['preciounitario'];
	  }

sqlsrv_free_stmt( $stmt);
					   ?>
                                    </tbody>
                                </table>
                            </div>

					</div>
												 <div class="col-md-6 pull-right" style="text-align:right">
 <span style="display:inline-table"><strong>TOTAL $</strong></span><input type="text" class="form-control"  style="display:inline-table;width:40%" name="total" id="total" value="<?php echo $total;?>" readonly>
 </div>

	<div class="col-md-12">
					
                        <div class="form-group">
					<label for="exampleTextarea">Declaracion del Tecnico</label>
					<textarea type="text" name="motivocierre" class="form-control" rows="3"></textarea>
					 <input type="submit" value="Guardar" class="btn btn-default">
					</div>
					</div>
 <input type="hidden" name="idorden" value="<?php echo $idorden;?>">
 </form>
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
<script>
var contador=<?php echo $contador;?>;
$(document).ready(function() {
  $(window).keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});
//BUSQUEDA DE PRODUCTOS---------------------------------------------------------
$(function() {
    function loadProd(codigo, nombre,precio ) {
		
	$("#grilla").append('<tr id="fila'+contador+'"><td><a href="#" onclick="eliminarFila('+contador+');" class="btn btn-primary"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td> <td><input type="hidden" name="procodigo[]" class="form-control" value="'+codigo+'" readonly><span>'+codigo+'</span></td> <td><input type="hidden" name="prodescripcion[]" class="form-control" value="'+nombre+'" readonly><span>'+nombre+'</span></td> <td><input type="text" name="pu[]" class="form-control pu" value="'+parseFloat(precio).toFixed(2)+'"></td></tr>');

calcularTotal();


    }
 
    $( "#producto" ).autocomplete({
      source: "ajax_search.php?tipo=producto",
      minLength: 2,
	  selectFirst:false,
      select: function( event, ui ) {
        loadProd(ui.item.id,ui.item.value,ui.item.precio);
		    $("#producto").select();
			return false;
      }
    })
  });
  
  
    //CALCULO DE TOTAL DE FACTURA
  function calcularTotal()
  {
	  var sumatoria=0;
	  //calcular subtotales
	  var pus = document.getElementsByName('pu[]');
for (var h = 0; h <pus.length; h++) {
var p=pus[h];
//calcular total gral

    sumatoria+=parseFloat(p.value);


  }
 $("#total").val(sumatoria.toFixed(2)); 
  }
  function eliminarFila(fila)
  {
	  $('#fila'+fila).remove();
	  calcularTotal();
  }
  
  
     jQuery(document ).on( "change", ".pu", function(){   calcularTotal();});
   
	
	    jQuery(document ).on( "keydown", ".pu", function(events){
    if(event.keyCode == 13) {
      event.preventDefault();
	  calcularTotal();
	}
	});
</script>
</html>