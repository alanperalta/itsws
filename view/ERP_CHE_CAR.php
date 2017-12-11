<?php include_once '../controller/ERP_CHE_CAR.php';?>
<!-- <script type="text/javascript" src="../js/ERP_CHE_CAR.js"></script> -->
<div class="container">
	<div class="panel panel-default">
    <div class="panel-heading">
        <h3 class="panel-title">Valores en cartera ($ <?php echo number_format($saldo,2,',','.') ?>) </h3>
    </div>   
    <div class="table-responsive">
        <table class="table table-responsive">
            <tr>
                <th>Fecha dep.</th>
                <th>Nro</th>
                <th>Empresa</th>
                <th>Importe</th>
                <th>Banco</th>
            </tr>
            <?php foreach ($get_data['data']->ROWDATA->ROW as $key => $row_item) { ?>
              <tr>
                  <td><?= date('d/m/Y',strtotime($row_item['FEC_DEP']))?></td>
                  <td><?=$row_item['NUMERO']?></td>
                  <td><?=$row_item['RAZ_SOCIAL']?></td>
                  <td><?=$row_item['IMPORTE']?></td>
                  <td><?=$row_item['DES_BANCOS']?></td>
              </tr>
            <?php }?>
        </table>
    </div>
	</div>
</div>

