<?php
    require_once('../includes/ConfigItrisWS.php');
    session_start();
    $_SESSION['db'] = $_POST['dbName'];
    $_SESSION['user'] = $_POST['user'];
    $_SESSION['password'] = $_POST['password'];
    
    $do_login = ItsLogin();
    
    $data = array();
    $data['error'] = $do_login['error'];
    if(!$data['error']){
        $_SESSION['login'] = TRUE;
        $_SESSION['userSession'] = $do_login['usersession'];
        ItsLogout($_SESSION['userSession']);
    }else{
        $data['message'] = $do_login['message'];
    }
    echo json_encode($data);
    
    
