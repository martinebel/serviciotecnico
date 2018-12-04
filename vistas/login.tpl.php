<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Servicio Tecnico</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
	<style>
#cuadrito{
	background:#eee;
	padding:20px;
	border-radius:20px;
	position:absolute;
	top:25%;
}
	</style>
  </head>
  <body >
  
   <div class="container">
<div class="row">
<div class="col-md-4 col-md-offset-3" id="cuadrito">
      <form class="form-signin" method="POST" action="validation.php">
        <h2 class="form-signin-heading" style="text-align:center">Servicio Tecnico</h2>
		
		<?php
		$usuario="1";
		if(isset($_REQUEST['u']))
		{
			$usuario=$_REQUEST['u'];
		}
		if(isset($_REQUEST['e']))
		{
			echo '<div class="alert alert-danger" role="alert">Error de inicio de sesion. Controle los datos ingresados.</div>';
		}
		?>
        <label for="inputEmail" class="sr-only">Usuario</label>
       <select class="form-control" name="usuario" required>
		<?php
		$sql = "select vendedores.* from VendedoresXSucursales inner join Vendedores on Vendedores.VendCodigo=VendedoresXSucursales.VendCodigo where Activo=1 and VendedoresXSucursales.idsucursal=".$idSucursal;
$stmt = sqlsrv_query( $conn, $sql );
if( $stmt === false) {
    die( print_r( sqlsrv_errors(), true) );
}

while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_ASSOC) ) {
      echo '<option value="'.$row['VendCodigo'].'" '.($usuario==$row['VendCodigo']?'selected':'').'>'.$row['VendNombre'].'</option>';
}

sqlsrv_free_stmt( $stmt);
		?>
	   </select>
        <label for="inputPassword" class="sr-only">Contraseña</label>
        <input type="password" name="password" class="form-control" placeholder="Contraseña" required  autofocus>
		<small id="divMayus" style="display:none" class="form-text text-muted text-warning">Atención: Mayúsculas Activadas</small>
        <div class="checkbox">
         
        </div>
        <button class="btn btn-lg btn-primary btn-block" type="submit">Iniciar Sesion</button>
      </form>
	  </div>
</div>
    </div> <!-- /container -->

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>

<script language="Javascript">
let isCapsLockOn = false;

document.addEventListener( 'keydown', function( event ) {
  var caps = event.getModifierState && event.getModifierState( 'CapsLock' );
  if(isCapsLockOn !== caps) isCapsLockOn = caps;
  
 if(caps==true)
 {
	 $("#divMayus").css("display","block");
 }
 else
 {
	 $("#divMayus").css("display","none");
 }
});


</script>