<?php
    require_once('../includes/ConfigItrisWS.php');
    session_start();
    $do_login = login($_SESSION['db'], $_SESSION['user'], $_SESSION['password']);
    if(!$do_login['error']) {

		$UserSession = $do_login['UserSession'];
                $Itris = new Itris;
                $client = $Itris->ItsCreateClient( $ws , $soapClient );
                
		$get_data = $Itris->ItsGetData( $soapClient ,  $UserSession , 'ERP_CHE_CAR', 500, '', 'FEC_DEP ASC');
		if(!$get_data['error']) {
                        $saldo = 0;
                        //Recorro los datos, acumulo saldos de cheques y guardo en array
                        foreach ($get_data['data']->ROWDATA->ROW as $key => $row ) {
                            $saldo += (real)$row['IMPORTE'];                       
                        }
                
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


