$('div.alert').not('.alert-important').delay(3000).fadeOut(350);
$('#flash-overlay-modal').modal();

$(document).ready(function() {
    $('.exam').on('change', function() {
    	window.location=window.location.pathname+'?exam='+this.value;
  	});

  

  	$( ".credit_count" ).keyup(function() {
	  var price = parseInt($('.credit_count').val());
	  var r = $('.credit_count').val();
	  var rate = parseInt($('.credit_rate').text());

	  var amount = price * rate;
	  if(amount)
	  	$('.price').text(amount);
	  else
		$('.price').text(0);

	});

  });



  
 





 
