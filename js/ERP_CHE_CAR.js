function FiltrarCheques() {
  
}

jQuery(document).ready(function() {
  $( "#fecha-desc" ).datepicker({
    altField: "#form-fecha",
    dateFormat: "dd/mm/yy",
    altFormat: "yy-mm-dd"
  });
});



/* $(document).ready(function() {
  $("table td").each(function() {
      var textoCelda = $(this).text();
      if ($.trim(textoCelda) == '') {
          $(this).css('background-color', 'cyan');
      }
  });

  $('#botonOcultar').click(function() {
      $("table tr td").each(function() {
          var celda = $.trim($(this).text());
          if (celda.length == 0) {
              $(this).parent().hide();
          }
      });
  });
  $('#botonMostrar').click(function() {
      $("table tr").each(function() {
          $(this).show();
      });
  });
}); */