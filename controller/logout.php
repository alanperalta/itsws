<?php
require_once('../includes/ConfigItrisWS.php');

session_start();
unset($_SESSION['login']);  
unset($_SESSION['user']);
$client = new SoapClient($ws);
$client->ItsLogout(array($_SESSION['userSession']));
session_destroy();
header("location: ../view/login.php");

