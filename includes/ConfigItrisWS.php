<?php
        ini_set('max_execution_time', 0);
        require_once('../includes/ItrisSDK.php');
	$ws = 'http://179.43.113.106/ITSWS/ItsCliSvrWS.asmx?WSDL';
        
        function login($db, $user, $pass) {
            $ws = 'http://179.43.113.106/ITSWS/ItsCliSvrWS.asmx?WSDL';

            $Itris = new Itris;

            // Creación del cliente SOAP con $ws. Instancia $soapClient por referencia en ItrisSDK.
            $client = $Itris->ItsCreateClient( $ws , $soapClient );

            if($client['error']){
                    $do_login = array();
                    $do_login['error'] = TRUE;
                    $do_login['message'] = $client['message'];
                    return $do_login;
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
            return $do_login;
        }
        
        function logout($userSession){
            $ws = 'http://179.43.113.106/ITSWS/ItsCliSvrWS.asmx?WSDL';

            $Itris = new Itris;

            // Creación del cliente SOAP con $ws. Instancia $soapClient por referencia en ItrisSDK.
            $client = $Itris->ItsCreateClient( $ws , $soapClient );

            if($client['error']){
                    $do_logout = array();
                    $do_logout['error'] = TRUE;
                    $do_logout['message'] = $client['message'];
                    return $do_logout;
            }
            $do_logout = $Itris->ItsLogout( $soapClient , $userSession );
            return $do_logout;
        }