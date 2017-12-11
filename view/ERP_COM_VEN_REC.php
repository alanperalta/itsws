<?php include_once '../controller/ERP_COM_VEN_REC.php';
//Mode = 0: Menu de recibos
//Mode = 1: Recibo nuevo
//Mode = 2: Recibo en base a factura
?>
<script type="text/javascript" src="../js/ERP_COM_VEN_REC.js"></script>

    <?php if(!isset($_GET['mode']) || !$_GET['mode']){?>
<div class="container">
    <div class="panel panel-default">
        <button type="button" class="btn btn-primary btn-lg btn-block" onclick="nuevoRecibo()">Crear recibo a cuenta</button>
        <button type="button" class="btn btn-primary btn-lg btn-block" onclick="nuevoReciboEnBase()">Recibo en base a factura</button>
    </div>
</div>
<?php }elseif($_GET['mode'] == 1){ //Recibo nuevo ?>
    <div class="container">

                    <div class="row">
                        <div class="col-sm-6 col-sm-offset-3 form-box">
                        	
                        	<form role="form" action="" method="post" class="registration-form">
                        		
                        		<fieldset>
		                        	<div class="form-top">
		                        		<div class="form-top-left">
		                        			<h3>Paso 1 / 3</h3>
		                            		<p>Datos del recibo:</p>
		                        		</div>
		                        		<div class="form-top-right">
		                        			<i class="fa fa-user"></i>
		                        		</div>
		                            </div>
		                            <div class="form-bottom">
                                                        <div class="form-group">
				                    		<label class="sr-only" for="form-first-name">Fecha</label>
                                                                <input type="text" name="fecha-desc" placeholder="Fecha..." class="form-fecha form-control" id="fecha-desc" readonly="" value="<?php echo date("d/m/Y")?>">
                                                                <input type="hidden" name="form-fecha" id="form-fecha" value="<?php echo date("Y-m-d")?>">
				                        </div>
				                    	<div class="form-group">
				                    		<label class="sr-only" for="form-first-name">Empresa</label>
                                                                <input type="text" name="form-empresa" placeholder="Empresa..." class="form-empresa form-control" id="form-empresa" readonly="">
                                                                <button id="btn-empresas" class="btn btn-primary btn-sm boton-empresa"><i class="fa fa-search"></i></button>
                                                        </div>
				                        <div class="form-group">
				                        	<label class="sr-only" for="form-importe">Importe</label>
                                                                <input type="number" name="form-importe" placeholder="Importe..." class="form-importe form-control" id="form-importe" step=".01">
				                        </div>
				                        <div class="form-group">
				                        	<label class="sr-only" for="form-observaciones">Observaciones</label>
				                        	<textarea name="form-observaciones" placeholder="Observaciones..." 
				                        				class="form-observaciones form-control" id="form-observaciones"></textarea>
				                        </div>
				                        <button type="button" class="btn btn-next">Siguiente</button>
				                    </div>
			                    </fieldset>
			                    
			                    <fieldset>
		                        	<div class="form-top">
		                        		<div class="form-top-left">
		                        			<h3>Paso 2 / 3</h3>
		                            		<p>Forma de pago:</p>
		                        		</div>
		                        		<div class="form-top-right">
		                        			<i class="fa fa-money"></i>
		                        		</div>
		                            </div>
		                            <div class="form-bottom">
				                        <div class="form-group">
				                        	<label class="sr-only" for="cuenta">Cuenta</label>
                                                                <?php cargarCuentas(); ?>;
				                        	<input type="hidden" name="cuenta" class="form-cuenta form-control" id="form-cuenta">
				                        </div>
				                        <button type="button" class="btn btn-previous">Atr&aacute;s</button>
                                                        <button type="button" class="btn btn-next">Siguiente</button>
				                    </div>
			                    </fieldset>
			                    
			                    <fieldset>
		                        	<div class="form-top">
		                        		<div class="form-top-left">
		                        			<h3>Paso 3 / 3</h3>
		                            		<p>Social media profiles:</p>
		                        		</div>
		                        		<div class="form-top-right">
		                        			<i class="fa fa-twitter"></i>
		                        		</div>
		                            </div>
		                            <div class="form-bottom">
				                    	<div class="form-group">
				                    		<label class="sr-only" for="form-facebook">Facebook</label>
				                        	<input type="text" name="form-facebook" placeholder="Facebook..." class="form-facebook form-control" id="form-facebook">
				                        </div>
				                        <div class="form-group">
				                        	<label class="sr-only" for="form-twitter">Twitter</label>
				                        	<input type="text" name="form-twitter" placeholder="Twitter..." class="form-twitter form-control" id="form-twitter">
				                        </div>
				                        <div class="form-group">
				                        	<label class="sr-only" for="form-google-plus">Google plus</label>
				                        	<input type="text" name="form-google-plus" placeholder="Google plus..." class="form-google-plus form-control" id="form-google-plus">
				                        </div>
				                        <button type="button" class="btn btn-previous">Previous</button>
				                        <button type="submit" class="btn">Sign me up!</button>
				                    </div>
			                    </fieldset>
		                    
		                    </form>
		                    
                        </div>
                    </div>
                </div>
        
<script src="../js/stepform.js"></script>
          <button type="button" class="btn btn-primary" onclick="volverRecibo()">Volver</button>
    </div>
<?php } elseif ($_GET['mode'] == 2) { //Recibo en base ?>
    <div class="container">
        modo2
          <button type="button" class="btn btn-primary btn-block" onclick="volverRecibo()">Volver</button>
    </div>
<?php } ?>

<!-- Modal -->
  <div class="modal fade" id="modal-empresas" role="dialog">
    <div class="modal-dialog">
        
      <!-- Modal content-->
      <div class="modal-content">
          <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 style="color:red;">Seleccione la empresa</h4>
          </div>
          <div class="modal-body">
              <input type="text" name="modal-input-empresa" placeholder="Buscar empresa..." class="form-control" id="modal-input-empresa">
              <ul id="lista-empresas">
                  
              </ul>
              <br/>
              <button id="btn-modal-empresa" class="btn btn-lg btn-primary" onclick="seleccionarEmpresa()" disabled="">Aceptar</button>
          </div>
      </div>
    </div>
  </div>