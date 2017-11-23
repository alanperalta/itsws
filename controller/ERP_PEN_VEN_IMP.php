<?php
    require_once('../includes/ConfigItrisWS.php');
    session_start();
    $do_login = login($_SESSION['db'], $_SESSION['user'], $_SESSION['password']);
    if(!$do_login['error']) {

		$UserSession = $do_login['UserSession'];
                $Itris = new Itris;
                $client = $Itris->ItsCreateClient( $ws , $soapClient );
                
		$get_data = $Itris->ItsGetData( $soapClient ,  $UserSession , 'ERP_PEN_VEN_IMP', 10, '', 'RAZON_SOCIAL ASC');
		if(!$get_data['error']) {
                        $primero = true;
                        $saldo = 0;
                        $datos = array();
                        foreach ($get_data['data']->ROWDATA->ROW as $key => $row ) {
                            if($primero){
                                $primero = FALSE;
                                $empresa = (string)$row['FK_ERP_EMPRESAS'];
                                $razSoc = (string)$row['RAZON_SOCIAL'];
                                $saldo += (real)$row['SALDO'];
                            }elseif ($empresa == (string)$row['FK_ERP_EMPRESAS']) {
                                $saldo += (real)$row['SALDO'];
                            }else{
                                $datos[] = array('EMPRESA' => $empresa, 'SALDO' => $saldo, 'RAZON_SOCIAL' => $razSoc);
                                $empresa = (string)$row['FK_ERP_EMPRESAS'];
                                $razSoc = (string)$row['RAZON_SOCIAL'];
                                $saldo = (real)$row['SALDO'];
                            }
                        }
                        $datos[] = array('EMPRESA' => $empresa, 'SALDO' => $saldo, 'RAZON_SOCIAL' => $razSoc);

                
			$do_logout = logout($UserSession);

			if($do_logout['error']){
                            echo $do_logout['message'];
                            exit();
			}

		} else {
			echo $get_data['message'];
                        exit();
		}

	} else if ($do_login['error']) {
		echo ($do_login['message'] . '<br>');
                exit();
	}


