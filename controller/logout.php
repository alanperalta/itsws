<?php
require_once('../includes/ConfigItrisWS.php');

session_start();
unset($_SESSION['login']);  
unset($_SESSION['user']);
session_destroy();
header("location: ../view/login.php");

