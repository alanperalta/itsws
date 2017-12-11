<?php
    require_once('../includes/ConfigItrisWS.php');
    session_start();
    $do_login = login($_SESSION['db'], $_SESSION['user'], $_SESSION['password']);
    if(!$do_login['error']) {

		$UserSession = $do_login['UserSession'];
                $Itris = new Itris;
                $client = $Itris->ItsCreateClient( $ws , $soapClient );
                
		$get_data = $Itris->ItsGetData( $soapClient ,  $UserSession , '_APP_DET_CUE_TES', 10, 'AFE_VEN = 1', 'DESCRIPCION ASC');
		if(!$get_data['error']) {
                        $txt = "";
                        foreach ($get_data['data']->ROWDATA->ROW as $key => $row ) {
                            echo  '<li class="ui-widget-content item-empresa" id="'+response[i].ID+'" onclick="verificarEmpresa();">'+response[i].DESCRIPCION+'</li>';(string)$row['FK_ERP_EMPRESAS'];
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


