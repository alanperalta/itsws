<?php
require_once('../includes/ConfigItrisWS.php');
session_start();

$do_login = ItsLogin();
$response = array();
if(!$do_login['error']) {
    $userSession = $do_login['usersession'];
    $getDataResult = ItsGetData($userSession, '_APP_PARAMETROS');
    if(!$getDataResult['error']) {
        //Traigo tipo de comprobante de recibos
        $tipCom = (string)$getDataResult['data'][0]['FK_ERP_T_COM_VEN_REC'];

                $dataset = array();
                
                //Asigno campos del recibo
                $dataset['FECHA']= $_POST['form-fecha'];
                $dataset['FK_ERP_T_COM_VEN'] = $tipCom;
                $dataset['FK_ERP_EMPRESAS'] = $_POST['form-empresa'];
                $dataset['OBSERVACIONES'] = $_POST['form-observaciones'];
                $dataset['FK_ERP_UNI_NEG'] = (int)$_POST['form-uni-neg'];
                
                //Detalle de imputaciones
                $imputado = 0;
                for ($i = 0; $i < $_POST['cant-fac']; $i++) {
                    $dataset['ERP_IMP_VEN'][$i]['FK_ERP_DEB_VEN']= $_POST['form-fac-'.$i];
                    $dataset['ERP_IMP_VEN'][$i]['IMP_COT']= (float)$_POST['form-imp-fac-'.$i];
                    $imputado += (float)$_POST['form-imp-fac-'.$i];
                }
                $dataset['IMP_A_CTA'] = (float)($_POST['form-importe'] - $imputado);
                
                //Detalle de tesorería
                $dataset['ERP_DET_TES'][0]['FK_ERP_CUE_TES']= (int)$getDataResult['data'][0]['FK_ERP_CUE_TES'];
                $dataset['ERP_DET_TES'][0]['TIPO']= 'H';
                $dataset['ERP_DET_TES'][0]['UNIDADES']= (float)$_POST['form-importe'];
                $dataset['ERP_DET_TES'][1]['FK_ERP_CUE_TES']= (int)$_POST['form-cuenta'];
                $dataset['ERP_DET_TES'][1]['TIPO']= 'D';
                $dataset['ERP_DET_TES'][1]['UNIDADES']= (float)$_POST['form-importe'];

                $post = ItsPostData($userSession, 'ERP_COM_VEN_REC', $dataset);
                ItsLogout($userSession);
                $response['error'] = $post['error'];
                $response['message'] = $post['message'];
    } else {
            ItsLogout($userSession);
            $response['message'] = $getDataResult['message'];
            $response['error'] = $getDataResult['error'];
            if($response['message'] == 'Sesión no válida'){
                header("location: ../view/login.php");
            }
    }

} else {
        $response['message'] = $do_login['message'];
        $response['error'] = $do_login['error'];
}

echo json_encode($response);
