<?php
require_once('../includes/ConfigItrisWS.php');
session_start();
$client = new SoapClient($ws);

if(isset($_SESSION['userSession'])) {
    $userSession = $_SESSION['userSession'];
    $paramData = array('UserSession' => $userSession,
                    'ItsClassName' => '_APP_PARAMETROS',
                    'RecordCount' => 1,
                    'SQLFilter' => '',
                    'SQLSort' => ''

    );
    $get_data = $client->ItsGetData($paramData);
    if(!$get_data->ItsGetDataResult) {
        $getDataResult = simplexml_load_string($get_data->XMLData);
        
        //Traigo tipo de comprobante de recibos
        $tipCom = (string)$getDataResult->ROWDATA->ROW[0]['FK_ERP_T_COM_VEN_REC'];
        
        $prepareAppend = $client->ItsPrepareAppend(array('UserSession' => $userSession, 'ItsClassName' => 'ERP_COM_VEN_REC'));

            if(!$prepareAppend->ItsPrepareAppendResult) {

                $dataset = simplexml_load_string($prepareAppend->XMLData);
                
                //Asigno valores del recibo
                $dataset->ROWDATA->ROW['FECHA']= $_POST['form-fecha'];
                $dataset->ROWDATA->ROW['FK_ERP_T_COM_VEN'] = $tipCom;
                $dataset->ROWDATA->ROW['FK_ERP_EMPRESAS'] = $_POST['form-empresa'];
                $dataset->ROWDATA->ROW['IMP_A_CTA'] = $_POST['form-importe'].'.00';
                $dataset->ROWDATA->ROW['OBSERVACIONES'] = $_POST['form-observaciones'];
                $dataset->ROWDATA->ROW['FK_ERP_UNI_NEG'] = '1';
                $dataset->ROWDATA->ROW->ERP_DET_TES->ROWERP_DET_TES[0]['FK_ERP_CUE_TES']= '14';
                $dataset->ROWDATA->ROW->ERP_DET_TES->ROWERP_DET_TES[0]['TIPO']= 'H';
                $dataset->ROWDATA->ROW->ERP_DET_TES->ROWERP_DET_TES[0]['IMPORTE']= $_POST['form-importe'].'.00';
                $dataset->ROWDATA->ROW->ERP_DET_TES->ROWERP_DET_TES[1]['FK_ERP_CUE_TES']= $_POST['form-cuenta'];
                $dataset->ROWDATA->ROW->ERP_DET_TES->ROWERP_DET_TES[1]['TIPO']= 'D';
                $dataset->ROWDATA->ROW->ERP_DET_TES->ROWERP_DET_TES[1]['IMPORTE']= $_POST['form-importe'].'.00';
                

                $oXMLData = $dataset->asXML();
                    //B.oXMLData
                    //Me guardo el XML que generó para luego modificarlo y volverlo a mandar.
                    $now = date('Ymd-H-i-s');
                    $oXMLDataXML = fopen("iXMLData".$now.".xml", "a");
                    fwrite($oXMLDataXML, $oXMLData. PHP_EOL);
                    fclose($oXMLDataXML);
                    
                $dataSession = $prepareAppend->DataSession;
                $set_data = $client->ItsSetData(array('UserSession' => $userSession, 'DataSession' => $dataSession, 'iXMLData' => $dataset->asXML()));
                if(!$set_data->ItsSetDataResult) {
                    $oXMLData = $set_data->oXMLData;
                    //B.oXMLData
                    //Me guardo el XML que generó para luego modificarlo y volverlo a mandar.
                    $now = date('Ymd-H-i-s');
                    $oXMLDataXML = fopen("oXMLData".$now.".xml", "a");
                    fwrite($oXMLDataXML, $oXMLData. PHP_EOL);
                    fclose($oXMLDataXML);

                    $post = $client->ItsPost(array('UserSession' => $userSession, 'DataSession' => $dataSession));
                    if(!$post->ItsPostResult) {
                                            // Inserción realizada con éxito.
                                            echo "Se inserto el recibo con exito";
                    } else {
                        // Fallo en la inserción. El mensaje de error queda guardado en $post['message'];
                        echo "error post: ".ItsError($client, $userSession);
                        exit();
                    }
                } else {
                    // Fallo en la inserción. El mensaje de error queda guardado en $set_data['message'];
                    echo "error setdata: ".ItsError($client, $userSession);
                    exit();
                }
            } else {
                echo "error prepareAppend: ".ItsError($client, $userSession);
                exit();
            }
    } else {
            echo "error getdata: ".$ItsError($client, $userSession);
            exit();
    }

} else {
        echo ("error login: ".ItsError($client, $userSession) . '<br>');
        exit();
}
