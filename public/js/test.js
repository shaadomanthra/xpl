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
    }

    function unanswered($sno){
    	$('.s'+$sno).removeClass('qblue-border');
    	$('.input_'+$sno).prop('checked',false);
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
