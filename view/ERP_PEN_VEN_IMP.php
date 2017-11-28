<?php include_once '../controller/ERP_PEN_VEN_IMP.php';?>
<script type="text/javascript" src="../js/ERP_PEN_VEN_IMP.js"></script>
<div class="container">
	<div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Pendientes de imputaci&oacute;n de ventas</h3>
        </div>   
        <ul class="list-group">
            <?php $i = 1; foreach ($datos as $key => $row) { ?>
            <li class="list-group-item <?=($row['SALDO'] <= 0)?"list-green":"list-red"?>">
                <div class="row toggle" id="dropdown-detail-<?=$i?>" data-toggle="detail-<?=$i?>">
                    <div class="col-xs-8">
                        <?php echo $row['RAZON_SOCIAL']."(".$row['EMPRESA']."): $".number_format($row['SALDO'],2,',','.');?>
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
                                </tr>
                                <?php foreach ($get_data['data']->ROWDATA->ROW as $key => $row_item) { 
                                    if((string)$row_item['FK_ERP_EMPRESAS'] == $row['EMPRESA']){?>
                                <tr>
                                    <td><?= date('d/m/Y',strtotime($row_item['FECHA']))?></td>
                                    <td><?=$row_item['FK_ERP_COM_VEN']?></td>
                                    <td><?=$row_item['IMPORTE']?></td>
                                    <td><?=$row_item['SALDO']?></td>
                                </tr>
                                <?php } 
                                }?>
                            </table>
                        </div>
                </div>
            </li>
            <?php $i++;} ?>
        </ul>
	</div>
</div>

