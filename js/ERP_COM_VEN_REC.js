function nuevoRecibo(){
    $('.contenido').load('../view/ERP_COM_VEN_REC.php?mode=1');
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
                fila += '<li class="ui-widget-content item-empresa" onclick="seleccionarEmpresa()" id="'+response[i].ID+'">'+response[i].DESCRIPCION+'</li>';
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

$('.fac-imp').on('change', function(){
    total = 0;
    $('.fac-imp').each(function(){
        total += $(this).val();
    });
    $('#form-importe').val(total);
});

function saldoCuenta(){
  saldo = parseFloat($('#saldo-cuenta-original').html());
  total = 0.00;
  $('.form-cuenta').each(function(){
      total += (parseFloat($(this).val()) || 0); //Convierte NaN a 0
  });
  saldo -= total;
  $('#saldo-cuenta').html(saldo.toFixed(2));
  
  if(saldo){
    $('button.next2').prop('disabled', true);
  }else $('button.next2').prop('disabled', false);
};

function completaSaldo(e){
    e.value = (parseFloat($('#saldo-cuenta').html()) || 0) + (parseFloat(e.value) || 0);
    saldoCuenta();
}