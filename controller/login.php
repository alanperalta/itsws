<?php
    ini_set('max_execution_time', 0);
    require_once('../includes/ItrisSDK.php');
    require_once('../includes/ConfigItrisWS.php');
    
    $Itris = new Itris;

    // Creación del cliente SOAP con $ws. Instancia $soapClient por referencia en ItrisSDK.
    $client = $Itris->ItsCreateClient( $ws , $soapClient );

    if($client['error']){
            echo $client['message'];
    //	exit;
    }
    
    $db = $_POST['dbName'];
    $user = $_POST['user'];
    $password = $_POST['password'];
    
    $do_login = $Itris->ItsLogin( $soapClient , $db , $user , $password , $UserSession );
    
    $data = array();
    $data['error'] = $do_login['error'];
    $data['message'] = utf8_encode($do_login['message']);
    
    echo json_encode($data);
    
    
