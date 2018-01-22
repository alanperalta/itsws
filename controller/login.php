<?php
    require_once('../includes/ConfigItrisWS.php');
    
    $db = $_POST['dbName'];
    $user = $_POST['user'];
    $password = $_POST['password'];
    
    $client = new SoapClient($ws);
    $parametros = array(
        'DBName' => $db,
        'UserName' => $user,
        'UserPwd' => $password,
        'LicType' => 'WS',
        'UserSession' => ''
    );
    
    $do_login = $client->ItsLogin($parametros);
    
    $data = array();
    $data['error'] = $do_login->ItsLoginResult;
    if($data['error'] <> 1){
        session_start();
        $_SESSION['login'] = TRUE;
        $_SESSION['user'] = $user;
        $_SESSION['db'] = $db;
        $_SESSION['password'] = $password;
        $_SESSION['userSession'] = $do_login->UserSession;
        //$client->ItsLogout(array('UserSession' => $_SESSION['userSession']));
    }else{
        $data['message'] = ItsError($client, $do_login->UserSession);
    }
    
    echo json_encode($data);
    
    
