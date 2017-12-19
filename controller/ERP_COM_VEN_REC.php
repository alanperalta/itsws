<?php
require_once('../includes/ConfigItrisWS.php');
session_start();
$do_login = login($_SESSION['db'], $_SESSION['user'], $_SESSION['password']);
if(!$do_login['error']) {
    $UserSession = $do_login['UserSession'];
    $Itris = new Itris;
    $client = $Itris->ItsCreateClient( $ws , $soapClient );

    $get_data = $Itris->ItsGetData( $soapClient ,  $UserSession , '_APP_PARAMETROS');
    if(!$get_data['error']) {
        //Traigo tipo de comprobante de recibos
        $tipCom = (string)$get_data['data']->ROWDATA->ROW[0]['FK_ERP_T_COM_VEN_REC'];
        
        $prepareAppend = $Itris->ItsPrepareAppend( $soapClient , $UserSession , 'ERP_COM_VEN_REC' );

            if(!$prepareAppend['error']) {

                //Asigno valores del recibo
                $dataset = $prepareAppend['data'];
                $dataset->ROWDATA->ROW[0]->FECHA = $_POST['form-fecha'];
                $dataset->ROWDATA->ROW[0]->FK_ERP_T_COM_VEN = $tipCom;
                $dataset->ROWDATA->ROW[0]->FK_ERP_EMPRESAS = $_POST['form-empresa'];
                $dataset->ROWDATA->ROW[0]->IMP_A_CTA = $_POST['form-importe'];
                $dataset->ROWDATA->ROW[0]->OBSERVACIONES = $_POST['form-observaciones'];
                $dataset->ROWDATA->ROW[0]->ERP_DET_TES->FK_ERP_CUE_TES = $_POST['form-cuenta'];
                $dataset->ROWDATA->ROW[0]->ERP_DET_TES->ROWTIPO = 'D';

                $set_data = $Itris->ItsSetData( $soapClient , $UserSession , $prepareAppend['DataSession'] , $dataset );
                if(!$set_data['error']) {

                    $post = $Itris->ItsPost( $soapClient, $UserSession , $prepareAppend['DataSession'] );
                    if(!$post['error']) {
                                            // Inserción realizada con éxito.
                                            echo "Se inserto el recibo con exito";
                    } else {
                        // Fallo en la inserción. El mensaje de error queda guardado en $post['message'];
                        echo "error post: ".$post['message'];
                    }
                } else {
                    // Fallo en la inserción. El mensaje de error queda guardado en $set_data['message'];
                    echo "error setdata: ".$set_data['message'];
                }

                $do_logout = logout($UserSession);

                if($do_logout['error']){
                    echo "error logout: ".$do_logout['message'];
                    exit();
                }
            } else {
                echo "error prepareAppend: ".$prepareAppend['message'];
                exit();
            }
    } else {
            echo "error getdata: ".$get_data['message'];
            exit();
    }

} else if ($do_login['error']) {
        echo ("error login: ".$do_login['message'] . '<br>');
        exit();
}
