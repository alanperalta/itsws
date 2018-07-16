function cargarContenido(id, filtro){
    $parametros = '';
    if(filtro && id == 'ERP_PEN_VEN_IMP'){
        $parametros = '?uniNeg='+filtro;
    }
        $('.contenido').html('<div id="loading-contenido">Cargando... <i class="fa fa-refresh fa-spin" style="font-size:24px"></i></div>');
        $('.contenido').load('../view/'+id+'.php'+$parametros);
        $('.toggle-btn').click();
}
