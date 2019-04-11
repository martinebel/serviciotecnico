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
<style>
.has-danger
{
	border:1px solid red;
}
</style>
</head>

<body>
	<?php include 'sidebar.php';?>
<div id="wrapper" class="">



        <!-- Page Content -->
        <div id="page-content-wrapper">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12 col-xs-12">
                        <legend>Abrir Orden de Servicio</legend>


	<form action="abrirordenservicio.php" method="post">
	<!--PASO 1-->
	<div class="row" id="paso1">
				<div class="col-md-12  col-xs-12">
				<input type="hidden" name="idcliente" id="idcliente">
                        <div class="form-group">
						<label for="nombrecliente">Cliente</label>
						<input type="text" class="form-control" name="nombrecliente" id="nombrecliente" placeholder="Cliente" style="text-transform: uppercase;">

						 <a href="#" id="crearcliente">Crear nuevo Cliente</a>
						</div>
				</div>
				<div class="col-md-6 col-xs-12">
						<div class="form-group">
						<label for="telefono">Telefono</label>
						<input type="text" class="form-control" name="telefono" id="telefono" placeholder="Telefono">
						</div>
				</div>
				<div class="col-md-6 col-xs-12">
						<div class="form-group">
						<label for="email">E-mail</label>
						<input type="text" class="form-control" name="email" id="email" placeholder="Email">
						</div>
				</div>
				<div class="col-md-12">
				<hr>
				<a href="#" style="float:right" id="iraPaso2" class="btn btn-default">Siguiente ></a>
				</div>
	</div> <!--FIN PASO 1-->
	<!--PASO 2-->
	<div class="row" id="paso2" style="display:none">
	<div class="col-md-12  col-xs-12">

                        <div class="form-group">
					<label for="exampleTextarea">Declaracion del Cliente</label>
					<textarea class="form-control" id="exampleTextarea" name="motivoingreso" rows="3" required></textarea>
					</div>
				</div>
				<div class="col-md-3 col-xs-6">
						<div class="form-group">
						<label for="tipo">Tipo de Equipo</label>
						<select class="form-control" name="tipo" id="tipo">
						<option value="CPU">CPU</option>
						<option value="NOTE">Notebook</option>
						<option value="MONIT">Monitor</option>
						<option value="IMPR">Impresora</option>
						<option value="HDD">Disco Rigido</option>
						<option value="PARL">Parlante</option>
						<option value="ACC">Accesorio</option>
						<option value="CEL">Celular / Movil</option>
						<option value="COMP">Otro</option>
						</select>
						</div>
				</div>
				<div class="col-md-3 col-xs-6">
						<div class="form-group">
						<label for="marca">Marca y Modelo</label>
						<input type="text" class="form-control" name="marca" id="marca" placeholder="Marca y Modelo">
						</div>
				</div>
				<div class="col-md-3 col-xs-6">
						<div class="form-group">
						<label for="serie">N° Serie</label>
						<input type="text" class="form-control" name="serie" id="serie" placeholder="N° Serie (opcional)">
						</div>
				</div>


				<div class="col-md-3 col-xs-6">
						<div class="form-group">

						<input type="checkbox" name="backup" value="1">Hacer Backup
						<br>
						<input type="checkbox" name="cargador" value="1">Deja cargador
						<br>
						<input type="checkbox" name="garantia" value="1" id="garantia">Entra por Garantia
						<br>
						<div class="form-group">
						<input type="text" class="form-control" name="factura" id="factura" placeholder="Factura" disabled="disabled">
						</div>

						</div>
				</div>

				<div class="col-md-12 col-xs-12">
				<hr>
				<a href="#" style="float:left" id="iraPaso1" class="btn btn-default">< Anterior</a>
				<a href="#" style="float:right" id="iraPaso3" class="btn btn-default">Siguiente ></a>
				<input type="hidden" name="action" value="save">

				</div>
	</div><!--FIN PASO 2*-->

		<!--PASO 3-->
	<div class="row" id="paso3" style="display:none">
				<div class="col-md-4 col-xs-12 col-md-offset-4" style="text-align:center">
						<div class="form-group">
						<label for="prioridad">Prioridad</label>
						<select class="form-control" name="prioridad" id="prioridad">
						<option value="1">ALTA</option>
						<option value="2">MEDIA</option>
						<option value="3">BAJA</option>
						</select>
						</div>

						<div id="aviso"><div class="alert alert-danger" role="alert">La prioridad ALTA implica la resolución del equipo en las próximas 24hs.</div></div>
<div id="divDocumento">
  <p>Ingrese DNI</p>
