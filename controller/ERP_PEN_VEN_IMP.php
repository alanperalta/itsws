<?php
    require_once('../includes/ConfigItrisWS.php');
    session_start();
    $client = new SoapClient($ws);
    $parametros = array(
        'DBName' => $_SESSION['db'],
        'UserName' => $_SESSION['user'],
        'UserPwd' => $_SESSION['password'],
        'LicType' => 'WS',
        'UserSession' => ''
    );
    
    $do_login = $client->ItsLogin($parametros);
    if(!$do_login->ItsLoginResult) {

		$UserSession = $do_login->UserSession;
                $paramData = array('UserSession' => $UserSession,
 				'ItsClassName' => 'ERP_PEN_VEN_IMP',
 				'RecordCount' => 500,
 				'SQLFilter' => '',
 				'SQLSort' => 'RAZON_SOCIAL ASC'
                    
                );
		$get_data = $client->ItsGetData($paramData);
		if(!$get_data->ItsGetDataResult) {
                        $primero = true;
                        $saldo = 0;
                        $datos = array();
                        
                        $getDataResult = simplexml_load_string($get_data->XMLData);
                        //Recorro los datos y acumulo saldos por empresa
                        foreach ($getDataResult->ROWDATA->ROW as $key => $row ) {
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
                        //Asigno ultimo saldo del for de empresas
                        if(isset($empresa)){
                            $datos[] = array('EMPRESA' => $empresa, 'SALDO' => $saldo, 'RAZON_SOCIAL' => $razSoc);
                        }
                
			$do_logout = $client->ItsLogout($UserSession);

			if($do_logout->ItsLogoutResult){
                            echo ItsError($client, $UserSession);
                            exit();
			}

		} else {
			echo ItsError($client, $UserSession);
                        exit();
		}

	} else {
		echo (ItsError($client, $UserSession) . '<br>');
                exit();
	}


