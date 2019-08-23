$(document).ready(function() {

	$('.submit').on('click',function(){
		$answer = $(this).data('answer');
		$qno = $(this).data('qno');
		$qname = 'q'+$qno;
		$submit_block = '.submit_'+$qno;
		$answer_block = '.answer_'+$qno;
		$kno_block = '.s'+$qno;
		console.log($kno_block);
		$correct_block = '.accuracy_correct_'+$qno;
		$incorrect_block = '.accuracy_incorrect_'+$qno;
		$response = $('input[name='+$qname+']:checked').val();

		$($submit_block).hide(1);
		$($answer_block).show();
		
		if($response == $answer)
		{
			$($kno_block).addClass('qgreen-border');
			$($correct_block).show();
		}else{
			$($kno_block).addClass('qred-border');
			$($incorrect_block).show();
		}

		$($kno_block).animate({
			  scrollTop: 1000
			}, 2000);
		

	});

	$(".kno").click(function() {
            $id = "#q"+$(this).data('qno'); 
            console.log($id);
            $([document.documentElement, document.body]).animate({
            scrollTop: $($id).offset().top 
        }, 1000);
     });

});