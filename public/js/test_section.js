
$(document).ready(function(){


    /* enter disabled */
  $('form').on('keydown', function(e) {
    if (e.which === 13 && !$(e.target).is('textarea')) {
      e.preventDefault();
      console.log("ENTER-KEY PREVENTED ON NON-TEXTAREA ELEMENTS");
    }
  });

    /* fullscreen check */
    $('.fullscreen').on('click', () => {
      var browser = $('.browser_details').html();
      var safari = browser.includes("Safari");
      var fullscreen = $('.assessment').data('fullscreen');
      console.log(fullscreen.trim());
      console.log("clicked fullscreen");
      if(!$('.start_btn').hasClass('disabled'))
        user_test_log(new Date().getTime() / 1000, 'Fullscreen - Enabled');
        if(safari || fullscreen.trim() =='no'){
              if(!$('.start_btn').hasClass('disabled')){
                $('.testpage').show();
                $('.fullscreen_container').hide();
                $('#check').hide();

                $('.start_btn').addClass('exam_started');
              }

        }else{
            if (screenfull.isEnabled && !$('.start_btn').hasClass('disabled')) {
                screenfull.request();
                $('.fullscreen_container').hide();
                $('.testpage').show();
                $('#check').hide();
                $('.fullscreen').html('back to fullscreen');
                $('.start_btn').addClass('exam_started');

                $('.full_screen_message').html('<span class="text-danger">You are not allowed to exit the fullscreen mode. Kindly click the below button to resume fullscreen.</span>');
            }

        }
        win_focus();

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

          console.log('window swap - '+count);
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
      if($('.start_btn').hasClass('exam_started')){
        var window_focus;
        var window_swap = parseInt($('.assessment').data('window_swap'));

        console.log('Exam Started - focus');
        if(window_swap){
          $(window).focus(function() {
                window_focus = true;
                console.log("Focused");
            }).blur(function() {
              if(parseInt($('.timer_count').data('value'))>5){
                var window_swap = parseInt($('.assessment').data('window_swap'));
                if(window_swap)
                  swapDetected();
              }
               
          });
        }
      }

    }

    // // start window focus events after 5 seconds
    // setTimeout(win_focus,5000);

    function stop_focus(){
      $('.assessment').data('window_swap',0);
      $('.upload_image_box').show();
      console.log('disabled swap');
    }

    var stopswap = parseFloat($('.assessment').data('stopswap'));
   // console.log('stopped - '+stopswap);
    if(stopswap)
      setTimeout(stop_focus,stopswap*60*1000);



    // /* check connectivity */
    // $('.connection_status').data('status',1);
    // const checkOnlineStatus = async () => {
    //   try {
    //     var time = new Date();
    //     const online = await fetch("/1pixel.png?time="+time);

    //     return online.status >= 200 && online.status < 300; // either true or false
    //   } catch (err) {
    //     return false; // definitely offline
    //   }
    // };

    // setInterval(async () => {
    //   const result = await checkOnlineStatus();
    //   //const statusDisplay = document.getElementById("status");
    //   textContent = result ? 1 : 0;
    //   if(textContent){
    //     $('.connection_status').html("<i class='fa fa-circle text-success'></i> Online");
    //     $('.testpage_wrap').show();
    //     $('#no_connectivity').modal('hide');
    //     $('.connection_status').data('status',1);
    //   }else{
    //     $('.testpage_wrap').hide();
    //     $('#no_connectivity').modal({backdrop: 'static', keyboard: false});
    //     $('.connection_status').html("<i class='fa fa-circle text-secondary'></i> Offline");
    //     $('.connection_status').data('status',0);
    //   }
    // }, 3000);




    /* user test log */
     function user_test_log($time,$action=null){

          var log = $('.url_testlog_log');
          $url = log.data('url');

          if(log.data('json')){
            $json = log.data('json')
            if($json['activity'])
              $json = log.data('json');
            else
              $json = JSON.parse(log.data('json'));
          }
          else
            $json = null;

          $time = Math.floor($time);

          if(!$json){


          }else{
            console.log('log  - '+$action);

            let time = $time;
            var activity = $json.activity;

            $json.username = $('.assessment').data('username');

            if($('.os_details').length){
              $json.os_details = $('.os_details').html();
              $json.browser_details = $('.browser_details').html();
              $json.js_details = $('.js_details').html();
              $json.ip_details = $('.ip_details').html();
            }
            $json.uname = $('.assessment').data('uname');
            $json.rollnumber = $('.assessment').data('rollnumber');

            if(activity)
              $json.activity[time] =$action;
            else{
              activity[time] = $action;
              $json.activity = activity;
            }

            $json.window_change =  $('input[name=window_change]').val();
            $json.last_photo = $('#photo').data('last_photo');
            $json.last_updated = $time;
            $json.last_seconds = new Date().getTime();


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
            if(!camera){
              if(!$('#d').length){
                $('.start_btn').removeClass('disabled');
              }
            }

         $('.cam_spinner').hide();
          },1000);


        });
      }
     }

     var tr = setInterval(termination_check,5000);

     //check for termination of the candidate
     function termination_check(){
      $url = $('.url_approval').data('url')+'?time='+ new Date();
      $username = $('.assessment').data('username');

      if(!$('.start_btn').hasClass('disabled'))
      $.ajax({
          type: "GET",
          url: $url
        }).done(function (result) {

        if(result)
          //console.log(result);
          if(result['terminated']){
            clearInterval(tr);
             $('#terminated').modal();
             user_test_log(new Date().getTime() / 1000, 'Test terminated by proctor');
             setTimeout(function(){
                  $("form")[0].submit();
                }, 3000);
          }



        }).fail(function () {
                      console.log("Sorry URL is not access able");
        });



      }



    function sortObject(obj) {
        return Object.keys(obj).sort().reduce(function (result, key) {
            result[key] = obj[key];
            return result;
        }, {});
    }

    function toDateTime(secs) {
      var t = new Date(1970, 0, 1); // Epoch
      t.setSeconds(secs);

    t.setHours(t.getHours() + 5);
    t.setMinutes(t.getMinutes() + 30);
    datetext = t.toTimeString();
    datetext = datetext.split(' ')[0];

      return datetext;
  }

    // chat system

    $('.m_student').on('click',function(e){

        $url = $(this).data('url')+"?time="+$.now();
        $username = $(this).data('username');
        $name = $(this).data('name');
        item = $('.m_'+$username);
         $('.chat_messages').html('');

         $.ajax({
                type: "GET",
                url: $url
            }).done(function (result) {

                const ordered = sortObject(result);
                i=0;
                for(var k in ordered) {
                   $u = ordered[k].name;
                   $message = ordered[k].message;
                   $('.chat_messages').append("<div class='mt-2'><b>"+$u+":</b><br>"+$message+"</div>");
                   i = i+1;
                   if((Object.keys(ordered).length) == i){
                      //console.log(k);
                      item.data('lastchat',k);
                      //console.log(item.data('lastchat'));
                      $('.chat_messages').animate({scrollTop: 10000},400);
                      $('.chats').animate({scrollTop: 5000},400);
                   }

                }

            }).fail(function () {
                console.log("Sorry URL is not access able");
        });

        $('#chat').modal();

     });


    $(document).on('click','.s_chat',function(){

    var objDiv = $('.chats')[0];
    objDiv.scrollTop = $('.chats')[0].scrollHeight+ 300;

    $username = $(this).data('username');
    $uname = $('.m_'+$username).data('name');
    $pname = $('.m_'+$username).data('proctor');
    $p = $('.m_'+$username).data('p');
    $testid = $(this).data('testid');
    $user = $(this).data('user');
    $message = $('#message-text').val();
    $url = $('.m_'+$username).data('url');
    $urlpost = $('.m_'+$username).data('urlpost');
    $test = $('#video').data('test');
    $name = $username+'_'+$test+'_chat';
    it = $('.m_'+$username);

    if($p)
      $uname = $pname;


    $('.chat_messages').animate({scrollTop: 10000},400);
    const now = new Date()
    const $time = Math.round(now.getTime() / 1000)

    $('.message_proctor').data('time',$time);

        $.ajax({
                type: "GET",
                url: $url
            }).done(function (result) {

                var item ={ "name": $uname, "username":$username,"message":$message};
                result[$time] = item;
                it.data('lastchat',item);
                var $data = JSON.stringify(result);
                $('.chat_messages').append("<div class='mt-2'><b>"+$uname+":</b><br>"+$message+"</div>");

                $('#message-text').val('');
                 $.ajax({
                      method: "PUT",
                      headers: {"Content-Type": "application/json"},
                      processData: false,
                      data: $data,
                      url: $urlpost
              })
              .done(function($url) {
                     $('.chat_messages').animate({scrollTop: 10000},400);
                      console.log('message sent');
              });

            }).fail(function () {
                console.log("Sorry URL is not access able");
        });

});

    function chat_refresh(){
      if($('.m_student').length && !$('#chat').is(':visible')){

        $url = $('.m_student').data('url')+"?time="+$.now();
        $username = $('.m_student').data('username');
        $lastchat = $('.m_student').data('lastchat');
        $name = $('.m_student').data('name');
        item = $('.m_'+$username);
        $lastestchat = $lastchat;
        $('.chat_messages').html('');


         $.ajax({
                type: "GET",
                url: $url
            }).done(function (result) {

                const ordered = sortObject(result);

                i=0;$count =0 ;
                for(var k in ordered) {
                   $u = ordered[k].name;
                   $message = ordered[k].message;
                   i = i+1;

                   // last item
                   $('.chat_messages').append("<div class='mt-2'><b>"+$u+":</b><br>"+$message+"</div>");
                   if((Object.keys(ordered).length) == i){
                      $lastestchat = k;
                      if(!$lastchat){
                        item.data('lastchat',k);
                      }else{

                        if(k>$lastchat)
                          $count++;

                        if($lastestchat > $lastchat){
                            $('.m_'+ordered[k].username).addClass('blink');

                            if($('#chat').is(':visible')){
                              // will only come inside after the modal is shown
                              $('.chat_messages').append("<div class='mt-2'><b>"+ordered[k].name+": <span class='badge badge-warning'>new</span></b><br>"+ordered[k].message+"</div>");
                            }else{
                              item.data('lastchat',k);
                              $('.m_'+ordered[k].username).removeClass('blink');
                              $('.chat_messages').animate({scrollTop: 10000},400);
                              $('.chats').animate({scrollTop: 5000},400);
                              $('#chat').modal();
                            }


                            // if($('.send_chat').data('username')==$username){
                            //   $('.chat_messages').append("<div class='mt-2'><b>"+$uname+": <span class='badge badge-warning'>new</span></b><br>"+$message+"</div>");
                            // }
                        }else{
                           $('.m_'+ordered[k].username).removeClass('blink');
                           $('.chat_count_'+ordered[k].username).hide();
                        }
                      }



                   }
                }


            }).fail(function () {
                console.log("Sorry URL is not access able");
          });
      }else if($('.m_student').length && $('#chat').is(':visible')){

        $url = $('.m_student').data('url')+"?time="+$.now();
        $username = $('.m_student').data('username');
        $lastchat = $('.m_student').data('lastchat');
        $name = $('.m_student').data('name');
        item = $('.m_'+$username);
        $lastestchat = $lastchat;


         $.ajax({
                type: "GET",
                url: $url
            }).done(function (result) {

                const ordered = sortObject(result);

                i=0;$count =0 ;
                for(var k in ordered) {
                   $u = ordered[k].name;
                   $message = ordered[k].message;
                   i = i+1;

                   // last item
                   if((Object.keys(ordered).length) == i){
                      $lastestchat = k;
                      if(!$lastchat){
                        item.data('lastchat',k);
                      }else{

                        if(k>$lastchat)
                          $count++;


                        if($lastestchat > $lastchat){
                            $('.chat_messages').append("<div class='mt-2'><b>"+ordered[k].name+": <span class='badge badge-warning'>new</span></b><br>"+ordered[k].message+"</div>");
                            $('.chat_messages').animate({scrollTop: 10000},400);
                            $('.chats').animate({scrollTop: 5000},400);
                            item.data('lastchat',k);

                        }else{

                        }
                      }



                   }
                }


            }).fail(function () {
                console.log("Sorry URL is not access able");
          });


      }
    }

    setInterval(chat_refresh,1000);





    // start test timer
    $start_time = $('.assessment').data('start');

    if($start_time){
      // Set the date we're counting down to
      $start_time = new Date($start_time.replace(/-/g, '/'));
      var countDownDate = new Date($start_time).getTime();

      // Update the count down every 1 second
      var w = setInterval(function() {

        // Get today's date and time
        var now = new Date().getTime();

        // Find the distance between now and the count down date
        var distance = countDownDate - now;

        // Time calculations for days, hours, minutes and seconds
        var days = Math.floor(distance / (1000 * 60 * 60 * 24));
        var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        var seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Output the result in an element with id="demo"
        if(document.getElementById("d")){
          if(days){
          document.getElementById("d").innerHTML = days + "days " + hours + "hours "+ minutes + "min " + seconds + "sec ";
          }else{
            if(hours){
            document.getElementById("d").innerHTML =  hours + "hours " + minutes + "min " + seconds + "sec ";
            }else{
              if(minutes){
                document.getElementById("d").innerHTML =   minutes + "min " + seconds + "sec ";
              }else{
                document.getElementById("d").innerHTML =   seconds + "sec ";

              }
            }
          }

        // If the count down is over, write some text
        if (distance < 0) {
          clearInterval(w);
          if(document.getElementById("d"))
          document.getElementById("d").innerHTML = "";
          $('.start_btn').removeClass('disabled');
          $('.started').html('started');
          load_timer();
          win_focus();
        }
        }
      }, 1000);

    }else{
      load_timer();
      win_focus();
    }

    var x;


    // exam timer
    function load_timer($sno=null){

        //show or hide controls based on question count
        if($sno != null)
        $qcount = parseInt($('.s'+$sno).data('qcount'));
        else
        $qcount = parseInt($('.s1').data('qcount'));

        $first = parseInt($('.assessment').data('first'));
        $last = parseInt($('.assessment').data('last'));
        console.log($first+' ---- '+$last);
        console.log($qcount+' ---- '+$sno);
        if($qcount!=1){
          if($first){
            $('.left-qno').hide();
            $('.right-qno').show();
          }else if($last){
            $('.left-qno').show();
            $('.right-qno').hide();
          }else{
            $('.left-qno').show();
            $('.right-qno').show();
          }
          
        }else{
          $('.left-qno').hide();
          $('.right-qno').hide();
        }
        // Set the date we're counting down to

        if($sno)
          var t = parseFloat($('.section_block_'+$snext).data('time'));
        else
        var t = parseFloat($('.assessment').data('exam_time'));
      
        var countDownDate = addMinutes(new Date(),t);

        //start video if any
        startvideo();

        // Update the count down every 1 second
        window.x = setInterval(function() {

         if(parseInt($('.connection_status').data('status'))){
            // Get todays date and time
            var now = new Date().getTime();

            // Find the distance between now and the count down date
            var distance = countDownDate - now;

            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);

            // Display the result in the element with id="demo"
            document.getElementById("timer").innerHTML =  hours + "h " + minutes + "m " + seconds + "s ";
            document.getElementById("timer2").innerHTML =  hours + "h " + minutes + "m " + seconds + "s ";


            if(hours==0 && minutes==5 && seconds==1)
              $('#timer_alert').modal();

            $tcount = parseInt($('.timer_count').data('value'))-1;
            $('.timer_count').data('value',$tcount);
            // if(seconds==56)
            //   $('#timer_alert').modal();

            // If the count down is finished, write some text
            if (distance < 0) {
              clearInterval(window.x);
              document.getElementById("timer").innerHTML = "EXPIRED";
              document.getElementById("timer2").innerHTML = "EXPIRED";
              //stop recording if any
              //stopRecording();
              //alert('The section time has expired. ');
              $('#timer_complete').modal();
              
              

            }
          }
        }, 1000);
    }

    $('#timer_complete').on('hidden.bs.modal', function (e) {
      clearInterval(window.x);
        console.log('Auto Submit section fired')
        auto_submit_section();
    });

    function addMinutes(date, minutes) {
        return new Date(date.getTime() + minutes*60000);
    }

    function stopTimer() {
      clearInterval(window.x);
    }


     // video


    /*
    *  Copyright (c) 2015 The WebRTC project authors. All Rights Reserved.
    *
    *  Use of this source code is governed by a BSD-style license
    *  that can be found in the LICENSE file in the root of the source
    *  tree.
    */

    // This code is adapted from
    // https://rawgit.com/Miguelao/demos/master/mediarecorder.html

    'use strict';

    /* globals MediaRecorder */

    var mediaRecorder;
    var recordedBlobs;

    const errorMsgElement = document.querySelector('span#errorMsg');
    const recordedVideo = document.querySelector('video#recorded');
    const recordButton = document.querySelector('button#record');
    // recordButton.addEventListener('click', () => {
    //   if (recordButton.textContent === 'Start Recording') {
    //     startRecording();
    //   } else {
    //     stopRecording();
    //     recordButton.textContent = 'Start Recording';
    //     playButton.disabled = false;
    //     downloadButton.disabled = false;
    //   }
    // });

    



    function handleDataAvailable(event) {
      //console.log('handleDataAvailable', event);
      if (event.data && event.data.size > 0) {
        recordedBlobs.push(event.data);
      }
    }

    function startRecording() {
      recordedBlobs = [];
      $('.recording').show();
      
      let options = {mimeType: 'video/webm;codecs=vp9,opus'};
      if (!MediaRecorder.isTypeSupported(options.mimeType)) {
        console.error(`${options.mimeType} is not supported`);
        options = {mimeType: 'video/webm;codecs=vp8,opus'};
        if (!MediaRecorder.isTypeSupported(options.mimeType)) {
          console.error(`${options.mimeType} is not supported`);
          options = {mimeType: 'video/webm'};
          if (!MediaRecorder.isTypeSupported(options.mimeType)) {
            console.error(`${options.mimeType} is not supported`);
            options = {mimeType: ''};
          }
        }
      }

      try {
        mediaRecorder = new MediaRecorder(window.stream, options);
        $sno = $('.clear-qno').data('sno');
        $qno = $('.s'+$sno).data('qno');
        $('#gum_'+$qno).show();
        $('#curr-qno').data('qno',$qno);
      } catch (e) {
        console.error('Exception while creating MediaRecorder:', e);
        errorMsgElement.innerHTML = `Exception while creating MediaRecorder: ${JSON.stringify(e)}`;
        return;
      }

      //console.log('Created MediaRecorder', mediaRecorder, 'with options', options);
      
      mediaRecorder.ondataavailable = handleDataAvailable;
      mediaRecorder.start();
      console.log('MediaRecorder started');
      //console.log('MediaRecorder started', mediaRecorder);
    }

    function stopRecording($final=null) {

      $sno = $('.clear-qno').data('sno');
      $qno = $('.s'+$sno).data('qno');
      if($('#gum_'+$qno).length){
        $('#gum_'+$qno).hide();
        $('.recording').hide();
        try {
         mediaRecorder.stop();


      mediaRecorder.onstop = (event) => {
        $('.recording').hide();
        console.log('Recorder stopped ');
        //console.log('Recorded Blobs: ', recordedBlobs);
        const blob = new Blob(recordedBlobs, {type: 'video/webm'});
        const url = window.URL.createObjectURL(blob);

        
        $qno = $('#curr-qno').data('qno');
        $url = $('.url_video_'+$qno).data('url');
        //console.log($qno);
        //console.log($url);
        if($url){
            $.ajax({
                    method: "PUT",
                    headers: {"Content-Type": "video/webm"},
                    processData: false,
                    data: blob,
                    url: $url
            })
            .done(function($url) {

                console.log('video uploaded');
                 if($final){
                    console.log(' --- reached final ----');
                    document.getElementById("assessment").submit();
                 }
                
            });
        }

        // const a = document.createElement('a');
        // a.style.display = 'none';
        // a.href = url;
        // a.download = 'test.webm';
        // document.body.appendChild(a);
        // a.click();
        // setTimeout(() => {
        //   document.body.removeChild(a);
        //   window.URL.revokeObjectURL(url);
        // }, 100);

      };

        } catch (e) {
          console.error('navigator.getUserMedia error:', e);
        }
       
      }



    }



    function handleSuccess(stream,qno) {
      recordButton.disabled = false;
      //console.log('getUserMedia() got stream:', stream);
      window.stream = stream;

      if($('#gum_'+qno).length){
        //console.log('video#gum_'+qno);
        const gumVideo = document.querySelector('video#gum_'+qno);
        gumVideo.srcObject = stream;
        setTimeout(startRecording,5000);
      }
      
    
    }

    async function init(constraints,qno) {
      try {
        const stream = await navigator.mediaDevices.getUserMedia(constraints);
        handleSuccess(stream,qno);
      } catch (e) {
        console.error('navigator.getUserMedia error:', e);
        //errorMsgElement.innerHTML = `navigator.getUserMedia error:${e.toString()}`;
      }
    }

    function startvideo(){

        $sno = $('.clear-qno').data('sno');
        $qno = $('.s'+$sno).data('qno');
        const constraints = {
        audio: {
          echoCancellation: {exact: true}
        },
        video: {
          width: 768, height: 432
        }
      };
      //console.log('Using media constraints:', constraints);
      init(constraints,$qno);
    }


    //end video



  // new test
    $(document).on('click','.test2qno', function() {
        $sno = $(this).data('sno');
        make_visible($sno);
        closeModals();
    });

    $(document).on('click','.right-qno', function() {
        $sno = parseInt($(this).data('sno'))-1;
        $qcount = parseInt($('.s'+$sno).data('qcount'));
        if($qcount>1){
          $sno = $sno+1;
          make_visible($sno);
        }
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

    $(document).on('click','.btn-sub-section', function() {
        $snext = parseInt($(this).data('section_next'));
        $sno = $('.section_block_'+$snext).data('sno');
        $section_next = parseInt($('.section_block_'+$snext).data('section_next'));

        

        make_visible_section($snext,$sno);
        $(this).data('section_next',$section_next);
    });

    function auto_submit_section(){
        $snext = parseInt($('.btn-sub-section').data('section_next'));
        $sno = $('.section_block_'+$snext).data('sno');
        $section_next = parseInt($('.section_block_'+$snext).data('section_next'));
        make_visible_section($snext,$sno);
        $('.btn-sub-section').data('section_next',$section_next);
    }

    

    $('.input').on('input',function(e){

      $sno = $(this).data('sno');
      $val = $(this).data('opt');
      $(".input_"+$sno+"_"+$val).val($val);
      if($(this).data('type')!='urq')
        answered($sno,$val);
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
     if($("#exampleModalSec").is(":visible"))
      $("#exampleModalSec").modal('hide');
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


    function make_visible_section($snext,$sno){
      $type = $('.s'+$sno).data('type');
      if($snext){
        $('.section_block').hide();
        $('.section_block_'+$snext).show();
        $sno = parseInt($sno) +1;

        $('.sec_qcount').html($('.section_block_'+$snext).data('qcount'));
        make_visible($sno);

        //stop recording if any
        stopRecording();

        //change timer
        stopTimer();
        load_timer($sno);

        closeModals();

      }else{
        if (typeof $sno === "undefined"){
          $sn = 1; 
          $type = $('.s'+$sn).data('type');
        }
        closeModals();
        $sno = parseInt($sno) +1;
        //stop recording if any
        stopRecording(1);
        //end test
        if($type!='vq'){
          document.getElementById("assessment").submit();
        }
        else
        {
          $('#video_upload').modal();
        }
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

    function answered($sno,$val){
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
        $(".input_"+$sno+"_"+$val).prop('checked',true);
        $(".input_"+$sno+"_"+$val).val($val);
        console.log($(".input_"+$sno+"_"+$val+":checked").val());
        resp.response = $val;
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

      $pos = $('.s'+$sno).data('pos').trim();

      if($pos=='start'){
        $('.left-qno').hide();
      }else{
        $('.left-qno').show();
      }

      // if(($sno-1)==0){
      //   $('.left-qno').hide();
      // }else{
      //   $('.left-qno').show();
      // }

      if($pos=='end')
      {
        $('.right-qno').hide();
      }else{
        $('.right-qno').show();
      }
      // if(!$('.s'+($sno+1)).length)
      // {
      //   $('.right-qno').hide();
      // }else{
      //   $('.right-qno').show();
      // }
    }


    function saveTest($sno=null,$live=null){

        if(!$('.ques_count').data('save'))
          return 1;


        if(!$sno)
          $sno = $('.active').data('sno');

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
        responses.qid = $('.s'+$sno).data('qno');
        responses.last_photo = $('#photo').data('last_photo');
        if($('#video').length)
        responses.c = parseInt($('#video').data('c'));

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

        if(!$live){
            user_test_log(new Date().getTime() / 1000, 'Solving Question - Q'+$sno);
            aws_cache(all_data);
        }else{

          //   $.ajax({
          //   type : 'post',
          //   url : $url,
          //   data:{'responses':all_data,'_token':responses.token},
          //   success:function(data){
          //     console.log('Live data updated');
          //   }
          // });

        }

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


    function saveLive($sno=null,$live=null){

        if(!$('.ques_count').data('save'))
          return 1;


        if(!$sno)
          $sno = $('.active').data('sno');

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
        responses.qid = $('.s'+$sno).data('qno');
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



          //   $.ajax({
          //   type : 'post',
          //   url : $url,
          //   data:{'responses':all_data,'_token':responses.token},
          //   success:function(data){
          //     console.log('Live data updated');
          //     console.log(data);
          //   }
          // });



    }

    setInterval(saveLive,60000);



});
