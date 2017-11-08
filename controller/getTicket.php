<?php
	ini_set('max_execution_time', 0);
	require_once('../includes/ItrisSDK.php');
        require_once('../includes/ConfigItrisWS.php');

	// Instancia la clase Itris importada en {ItrisSDK}
	$Itris = new Itris;

	// Creación del cliente SOAP con $ws. Instancia $soapClient por referencia en ItrisSDK.
	$client = $Itris->ItsCreateClient( $ws , $soapClient );
	
	if($client['error']){
		echo $client['message'];
	//	exit;
	}

	/*--------------------------------------------------

		Ejecuta el método ItsLogin instanciado en la clase Itris.
		Recibe como parámetros obligatorios:
		{
			$soapClient: Instanciado por referencia en ItrisSDK,
			$db,
			$user,
			$pass
		}

	----------------------------------------------------*/
	$do_login = $Itris->ItsLogin( $soapClient , $db , $user , $pass , $UserSession );

	// Todos los métodos devuelven un objeto con el parámetro BOOL {'error'}.
	if(!$do_login['error']) {

		$UserSession = $do_login['UserSession'];

		/*--------------------------------------------------

		Ejecuta el método ItsGetData instanciado en la clase Itris.
		Recibe como parámetros obligatorios:
		{
			$soapClient: Instanciado por referencia en ItrisSDK,
			$UserSession: Token de sesión del usuario,
			$ItsClass: Clase de Itris a ejecutar ItsGetData
		}

		Recibe como parámetros opcionales: 
		{
			$RecordCount: Cantidad de registros que devolverá el método. Debe indicarse '-1' si se desean obtener 				  todos los registros. Default: 10,
			$SQLFilter: Filtro SQL a aplicar a la consulta en formato ' ID = {ID} '. Default: '',
			$SQLSort: Equivalente al comando SQL ORDER BY en formato ' ID ASC '. Default: ''
		}

		----------------------------------------------------*/
		$get_data = $Itris->ItsGetData( $soapClient ,  $UserSession , '_DEM_COM_NOV', 1);
                var_dump($get_data['data']->ROWDATA->ROW[0]);
		if(!$get_data['error']) {
                    
			echo 'Ticket: '.$get_data['data']->ROWDATA->ROW[0]['ID'].'<br/>';
                        echo 'Estado: '.$get_data['data']->ROWDATA->ROW[0]['Z_ESTADO'].'<br/>';
                        echo 'Fecha: '.$get_data['data']->ROWDATA->ROW[0]['FECHA'].'<br/>';
                        echo 'Descripcion: '.$get_data['data']->ROWDATA->ROW[0]['DESCRIPCION'].'<br/>';
                        echo 'Empresa: '.$get_data['data']->ROWDATA->ROW[0]['RAZ_SOCIAL'].'<br/><br/>';
                        echo '<a href="../index.php">Consultar otro ticket</a>';
                        
			$do_logout = $Itris->ItsLogout( $soapClient , $UserSession );

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