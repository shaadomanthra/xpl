$('div.alert').not('.alert-important').delay(3000).fadeOut(350);
$('#flash-overlay-modal').modal();


$(document).ready(function() {
    $('.exam').on('change', function() {
    	window.location=window.location.pathname+'?exam='+this.value;
  	});

    $('.batch').on('change', function() {
      if ($('input.batch').is(':checked'))
      window.location=window.location.pathname+'?batch=1';
      else
      window.location=window.location.pathname+'?batch=0';
    });
    

    /* scroll to */
    var loc = $(location).attr('href').split("/")[8];
    if(!$.isNumeric(loc)){

    	var loc = $(location).attr('href').split("/")[7];
      if(!$.isNumeric(loc))
        var loc = $(location).attr('href').split("/")[6];
      console.log("Questions is :"+loc);
    }

    if($.isNumeric(loc)){
      console.log('location:'+loc);
    	var b = $('.qset').offset().top;
	    var a = $('#q'+loc).offset().top - b;
      console.log('location:'+a+' '+b);
	  	$('.qset').scrollTop(a);
    }
    
    
    //var target = $().text(); // get the text of the span
    //var scrollPos = $('#' + target).position().top; // use the text of the span to create an ID and get the top position of that element
    
  

  	$( ".credit_count" ).keyup(function() {
	  var price = parseInt($('.credit_count').val());
	  var r = $('.credit_count').val();
	  var rate = 500;
	  if(r < 250)
	  	rate = 500;
	  else if( r > 249 && r < 500)
	  	rate = 400;
	  else if( r > 499 && r < 1000)
	  	rate = 300;
	  else
	  	rate = 200;

	  var amount = price * rate;
	  if(amount)
	  	$('.price').text(amount);
	  else
		$('.price').text(0);

		$('.credit_rate').val(rate);

	});
    
$(".coupon-button").on('click', function () {
    var code = $(".coupon-input").val();
    var amount = $(".amount").val();
    var product = $(".product").val();
    
    var url = $(".url").val();
    if (!code){  alert('Enter Valid Code');  }else {
      $.get(url + "/coupon/getamount/" + amount + "/" + code + "/" + product + "/", function (data) {
        var obj = JSON.parse(data);
        $("span.total").replaceWith(obj.amount);
        $(".amount").val(obj.amount);
        $("span.status").replaceWith('<span class="border bg-white rounded p-2">' + obj.status + '</span>');
      });
    }
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

    $('.section').on('change', function() {

       var val = $(this).data('id');
      
       var ques = $(this).data('ques');
       var url = $(this).data('url');

       console.log( val + " | " + ques + " | " + url );

       if (this.checked) {
                $.get( url + "/question/attachsection/" + ques + "/" + val + "/", function( data ) {
          console.log( "attached." );
        });
            }else{
              $.get( url + "/question/detachsection/" + ques + "/" + val + "/", function( data ) {
          console.log("detached." );
        });
            }
  
    });



    /* test */

    

    var myVar = setInterval(myTimer, 1000);

    function myTimer() {
        var count = $('.qset').data('counter')+1;
        $('.qset').data('counter',count);
        //console.log(count);
    }

    $(document).on('click','.testqno', function() {
      var qno = $(this).data('qno');
      var qqno = $('.qno').data('qqno');
      var last = $('.qset').data('lastsno');
      var time = $('.qset').data('counter');
      var sno = $('#q'+qno).data('sno');
      var user = $('.qset').data('user');
      
      $('.qset').data('counter',0);

      
      var testname = $(this).data('testname');
      var url = $('.qset').data('url');
      $('.testqno').removeClass('active');
      $('#q'+qno).addClass('active');
      $('.qset_qno').text(sno);

      if(sno==1){
        $('.left').addClass('d-none');
        $('.left').removeClass('d-block');
        $('.right').addClass('d-block');
        $('.right').data('qno',$('.s2').data('qno'));
        

      }else if(sno == last){
        $('.left').addClass('d-block');
        $('.right').addClass('d-none');
        $('.right').removeClass('d-block');
        $('.left').data('qno',$('.s'+(sno-1)).data('qno'));
      }else{
        $('.left').addClass('d-block');
        $('.right').addClass('d-block');
        $('.right').data('qno',$('.s'+(sno+1)).data('qno'));
        $('.left').data('qno',$('.s'+(sno-1)).data('qno'));

      }

      $.get( url + "/" + qqno + "/save",{'question_id':qqno,'time':time,'user_id':user}, function( data ) {
          console.log('saved');

        });

      $.get( url + "/" + qno + "/", function( data ) {
          console.log(data);
          $( "div.question_block" ).replaceWith( data );
          MathJax.Hub.Queue(["Typeset",MathJax.Hub, "div.question_block"]);

        });

    });

    $(document).on('click','.qno-save', function() {
      var qno = $(this).data('qno');
      var time = $('.qset').data('counter');
      var user = $('.qset').data('user');
      var url = $('.qset').data('url');
      var opt = $('input[name=response]:checked').val();
      
      if(opt){
        $('.qset').data('counter',0);
        $('#q'+qno).addClass('qblue-border');
        $('.qno').addClass('qblue');
        $.get( url + "/" + qno + "/save",{'question_id':qno,'response':opt,'time':time,'user_id':user}, function( data ) {
          console.log('saved');

        });
      }
    else
      alert('Option not selected');
     

       

    });

    $(document).on('click','.qno-clear', function() {
      var qno = $(this).data('qno');
      $('#q'+qno).removeClass('qblue-border');
      $('.qno').removeClass('qblue');
      $('.qno').addClass('qyellow');
      var url = $('.qset').data('url');
      $('input[name="response"]').prop('checked', false);
      console.log('cleared');


      var time = $('.qset').data('counter');
      var user = $('.qset').data('user');
      $('.qset').data('counter',0);
      
      $.get( url + "/" + qno + "/clear",{'question_id':qno,'time':time,'user_id':user}, function( data ) {
          console.log('saved');
        });

     
/*
      $.get( url + "/" + qno + "/", function( data ) {
          $( "div.question_block" ).replaceWith( data );

        }); */

    });

    $(document).on('change','input[name=response]', function() {

      var qno = $('.qno').data('qqno');
      var time = $('.qset').data('counter');
      var user = $('.qset').data('user');
      var url = $('.qset').data('url');
      var opt = $('input[name=response]:checked').val();
      $('.qset').data('counter',0);

      if(opt){

        $('#q'+qno).addClass('qblue-border');
        $('.qno').addClass('qblue');
        $.get( url + "/" + qno + "/save",{'question_id':qno,'response':opt,'time':time,'user_id':user}, function( data ) {
          console.log('saved : change');

        });
      }
    else
      alert('Option not selected');

    });

    

    
});

  $(document).ready(function() {

      // passage 
      $(document).on('click','.view',function(){
          $item = '.'+$(this).data('item');
          if($($item).is(":visible")){
            $($item).slideUp();
          }
          else{
            $($item).slideDown();
          }
      });

       $(document).on('click','.btn-attach',function(){
          $id= $(this).data('id');
          $data = $('.passage_'+$id).html();
          $('input[name="passage_id"]').val($id);
          $('.passage').html($data);

      });

       $(document).on('click','.btn-dettach',function(){
          $('input[name="passage_id"]').val('');
          $('.passage').html('');
      });





     // search data
     $('#search').on('keyup',function(){
      $value=$(this).val();
      $url = $(this).data('url');
      $.ajax({
        type : 'get',
        url : $url,
        data:{'search':true,'item':$value},
        success:function(data){
          $('#search-items').html(data);
        }
      });
    });

     // video close
    $('.btn-close').on('click',function(){
      var video = $('#intro').attr("src");
      $("#intro").attr("src","");
      $("#intro").attr("src",video);
    });

  });


  
 





 
