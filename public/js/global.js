$('div.alert').not('.alert-important').delay(3000).fadeOut(350);
$('#flash-overlay-modal').modal();

$(document).ready(function() {
    $('.exam').on('change', function() {
    	window.location=window.location.pathname+'?exam='+this.value;
  	});

  

  	$( ".credit_count" ).keypress(function() {
	  alert('a');
	});

  });



  
 





 
