<?php
require_once('../includes/ConfigItrisWS.php');
session_start();
$client = new SoapClient($ws);

if(isset($_SESSION['userSession'])) {

    $userSession = $_SESSION['userSession'];
    $paramData = array('UserSession' => $userSession,
                    'ItsClassName' => 'ERP_EMPRESAS',
                    'RecordCount' => 10,
                    'SQLFilter' => "DESCRIPCION LIKE '%".$_POST['clave']."%'",
                    'SQLSort' => 'DESCRIPCION ASC'

    );
    $get_data = $client->ItsGetData($paramData);
    if(!$get_data->ItsGetDataResult) {
        $data = array();
        $getDataResult = simplexml_load_string($get_data->XMLData);
        
        foreach ($getDataResult->ROWDATA->ROW as $row){
            $data[] = array('ID' => (string)$row['ID'], 'DESCRIPCION' => (string)$row['DESCRIPCION']);
        }
        $json = json_encode($data);
        echo $json;

    } else {
        echo ItsError($client, $userSession);
        exit();
    }
} else {
    echo ('Sesi&oacute;n finalizada, debe volver a loguearse.');
    exit();
}

