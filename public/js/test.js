$(document).ready(function(){
	// new test
    $(document).on('click','.test2qno', function() {
        $sno = $(this).data('sno');
        make_visible($sno);
    });

    $(document).on('click','.right-qno', function() {
        $sno = $(this).data('sno');
        make_visible($sno);
    });

    $(document).on('click','.left-qno', function() {
        $sno = $(this).data('sno');
        make_visible($sno);
    });

    $(document).on('click','.clear-qno', function() {
        $sno = $(this).data('sno');
       	unanswered($sno);
    });

    $('.input').on('input',function(e){
    	$sno = $(this).data('sno');
    	answered($sno);
    });

    //time
    var myVar = setInterval(myTimer, 1000);

    function myTimer() {
    	$sno = $('.active').data('sno');
        var count = parseInt($('.'+$sno+'_time').val());
 
        $('.'+$sno+'_time').val((count+1));
      
    }

    function scroll($sno){
        /* scroll to */
        $('.qset').scrollTop(0); 
        var start = $('.start').offset().top;
        var qset = $('.qset').offset().top;
        var s = $('.s'+$sno).offset().top;
        var offset =  $('.s'+$sno).offset().top - qset;
        var scrollto = offset+start;
        if(offset!=0){
            if(start==qset)
                $('.qset').scrollTop(offset); 
            
        }
    }

    function make_visible($sno){
    	$('.active').removeClass('active');
        $('.s'+$sno).addClass('active');
        $('.question_block').hide();
        $('.qblock_'+$sno).show();
        update_sno($sno);
        saveTest()
        scroll($sno);
    }
    function update_sno($sno){
    	
    	$('.left-qno').data('sno',$sno-1);
    	$('.clear-qno').data('sno',$sno);
    	$('.right-qno').data('sno',$sno+1);
    	hide_buttons($sno);
    }

    function answered($sno){
    	if(!$('.s'+$sno).hasClass('qblue-border'))
    		$('.s'+$sno).addClass('qblue-border');
        if(!$('.s'+$sno).hasClass('active'))
            $('.s'+$sno).removeClass('active')
    }

    function unanswered($sno){
    	$('.s'+$sno).removeClass('qblue-border');
    	$('.input_'+$sno).prop('checked',false);
        $('.s'+$sno).addClass('active')
    }

    function hide_buttons($sno){
    	if(($sno-1)==0){
    		$('.left-qno').hide();
    	}else{
    		$('.left-qno').show();
    	}

    	if(!$('.s'+($sno+1)).length)
    	{
    		$('.right-qno').hide();
    	}else{
    		$('.right-qno').show();
    	}
    }

    function saveTest(){
        
        $ques_count = $('.ques_count').data('count');
        $qno = 1
        var responses = [];
        responses['test_id'] =  $('input[name=test_id]').val();
        responses['user_id'] =  $('input[name=user_id]').val();
        responses['_token'] =  $('input[name=_token]').val();
        responses['code'] =  $('input[name=code]').val();
        responses['admin'] =  $('input[name=admin]').val();
        responses['window_change'] =  $('input[name=window_change]').val();

        responses[$qno]['question_id'] = $('input[name='+$qno+'_question_id]').val();
        responses[$qno]['section_id'] = $('input[name='+$qno+'_section_id]').val();
        responses[$qno]['time'] = $('input[name='+$qno+'_time]').val();
        responses[$qno]['dynamic'] = $('input[name='+$qno+'_dynamic]').val();
        responses[$qno]['response'] = $('input[name='+$qno+']').val();

        console.log(responses);

    }

    $(document).keydown(function(e) {
      if(e.keyCode == 37) { // left

        $sno = parseInt($('.active').data('sno'))-1;
        if($('.qblock_'+$sno).length)
        make_visible($sno);
      }
      else if(e.keyCode == 39) { // right
        $sno = parseInt($('.active').data('sno'))+1;
        if($('.qblock_'+$sno).length)
        make_visible($sno);
      }
    });
});
