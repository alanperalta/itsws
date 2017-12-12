<?php
require_once('../includes/ConfigItrisWS.php');
session_start();
$do_login = login($_SESSION['db'], $_SESSION['user'], $_SESSION['password']);
if(!$do_login['error']) {
    $UserSession = $do_login['UserSession'];
    $Itris = new Itris;
    $client = $Itris->ItsCreateClient( $ws , $soapClient );

    $get_data = $Itris->ItsGetData( $soapClient ,  $UserSession , '_APP_DET_CUE_TES', 10, 'AFE_VEN = 1', 'DESCRIPCION ASC');
    if(!$get_data['error']) {
        $do_logout = logout($UserSession);

        if($do_logout['error']){
            echo $do_logout['message'];
            exit();
        }
        $data = array();
        foreach ($get_data['data']->ROWDATA->ROW as $row){
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
            echo $get_data['message'];
            exit();
    }

} else if ($do_login['error']) {
        echo ($do_login['message'] . '<br>');
        exit();
}
