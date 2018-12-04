 <?php
 //si no hay sesion, ir al login
 if (!isset($_SESSION['idusuario'])) {
       header("Location:index.php");
    }
 ?>
 <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav" style="height:100%;">
                <li class="sidebar-brand" style="    text-indent: 0px;
    text-align: center;">
                    <a href="inicio.php">
                       <img src="img/logo.jpg">
                    </a>
                </li>
                <li>
                    <a href="abrirordenservicio.php">Nueva Orden</a>
                </li>
                <li>
                    <a href="#" onclick="showbuscarOrden();">Trabajar Orden</a>
                </li>
                <li>
                    <a href="listaordenes.php?v=1">Lista de Ordenes</a>
                </li>
				<?php
				if($_SESSION['tipousuario']=="1")
				{
					echo ' <li>
                    <a href="config.php">Configuracion</a>
                </li>';
				}
				?>
                 <li style="position:absolute;bottom:0px;">
                    <?php echo $_SESSION["nombreusuario"];?> <a href="logout.php" style="display:inline">Cerrar Sesion</a>
                </li>
               
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->
		
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
