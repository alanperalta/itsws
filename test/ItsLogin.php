<?php
	
	// Sin máximo tiempo de ejecución del thread PHP
	ini_set('max_execution_time', 0);

	/*-----------------------------------------

		require_once ItrisSDK.
		Importa al fichero la clase {Itris}.

	-------------------------------------------*/
//	require_once('../lib/nusoap.php');

	/*-----------------------------------------

		require_once ConfigItrisWS.php.
		Importa parámetros de configuración para la conexión al WebService
		{
			$ws,
			$db,
			$user,
			$pass
		}

	-------------------------------------------*/
	require_once('../includes/ConfigItrisWS.php');

	// Instancia la clase Itris importada en {ItrisSDK}
	$oSoapClient = new SoapClient($ws);
        $itsParameters = array(
				'DBName' => 'PRUEBA',
				'UserName' => 'alan',
				'UserPwd' => 'x1234567',
				'LicType' => 'WS',
				'UserSession' => ''
			);
        try{
        $LoginResponse = $oSoapClient -> ItsLogin( $itsParameters );
        } catch (Exception $e){
        echo $e->getMessage();
        }
        
	// Creación del cliente SOAP con $ws. Instancia $soapClient por referencia en ItrisSDK.
	
        $DataResult = $LoginResponse->ItsLoginResult;
			$UserSession = $LoginResponse->UserSession;

			if($DataResult == 0) {
				$response = array(
					'status' => 201,
					'message' => 'Inicio de sesión exitoso',
					'error' => false,
					'UserSession' => $UserSession
				);
			} else if ($DataResult == 1) {
				$response = $oSoapClient ->ItsGetLastError (array('UserSession' => $UserSession));
			}

			var_dump($response);
        