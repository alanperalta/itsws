<?php
require_once('../includes/ConfigItrisWS.php');
session_start();
$do_login = ItsLogin();
    if(!$do_login['error']) {
    $userSession = $do_login['usersession'];
    $getDataResult = ItsGetData($userSession, 'ERP_EMPRESAS', '10', "DESCRIPCION LIKE '%".$_POST['clave']."%'".$_POST['filtro'], 'DESCRIPCION ASC');
    if(!$getDataResult['error']) {
        $data = array();
        foreach ($getDataResult['data'] as $row){
            $data[] = array('ID' => (string)$row['ID'], 'DESCRIPCION' => (string)$row['DESCRIPCION']);
        }
        ItsLogout($userSession);
        $json = json_encode($data);
        echo $json;
    } else {
        ItsLogout($userSession);
        echo $getDataResult['message'];
        exit();
    }
} else {
    echo $do_login['message'];
    exit();
}

