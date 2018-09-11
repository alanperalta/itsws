<?php
require_once('../includes/ConfigItrisWS.php');

$do_login = ItsLogin();
if(!$do_login['error']) {
$userSession = $do_login['usersession'];
$getDataResult = ItsGetData($userSession, 'ERP_BANCOS', '500', '', 'DESCRIPCION ASC');
if(!$getDataResult['error']) {
    $data_bancos = array();
    foreach ($getDataResult['data'] as $row){
        $data_bancos[] = array('ID' => (string)$row['ID'], 'DESCRIPCION' => (string)$row['DESCRIPCION']);
    }
    ItsLogout($userSession);
    } else {
        ItsLogout($userSession);
        echo $getDataResult['message'];
        exit();
    }
} else{
        echo $do_login['message'];
        exit();
}
