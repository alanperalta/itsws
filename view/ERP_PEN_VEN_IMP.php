<?php include_once '../controller/ERP_PEN_VEN_IMP.php';?>
<script type="text/javascript" src="../js/ERP_PEN_VEN_IMP.js"></script>
<div class="container">
	<div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Pendientes de imputaci&oacute;n de ventas</h3>
            <select onchange="cargarContenido('ERP_PEN_VEN_IMP',this.value)">
                <option value="0" <?=(isset($_GET['uniNeg']) && $_GET['uniNeg'] == 0)?'selected':''?>>Todo</option>
                <option value="1" <?=(isset($_GET['uniNeg']) && $_GET['uniNeg'] == 1)?'selected':''?>>Sistemas</option>
                <option value="3" <?=(isset($_GET['uniNeg']) && $_GET['uniNeg'] == 3)?'selected':''?>>Revista</option>
                <option value="4" <?=(isset($_GET['uniNeg']) && $_GET['uniNeg'] == 4)?'selected':''?>>Dami&aacute;n</option>
                <option value="5" <?=(isset($_GET['uniNeg']) && $_GET['uniNeg'] == 5)?'selected':''?>>Liliana</option>
                <option value="6" <?=(isset($_GET['uniNeg']) && $_GET['uniNeg'] == 6)?'selected':''?>>Consultor&iacute;a</option>
            </select>
        </div>   
        <ul class="list-group">
            <?php $i = 1; $total = 0; foreach ($datos as $key => $row) {
                if(isset($_GET['uniNeg']) && ($_GET['uniNeg'] != $row['UNI_NEG']) && $_GET['uniNeg']){
                    continue;
                }
            ?>
            <li class="list-group-item <?=($row['SALDO'] <= 0)?"list-green":"list-red"?>">
                <div class="row toggle" id="dropdown-detail-<?=$i?>" data-toggle="detail-<?=$i?>">
                    <div class="col-xs-8">
                        <?php 
                            $saldo = number_format($row['SALDO'],2,',','.');
                            $total += round($row['SALDO'], 2);
                            echo utf8_decode($row['RAZON_SOCIAL'])."(".$row['EMPRESA']."): $".$saldo;
                        ?>
                    </div>
                    <div class="col-xs-2 pull-right"><i class="fa fa-chevron-down pull-right"></i></div>
                </div>
                <div id="detail-<?=$i?>">
                    <br/>
                    <div class="table-responsive">
                            <table class="table table-responsive">
                                <tr>
                                    <th>Fecha</th>
                                    <th>Nro</th>
                                    <th>Importe</th>
                                    <th>Saldo</th>
                                    <th></th>
                                </tr>
                                <?php foreach ($getDataResult['data'] as $key => $row_item) { 
                                    if((string)$row_item['FK_ERP_EMPRESAS'] == $row['EMPRESA']){?>
                                <tr>
                                    <td><?= date('d/m/Y',strtotime($row_item['FECHA']))?></td>
                                    <td><?=$row_item['FK_ERP_COM_VEN']?></td>
                                    <td><?=number_format($row_item['IMPORTE'],2,",",".")?></td>
                                    <td class="saldo"><?=number_format($row_item['SALDO'],2,",",".")?></td>
                                    <td><?php if($row_item['SALDO'] > 0){ ?>
                                        <input style="zoom:1.5;" type="checkbox" class="tilde-recibo" id="<?=$row_item['FK_ERP_EMPRESAS']."_".$row_item['FK_ERP_COM_VEN']."_".$row_item['_FK_ERP_UNI_NEG'];?>" value="<?=$row_item['FK_ERP_COM_VEN']."_".$row_item['SALDO']."_".$row_item['FK_ERP_EMPRESAS']."_".$row_item['_FK_ERP_UNI_NEG'];?>">
                                    <?php } ?>
                                    </td>
                                </tr>
                                <?php } 
                                }?>
                            </table>
                        </div>
                </div>
            </li>
            <?php $i++;} ?>
            <li class="list-group-item total-pendiente"><?="TOTAL PENDIENTE: ".number_format($total,2,",",".")?></li>
        </ul>
	</div>
    <button class="btn btn-primary btn-gen-recibo" id="gen-recibo">Generar recibo</button>
</div>

