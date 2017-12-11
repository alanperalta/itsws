
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
    	
    	parent_fieldset.find('input.form-empresa, input.form-fecha, input.form-importe, input.form-cuenta').each(function() {
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
        altFormat: "yy-mm-dd"
  });
});
