function cargarContenido(id){
        $('.contenido').load('../view/'+id+'.php');
        $('.toggle-btn').click();
}
