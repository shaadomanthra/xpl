
$(document).ready(function(){
	

    var browser = $('.browser_details').html();
    var safari = browser.includes("Safari");
    /* fullscreen check */
    $('.fullscreen').on('click', () => {
        if(safari){
                $('.testpage').show();
                $('.fullscreen_container').hide();
                $('#check').hide();
        }else{
            if (screenfull.isEnabled) {
                screenfull.request();
                $('.fullscreen_container').hide();
                $('.testpage').show();
                $('#check').hide();
                $('.fullscreen').html('back to fullscreen');
                $('.full_screen_message').html('<span class="text-danger">You are not allowed to exit the fullscreen mode. Kindly click the below button to resume fullscreen.</span>');
            }

        }
        
    });

    if (screenfull.isEnabled) {
        screenfull.on('change', () => {
            console.log('Am I fullscreen?', screenfull.isFullscreen ? 'Yes' : 'No');
            if(!safari)
            if(!screenfull.isFullscreen){
                $('.fullscreen_container').show();
                $('.testpage').hide();
            }
        });
    }

    /* windowswap detection */
    function swapDetected() {
          var count = parseInt(document.getElementById("window_change").value) +1;
          var message = '';
          var window_swap = parseInt($('.assessment').data('window_swap'));
          var auto_terminate = parseInt($('.assessment').data('auto_terminate'));
          if(window_swap){
             if(auto_terminate==0){
                 var message = 'We have noticed a window swap ('+count+'). Kindly note that numerous swaps will lead to cancellation of the test.'; 
             }else{
                if(count == auto_terminate)
                    var message = 'We have noticed '+auto_terminate+' window swaps. Next swap will lead to termination of the test.';
                else if(count > auto_terminate)
                    var message = 'You have reached the '+auto_terminate+' swap limit. The test will be terminated here.';
                else
                    var message = 'We have noticed a window swap ('+count+'). Kindly note that '+auto_terminate+' swaps will lead to cancellation of the test.';
        
             }

          }
      
          $('.swap-message').html(message);
          if($('.testpage').is(":visible"))
            $('#exampleModalCenter').modal();
          document.getElementById("window_change").value = count;


          // auto submit the test
          if(window_swap){
            if(count == auto_terminate){
                setTimeout(function(){ 
                  $('#exampleModalCenter').modal('toggle');
                  $("form")[0].submit();
                }, 3000);
            }
          }
          console.log("Blured");
    }

    function win_focus(){
      console.log('Started focus events');
      var window_focus;
      var window_swap = parseInt($('.assessment').data('window_swap'));

      if(window_swap){
        $(window).focus(function() {
              window_focus = true;
              console.log("Focused");
          }).blur(function() {
            if(parseInt($('.timer_count').data('value'))>5)
              swapDetected();
        });
      }
    }

    // start window focus events after 5 seconds
    setTimeout(win_focus,5000);


});
