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
 <?php include 'sidebar.php';?>
    <div id="wrapper" class="">



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



  echo '</p><p> <strong>Fecha Entrega: </strong>'.date_format($row['fechaaprox'],'d-m-Y').' </p>';
  if($row["garantia"]=="1")
{
  echo ' <p style="background:#f2dede;color:#a94442;padding: 5px;border: 1px solid;"><strong>EQUIPO EN GARANTIA</strong></p>';
}
 echo ' </div></div>';
$motivocierre=$row['motivocierre'];
$estado=$row['estado'];
	  }

sqlsrv_free_stmt( $stmt);
					   ?>

                    </div>
				<div class="col-md-12">
          <ul class="nav nav-tabs">
           <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">Productos</a></li>
    <li role="presentation"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">Tareas</a></li>
    <li role="presentation"><a href="#espera" aria-controls="espera" role="tab" data-toggle="tab"><?php if($estado=="EN ESPERA"){echo "Salir de Espera";}else{echo "Pasar a Espera";}?></a></li>
  </ul>
   <form action="trabajarorden.php" method="post">
   <div class="tab-content">

    <div role="tabpanel" class="tab-pane active" id="home">

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

                                            <th style="width:10%">P.U.</th>
                                            <th style="width:10%">Cant.</th>
                                            <th style="width:10%">SubTot.</th>
                                        </tr>
                                    </thead>
                                    <tbody id="grilla">
                                         <?php
                     $contador=0;
                     $total=0;
             $sql = "select * from detalleoservicio where idorden=".$idorden;
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
    <td><input type="text" name="pu[]" class="form-control pu" value="'.$row['preciounitario'].'"></td>
    <td><input type="text" name="cant[]" class="form-control pu" value="'.$row['cantidad'].'"></td>
    <td><input type="text" name="st[]" class="form-control pu" id="st'.$contador.'" value="'.$row['preciototal'].'"  readonly></td></tr>';
$contador++;
$total+=$row['preciototal'];
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


    </div>

    <div role="tabpanel" class="tab-pane" id="profile">

      <div class="col-md-12">

                        <div class="form-group">
          <label for="exampleTextarea">Agregar Tarea</label>
          <input type="text" name="motivocierre" class="form-control">

          </div>
          </div>

          <div class="col-md-12">

          <div class="table-responsive table-bordered">
                                <table class="table">
                                    <thead>
                                        <tr>

                                            <th style="width:20%">Fecha</th>
                                            <th style="width:20%">Vendedor</th>
                                            <th style="width:60%">Informe</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                         <?php
             $sql = "select bitacoraOrdenes.*,vendedores.vendnombre from bitacoraOrdenes inner join vendedores on vendedores.vendcodigo=bitacoraOrdenes.idvendedor where idorden=".$idorden." order by fecha desc";
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
    </div>
  <div role="tabpanel" class="tab-pane" id="espera">
    <?php
    if($estado=="EN ESPERA")
    {
      echo '<div class="col-md-6">
      <p>Indique el motivo de la SALIDA de la espera</p>
      <input type="text" id="motivoespera" class="form-control">
      </div>
      <div class="col-md-6">
      <p>&nbsp;</p>
      <a href="#" id="salirespera" class="btn btn-warning">Salir de Espera</a>
      </div>';
    }
    else
    {
      echo '<div class="col-md-6">
      <p>Indique el motivo de la ENTRADA de la espera</p>
      <input type="text" id="motivoespera" class="form-control">
      </div>
      <div class="col-md-6">
      <p>&nbsp;</p>
      <a href="#" id="entrarespera" class="btn btn-warning">Entrar a Espera</a>
      </div>';
    }
    ?>
    <br><p>&nbsp;</p>
  </div>
   </div>
   <br><p>&nbsp;</p>

  <input type="submit" value="Guardar Orden" class="btn btn-default">
            <a href="inicio.php" class="btn btn-default">Salir</a>

            <input type="hidden" name="idorden" id="idorden" value="<?php echo $idorden;?>">
    </form>

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

  function loadProd(codigo, nombre,precio ) {

  $("#grilla").append('<tr id="fila'+contador+'"><td><a href="#" onclick="eliminarFila('+contador+');" class="btn btn-primary"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td> <td><input type="hidden" name="procodigo[]" class="form-control" value="'+codigo+'" readonly><span>'+codigo+'</span></td> <td><input type="hidden" name="prodescripcion[]" class="form-control" value="'+nombre+'" readonly><span>'+nombre+'</span></td> <td><input type="text" name="pu[]" class="form-control pu" readonly value="'+parseFloat(precio).toFixed(2)+'"></td><td><input type="text" name="cant[]" class="form-control pu" value="1"></td><td><input type="text" name="st[]" class="form-control pu" id="st'+contador+'" value="'+parseFloat(precio).toFixed(2)+'"  readonly></td></tr>');
contador++;
calcularTotal();


    }


    //CALCULO DE TOTAL DE FACTURA
  function calcularTotal()
  {
	  var sumatoria=0;
	  //calcular subtotales
	  var pus = document.getElementsByName('pu[]');
    var cants=document.getElementsByName('cant[]');
     var subtot=document.getElementsByName('st[]');
for (var h = 0; h <pus.length; h++) {

var p=pus[h];
var c = cants[h];
//calcular total gral
$(subtot[h]).val((parseFloat(p.value)*parseFloat(c.value)).toFixed(2));

sumatoria+=(parseFloat(p.value)*parseFloat(c.value));


  }
 $("#total").val(sumatoria.toFixed(2));
  }

  function eliminarFila(fila)
  {
	  $('#fila'+fila).remove();
	  calcularTotal();
  }

  $(document).on('change', '.pu', function() { calcularTotal(); });

  //$('.pu').on( "change",function(){console.log("change");   calcularTotal(); });

	$(document).on('keydown', '.pu', function() {
    if(event.keyCode == 13) {
      event.preventDefault();
    calcularTotal();
}
  });

  $(document).on('click', '#entrarespera', function() {
  window.location.href="trabajarorden.php?action=entrarespera&motivo="+$("#motivoespera").val()+"&idorden="+$("#idorden").val()
  });

  $(document).on('click', '#salirespera', function() {
  window.location.href="trabajarorden.php?action=salirespera&motivo="+$("#motivoespera").val()+"&idorden="+$("#idorden").val()
  });

	    /* $('.pu').on( "keydown", function(events){
    if(event.keyCode == 13) {
      event.preventDefault();
      console.log("keydown");
	  calcularTotal();
}
	});*/

</script>
</body>
</html>
