
jQuery(document).ready(function() {
	
    /*
        Fullscreen background
    */
    $.backstretch("../includes/img/backgrounds/1.jpg");
    
    $('#top-navbar-1').on('shown.bs.collapse', function(){
    	$.backstretch("resize");
    });
    $('#top-navbar-1').on('hidden.bs.collapse', function(){
    	$.backstretch("resize");
    });
    
    /*
        Form
    */
    $('.registration-form fieldset:first-child').fadeIn('slow');
    
    $('input.form-empresa, input.form-fecha, input.form-importe, input.form-cuenta').on('focus', function() {
    	$(this).removeClass('input-error');
    });
    
    // next step
    $('.registration-form .btn-next').on('click', function() {
    	var parent_fieldset = $(this).parents('fieldset');
    	var next_step = true;
    	
    	parent_fieldset.find('input.form-empresa, input.form-fecha, input.form-importe').each(function() {
    		if( $(this).val() == "" ) {
    			$(this).addClass('input-error');
    			next_step = false;
    		}
    		else {
    			$(this).removeClass('input-error');
    		}
    	});
    	
        //Importe debe ser valido
        var importe = $('#form-importe').val();
        if(importe && !/^(?:\d*\.\d{1,2}|\d+)$/.test(importe)){
            next_step = false;
            $('#form-importe').addClass('input-error');
            alert('Importe fuera de rango, debe tener formato 0.00');
        }
        
    	if( next_step ) {
            if($(this).hasClass("next1")){
                $('#saldo-cuenta').html($('#form-importe').val());
                $('#saldo-cuenta-original').html($('#form-importe').val());
                $.ajax({
                    url: '../controller/APP_CUENTAS.php',
                    type: 'post',
                    dataType: 'json',
                    beforeSend: function (xhr) {
                        $('#lista-cuentas').html(
                            '<div id="loading-cuentas">Cargando... <i class="fa fa-refresh fa-spin" style="font-size:24px"></i></div>'
                        );
                    }
                }).done( function (response) {
                    fila = '';
                    //Recorro el JSON y agrego un item de lista por cada cuenta encontrada
                    $.each(response, function(i, member) {
                        fila += '<li class="item-cuenta">'+response[i].DESCRIPCION+': <input class="form-cuenta" name="form-cuenta-'+response[i].ID+'" type="number" onchange="saldoCuenta();" ondblclick="completaSaldo(this);"/></li>';
                    });
                    $('#lista-cuentas').html(fila);
                });
            }
            //Cargo resumen en el 3er paso
            if($(this).hasClass("next2")){
                $('.resumen-cuenta').html($('#form-cuenta').val());
                $('.resumen-empresa').html($('#form-empresa').val());
                $('.resumen-fecha').html($('#fecha-desc').val());
                $('.resumen-importe').html($('#form-importe').val());
            }
            
            parent_fieldset.fadeOut(400, function() {
                    $(this).next().fadeIn();
            });
                
    	}
    	
    });
    
    // previous step
    $('.registration-form .btn-previous').on('click', function() {
    	$(this).parents('fieldset').fadeOut(400, function() {
    		$(this).prev().fadeIn();
    	});
    });
    
    // submit
    $('.registration-form').on('submit', function(e) {
    	
    	$(this).find('input.form-empresa, input.form-fecha, input.form-importe, input.form-cuenta').each(function() {
    		if( $(this).val() == "" ) {
    			e.preventDefault();
    			$(this).addClass('input-error');
    		}
    		else {
    			$(this).removeClass('input-error');
    		}
    	});
    	
    });
    $( "#fecha-desc" ).datepicker({
        altField: "#form-fecha",
        dateFormat: "dd/mm/yy",
        altFormat: "yymmdd"
  });
  
  $('form.registration-form').on('submit', function (event){
      event.preventDefault();
      $.ajax({
          url: $(this).attr('action'),
          data: $(this).serialize(),
          type: 'POST',
          dataType: 'json',
          beforeSend: function (xhr) {
            $('#confirmarRecibo').html('Procesando <i class="fa fa-refresh fa-spin" style="font-size:24px"></i>');
            $('#confirmarRecibo').prop('disabled', true);
        }
      }).done( function (response) {
        if(response.error){
            alert(response.message);
            $('#confirmarRecibo').prop('disabled', false);
            $('#confirmarRecibo').html('Confirmar');
        }else {
           $('#confirmarRecibo').html('<i class="fa fa-check style="font-size:24px"></i>');
           setTimeout(function(){
             $('.contenido').load('../view/ERP_COM_VEN_REC.php');
           }, 1500);
        }
    });
  });
});