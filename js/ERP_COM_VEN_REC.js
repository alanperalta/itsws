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
            dataType: 'json',
            beforeSend: function (xhr) {
                $('#lista-empresas').html(
                    '<div id="loading-empresas">Buscando... <i class="fa fa-refresh fa-spin" style="font-size:24px"></i></div>'
                );
            }
        }).done( function (response) {
            fila = '';
            //Recorro el JSON y agrego un item de lista por cada empresa encontrada
            $.each(response, function(i, member) {
                fila += '<li class="ui-widget-content item-empresa" id="'+response[i].ID+'">'+response[i].DESCRIPCION+'</li>';
            });
            $('#lista-empresas').html(fila);
            $('#lista-empresas').selectable({
                selected: function(e, ui){
                    seleccion = $('li.ui-selected').length;
                    if(seleccion === 1){
                        $('#btn-modal-empresa').prop("disabled", false);
                    }else $('#btn-modal-empresa').prop("disabled", true);
                }
            });
            $('#loading-empresas').hide();
            $('#modal-input-empresa').blur();
        });
    }
});

//Muestro pop-up de empresas
$('#btn-empresas').on("click", function(e){
    e.preventDefault();
    $('#modal-empresas').modal("show");
    $('#modal-input-empresa').focus();
});