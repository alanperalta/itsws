<?php session_start();?>
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
                        $i = 0;
                        $total = 0;
                        $empresa = '';
                        foreach ($_POST as $factura) {
                                 if($i === 0){
                                    echo 'Imputaciones';
                                    $empresa = $factura['empresa'];
                                    $uniNeg = $factura['uni_neg'];
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
                        if (($i) == count($_POST)){?>
                             <hr class="linea-fac"/>
                        <?php }}
                            if(!isset($uniNeg) && isset($_GET['uniNeg'])){
                                $uniNeg = $_GET['uniNeg'];
                            }
                        ?>
                             <input type="hidden" name="cant-fac" value="<?php echo $i?>"/>
                        <div class="form-group">
                            <label class="sr-only" for="fecha-desc">Fecha</label>
                            <input type="text" name="fecha-desc" placeholder="Fecha..." class="form-fecha form-control" id="fecha-desc" readonly="" value="<?php echo date("d/m/Y")?>">
                            <input type="hidden" name="form-fecha" id="form-fecha" value="<?php echo date("Y-m-d")?>">
                        </div>
                        <div class="form-group">
                            <label class="sr-only" for="form-empresa">Empresa</label>
                            <input type="text" name="form-empresa" placeholder="Empresa..." class="form-empresa form-control" id="form-empresa" readonly="" value="<?php echo $empresa?>">
                            <button type="button" id="btn-empresas" class="btn btn-primary btn-sm boton-empresa"><i class="fa fa-search"></i></button>
                        </div>
                             
                        <div class="form-group">
                            <?php if(isset($uniNeg)){?>
                                <input type="hidden" name="form-uni-neg" value="<?=$uniNeg?>"/>
                            <?php }else{?>
                            <label class="sr-only" for="form-uni-neg">Uni. Neg</label>
                            <select name="form-uni-neg" placeholder="Uni. Neg..." class="form-uni-neg form-control" id="form-uni-neg">
                                <option value="1" <?=(isset($uniNeg) && $uniNeg == 1)?'selected':''?>>Sistemas</option>
                                <option value="3" <?=(isset($uniNeg) && $uniNeg == 3)?'selected':''?>>Revista</option>
                                <option value="4" <?=(isset($uniNeg) && $uniNeg == 4)?'selected':''?>>Dami&aacute;n</option>
                                <option value="5" <?=(isset($uniNeg) && $uniNeg == 5)?'selected':''?>>Liliana</option>
                                <option value="6" <?=(isset($uniNeg) && $uniNeg == 6)?'selected':''?>>Consultor&iacute;a</option>
                            </select>
                            <?php }?>
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
                            Saldo: $<span id="saldo-cuenta"></span>
                            <span id="saldo-cuenta-original" style="display: none"></span>
                            <ul id="lista-cuentas">

                            </ul>
                        </div>
                        <button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#ModalLoginForm">
                            Agregar cheque
                        </button>
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
                        Detalle de Cuentas: <p class="resumen resumen-cuenta"></p>
                        Total: $<p class="resumen resumen-importe"></p>

                        <button type="button" class="btn btn-previous">Atr&aacute;s</button>
                        <button type="submit" id="confirmarRecibo" class="btn">Confirmar</button>
                    </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>
        
<script src="../js/stepform.js"></script>

<!-- Modal empresa-->
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
          </div>
      </div>
    </div>
  </div>

<!-- Modal Cheques -->
<div id="ModalLoginForm" class="modal fade">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title">Valores de terceros</h1>
            </div>
            <div class="modal-body">
                <form role="form" method="POST" action="">
                    <div class="form-group">
                        <label class="control-label">Banco</label>
                        <div>
                            <input type="email" class="form-control input-lg" name="email" value="">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">N&uacute;mero</label>
                        <div>
                            <input type="number" class="form-control input-lg" name="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Importe</label>
                        <div>
                            <input type="password" class="form-control input-lg" name="password">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Tipo</label>
                        <div>
                            <select class="form-control input-lg" name="password">
                                <option value="C">Com&uacute;n</option>
                                <option value="D" selected>Diferido</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <div class="checkbox">
                                <label>
                                    <input type="checkbox" name="remember"> No a la orden
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="form-first-name">Fecha de emisi&oacute;n</label>
                        <input type="text" name="fecha-desc" placeholder="Fecha..." class="form-fecha form-control" id="fecha-desc" readonly="" value="<?php echo date("d/m/Y")?>">
                        <input type="hidden" name="form-fecha" id="form-fecha" value="<?php echo date("Y-m-d")?>">
                    </div>
                    <div class="form-group">
                        <label class="sr-only" for="form-first-name">Fecha de dep&oacute;sito</label>
                        <input type="text" name="fecha-desc" placeholder="Fecha..." class="form-fecha form-control" id="fecha-desc" readonly="" value="<?php echo date("d/m/Y")?>">
                        <input type="hidden" name="form-fecha" id="form-fecha" value="<?php echo date("Y-m-d")?>">
                    </div>
                    <div class="form-group">
                        <input type="hidden" value="$('#form-empresa').val()"/>
                        <div>
                            <button type="submit" class="btn btn-success">Aceptar</button>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
