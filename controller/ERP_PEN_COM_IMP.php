<?php
    require_once('../includes/ConfigItrisWS.php');
    session_start();
    $client = new SoapClient($ws);
//    $parametros = array(
//        'DBName' => $_SESSION['db'],
//        'UserName' => $_SESSION['user'],
//        'UserPwd' => $_SESSION['password'],
//        'LicType' => 'WS',
//        'UserSession' => ''
//    );
//    
//    $do_login = $client->ItsLogin($parametros);
//    if(!$do_login->ItsLoginResult){
    if(isset($_SESSION['userSession'])) {

		$userSession = $_SESSION['userSession'];
                $paramData = array('UserSession' => $userSession,
 				'ItsClassName' => 'ERP_PEN_COM_IMP',
 				'RecordCount' => 500,
 				'SQLFilter' => '',
 				'SQLSort' => 'RAZ_SOCIAL ASC'
                    
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

		} else {
			echo ItsError($client, $userSession);
                        exit();
		}

	} else {
		echo ('Sesi&oacute;n finalizada, debe volver a loguearse.');
                exit();
	}


