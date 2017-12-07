//modo = 0: Menú de recibos
//Modo = 1: Recibo nuevo
//Modo = 2: Recibo en base a factura

function nuevoRecibo(){
    $('.contenido').load('../view/ERP_COM_VEN_REC.php?mode=1');
}

function nuevoReciboEnBase(){
    $('.contenido').load('../view/ERP_COM_VEN_REC.php?mode=2');
}

function volverRecibo(){
    $('.contenido').load('../view/ERP_COM_VEN_REC.php?mode=0');
}

function seleccionarEmpresa(){
    $('#form-empresa').val($('li.ui-selected').attr('id'));
    $('#modal-empresas').modal('hide');
}

//Si apreto enter en el campo empresa, no intenta submit, ejecuta la función para buscar empresas
$('#modal-input-empresa').keypress(function(event) {
    if (event.keyCode === 10 || event.keyCode === 13){ 
        event.preventDefault();
        var parametros = {
            'clave':$('#modal-input-empresa').val()
        };
        $.ajax({
            data:  parametros,
            url:   '../controller/ERP_EMPRESAS.php',
            type:  'post',
            dataType: 'json'
        }).done( function (response) {
            fila = '';
            $.each(response, function(i, member) {
                fila += '<li class="ui-widget-content" id="'+response[i].ID+'">'+response[i].DESCRIPCION+'</li>';
            });
            $('#lista-empresas').html(fila);
            $('#lista-empresas').selectable();
            
        });
    }
});

$('#btn-empresas').on("click", function(){
    $('#modal-empresas').modal("show");
});