<input type="text" id="documento" class="form-control">
<input type="hidden" name="idvendedor" id="idvendedor">
</div>
            <p id="recibe"></p>
				</div>
				<div class="col-md-12">
				<hr>
				<a href="abrirordenservicio.php" style="float:left"  class="btn btn-default">Cancelar</a>
				<input type="submit" style="float:right" class="btn btn-default" value="Imprimir">
				</div>
	</div> <!--FIN PASO 3-->
	</form>



                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->


		<div class="modal fade" tabindex="-1" role="dialog" id="nuevoclientedialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">

        <h4 class="modal-title">Nuevo Cliente</h4>
      </div>
      <div class="modal-body">
         <div class="form-group">
						<label for="nombrecliented">Cliente</label>
						<input type="text" class="form-control" name="nombrecliented" id="nombrecliented" placeholder="Cliente">

						</div>


						<div class="form-group">
						<label for="telefonod">Telefono</label>
						<input type="text" class="form-control" name="telefonod" id="telefonod" placeholder="Telefono">
						</div>

						<div class="form-group">
						<label for="email">E-mail</label>
						<input type="text" class="form-control" name="emaild" id="emaild" placeholder="Email">
						</div>

						<div class="form-group">
						<label for="direccion">Direccion</label>
						<input type="text" class="form-control" name="direccion" id="direccion" placeholder="Direccion">
						</div>

						<div class="form-group">
						<label for="localidad">Localidad</label>
						<input type="text" class="form-control" name="localidad" id="localidad" placeholder="Localidad">
						</div>

						<div class="form-group">
						<label for="provincia">Provincia</label>
						<input type="text" class="form-control" name="provincia" id="provincia" placeholder="Provincia">
						</div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" id="guardarcliente">Guardar</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

    </div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="js/jquery.min.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>
	<script src="js/jquery-ui.min.js"></script>
	<script src="js/custom.js"></script>
<script>


$(function() {
    function log( msg ) {
  //traer datos del cliente
  $("#idcliente").val(msg);
      $.ajax({
        type: "POST",
        url: "ajax_search.php?codigo="+msg,
        processData: false,
        contentType: "application/json"
    })
    .done(function(datae, textStatus, jqXHR){
	//$("#datoscliente").css("display","block");
 var obj = JSON.parse( datae );
 $("#telefono").val(obj[0].telefono);
 $("#email").val(obj[0].email);
 $("#nombrecliente").removeClass("has-danger");
    })
    .fail(function(jqXHR, textStatus, errorThrown){

    });
    }

    $( "#nombrecliente" ).autocomplete({
      source: "ajax_search.php?clienteS=asd",
      minLength: 2,
      select: function( event, ui ) {
		  //$("#nuevocliente").css("display","none");
        log(ui.item.id);
      },
    response: function(event, ui) {
        if (!ui.content.length) {
           // $("#nuevocliente").css("display","block");
        }
    }
    })

  });

  $("#crearcliente").on("click", function()
    {
		//blanquear campos
		$("#nombrecliented").val("");
		$("#telefonod").val("");
		$("#emaild").val("");
		$("#direccion").val("");
		$("#localidad").val("");
		$("#provincia").val("");
		 $("#nombrecliented").removeClass("has-danger");
		  $("#telefonod").removeClass("has-danger");
		   $("#emaild").removeClass("has-danger");
		    $("#direccion").removeClass("has-danger");
			 $("#localidad").removeClass("has-danger");
			  $("#provincia").removeClass("has-danger");
		$('#nuevoclientedialog').modal({
		keyboard:false,
		backdrop:'static'
		})
	});


	  $("#prioridad").on("change", function()
    {
		switch($("#prioridad").val())
		{
			case "1": $("#aviso").html('<div class="alert alert-danger" role="alert">La prioridad ALTA implica la resolución del equipo en las próximas 24hs.</div>'); break;
			case "2": $("#aviso").html('<div class="alert alert-warning" role="alert">La prioridad MEDIA implica la resolución del equipo en las próximas 48hs.</div>'); break;
			case "3": $("#aviso").html('<div class="alert alert-success" role="alert">La prioridad BAJA implica la resolución del equipo en las próximas 72hs o mas.</div>'); break;
		}
	});

  $("#guardarcliente").on("click", function()
    {
		 $("#nombrecliented").removeClass("has-danger");
		  $("#telefonod").removeClass("has-danger");
		   $("#emaild").removeClass("has-danger");
		    $("#direccion").removeClass("has-danger");
			 $("#localidad").removeClass("has-danger");
			  $("#provincia").removeClass("has-danger");

		if($("#nombrecliented").val()==""){$("#nombrecliented").toggleClass("has-danger"); return;}
		if($("#telefonod").val()==""){$("#telefonod").toggleClass("has-danger"); return;}
		if($("#emaild").val()==""){$("#emaild").toggleClass("has-danger"); return;}
		if($("#direccion").val()==""){$("#direccion").toggleClass("has-danger"); return;}
		if($("#localidad").val()==""){$("#localidad").toggleClass("has-danger"); return;}
		if($("#provincia").val()==""){$("#provincia").toggleClass("has-danger"); return;}

		$.ajax({
        type: "POST",
        url: "ajax_search.php?nuevo=true&nombre="+$("#nombrecliented").val()+"&telefono="+$("#telefonod").val()+"&email="+$("#emaild").val()+"&direccion="+$("#direccion").val()+"&localidad="+$("#localidad").val()+"&provincia="+$("#provincia").val(),
        processData: false,
        contentType: "application/json"
    })
    .done(function(datae, textStatus, jqXHR){
 var obj = JSON.parse( datae );
  $("#idcliente").val(obj[0].codigo);
 $("#telefono").val(obj[0].telefono);
 $("#email").val(obj[0].email);
  $("#nombrecliente").val(obj[0].nombre);
 $("#nombrecliente").removeClass("has-danger");
 $('#nuevoclientedialog').modal('hide')
    })
    .fail(function(jqXHR, textStatus, errorThrown){

    });
	});
  </script>
