<?php
    require_once('../includes/ConfigItrisWS.php');
    
    $db = $_POST['dbName'];
    $user = $_POST['user'];
    $password = $_POST['password'];
    
    $do_login = login($db, $user, $password);
    
    $data = array();
    $data['error'] = $do_login['error'];
    $data['message'] = utf8_encode($do_login['message']);
    if($data['error'] <> 1){
        session_start();
        $_SESSION['login'] = TRUE;
        $_SESSION['user'] = $user;
        $_SESSION['db'] = $db;
        $_SESSION['password'] = $password;
        $_SESSION['userSession'] = $do_login['UserSession'];
    }
    $do_logout = logout($_SESSION['userSession']);
    echo json_encode($data);
    
    
