<?php
require_once('../includes/ConfigItrisWS.php');
session_start();

$do_login = ItsLogin();
if(!$do_login['error']) {
$userSession = $do_login['usersession'];
$getDataResult = ItsGetData($userSession, 'ERP_CUE_TES', '10', 'AFE_VEN = 1 AND _APP = 1', 'DESCRIPCION ASC');
if(!$getDataResult['error']) {
    $data = array();
    foreach ($getDataResult['data'] as $row){
        $id = (string)$row['ID'];
        $data[] = array('ID' => $id, 'DESCRIPCION' => (string)$row['DESCRIPCION']);
    }
    ItsLogout($userSession);
    $json = json_encode($data);
    echo $json;
    } else {
        ItsLogout($userSession);
        echo $getDataResult['message'];
        exit();
    }

} else{
        echo $do_login['message'];
        exit();
}
