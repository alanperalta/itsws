<?php
require_once('../includes/ConfigItrisWS.php');
session_start();

$client = new SoapClient($ws);
if(isset($_SESSION['userSession'])) {

$userSession = $_SESSION['userSession'];
$paramData = array('UserSession' => $userSession,
                'ItsClassName' => '_APP_DET_CUE_TES',
                'RecordCount' => 10,
                'SQLFilter' => 'AFE_VEN = 1',
                'SQLSort' => 'DESCRIPCION ASC'

);
$get_data = $client->ItsGetData($paramData);
if(!$get_data->ItsGetDataResult) {
    $getDataResult = simplexml_load_string($get_data->XMLData);
    $data = array();
    foreach ($getDataResult->ROWDATA->ROW as $row){
        $id = (string)$row['FK_ERP_CUE_TES'];
        //Hago esto, porque por algun motivo, el ID de la cuenta viene con un punto al final
        if(substr($id, -1) == "."){
            $id = substr($id, 0, -1);
        }
        $data[] = array('ID' => $id, 'DESCRIPCION' => (string)$row['DESCRIPCION']);
    }
    $json = json_encode($data);
    echo $json;

    } else {
            echo ItsError($client, $userSession);
            exit();
    }

} else{
        echo ItsError($client, $userSession);
        exit();
}
