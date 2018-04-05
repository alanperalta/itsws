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
 				'ItsClassName' => 'ERP_PEN_VEN_IMP',
 				'RecordCount' => 500,
 				'SQLFilter' => '',
 				'SQLSort' => 'RAZON_SOCIAL ASC, _FK_ERP_UNI_NEG ASC'
                    
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
                                $uniNeg = (string)$row['_FK_ERP_UNI_NEG'];
                            }elseif ($empresa == (string)$row['FK_ERP_EMPRESAS'] && $uniNeg == (int)$row['_FK_ERP_UNI_NEG']) {
                                $saldo += (real)$row['SALDO'];
                            }else{
                                $datos[] = array('EMPRESA' => $empresa, 'SALDO' => $saldo, 'RAZON_SOCIAL' => $razSoc, 'UNI_NEG' => $uniNeg);
                                $empresa = (string)$row['FK_ERP_EMPRESAS'];
                                $razSoc = (string)$row['RAZON_SOCIAL'];
                                $saldo = (real)$row['SALDO'];
                                $uniNeg = (string)$row['_FK_ERP_UNI_NEG'];
                            }
                        }
                        //Asigno ultimo saldo del for de empresas
                        if(isset($empresa)){
                            $datos[] = array('EMPRESA' => $empresa, 'SALDO' => $saldo, 'RAZON_SOCIAL' => $razSoc, 'UNI_NEG' => $uniNeg);
                        }

		} else {
			echo ItsError($client, $userSession);
                        exit();
		}

	} else {
		echo ('Sesi&oacute;n finalizada, debe volver a loguearse.');
                exit();
	}


