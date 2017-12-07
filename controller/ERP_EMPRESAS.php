<?php
require_once('../includes/ConfigItrisWS.php');
session_start();
$do_login = login($_SESSION['db'], $_SESSION['user'], $_SESSION['password']);
if(!$do_login['error']) {
    $UserSession = $do_login['UserSession'];
    $Itris = new Itris;
    $client = $Itris->ItsCreateClient( $ws , $soapClient );

    $get_data = $Itris->ItsGetData( $soapClient ,  $UserSession , 'ERP_EMPRESAS', 10, "DESCRIPCION LIKE '%".$_POST['clave']."%'", 'DESCRIPCION ASC');
    if(!$get_data['error']) {
        $do_logout = logout($UserSession);

        if($do_logout['error']){
            echo $do_logout['message'];
            exit();
        }
        $data = array();
        foreach ($get_data['data']->ROWDATA->ROW as $row){
            $data[] = array('ID' => (string)$row['ID'], 'DESCRIPCION' => (string)$row['DESCRIPCION']);
        }
        $json = json_encode($data);
        echo $json;

    } else {
            echo $get_data['message'];
            exit();
    }

} else if ($do_login['error']) {
        echo ($do_login['message'] . '<br>');
        exit();
}
