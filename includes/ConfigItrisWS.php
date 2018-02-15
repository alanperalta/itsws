<?php
        ini_set('max_execution_time', 0);
//        require_once('../includes/ItrisSDK.php');
	$ws = 'http://179.43.113.106/ITSWS/ItsCliSvrWS.asmx?WSDL';
        
        function ItsError($client, $userSession){
            $error = $client->ItsGetLastError(array('UserSession' => $userSession));
            return $error->Error;
        }