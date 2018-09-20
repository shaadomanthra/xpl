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


	$('.course_data').on('change', function() {
		var course_id = $(".course_data option:selected").val();
		var course_name = $(".course_data option:selected").text();
		var credit = $(".course_"+course_id).val();
		console.log(course_id+' '+course_name);
    	$('.course_id').val(course_id);
    	$('.course_name').text(course_name);
    	$('.credit_count').text(credit);
  	});

  	$('.validity_data').on('change', function() {

		var validity = $(".validity_data option:selected").val();
		var course_validity = $(".validity_data option:selected").text();
		console.log(validity+' '+course_validity);
    	$('.validity').val(validity);
    	$('.course_validity').text(course_validity);
  	});


  	$('.n').on('change', function() {

  		 var val = $(this).data('id');
  		
  		 var ques = $(this).data('ques');
  		 var url = $(this).data('url');

  		 if (this.checked) {
                $.get( url + "/question/attach/" + ques + "/" + val + "/", function( data ) {
				  console.log( "attached." );
				});
            }else{
            	$.get( url + "/question/detach/" + ques + "/" + val + "/", function( data ) {
				  console.log("detached." );
				});
            }
  
  	});

  });



  
 





 