<script>
$( "#iraPaso2" ).on( "click", function() {
	 $("#nombrecliente").removeClass("has-danger");
		  $("#telefono").removeClass("has-danger");
		   $("#email").removeClass("has-danger");
	if(!$("#idcliente").val()){
		$("#nombrecliente").toggleClass("has-danger");
		return;
	}
	if(!$("#telefono").val()){
		$("#telefono").toggleClass("has-danger");
		return;
	}
	if(!$("#email").val()){
		$("#email").toggleClass("has-danger");
		return;
	}
$("#paso1").css("display","none");
$("#paso3").css("display","none");
 $("#paso2").css("display","block");
});

$( "#volveraPaso2" ).on( "click", function() {
$("#paso1").css("display","none");
$("#paso3").css("display","none");
 $("#paso2").css("display","block");
});

$( "#iraPaso3" ).on( "click", function() {
	if(!$("#exampleTextarea").val()){
		$("#exampleTextarea").toggleClass("has-danger");
		return;
	}
		if(!$("#marca").val()){
		$("#marca").toggleClass("has-danger");
		return;
	}

if(checkGarantia()==false){return;}
if($("#garantia").is(':checked'))
	{
$("#exampleTextarea").val("EQUIPO EN GARANTIA - FACTURA "+$("#factura").val()+" -- "+$("#exampleTextarea").val());
}
$("#paso1").css("display","none");
$("#paso2").css("display","none");
 $("#paso3").css("display","block");
});

$( "#iraPaso1" ).on( "click", function() {
 $("#paso2").css("display","none");
 $("#paso1").css("display","block");
});

function checkGarantia()
{
	$("#factura").removeClass("has-danger");
	if($("#garantia").is(':checked'))
	{
		if($("#factura").val().trim() == ''){$("#factura").toggleClass("has-danger");return false;}
		//comprobar la factura
		$.ajax({
        type: "POST",
        url: "ajax_search.php?factura=true&numero="+$("#factura").val()+"&idcliente="+$("#idcliente").val(),
        processData: false,
        contentType: "application/json"
    })
    .done(function(datae, textStatus, jqXHR){
 var obj = JSON.parse( datae );
if(obj[0].msg=="ERROR")
{
	$("#factura").toggleClass("has-danger");
	return false;
}
else
{
	$("#factura").removeClass("has-danger");
	$("#factura").attr("disabled", "disabled");

	return true;
}
    })
    .fail(function(jqXHR, textStatus, errorThrown){

    });
	}
	else
		{return true;}
}

$( "#documento" ).on( "keypress", function(e) {

  if(e.which == 13) {
    e.preventDefault();
    $.ajax({
    url: 'ajax_documento.php?documento='+$("#documento").val(),
    async: true,
    contentType: "application/json",
       success: function(data) {
         var obj=JSON.parse(data);
         if(obj.length>0)
         {
           $("#idvendedor").val(obj[0].codigo);
           $("#divDocumento").hide();
           $("#recibe").html('Recibe: '+obj[0].nombre);
           $("#recibe").show();
         }
       }
    });
      }
});

$(document).ready(function() {

    $('#garantia').change(function() {
        if(!this.checked) {
            $("#factura").attr("disabled", "disabled");
        }
        else
        {
        	$("#factura").removeAttr("disabled");
        }
    });
});

</script>


</body>

</html>
