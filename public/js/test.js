
$(document).ready(function(){
	

   
    /* fullscreen check */
    $('.fullscreen').on('click', () => {
      var browser = $('.browser_details').html();
      var safari = browser.includes("Safari");
        if(safari){
              if(!$('.start_btn').hasClass('disabled')){
                $('.testpage').show();
                $('.fullscreen_container').hide();
                $('#check').hide();
              }
                
        }else{
            if (screenfull.isEnabled && !$('.start_btn').hasClass('disabled')) {
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
          var browser = $('.browser_details').html();
          var safari = browser.includes("Safari");
            console.log('Am I fullscreen?', screenfull.isFullscreen ? 'Yes' : 'No');
            if(!safari){
              if(!screenfull.isFullscreen){
                  $('.fullscreen_container').show();
                  $('.testpage').hide();
                  user_test_log(new Date().getTime() / 1000, 'Fullscreen exit');
              }else{
                  $('.testpage').show();
              }
            }else{
    
            }
            
        });
    }


    /* windowswap detection */
    function swapDetected() {
          var count = parseInt(document.getElementById("window_change").value) +1;
          var message = '';
          var window_swap = parseInt($('.assessment').data('window_swap'));
          var auto_terminate = parseInt($('.assessment').data('auto_terminate'));
          document.getElementById("window_change").value = count;
          if(window_swap){
             user_test_log(new Date().getTime() / 1000, 'Window Swap - '+count);
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


    

    /* check connectivity */
    $('.connection_status').data('status',1);
    const checkOnlineStatus = async () => {
      try {
        var time = new Date();
        const online = await fetch("/1pixel.png?time="+time);

        return online.status >= 200 && online.status < 300; // either true or false
      } catch (err) {
        return false; // definitely offline
      }
    };

    setInterval(async () => {
      const result = await checkOnlineStatus();
      //const statusDisplay = document.getElementById("status");
      textContent = result ? 1 : 0;
      if(textContent){
        $('.connection_status').html("<i class='fa fa-circle text-success'></i> Online");
        $('.testpage_wrap').show();
        $('#no_connectivity').modal('hide');
        $('.connection_status').data('status',1);
      }else{
        $('.testpage_wrap').hide();
        $('#no_connectivity').modal({backdrop: 'static', keyboard: false});
        $('.connection_status').html("<i class='fa fa-circle text-secondary'></i> Offline");
        $('.connection_status').data('status',0);
      }
    }, 3000);



    /* user test log */
     function user_test_log($time,$action=null){

          var log = $('.url_testlog_log');
          $url = log.data('url');
          
          if(log.data('json')){

            $json = log.data('json')

            if($json.username)
              $json = log.data('json');
            else
              $json = JSON.parse(log.data('json'));
          }
          else
            $json = null;


          $time = Math.floor($time);



          if(!$json){


            $geturl = $('.url_testlog_log_get').data('url');
            $.ajax({
                method: "GET",
                headers: {"Content-Type": "application/json"},
                processData: false,
                url: $geturl,
                success: function (response) {
                    $json = response;
                    if(!$json.completed){
                      $jsondata = JSON.stringify($json);
                      log.data('json',$jsondata);

                       $.ajax({
                          method: "PUT",
                          headers: {"Content-Type": "application/json"},
                          processData: false,
                          data: $jsondata,
                          url: $url
                        })
                        .done(function($url) {
                                console.log('log updated');
                        });
                    }
                },
                error: function (jqXHR, exception) {
                    var msg = '';
                    if (jqXHR.status === 0) {
                        msg = 'Not connect.\n Verify Network.';
                        $json = {};
                        var activity = {};
                        let time = $time;

                        $json.username = $('.assessment').data('username');

                        if($('.os_details').length){
                          $json.os_details = $('.os_details').html();
                          $json.browser_details = $('.browser_details').html();
                          $json.js_details = $('.js_details').html();
                          $json.ip_details = $('.ip_details').html();
                        }
                        $json.uname = $('.assessment').data('uname');
                        $json.rollnumber = $('.assessment').data('rollnumber');

                        $json.start = $time;
                        activity[time] = 'Exam Started';
                        $json.activity = activity;
                        $json.completed = 0;

                        if(!$json.completed){
                          $jsondata = JSON.stringify($json);
                          log.data('json',$jsondata);

                           $.ajax({
                              method: "PUT",
                              headers: {"Content-Type": "application/json"},
                              processData: false,
                              data: $jsondata,
                              url: $url
                            })
                            .done(function($url) {
                                    console.log('log updated');
                            });
                        }

                    } else if (jqXHR.status == 404) {
                        msg = 'Requested page not found. [404]';
                    } else if (jqXHR.status == 500) {
                        msg = 'Internal Server Error [500].';
                    } else if (exception === 'parsererror') {
                        msg = 'Requested JSON parse failed.';
                    } else if (exception === 'timeout') {
                        msg = 'Time out error.';
                    } else if (exception === 'abort') {
                        msg = 'Ajax request aborted.';
                    } else {
                        msg = 'Uncaught Error.\n' + jqXHR.responseText;
                    }
                    console.log(msg);
                }
              });
            
          }else{
            let time = $time;
            var activity = $json.activity;
            
            $json.activity[time] =$action;
            $json.window_change =  $('input[name=window_change]').val();
            $json.last_photo = $('#photo').data('last_photo');
            $json.last_updated = $time;
            
            $json.window_swap = parseInt($('.assessment').data('window_swap'));
            if($action && $action!='null')
            if(!$json.completed){
              $jsondata = JSON.stringify($json);
              log.data('json',$jsondata);

               $.ajax({
                  method: "PUT",
                  headers: {"Content-Type": "application/json"},
                  processData: false,
                  data: $jsondata,
                  url: $url
                })
                .done(function($url) {
                        console.log('log updated');
                });
            }

          }

         

          
      }


      system_check();
    // device details
     function system_check(){

      'use strict';
      var camera = parseInt($('.assessment').data('camera'));
      var module = {
          options: [],
          header: [navigator.platform, navigator.userAgent, navigator.appVersion, navigator.vendor, window.opera],
          dataos: [
              { name: 'Windows Phone', value: 'Windows Phone', version: 'OS' },
              { name: 'Windows', value: 'Win', version: 'NT' },
              { name: 'iPhone', value: 'iPhone', version: 'OS' },
              { name: 'iPad', value: 'iPad', version: 'OS' },
              { name: 'Kindle', value: 'Silk', version: 'Silk' },
              { name: 'Android', value: 'Android', version: 'Android' },
              { name: 'PlayBook', value: 'PlayBook', version: 'OS' },
              { name: 'BlackBerry', value: 'BlackBerry', version: '/' },
              { name: 'Macintosh', value: 'Mac', version: 'OS X' },
              { name: 'Linux', value: 'Linux', version: 'rv' },
              { name: 'Palm', value: 'Palm', version: 'PalmOS' }
          ],
          databrowser: [
              { name: 'Chrome', value: 'Chrome', version: 'Chrome' },
              { name: 'Firefox', value: 'Firefox', version: 'Firefox' },
              { name: 'Safari', value: 'Safari', version: 'Version' },
              { name: 'Internet Explorer', value: 'MSIE', version: 'MSIE' },
              { name: 'Opera', value: 'Opera', version: 'Opera' },
              { name: 'BlackBerry', value: 'CLDC', version: 'CLDC' },
              { name: 'Mozilla', value: 'Mozilla', version: 'Mozilla' }
          ],
          init: function () {
              var agent = this.header.join(' '),
                  os = this.matchItem(agent, this.dataos),
                  browser = this.matchItem(agent, this.databrowser);
              
              return { os: os, browser: browser };
          },
          matchItem: function (string, data) {
              var i = 0,
                  j = 0,
                  html = '',
                  regex,
                  regexv,
                  match,
                  matches,
                  version;
              
              for (i = 0; i < data.length; i += 1) {
                  regex = new RegExp(data[i].value, 'i');
                  match = regex.test(string);
                  if (match) {
                      regexv = new RegExp(data[i].version + '[- /:;]([\\d._]+)', 'i');
                      matches = string.match(regexv);
                      version = '';
                      if (matches) { if (matches[1]) { matches = matches[1]; } }
                      if (matches) {
                          matches = matches.split(/[._]+/);
                          for (j = 0; j < matches.length; j += 1) {
                              if (j === 0) {
                                  version += matches[j] + '.';
                              } else {
                                  version += matches[j];
                              }
                          }
                      } else {
                          version = '0';
                      }
                      return {
                          name: data[i].name,
                          version: parseFloat(version)
                      };
                  }
              }
              return { name: 'unknown', version: 0 };
          }
      };
      
      var e = module.init(),
          debug = '';
      
      debug += 'os.name = ' + e.os.name + '<br/>';
      debug += 'os.version = ' + e.os.version + '<br/>';
      debug += 'browser.name = ' + e.browser.name + '<br/>';
      debug += 'browser.version = ' + e.browser.version + '<br/>';
      
      debug += '<br/>';
      debug += 'navigator.userAgent = ' + navigator.userAgent + '<br/>';
      debug += 'navigator.appVersion = ' + navigator.appVersion + '<br/>';
      debug += 'navigator.platform = ' + navigator.platform + '<br/>';
      debug += 'navigator.vendor = ' + navigator.vendor + '<br/>';
      
      if($('.os_details').length)
          $('.os_details').html(e.os.name+' v'+ Math.round(e.os.version));

      if($('.browser_details').length){
        var $msg = e.browser.name+' v'+ Math.round(e.browser.version)
         if(e.browser.name == 'Firefox'){
            $msg = $msg+ ' (Kindly use chrome browser. Camera enabled tests will not work in this browser)';
        }

        $('.browser_details').html($msg);
      }
          
      if($('.js_details').length){
          $('.js_details').html("enabled");
          $('.accesscode_btn_wrap').show();
          
          
    
      }
          

      if($('.ip_details').length){
         $.getJSON("https://api.ipify.org?format=json", 
                                            function(data) {
          $('.ip_details').html(data.ip);
          setTimeout(function(){
            if(!camera)
           $('.start_btn').removeClass('disabled');
          },500);
          
          setTimeout(user_test_log(new Date().getTime() / 1000),1000);
        });
      }
     }


  // new test
    $(document).on('click','.test2qno', function() {
        $sno = $(this).data('sno');
        make_visible($sno);
        closeModals();
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

    $(document).on('click','.mark-qno', function() {
        $sno = $(this).data('sno');
        mark($sno);
    });

    $('.input').on('input',function(e){
      $sno = $(this).data('sno');
      if($(this).data('type')!='urq')
        answered($sno);
    });

    //time
    var myVar = setInterval(myTimer, 1000);

    function myTimer() {
      $sno = $('.active').data('sno');
        var count = parseInt($('.'+$sno+'_time').val());
 
        $('.'+$sno+'_time').val((count+1));
      
    }

    function closeModals(){
      if($("#questions").is(":visible"))
      $("#questions").modal('hide');
      if($("#exampleModal").is(":visible"))
      $("#exampleModal").modal('hide');
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
        if(parseInt($('.save_test').val()))
          saveTest($sno);
    }
    function update_sno($sno){
      
      $('.left-qno').data('sno',$sno-1);
      $('.clear-qno').data('sno',$sno);
      
      $('.right-qno').data('sno',$sno+1);
      update_mark($sno);
      hide_buttons($sno);
    }

    function update_mark($sno){
      $('.mark-qno').data('sno',$sno);
      if(!$('.s'+$sno).hasClass('qmark')){
        $('.mark-qno').html('Mark');
      }
      else{
        $('.mark-qno').html('Unmark');
      }
    }

    function answered($sno){
      if(!$('.s'+$sno).hasClass('qblue-border'))
        $('.s'+$sno).addClass('qblue-border');
      if(!$('.s'+$sno).hasClass('active'))
            $('.s'+$sno).removeClass('active');

      // update answer
      var resp = {};
      if($('.input_'+$sno).is(':checkbox')){
        var ans =[]
        $.each($(".input_"+$sno+":checked"), function(){
          ans.push($(this).val());
        });
        resp.response = ans.join(",");
      }
      else if($('.input_'+$sno).is(':radio')){
        resp.response = $(".input_"+$sno+":checked").val();
      }else if($('.input_'+$sno).is("textarea")){
        resp.response = $('.input_'+$sno).val();
      }
      else
        resp.response = $('.input_'+$sno).val();



      $('.final_response_'+$sno).html(resp.response);
    }

    function unanswered($sno){
      $('.s'+$sno).removeClass('qblue-border');
      $('.input_'+$sno).prop('checked',false);
      if($('.input_fillup_'+$sno).length)
      $('.input_fillup_'+$sno).val('');

      if($('.input_'+$sno).length){
        $('.input_'+$sno).val('');
        $('.output_'+$sno).html("-");
      }
      $('.s'+$sno).addClass('active');
      $('.final_response_'+$sno).html('');
    }

    function mark($sno){
      if(!$('.s'+$sno).hasClass('qmark')){
        $('.s'+$sno).addClass('qmark').addClass('qmark-border');
        $('.mark-qno').html('Unmark');
      }
      else{
        $('.s'+$sno).removeClass('qmark').removeClass('qmark-border');
        $('.mark-qno').html('Mark');
      }

    
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


    function saveTest($sno){
        
        if(!$('.ques_count').data('save'))
          return 1;

        $ques_count = $('.ques_count').data('count');


        $url = $('.ques_count').data('url');
        $qno = 1;
        var responses = {};
        number =1;
        
        responses.test_id =  $('input[name=test_id]').val();
        responses.user_id =  $('input[name=user_id]').val();
        responses.token =  $('input[name=_token]').val();
        responses.code =  $('input[name=code]').val();
        responses.admin =  $('input[name=admin]').val();
        responses.window_change =  $('input[name=window_change]').val();
        responses.username = $('#photo').data('username');

        if($('.os_details').length){
          responses.os_details = $('.os_details').html();
          responses.browser_details = $('.browser_details').html();
          responses.js_details = $('.js_details').html();
          responses.ip_details = $('.ip_details').html();
        }
        

        responses.uname = $('#photo').data('uname');
        responses.qno = $sno;
        responses.last_photo = $('#photo').data('last_photo');

        var seconds = new Date().getTime() / 1000;
        responses.last_updated = seconds;
        responses.completed = 0;


        var r = [];
        while (number <= $ques_count) {  
          var resp = {};
          resp.question_id = $('input[name='+$qno+'_question_id]').val();
          resp.section_id = $('input[name='+$qno+'_section_id]').val();
          resp.time = $('input[name='+$qno+'_time]').val();
          resp.dynamic = $('input[name='+$qno+'_dynamic]').val();


          if($('.code_'+$sno).length)
            resp.code = $('.code_'+$sno).val();
          if($('.input_'+$qno).is(':checkbox')){
              var ans =[]
              $.each($(".input_"+$qno+":checked"), function(){
                  ans.push($(this).val());
              });
              resp.response = ans.join(",");
          }
          else if($('.input_'+$qno).is(':radio')){
                resp.response = $(".input_"+$qno+":checked").val();
          }else if($('.input_'+$qno).is("textarea")){
                resp.response = $('.input_'+$qno).val();
          }
          else
              resp.response = $('.input_'+$qno).val();
          //console.log('selected='+resp.response);
          r.push(resp);
          number++; 
          $qno++;            
        }
        responses.responses = r;

        var all_data = JSON.stringify(responses);

        user_test_log(new Date().getTime() / 1000, 'Solving Question - Q'+$sno);
        //console.log(all_data);
        aws_cache(all_data);

        // $.ajax({
        //   type : 'post',
        //   url : $url,
        //   data:{'responses':all_data,'_token':responses.token},
        //   success:function(data){
        //     console.log('data cached');
        //     console.log(data);
        //   }
        // });

    }

    function aws_cache($data){
      var $url = $('.url_testlog').data('url');
      //console.log($url);

      $.ajax({
              method: "PUT",
              headers: {"Content-Type": "application/json"},
              processData: false,
              data: $data,
              url: $url
      })
      .done(function($url) {
              console.log('cached');
      });
    }


      

});
