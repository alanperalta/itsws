<?php include_once '../controller/ERP_PEN_VEN_IMP.php';?>
<script type="text/javascript" src="../js/ERP_PEN_VEN_IMP.js"></script>
<div class="container">
	<div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">Pendientes de imputaci&oacute;n de ventas</h3>
        </div>   
        <ul class="list-group">
            <?php $i = 1; foreach ($datos as $row) { ?>
            <li class="list-group-item">
                <div class="row toggle" id="dropdown-detail-<?=$row['']?>" data-toggle="detail-<?=$i?>">
                    <div class="col-xs-10">
                        Item <?php echo $key.": ".array_sum(array_column($row[$key],'IMPORTE'));?>
                    </div>
                    <div class="col-xs-2"><i class="fa fa-chevron-down pull-right"></i></div>
                </div>
                <div id="detail-<?=$i?>">
                    <hr></hr>
                    <div class="container">
                        <div class="fluid-row">
                            <div class="col-xs-1">
                                Detail:
                            </div>
                            <div class="col-xs-5">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            </div>
                            <div class="col-xs-1">
                                Detail:
                            </div>
                            <div class="col-xs-5">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            </div>
                            <div class="col-xs-1">
                                Detail:
                            </div>
                            <div class="col-xs-5">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            </div>
                            <div class="col-xs-1">
                                Detail:
                            </div>
                            <div class="col-xs-5">
                                Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                            </div>
                        </div>
                    </div>
                </div>
            </li>
            <?php $i++;} ?>
        </ul>
	</div>
</div>

