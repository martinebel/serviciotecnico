 <?php
 //si no hay sesion, ir al login
 if (!isset($_SESSION['idusuario'])) {
       header("Location:index.php");
    }
 ?>

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="listaordenes.php?v=1&t=2"><img src="img/logo.jpg"></a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="abrirordenservicio.php">Nueva Orden</a></li>
        <li><a href="listaordenes.php?v=1&t=2">Lista de Ordenes</a></li>
        <?php
        if($_SESSION['tipousuario']=="1")
        {
          echo ' <li>
                    <a href="config.php">Configuracion</a>
                </li>';
        }
        ?>

      </ul>
      
      <ul class="nav navbar-nav navbar-right">
        <li>
          <a href="logout.php">Cerrar Sesion (<?php echo $_SESSION["nombreusuario"];?>)</a> </li>
        
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

 
		
		<div class="modal fade" tabindex="-1" role="dialog" id="idordendialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
       
        <h4 class="modal-title">Buscar Orden</h4>
      </div>
      <div class="modal-body">
         <div class="form-group">
						<label for="nombrecliented">N° de Orden</label>
						<input type="text" class="form-control" name="nroridend" id="nroridend" placeholder="N° de Orden">
						</div>
						<span style="color:red;display:none;" id="buscarordenerror">No se encuentra esta orden o la misma está cerrada!</span>
				
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-primary" onclick="buscarorden();">Abrir</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
