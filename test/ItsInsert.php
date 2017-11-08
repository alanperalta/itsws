<?php
	
	ini_set('max_execution_time', 0);
	require_once('../ItrisSDK.php');
	require_once('../ConfigItrisWS.php');

	// Instancia la clase Itris importada en {ItrisSDK}
	$Itris = new Itris;

	// Creación del cliente SOAP con $ws. Instancia $soapClient por referencia en ItrisSDK.
	$client = $Itris->ItsCreateClient( $ws , $soapClient );
	
	if($client['error']){
		echo $client['message'];
		exit;
	};

	$do_login = $Itris->ItsLogin( $soapClient , $db , $user , $pass , $UserSession );

	// Todos los métodos devuelven un objeto con el parámetro BOOL {'error'}.
	if(!$do_login['error']) {

		$UserSession = $do_login['UserSession'];

		$prepare_append = $Itris->ItsPrepareAppend( $soapClient , $UserSession , 'ERP_PAISES' );

		if(!$prepare_append['error']) {
			$DataSession = $prepare_append['DataSession'];
            $dataset = $prepare_append['data'];
            $dataset->ROWDATA->ROW[0]->DESCRIPCION = 'PAIS_TEST_WS';
            $dataset->ROWDATA->ROW[0]->SIGLA = 'ws';
            
            $set_data = $Itris->ItsSetData( $soapClient , $UserSession , $DataSession , $dataset );
            if(!$set_data['error']) {

                $post = $Itris->ItsPost( $soapClient, $UserSession , $DataSession );
                if(!$post['error']) {
					// Inserción realizada con éxito.
					echo "Se inserto el pais con exito";
                } else {
                    // Fallo en la inserción. El mensaje de error queda guardado en $post['message'];
                }
            } else {
                // Fallo en la inserción. El mensaje de error queda guardado en $set_data['message'];
                echo $set_data['message'];
            }
		} else {
			echo $prepare_append['message'];
		}

	}