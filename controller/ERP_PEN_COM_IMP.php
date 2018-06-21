<?php
    require_once('../includes/ConfigItrisWS.php');
    session_start();
    $do_login = ItsLogin();
    if(!$do_login['error']) {
        $userSession = $do_login['usersession'];
        $getDataResult = ItsGetData($userSession, 'ERP_PEN_COM_IMP', '500', '', 'RAZ_SOCIAL ASC');
        if(!$getDataResult['error']) {
                $primero = true;
                $saldo = 0;
                $datos = array();
                //Recorro los datos y acumulo saldos por empresa
                foreach ($getDataResult['data'] as $key => $row ) {
                    if($primero){
                        $primero = FALSE;
                        $empresa = (string)$row['FK_ERP_EMPRESAS'];
                        $razSoc = (string)$row['RAZ_SOCIAL'];
                        $saldo += (real)$row['SALDO'];
                    }elseif ($empresa == (string)$row['FK_ERP_EMPRESAS']) {
                        $saldo += (real)$row['SALDO'];
                    }else{
                        $datos[] = array('EMPRESA' => $empresa, 'SALDO' => $saldo, 'RAZ_SOCIAL' => $razSoc);
                        $empresa = (string)$row['FK_ERP_EMPRESAS'];
                        $razSoc = (string)$row['RAZ_SOCIAL'];
                        $saldo = (real)$row['SALDO'];
                    }
                }
                //Asigno ultimo saldo del for de empresas
                if(isset($empresa)){
                    $datos[] = array('EMPRESA' => $empresa, 'SALDO' => $saldo, 'RAZ_SOCIAL' => $razSoc);
                }
                
                ItsLogout($userSession);
        } else {
                ItsLogout($userSession);
                $error = $getDataResult['message'];
                if($error == 'Sesión no válida'){
                    header("location: ../view/login.php");
                }else{
                    echo $error;
                    exit();
                }
        }
    } else {
            echo $do_login['message'];
            exit();
    }


