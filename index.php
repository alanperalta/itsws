<?php 
    session_start();
    if(isset($_SESSION['login']) && $_SESSION['login']){
        header("location: view/menu.php");
    }else header("location: view/login.php");;