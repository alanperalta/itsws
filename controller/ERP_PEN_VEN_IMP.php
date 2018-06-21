<?php
    require_once('../includes/ConfigItrisWS.php');
    session_start();
    $do_login = ItsLogin();
    if(!$do_login['error']) {
        $userSession = $do_login['usersession'];
        $getDataResult = ItsGetData($userSession, 'ERP_PEN_VEN_IMP', '500', '', 'RAZON_SOCIAL ASC, _FK_ERP_UNI_NEG ASC');
        if(!$getDataResult['error']) {
                $primero = true;
                $saldo = 0;
                $datos = array();
                //Recorro los datos y acumulo saldos por empresa
                foreach ($getDataResult['data'] as $key => $row ) {
                    if($primero){
                        $primero = FALSE;
                        $empresa = (string)$row['FK_ERP_EMPRESAS'];
                        $razSoc = utf8_encode((string)$row['RAZON_SOCIAL']);
                        $saldo += (real)$row['SALDO'];
                        $uniNeg = (string)$row['_FK_ERP_UNI_NEG'];
                    }elseif ($empresa == (string)$row['FK_ERP_EMPRESAS'] && $uniNeg == (int)$row['_FK_ERP_UNI_NEG']) {
                        $saldo += (real)$row['SALDO'];
                    }else{
                        $datos[] = array('EMPRESA' => $empresa, 'SALDO' => $saldo, 'RAZON_SOCIAL' => $razSoc, 'UNI_NEG' => $uniNeg);
                        $empresa = (string)$row['FK_ERP_EMPRESAS'];
                        $razSoc = utf8_encode((string)$row['RAZON_SOCIAL']);
                        $saldo = (real)$row['SALDO'];
                        $uniNeg = (string)$row['_FK_ERP_UNI_NEG'];
                    }
                }
                //Asigno ultimo saldo del for de empresas
                if(isset($empresa)){
                    $datos[] = array('EMPRESA' => $empresa, 'SALDO' => $saldo, 'RAZON_SOCIAL' => $razSoc, 'UNI_NEG' => $uniNeg);
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


