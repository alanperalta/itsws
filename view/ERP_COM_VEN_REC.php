<script type="text/javascript" src="../js/ERP_COM_VEN_REC.js"></script>
<div class="container">
    <div class="row">
        <div class="col-sm-6 col-sm-offset-3 form-box">
            <form role="form" action="../controller/ERP_COM_VEN_REC.php" method="post" class="registration-form">
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
                            <!--Imputaciones de ventas -->
                            <div class="form-bottom">
                                <?php 
                                $i = 1;
                                $total = 0;
                                $empresa = '';
                                foreach ($_POST as $factura) {
                                         if($i === 1){
                                            echo 'Imputaciones';
                                            $empresa = $factura['empresa'];
                                         }
                                    ?>
                                    <div class="form-group">
                                        <label class="sr-only" for="form-fac-<?php echo $i?>">Factura</label>
                                        <input type="text" name="form-fac-<?php echo $i?>" class="fac form-control" id="form-fac-<?php echo $i?>" readonly="" value="<?php echo $factura['id'];?>">
                                        <label class="sr-only" for="form-imp-fac-<?php echo $i?>">Importe</label>
                                        <input type="number" name="form-imp-fac-<?php echo $i?>" placeholder="Importe..." class="fac-imp form-control" id="form-imp-fac-<?php echo $i?>" step=".01" value="<?php echo number_format($factura['saldo'], 2, '.', '');?>">
                                    </div>
                                <?php $i++;
                                $total += $factura['saldo'];
                                if (($i-1) == count($_POST)){?>
                                     <hr class="linea-fac"/>
                                <?php }}?>
                                <div class="form-group">
                                    <label class="sr-only" for="form-first-name">Fecha</label>
                                    <input type="text" name="fecha-desc" placeholder="Fecha..." class="form-fecha form-control" id="fecha-desc" readonly="" value="<?php echo date("d/m/Y")?>">
                                    <input type="hidden" name="form-fecha" id="form-fecha" value="<?php echo date("Ymd")?>">
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="form-first-name">Empresa</label>
                                    <input type="text" name="form-empresa" placeholder="Empresa..." class="form-empresa form-control" id="form-empresa" readonly="" value="<?php echo $empresa?>">
                                    <button id="btn-empresas" class="btn btn-primary btn-sm boton-empresa"><i class="fa fa-search"></i></button>
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="form-importe">Importe</label>
                                    <input type="number" name="form-importe" placeholder="Importe..." class="form-importe form-control" id="form-importe" step=".01" value="<?php echo number_format($total, 2, '.', '')?>">
                                </div>
                                <div class="form-group">
                                    <label class="sr-only" for="form-observaciones">Observaciones</label>
                                    <textarea name="form-observaciones" placeholder="Observaciones..." class="form-observaciones form-control" id="form-observaciones"></textarea>
                                </div>
                                <button type="button" class="btn btn-next next1">Siguiente</button>
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
                                            <ul id="lista-cuentas">

                                            </ul>
                                            <input type="hidden" name="form-cuenta" class="form-cuenta form-control" id="form-cuenta">
                                    </div>
                                    <button type="button" class="btn btn-previous">Atr&aacute;s</button>
                                    <button type="button" class="btn btn-next next2" disabled="">Siguiente</button>
                                </div>
                        </fieldset>

                        <fieldset>
                            <div class="form-top">
                                    <div class="form-top-left">
                                            <h3>Paso 3 / 3</h3>
                                    <p>Confirme el recibo:</p>
                                    </div>
                                    <div class="form-top-right">
                                            <i class="fa fa-twitter"></i>
                                    </div>
                        </div>
                            <div class="form-bottom resumen">
                                Fecha: <p class="resumen resumen-fecha"></p>
                                Empresa: <p class="resumen resumen-empresa"></p>
                                Cuenta: <p class="resumen resumen-cuenta"></p>
                                Importe: <p class="resumen resumen-importe"></p>

                                <input type="hidden" name="mode" value="<?php echo $_GET['mode']?>">
                                <button type="button" class="btn btn-previous">Atr&aacute;s</button>
                                <button type="submit" class="btn">Confirmar</button>
                            </div>
                        </fieldset>

                    </form>

        </div>
    </div>
</div>
        
<script src="../js/stepform.js"></script>

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