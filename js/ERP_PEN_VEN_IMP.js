//Esto sirve para abrir el detalle de los pendientes haciendo clic en el nombre del grupo
$(document).ready(function() {
    $('[id^=detail-]').hide();
    $('.toggle').click(function() {
        $input = $( this );
        $target = $('#'+$input.attr('data-toggle'));
        $target.slideToggle();
    });
});

//Validar generar recibo en base a facturas
$('#gen-recibo').on('click', function(){
    var empresa = '';
    var ok = true;
    $('.tilde-recibo:checked').each(function(){
        var id = $(this).attr('id');
        emp = id.split('_');
        if(empresa == ''){
            empresa = emp[0];
        }else{
            if(empresa != emp[0]){
                ok = false;
                return false;
            }
        }
    });
    if(ok){
        generarRecibo();
    }else{
        alert('No se puede generar un recibo para facturas de distintas empresas');
    }
});

//Genera recibo
function generarRecibo(){
    var fac = [];
    $('.tilde-recibo:checked').each(function(){
        fac.push($(this).val());
    });
    $.ajax({
        type: "POST",
        url: "script.php",
        data: {data : fac}, 
        cache: false,

        success: function(){
            alert("OK");
        }
    });
}

