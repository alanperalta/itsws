<?php
    require_once('../includes/ConfigItrisWS.php');
    session_start();
    $do_login = ItsLogin();
    if(!$do_login['error']) {
        $userSession = $do_login['usersession'];
        $get_data = ItsGetData( $userSession, 'ERP_CHE_CAR', '500', '', 'FEC_DEP ASC');
        if(!$get_data['error']) {
                $saldo = 0;
                //Recorro los datos, acumulo saldos de cheques y guardo en array
                foreach ($get_data['data'] as $key => $row ) {
                    $saldo += (real)$row['IMPORTE'];                       
                }

                $do_logout = ItsLogout($userSession);

                if($do_logout['error']){
                    echo $do_logout['message'];
                    exit();
                }

        } else {
            ItsLogout($userSession);
            echo $get_data['message'];
            exit();
        }

    } else if ($do_login['error']) {
            echo ($do_login['message'] . '<br>');
            exit();
    }


