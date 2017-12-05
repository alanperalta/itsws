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

//Si apreto enter en el campo empresa, no intenta submit, ejecuta la función para buscar empresas
$("#form-empresa").keypress(function(event) {
    if (event.keyCode === 10 || event.keyCode === 13){ 
        event.preventDefault();
        var parametros = {
            'clave':$("#form-empresa").val()
        };
        $.ajax({
            data:  parametros,
            url:   '../controller/ERP_EMPRESAS.php',
            type:  'post',
            dataType: 'json'
        }).done( function (response) {
             
             alert(response);
            }
        );
    }
});