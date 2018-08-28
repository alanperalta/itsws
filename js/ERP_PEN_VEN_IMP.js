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
    var uni_neg = '';
    var ok = true;
    $('.tilde-recibo:checked').each(function(){
        var id = $(this).attr('id');
        emp = id.split('_');
        if(empresa == ''){
            empresa = emp[0];
            uni_neg = emp[2];
        }else{
            if(empresa != emp[0] || uni_neg != emp[2]){
                ok = false;
                return false;
            }
        }
    });
    if(ok){
        generarRecibo();
    }else{
        alert('No se puede generar un recibo para facturas de distintas empresas o distintas unidades de negocios');
    }
});

//Genera recibo
function generarRecibo(){
    var fac = [];
    $('.tilde-recibo:checked').each(function(){
        ele = {};
        valores = ($(this).val()).split('_');
        ele.id = valores[0];
        ele.saldo = valores[1];
        ele.empresa = valores[2];
        ele.uni_neg = valores[3];
        fac.push(ele);
    });
    
    //????????? no se que es esto pero es lo que necesitaba para que ande el código
    if(fac.length > 0){
        var obj = fac.reduce(function(acc, cur, i) {
            acc[i] = cur;
            return acc;
        }, {});
        $('.contenido').load('../view/ERP_COM_VEN_REC.php', obj);
    }
}

