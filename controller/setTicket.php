<?php
    ini_set('max_execution_time', 0);
	require_once('../includes/ItrisSDK.php');
        require_once('../includes/ConfigItrisWS.php');

	// Instancia la clase Itris importada en {ItrisSDK}
	$Itris = new Itris;

	// Creación del cliente SOAP con $ws. Instancia $soapClient por referencia en ItrisSDK.
	$client = $Itris->ItsCreateClient( $ws , $soapClient );
    
    $do_login = $Itris->ItsLogin( $soapClient , $db , $user , $pass , $UserSession );
    if(!$do_login['error']) {
        $UserSession = $do_login['UserSession'];
        $do_prepare_append = $Itris->ItsPrepareAppend( $soapClient , $UserSession , '_DEM_COM_NOV' );
        if(!$do_prepare_append['error']) {
            // Ejemplo: setear fecha y empresa del pedido
            $DataSession = $do_prepare_append['DataSession'];
            $dataset = $do_prepare_append['data'];
            $row_data = $dataset->ROWDATA->ROW[0];
            $row_data['FECHA'] = "20171111T11:25:28000";
            $row_data['FK_ERP_EMPRESAS'] = 'CONSULTABLE';
            $row_data['CONTACTO'] = '162';
            $row_data['MODULO'] = 'V';
            $row_data['ESTADO'] = 'C';
            $row_data['ORIGEN'] = 'E';
            $row_data['DESCRIPCION'] = 'PRUEBA DE WS';
            $row_data['RESPONSABLE'] = 'C';
            $row_data['USER_RESPONSABLE'] = 'ALAN';
            $row_data['ESTADO_SERVICIO'] = 'A';
            
            $do_set_data = $Itris->ItsSetData( $soapClient , $UserSession , $DataSession , $dataset );
            if(!$do_set_data['error']) {
                // Inserción exitosa
                $do_post = $Itris->ItsPost( $soapClient, $UserSession , $DataSession );
                if(!$do_post['error']) {
                    // Inserción realizada con éxito.
                } else {
                    echo $do_post['message'];
                }
            } else {
                // Fallo en el SetData. El mensaje de error queda guardado en $do_set_data['message'];
                echo $do_set_data['message'];
            }
        } else {
            echo $do_prepare_append['message'];
        }
    }
    