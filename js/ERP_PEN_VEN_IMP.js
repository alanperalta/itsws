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
    console.log('x');
    $('.tilde-recibo:checked').each(function(){
        ele = {};
        valores = ($(this).val()).split('_');
        ele.id = valores[0];
        ele.saldo = valores[1];
        fac.push(ele);
    });
    if(fac.length > 0){
        var obj = fac.reduce(function(acc, cur, i) {
            acc[i] = cur;
            return acc;
        }, {});
        $('.contenido').load('../view/ERP_COM_VEN_REC.php', obj);
    }
}

