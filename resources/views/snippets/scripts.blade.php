<script src="{{ asset('js/script.js')}}?new=36"></script>
<script src="{{ asset('js/jquery.ui.min.js')}}?new=09"></script>
<script src="{{ asset('js/osc.js')}}?new=09"></script>
@if(subdomain())
<script src="{{ asset('js/client.js')}}?new=09"></script>
@endif
@if(isset($proctor))
<script src="{{ asset('js/proctor.js')}}"></script>
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
@endif

 @if($_SERVER['HTTP_HOST'] == 'iidt.xp.test' || $_SERVER['HTTP_HOST'] == 'piofx.com' || $_SERVER['HTTP_HOST'] == 'corporate.onlinelibrary.test')
<!--begin::Global Config(global config for global JS scripts)-->
    <script>var KTAppSettings = { "breakpoints": { "sm": 576, "md": 768, "lg": 992, "xl": 1200, "xxl": 1200 }, "colors": { "theme": { "base": { "white": "#ffffff", "primary": "#3699FF", "secondary": "#E5EAEE", "success": "#1BC5BD", "info": "#8950FC", "warning": "#FFA800", "danger": "#F64E60", "light": "#F3F6F9", "dark": "#212121" }, "light": { "white": "#ffffff", "primary": "#E1F0FF", "secondary": "#ECF0F3", "success": "#C9F7F5", "info": "#EEE5FF", "warning": "#FFF4DE", "danger": "#FFE2E5", "light": "#F3F6F9", "dark": "#D6D6E0" }, "inverse": { "white": "#ffffff", "primary": "#ffffff", "secondary": "#212121", "success": "#ffffff", "info": "#ffffff", "warning": "#ffffff", "danger": "#ffffff", "light": "#464E5F", "dark": "#ffffff" } }, "gray": { "gray-100": "#F3F6F9", "gray-200": "#ECF0F3", "gray-300": "#E5EAEE", "gray-400": "#D6D6E0", "gray-500": "#B5B5C3", "gray-600": "#80808F", "gray-700": "#464E5F", "gray-800": "#1B283F", "gray-900": "#212121" } }, "font-family": "Poppins" };</script>
    <!--end::Global Config-->
    <!--begin::Global Theme Bundle(used by all pages)-->
    <script src="{{ asset('assets/plugins/global/plugins.bundle.js?v=7.0.4')}}"></script>
    <script src="{{ asset('assets/plugins/custom/prismjs/prismjs.bundle.js?v=7.0.4')}}"></script>
    <script src="{{ asset('assets/js/scripts.bundle.js?v=7.0.4')}}"></script>
    <!--end::Global Theme Bundle-->
    <!--begin::Page Scripts(used by this page)-->
    <script src="{{ asset('assets/js/pages/widgets.js?v=7.0.4')}}"></script>
      
@endif

<script>
$(function(){  

var wrapper = $("#wrapper"),
    $menu = $("#item"),
    $window = $(window);

$menu.on("click","span", function(){
    var $this = $(this),
        href = $this.attr("href"),
        topY = $(href).offset().top;
        wraptop = $('#wrapper').offset().top;
      console.log(topY);
      console.log(wraptop);
    $("html, body").animate({ scrollTop: (topY-80) });
  
  return false;
});  
  
});

</script>

@if(isset($status))

<script>
$(function(){
    $(document).on('click','.refresh',function(e){

      e.preventDefault();
      $username = $(this).data('username');
      $url = $(this).data('url');
      $('.loading_'+$username).show();
      $.get( $url, function( data ) {
        $('.student_'+$username).html(data);
        $('.loading_'+$username).hide();
        console.log(data);
      });
      
    });
});
</script>
@endif

@if(isset($select))
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<script>
$('select').select2({
    theme: 'bootstrap4',
});
</script>
@endif

  <script>
$(function(){

  /* show user ajax */
  $('.showuser').on('click',function(e){
    e.preventDefault();

    $('.loading').show();
    $('#user_data').hide();
    $('#user_tools').hide();
    $('#user').modal();
    $url = $(this).data('url');
    $id = $(this).data('id');
      $.ajax({
        type : 'get',
        url : $url,
        data:{'ajax':true},
        success:function(data){
          $('#user_data').html('<div class="userdata">'+data+'</div>');
          $('#user_data').show();
          $('#user_tools').show();
          $score = $('#u'+$id).data('score');
          console.log($score);
          $shortlisted = $('#u'+$id).data('shortlisted');
          $('#score').val($score);
          $('#shortlisted').val($shortlisted);
          $('.message').remove();
          $('.tools_save').data('user_id',$id)
          $('.loading').hide();
        }
      });
  });

  $('.tools_save').on('click',function(e){
    e.preventDefault();

    $('.spinner-border2').show();
    $url = $(this).data('url');
    $user_id = $(this).data('user_id');
    $post_id = $(this).data('post_id');
    $token = $(this).data('token');
    $score = $('#score').val();
    $shortlisted = $('#shortlisted').val();

    var fd = new FormData();
    fd.append('user_id',$user_id);
    fd.append('post_id',$post_id);
    fd.append('_token',$token);
    fd.append('score',$score);
    fd.append('shortlisted',$shortlisted);
     
    $.ajax({
          type : 'POST',
          url : $url,
          data:fd,
          cache: false,
          processData: false,
          contentType: false,
          beforeSend: function (request) {
              return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
          },
          success:function(response){
            $('.message').remove();
            $('.spinner-border2').hide();
            console.log(response);
            $('#u'+$user_id).data('score',$score);
            $('#u'+$user_id).data('shortlisted',$shortlisted);
            if(response != 0){

                  
                  $('<div class="message text-success mt-3"><i class="fa fa-check-circle"></i> Saved</div>').insertAfter('.tools_save');
                  if($shortlisted=='YES')
                    $('#tr'+$user_id).css('background','#dffbe2');
                  else if($shortlisted=='MAY BE')
                    $('#tr'+$user_id).css('background','#ffffed');
                  else if($shortlisted=='NO')
                    $('#tr'+$user_id).css('background','#fff3f3');
                }else{
                  console.log('error');
                  $('<div class="message text-danger"">Data save failed. Kindly retry.</div>').insertAfter('.tools_save');
                }
          },
          
        });
  });

  /* profile completion page */
  if($('.screen').length){
    $('.college_name').hide();
    $('.screen_1').show();

    $('.screen_next').on('click',function(){
        $next = $(this).data('next');
        screen($next);
    });
    $('.screen_back').on('click',function(){
        $next = $(this).data('back');
        screen($next);
    });

    $("form :input").change(function() {
      $name = $(this).attr('name');
      ele = $('.'+$name);

      $error = 0;
      // string length condition
      if(parseInt($(this).data('vcount'))){
        if($(this).val().length!= parseInt($(this).data('vcount'))){
          $('.help_'+$name).show();
            $('.help_'+$name).html($(this).data('vcount')+' digit number are required');
            $error = 1;
        }else{
            $('.help_'+$name).hide();
        }
      }


      if($name=='college_id'){
        if($(this).val()==5 || $(this).val()==295)
        {
          $('.college_name').slideDown();
        }else{
          $('.info').val('');
          $('.college_name').hide();
        }

      }

      // min and max condition
      if($(this).attr('min')){

        if(parseInt($(this).val()) < parseInt($(this).attr('min'))){
          $('.help_'+$name).show();
          $('.help_'+$name).html('The number cannot be less than 30');
            $error = 1;
        }else if(parseInt($(this).val()) > parseInt($(this).attr('max'))){
          $('.help_'+$name).show();
          $('.help_'+$name).html('The number cannot be greater than 100');
            $error = 1;
        }else{
            $('.help_'+$name).hide();
        }

      }

      if(ele.length && !$error){
        ele.removeClass('text-silver');
        ele.addClass('text-success');
        percent();
      }
    });
  }

  function screen($next){
     
      $('.'+$next).show();
  }

  function percent(){
      $step = $('.progress-bar').data('step');
      $percent = $('.progress-bar').data('percent');
      $new = parseInt($step)+parseInt($percent);
      $('.progress-bar').css('width',$new+"%");
      $('.progress-bar').data('percent',$new);

  }



  //proctoring
  $('.btn-approve').on('click',function(e){

    e.preventDefault();
    $username = $(this).data('username');
    $approved = parseInt($(this).data('approved'));
    $alert = $(this).data('alert');
    $url = $(this).data('url');
    $token = $(this).data('token');

    $('.spinner_'+$username).show();

     $.post( $url ,{'username': $username ,'approved':$approved,'alert':$alert,'_token':$token,'api':1}, function( data ) {
            if($approved==1){
              if($('.card_'+$username).hasClass('bg-light-danger') || $('.card_'+$username).hasClass('bg-light-warning') ){
              if($('.card_'+$username).hasClass('bg-light-danger')){
                  $('.counter_rejected').text(parseInt($('.counter_rejected').text())-1);
                  $('.counter_approved').text(parseInt($('.counter_approved').text())+1);
              }else{
                $('.counter_waiting').text(parseInt($('.counter_waiting').text())-1);
                $('.counter_approved').text(parseInt($('.counter_approved').text())+1);
              }
              $('.card_'+$username).removeClass('bg-light-warning').removeClass('bg-light-danger');
              $('.action_'+$username).hide();
              $('.status_'+$username).html("<div class='h3 text-success mt-3'><i class='fa fa-check-circle text-success'></i> Approved</div>");

            }
              
            }
            
            if($approved==2){
              if(!$('.card_'+$username).hasClass('bg-light-danger')){
                  if($('.card_'+$username).hasClass('bg-light-warning')){
                  $('.counter_waiting').text(parseInt($('.counter_waiting').text())-1);
                  $('.counter_rejected').text(parseInt($('.counter_rejected').text())+1);
                }else{
                  $('.counter_approved').text(parseInt($('.counter_approved').text())-1);
                  $('.counter_rejected').text(parseInt($('.counter_rejected').text())+1);
                }

                $('.card_'+$username).removeClass('bg-light-warning').addClass('bg-light-danger');
              }
              
              $('.status_'+$username).html("<div class='h3 text-danger mt-3'><i class='fa fa-times-circle text-danger'></i> Rejected</div>");
              
            }
             $('.spinner_'+$username).hide();
      });

  });


  function check_messages(){
  if($('#photo').length){
      $username = $('#photo').data('username');
      $bucket = $('#photo').data('bucket');
      $region = $('#photo').data('region');
      $test= $('#photo').data('test');
      $aws_url = 'https://'+$bucket+'.s3.'+$region+'.amazonaws.com/testlogs/chats/'+$test+'/';
      $url = $aws_url+$username+'.json';

      $.ajax({
                type: "GET",
                url: $url
            }).done(function (result) {
                 $message = JSON.stringify(result);
                 $('.chat_messages').html('');
                 var  i =0;
                 for(var k in result) {
                   $u = result[k].person;
                   $message = result[k].message;
                   $('.chat_messages').append("<div class='mt-2'><b>"+$username+":</b><br>"+$message+"</div>");
                   i = i+1;
                   if((Object.keys(result).length) == i){
                    $time = parseInt($('.message_proctor').data('time'));
                    $new_time = parseInt(result[k].time);
                      if($new_image != $time){
                          $('.message_proctor').addClass('text-danger').addClass('bg-warning');
                      }
                   }
                    
                  }

                //window.location.href = backendUrl;
            }).fail(function () {
                console.log("Sorry URL is not access able");
        });
   }
}



 function sortObject(obj) {
        return Object.keys(obj).sort().reduce(function (result, key) {
            result[key] = obj[key];
            return result;
        }, {});
    }


$('.message_student').on('click',function(e){

        $url = $(this).data('url')+"?time="+$.now();
        $username = $(this).data('username');
        $name = $(this).data('name');
        item = $('.message_'+$username);
        $('.message_name').html($name);
        $('.send_chat').data('username',$username);
        $('.chat_messages').html('');

         $.ajax({
                type: "GET",
                url: $url
            }).done(function (result) {
                // result.forEach(obj => {
                //     Object.entries(obj).forEach(([key, value]) => {
                //         console.log(`${key} ${value}`);
                //     });
                //     console.log('-------------------');
                // });

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
                      $('.chat_messages').animate({scrollTop: 5000},400);
                   $('.chats').animate({scrollTop: 5000},400);
                   }

                }

                

                //console.log(result);
                //console.log(ordered);

                 
                
            }).fail(function () {
                console.log("Sorry URL is not access able");
        });

        $('#chat').modal();

     });

function toDateTime(secs) {
      var t = new Date(1970, 0, 1); // Epoch
      t.setSeconds(secs);
      
    t.setHours(t.getHours() + 5); 
    t.setMinutes(t.getMinutes() + 30);
    datetext = t.toTimeString();
    datetext = datetext.split(' ')[0];

      return datetext;
  }

$(document).on('click','.send_chat',function(){

    var objDiv = $('.chats')[0];
    objDiv.scrollTop = $('.chats')[0].scrollHeight+ 300;

    $username = $(this).data('username');
    $uname = $('.message_'+$username).data('name');
    $pname = $('.message_'+$username).data('proctor');
    $p = $('.message_'+$username).data('p');
    $testid = $(this).data('testid');
    $user = $(this).data('user');
    $message = $('#message-text').val();
    $url = $('.message_'+$username).data('url');
    $urlpost = $('.message_'+$username).data('urlpost');
    $test = $('#video').data('test');
    $name = $username+'_'+$test+'_chat';
    it = $('.message_'+$username);

    if($p)
      $uname = $pname;

    
    $('.chat_messages').animate({scrollTop: 5000},400);
    const now = new Date()  
    const $time = Math.round(now.getTime() / 1000) 

    $('.message_proctor').data('time',$time);

        $.ajax({
                type: "GET",
                url: $url
            }).done(function (result) {

                var item ={ "name": $uname, "username":$username,"message":$message};
                result[$time] = item;
                it.data('lastchat',$time);
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
                     $('.chat_messages').animate({scrollTop: 5000},400);
                     $('.student_name_'+$username).html($uname);
                     $('.student_message_'+$username).html($message);
                     $('.time_'+$username).html(toDateTime($time));
                      console.log('message sent');
              });
                
            }).fail(function () {
                console.log("Sorry URL is not access able");
        });

});


$('.ques_count').on('click',function(){
    $('.qsset').slideToggle();
});






function chat_refresh(){
  if($('.message_student').length){

      $('.message_student').each(function(i, obj) {
          
        $url = $(this).data('url')+"?time="+$.now();
        $username = $(this).data('username');
        $lastchat = $(this).data('lastchat');
        $name = $(this).data('name');
        item = $('.message_'+$username);
        $lastestchat = $lastchat;


         $.ajax({
                type: "GET",
                url: $url
            }).done(function (result) {

                const ordered = sortObject(result);

                i=0;$count =0 ;
                for(var k in ordered) {
                   $u = ordered[k].name;
                   i = i+1;

                   if((Object.keys(ordered).length) == i){
                      
                      $lastestchat = k;
                      $lastchat = $('.message_'+ordered[k].username).data('lastchat');

                      if(ordered[k].username){
                        if($('.student_name_'+ordered[k].username).length){
                              $('.student_name_'+ordered[k].username).html(ordered[k].name);
                             $('.student_message_'+ordered[k].username).html(ordered[k].message);
                             $('.time_'+ordered[k].username).html(toDateTime(k));
                        }
                      }

                      
                        

                      //console.log($lastestchat+' - '+$lastchat+' - '+ordered[k].username);
                     
                      if(!$lastchat){
                        $('.message_'+ordered[k].username).data('lastchat',k);
                      }else{
                        
                        if(k>$lastchat)
                          $count++;

                        if($lastestchat > $lastchat){
                          if($('#chat').is(':visible')){
                            $live_username = $('.send_chat').data('username');
                            if($live_username==ordered[k].username){
                              console.log("new append");
                              $('.chat_messages').append("<div class='mt-2'><b>"+ordered[k].name+": <span class='badge badge-warning'>new</span></b><br>"+ordered[k].message+"</div>");
                              $('.message_'+ordered[k].username).data('lastchat',k);
                            }
                            

                          }else{
                              $('.message_'+ordered[k].username).addClass('blink');
                          }

                            
                            // if($('.send_chat').data('username')==$username){
                            //   
                            // }
                        }else{
                           $('.message_'+ordered[k].username).removeClass('blink');
                           $('.chat_count_'+ordered[k].username).hide();
                        } 
                      }

                      

                   }
                }

                

                //console.log(result);
               /// console.log(ordered);

                 
                
            }).fail(function () {
                console.log("Sorry URL is not access able");
        });
      });

      

  }
}

setInterval(chat_refresh,1000);


function image_refresh(){
  if($('.image_refresh').length){

      $('.image_refresh').each(function(i, obj) {
          $username = $(this).data('username');
          //console.log($username);
          // $bucket = $(this).data('bucket');
          // $region = $(this).data('region');
          // $test= $(this).data('test');
          // $aws_url = 'https://'+$bucket+'.s3.'+$region+'.amazonaws.com/testlogs/pre-message/'+$test+'/';
          // $aws2 = 'https://'+$bucket+'.s3.'+$region+'.amazonaws.com/';
          // if($(this).data('url2').length)
          // $url = $(this).data('url2')+'?time='+new Date();
          // else
          $url = $(this).data('url')+'?time='+new Date(); 



          $item = $(this);

          $.ajax({
                type: "GET",
                url: $url
            }).done(function (result) {

                 window_change = result.window_change;
                 last_photo = result.last_photo;
                 
                 $username = result.username;
                 
                 $completed = $('.image_refresh_'+$username).data('completed');
                

                 if($username){
                     $('.image_refresh_'+$username).attr('src',last_photo);
                 if(window_change){
                    $('.window_change_'+$username).show();
                 }
                    $('.window_change_'+$username).html(window_change);
                 }

                 if(result.completed && !$completed){

                  $('.card_'+$username).removeClass('bg-light-danger').removeClass('bg-light-warning');

                 }
                 else if(result.last_updated && !$completed){
                    $('.card_'+$username).data('last',result.last_updated);
                    $time = new Date().getTime() ;
                    if(result.last_seconds){
                      if((parseInt($time) - result.last_seconds)/1000 > 30){
                          $('.card_'+$username).removeClass('bg-light-warning').addClass('bg-light-danger');
                      }
                    else
                      $('.card_'+$username).addClass('bg-light-warning').removeClass('bg-light-danger');
                    }
                 }else{

                 }

                 if(result.completed){
                  if($('.completed_msg').length){
                    $('.completed_msg').html('<b><i class="fa fa-check-circle text-success"></i> completed</b>');
                  }
                 }
                  

                //window.location.href = backendUrl;
            }).fail(function () {
                console.log("Sorry URL is not access able");
          });

          if($(this).is(":empty")){
            //$(this).attr("src","second.jpg");
        }
      });

      

  }
}

image_refresh();
if($('.proctoring').data('active')=='0')
  setInterval(image_refresh,3000);


});
</script>


<script>



  </script>

<script>
$(function(){

   $('.rdelete').on('click',function(e){
    e.preventDefault();
    url = $(this).attr('href');
    name = $(this).data('name');

    $('.rdelete_form').attr('action',url);
    $('.rname').show().html(' - '+ name);

    $('#r\delete').modal();
  });

  $('.ddelete').on('click',function(e){
    e.preventDefault();
    url = $(this).attr('href');
    name = $(this).data('name');

    $('.ddelete_form').attr('action',url);
    $('.dname').show().html(' - '+ name);

    $('#ddelete').modal();
  });

  $('.dresource').on('click',function(e){
    e.preventDefault();
    url = $(this).attr('href');
    name = $(this).data('name');
    schedule_id = $(this).data('id');

    $('.dresource_form').attr('action',url);
    $('.dschedule_id').attr('value',schedule_id);
    $('.drname').show().html(' - '+ name);
    $('#dresource').modal();
  });

  $('.dattendance').on('click',function(e){
    e.preventDefault();
    url = $(this).attr('href');
    name = $(this).data('name');
    schedule_id = $(this).data('id');

    $('.dattendance_form').attr('action',url);
    $('.daschedule_id').attr('value',schedule_id);
    $('.daname').show().html(' - '+ name);
    $('#dattendance').modal();
  });

  $('.block').hide();
  $('.block_item').on('click',function(){
      id = $(this).data('id');
      $('.block_'+id).slideToggle();
  });
});
  </script>

<script>
 $(document).keypress(function(){

      var key = (event.keyCode ? event.keyCode : event.which); 
        if (key == 108) {
          
          if( $('.prev').length ) {
            var url = $('.prev').data('prev');
            window.location= url;
          }
        }
        else if(key == 114){
          if( $('.next').length ) {
             var url = $('.next').data('next');
            window.location= url;
          }
         
        }
    });

 $(function () {
  $('[data-toggle="tooltip"]').tooltip()
});

 $(".check").click(function () {
    var c = $(this).data('name');
    $("."+c).prop('checked', $(this).prop('checked'));
});

 $(document).on('click','.show_image',function(e){
      e.preventDefault();
      console.log('here');
          url = $(this).data('url');
          imgurl = $(this).data('imgurl');
          $('.canvas').html('<canvas id="sketchpad" width="1100px" height="1100px" style="background:#f8f8f8 ;background-image:url('+url+');background-repeat: no-repeat;background-size:100%"></canvas>').promise().done(function(){
          $('#exampleModal').modal();
      });

          if($('.img_resp').length){
            $('.img_resp').attr('src',imgurl);
          }
     
      
  });

 $(document).on('click','.score_edit',function(e){
    e.preventDefault();
    $id = $(this).data('id');
    $('.review_'+$id).removeClass('badge-success').html('under review').addClass('badge-warning');
    $('.score_save_'+$id).show();
    $('.qno_'+$id).removeClass('qgreen').addClass('qred');
    $('.box_'+$id).removeClass('qgreen').addClass('qred');
    $('.score_entry_'+$id).show();
    $('.feedback_'+$id).remove();
    $('.score_entry_val_'+$id).remove();

 });

 $(document).on('click','.score_save',function(e){
      e.preventDefault();

      $url = $(this).data('url');
      $id = $(this).data('id');
      $slug = $(this).data('slug');
      $score = $('input[name=score_'+$id+']:checked').val();
      $comment = $('.comment_'+$id).val();
      $student = $(this).data('student');
      $token = $(this).data('token');

      console.log($id+' '+$score+' '+$comment);
      $('.loading_'+$id).show();
      $.ajax({
          type : 'post',
          url : $url,
          data:{'score':$score,'comment':$comment,'student':$student,'slug':$slug,'_token':$token},
          success:function(data){
            json = JSON.parse(data);
            console.log(json);
            if(json.status==0){
              $('.under_review_main').hide();
              $('.score_main').html("<div class='display-4'>"+json.score+"</div>");
            }
            
            $('.review_'+$id).removeClass('badge-warning').html('evaluated').addClass('badge-success');
            $('.box_'+$id).removeClass('qred').addClass('qgreen');
            $('.score_entry_'+$id).hide();
            if($comment)
            $('<div class="score_entry_val_'+$id+'"><div>'+$score+' <i class="fa fa-edit text-primary cursor score_edit" data-id="'+$id+'"></i></div><div class="feedback_'+$id+'"><div class="my-2"><b>Feedback</b></div><p>'+$comment+'</p></div></div>').insertAfter('.score_entry_'+$id);
            else
            $('<div class="score_entry_val_'+$id+'"><div>'+$score+' <i class="fa fa-edit text-primary cursor score_edit" data-id="'+$id+'"></i></div></div>').insertAfter('.score_entry_'+$id);
            $('.score_save_'+$id).hide();
            $('.loading_'+$id).hide();
            $('.qno_'+$id).removeClass('qred').addClass('qgreen');
            
            
          }
        });
     
      
  });

  $(document).on('click','.rotate_save',function(e){
      e.preventDefault();

      $url = $(this).data('url');
      $id = $(this).data('id');
      $imgurl = $(".img_"+$id).attr('src');
  

      $('.img_loading_'+$id).show();
      $.ajax({
          type : 'get',
          url : $url,
          data:{'imgurl':$imgurl},
          success:function(data){
            //console.log(data);
            $(".img_"+$id).attr("src", data);
            //console.log(".img_"+$id);
            //console.log($(".img_"+$id).attr("src"));
            $('.img_loading_'+$id).hide();
            // json = JSON.parse(data);
            // if(json.status==0){
            //   $('.under_review_main').hide();
            //   $('.score_main').html("<div class='display-4'>"+json.score+"</div>");
            // }
            
            // $('.review_'+$id).removeClass('badge-warning').html('evaluated').addClass('badge-success');
            // $('.box_'+$id).removeClass('qyellow').addClass('qgreen');
            // if($comment)
            // $('.score_entry_'+$id).html('<div>'+$score+'</div><div class="my-2"><b>Feedback</b></div><p>'+$comment+'</p>');
            // else
            // $('.score_entry_'+$id).html('<div>'+$score+'</div>');
            // $('.score_save_'+$id).hide();
            // $('.loading_'+$id).hide();
            // $('.qno_'+$id).removeClass('qyellow').addClass('qgreen');
            
            
          }
        });
     
  });

   $(document).on('click','.rotate_save2',function(e){
      e.preventDefault();

      $url = $(this).data('url');
      $id = $(this).data('id');
      $imgurl = $(".img_"+$id).attr('src');
  

      $('.img_loading_'+$id).show();
      $.ajax({
          type : 'get',
          url : $url,
          data:{'imgurl':$imgurl},
          success:function(data){
            //console.log(data);
            $(".img_"+$id).attr("src", data);
            location.reload();
            //console.log(".img_"+$id);
            //console.log($(".img_"+$id).attr("src"));
            $('.img_loading_'+$id).hide();
            // json = JSON.parse(data);
            // if(json.status==0){
            //   $('.under_review_main').hide();
            //   $('.score_main').html("<div class='display-4'>"+json.score+"</div>");
            // }
            
            // $('.review_'+$id).removeClass('badge-warning').html('evaluated').addClass('badge-success');
            // $('.box_'+$id).removeClass('qyellow').addClass('qgreen');
            // if($comment)
            // $('.score_entry_'+$id).html('<div>'+$score+'</div><div class="my-2"><b>Feedback</b></div><p>'+$comment+'</p>');
            // else
            // $('.score_entry_'+$id).html('<div>'+$score+'</div>');
            // $('.score_save_'+$id).hide();
            // $('.loading_'+$id).hide();
            // $('.qno_'+$id).removeClass('qyellow').addClass('qgreen');
            
            
          }
        });
     
  });


  $('.typed_answer').on('keyup',function(){
      $question  = $('.typed_question').text();
      $sno = $(this).data('sno');

      $elapsed_time = parseInt($('.'+$sno+'_time').val());
      $start_time = parseInt($('.'+$sno+'_time_start').val());

      if(!$start_time)
        $('.'+$sno+'_time_start').val($elapsed_time);


      $response=$(this).val();
      $d = match($question,$response);
      $('.typed_question_html').html($d['html']);
      $('.word_total').text($d['total']);
      $('.word_typed').text($d['typed']);
      $('.word_pending').text($d['pending']);
      $('.word_error').text($d['error']);

      $effective_time = $elapsed_time-$start_time;
      $('.'+$sno+'_time_end').val($effective_time);
      
      $wpm = parseInt((($d['chars']/5)-parseInt($d['error']))*60/$effective_time);
      $accuracy = parseInt(100 - ($d['error']*100/$d['total']));
      $('.'+$sno+'_wpm').val($wpm);
      $('.'+$sno+'_accuracy').val($accuracy);

    });


   function match($question,$response){
      $qtokens = $question.split(" ");
      $rtokens = $response.split(" ");
      $dtokens = [];
      $error = 0;
      $data = [];
      $qtokens.forEach(function(item,index){


        if($rtokens[index]){
          //console.log($rtokens[index]+' '+item);
          if($rtokens[index] == item)
            $dtokens[index] = '<span class="text-success">'+item+'</span>';
          else{
            if(index != ($rtokens.length-1)){
              $error++;
              $dtokens[index] = '<span class="text-danger">'+item+'</span>';
            }
            else
              $dtokens[index] = '<span class="text-primary ">'+item+'</span>';
          }
        }else{
           $dtokens[index] = item;
        }
      });

      $data['html'] = $dtokens.join(' ');
      $data['chars'] = $response.replace(/\s/g, '').length;
      $data['total'] = $qtokens.length;
      $data['typed'] = $rtokens.length;
      $data['pending'] = $data['total'] -$data['typed'];
      $data['error'] = $error;
      return $data;
      
   }



  </script>

@if(isset($sketch))


@endif
@if(isset($sketchpad))
<script src="{{asset('js/sketchpad.js')}}"></script>    

<script>


  function late(item){
    url = item.data('url');
    height = $('.save_image').data('height');
    console.log($('.save_image').data('url'));
    $('.canvas').html('<canvas id="sketchpad" width="1100px" height="'+height+'px" style="background:#f8f8f8 ;background-image:url('+url+');background-repeat: no-repeat;background-size:100%"></canvas>').promise().done(function(){
          init();
          $('#exampleModal').modal();
      });

  }


  


  $(document).on('click','.correct_image',function(e){
      e.preventDefault();
      if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
          alert('Edit option available for desktop users only.');
      }else{
          name = $(this).data('name');
          id = $(this).data('id');
          url = $(this).data('url');
          imgurl = $(this).data('imgurl');

          iurl = $('.img_'+id).attr('src');
         
          $('.canvas_message').html('');
          if(iurl!=imgurl){
            $('.canvas_message').html('<div class="p-3 text-danger">The image was updated. Kindly refresh the page to load the new image.</div>')
          }
          dimensions = $('.correct_image').data('dimensions');
          var res = dimensions.split("-");
          width = res[0]
          height = res[1];
          height = Math.round((1100/width)*height);
          $('.save_image').data('height',height);
          $('.save_image').data('name',$(this).data('name'));
          $('.save_image').data('id',$(this).data('id'));
          $('.save_image').data('url',$(this).data('eurl'));
          $('.save_image').data('qid',$(this).data('qid'));
          $('.save_image').data('imgurl',$(this).data('imgurl'));


          late($(this));
      }
      
  });

  function redirectPost(url, data) {
    var form = document.createElement('form');
    document.body.appendChild(form);
    form.method = 'post';
    form.action = url;
    for (var name in data) {
        var input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = data[name];
        form.appendChild(input);
    }
    form.submit();
  } 

  $(document).on('click','.clear_image',function(e){
    clearCanvas(canvas,ctx);

  });

  $(document).on('click','.save_image2',function(e){
    e.preventDefault();
    url = $(this).data('url');

    data = [];
    data['name'] = $(this).data('name');
    data['named'] = $(this).data('named');
    $id = $(this).data('id');
    data['imgurl'] = $(this).data('imgurl');
    data['width'] = $(this).data('width');
    data['height'] = $(this).data('height');
    data['user_id'] = $(this).data('user_id');
    data['slug'] = $(this).data('slug');
    data['qid'] = $(this).data('qid'); 
    data['id'] = $(this).data('id'); 
    data['_token'] = $(this).data('token');

    data['student'] = $(this).data('student');
    canvas = document.getElementById(data['named']);
    data['image'] = canvas.toDataURL("image/png");
    //redirectPost(url,data);
    $('.saved_'+$id).hide();


    $('.img_loading_'+$id).show();
      $.ajax({
          type : 'post',
          url : url,
          data:{'imgurl':data['imgurl'],'name':data['name'],'width':data['width'],'height':data['height'],'user_id':data['user_id'],'slug':data['slug'],'qid':data['qid'],'id':data['id'],'_token':data['_token'],'student':data['student'],'image':data['image'],'ajax':1},
          success:function(data){
            console.log(data);
            //$(".img_"+$id).attr("src", data);
            //console.log(".img_"+$id);
            //console.log($(".img_"+$id).attr("src"));
            $('.img_loading_'+$id).hide();
            $('.saved_'+$id).show();
            // json = JSON.parse(data);
            // if(json.status==0){
            //   $('.under_review_main').hide();
            //   $('.score_main').html("<div class='display-4'>"+json.score+"</div>");
            // }
            
            // $('.review_'+$id).removeClass('badge-warning').html('evaluated').addClass('badge-success');
            // $('.box_'+$id).removeClass('qyellow').addClass('qgreen');
            // if($comment)
            // $('.score_entry_'+$id).html('<div>'+$score+'</div><div class="my-2"><b>Feedback</b></div><p>'+$comment+'</p>');
            // else
            // $('.score_entry_'+$id).html('<div>'+$score+'</div>');
            // $('.score_save_'+$id).hide();
            // $('.loading_'+$id).hide();
            // $('.qno_'+$id).removeClass('qyellow').addClass('qgreen');
            
            
          }
        });
    
  });


  $(document).on('click','.save_image',function(e){
    e.preventDefault();
    url = $(this).data('url');

    data = [];
    data['name'] = $(this).data('name');
    $id = $(this).data('id');
    data['imgurl'] = $(this).data('imgurl');
    data['width'] = $(this).data('width');
    data['height'] = $(this).data('height');
    data['user_id'] = $(this).data('user_id');
    data['slug'] = $(this).data('slug');
    data['qid'] = $(this).data('qid'); 
    data['_token'] = $(this).data('token');
    data['id'] = $(this).data('id'); 

    data['student'] = $(this).data('student');
    canvas = document.getElementById('sketchpad');
    data['image'] = canvas.toDataURL("image/png");
    //redirectPost(url,data);

    $('#exampleModal').modal('hide');

    $('.img_loading_'+$id).show();
      $.ajax({
          type : 'post',
          url : url,
          data:{'imgurl':data['imgurl'],'name':data['name'],'width':data['width'],'height':data['height'],'user_id':data['user_id'],'slug':data['slug'],'qid':data['qid'],'id':data['id'],'_token':data['_token'],'student':data['student'],'image':data['image'],'ajax':1},
          success:function(data){
            console.log(data);
            $(".img_"+$id).attr("src", data);
            //console.log(".img_"+$id);
            //console.log($(".img_"+$id).attr("src"));
            $('.img_loading_'+$id).hide();
            // json = JSON.parse(data);
            // if(json.status==0){
            //   $('.under_review_main').hide();
            //   $('.score_main').html("<div class='display-4'>"+json.score+"</div>");
            // }
            
            // $('.review_'+$id).removeClass('badge-warning').html('evaluated').addClass('badge-success');
            // $('.box_'+$id).removeClass('qyellow').addClass('qgreen');
            // if($comment)
            // $('.score_entry_'+$id).html('<div>'+$score+'</div><div class="my-2"><b>Feedback</b></div><p>'+$comment+'</p>');
            // else
            // $('.score_entry_'+$id).html('<div>'+$score+'</div>');
            // $('.score_save_'+$id).hide();
            // $('.loading_'+$id).hide();
            // $('.qno_'+$id).removeClass('qyellow').addClass('qgreen');
            
            
          }
        });
    
  });
</script>

@endif

@if(isset($editor))
<!-- include summernote css/js-->
<script src="{{asset('js/summernote/summernote-bs4.js')}}"></script>    
<script src="{{asset('js/jquery.form.js')}}"></script>  

<script>
  $(document).ready(function() {
            $('.summernote2').summernote({
        toolbar: [
          // [groupName, [list of button]]
          ['style', ['bold', 'italic', 'underline', 'clear']],
          ['fontsize', ['fontsize','superscript', 'subscript']],
          ['color', ['color']],
          ['para', ['ul', 'ol', 'paragraph']],
          ['height', ['height']]
        ]
      });
});

 </script>
 <script>
        $(document).ready(function() {
            $('.summernote').summernote({
                placeholder: 'Hello ! Write something...',
                tabsize: 2,
                height: 200,                // set editor height
                minHeight: null,             // set minimum height of editor
                maxHeight: null,             // set maximum height of editor
                focus: true, 
                codemirror: { // codemirror options
                  theme: 'monokai'
                },toolbar: [
      ['style', ['bold', 'italic', 'underline', 'clear']],
      ['font', ['superscript', 'subscript']],
      ['fontsize', ['fontsize']],
      ['color', ['color']],
      ['para', ['ul', 'ol', 'paragraph']],
      ['table', ['table']],
      ['insert', ['link', 'picture', 'video']],
      ['view', ['fullscreen', 'codeview', 'help']]
    ],
                callbacks: {
        onPaste: function (e) {
            var bufferText = ((e.originalEvent || e).clipboardData || window.clipboardData).getData('Text');
            e.preventDefault();
            document.execCommand('insertText', false, bufferText);
        }
    },
              });
          });

        
</script>
@endif

@if(isset($highlight))
<script src="{{asset('js/highlight.pack.js')}}"></script>  
<script>hljs.initHighlightingOnLoad();</script>
@endif


@if(isset($csq))


@endif
@if(isset($code))
<!-- Codemirror-->
<script src="{{asset('js/codemirror/lib/codemirror.js')}}"></script>  
  <script src="{{asset('js/codemirror/addon/fold/foldcode.js')}}"></script>  
    <script src="{{asset('js/codemirror/addon/fold/foldgutter.js')}}"></script>  
      <script src="{{asset('js/codemirror/addon/fold/indent-fold.js')}}"></script>  
        <script src="{{asset('js/codemirror/addon/fold/comment-fold.js')}}"></script>  
  <script src="{{asset('js/codemirror/addon/fold/brace-fold.js')}}"></script>  
    <script src="{{asset('js/codemirror/addon/edit/closebrackets.js')}}"></script>  
      <script src="{{asset('js/codemirror/addon/search/search.js')}}"></script>  
        <script src="{{asset('js/codemirror/addon/search/searchcursor.js')}}"></script>  
<script src="{{asset('js/codemirror/mode/xml/xml.js')}}"></script>  
<script src="{{asset('js/codemirror/mode/javascript/javascript.js')}}"></script> 
<script src="{{asset('js/codemirror/mode/clike/clike.js')}}"></script>  
<script src="{{asset('js/codemirror/addon/display/autorefresh.js')}}"></script>  
<script src="{{asset('js/codemirror/mode/markdown/markdown.js')}}"></script>  

<script type="text/javascript">
$(document).ready(function() {
  var options = {
          lineNumbers: true,
          styleActiveLine: true,
          matchBrackets: true,
          autoRefresh:true,
          mode: "text/x-c++src",
          theme: "monokai",
    lineWrapping: true,
    extraKeys: {"Ctrl-Q": function(cm){ cm.foldCode(cm.getCursor()); },"Alt-F": "findPersistent"},
    foldGutter: true,
    gutters: ["CodeMirror-linenumbers", "CodeMirror-foldgutter"],
    autoCloseBrackets: true,
          indentUnit: 4
        };
  if(document.getElementById("code"))
    var editor = CodeMirror.fromTextArea(document.getElementById("code"), options);

  var editor_array =[];
  @if(isset($code_ques))
  @foreach($code_ques as $c=>$d)
    editor_array['code_{{$c}}'] = CodeMirror.fromTextArea(document.getElementById("code_{{$c}}"), options);
  @endforeach
  @endif

  // $('.runcode').on('click',function(){
  //     $qno = $(this).data('qno');
  //     $lang = $(this).data('lang');
  //     $name = $(this).data('name');
  //     $c = ($(this).data('c'))?$(this).data('c'):null;
  //     $input = $(this).data('input');
  //     $url= $(this).data('url');
  //     $url_stop= $(this).data('url_stop');
  //     $url_remove= $(this).data('url_remove');
      
  //     $random = Math.random().toString(36).substring(7);
   

  //     var editor_ = editor_array[$name];

  //     var code = editor_.getValue();
      
  //     $('.loading').show();

  //       $.ajax({
  //         type : 'get',
  //         url : $url_remove,
  //         success:function(data){
  //         }
  //       });

  //       $.ajax({
  //         type : 'get',
  //         url : $url,
  //         data:{'testcase':'1','code':code,'lang':$lang,'c':$c,'input':$input,'name':$random},
  //         success:function(data){
  //           console.log(data);
  //           data = JSON.parse(data);
   
  //           if(data){
  //             if(data.stderr){
  //               $('.output_'+$qno).html(data.stderr);
  //             }else{
  //               $('.output_'+$qno).html(data.stdout);
  //               $('.input_'+$qno).attr('value',data.stdout);
  //             }
  //           }else{
  //              $('.output_'+$qno).html("Data not compiled");
  //           }
            
  //           $('.loading').hide();
  //         }
  //       });

  //       setTimeout( function(){ 
  //       $.ajax({
  //         type : 'get',
  //         url : $url_stop,
  //         data:{'name':$random},
  //         success:function(data){
  //         }
  //       });
  //       }  , 3000 );
        

  //   }); 
  $('.lang').on('focusin', function(){
    $qno = $(this).data('qno');
    $n = '.preset_'+$(this).val()+'_'+$qno;
    $name='code_'+$qno;
    var editor_ = editor_array[$name];
    var code = editor_.getValue();
    $($n).data('code',code);
    console.log("Saving value " + code);
    console.log($(this).val());
  
  });
  $('.lang').on('change',function(e){
    $qno = $(this).data('qno');
    $n = '.preset_'+$(this).val()+'_'+$qno;
    $code = $($n).data('code');
    $name='code_'+$qno;

        $('.runcode_'+$qno).data('lang',$(this).val());
      if($(this).val()=='c'){
        $('.runcode_'+$qno).data('lang','clang');
        $('.runcode_'+$qno).data('c',1);
      }else if($(this).val()=='cpp'){
        $('.runcode_'+$qno).data('lang','clang');
        $('.runcode_'+$qno).data('c',0);
      }

    
    var editor_ = editor_array[$name];
    editor_.getDoc().setValue($code);
    console.log("Set value " + $code + ' - '+$n);
    console.log($(this).val());
    console.log($('.runcode_'+$qno).data('lang'));
  });


   $('body').on('click','.runcode2',function(){
      $qn = $qno = $(this).data('qno');
      $lang = $(this).data('lang');
      $name = $(this).data('name');
      $test = $(this).data('test');
      $qslug = $(this).data('qslug');
      i = $testcase = parseInt($(this).data('testcase'));
      $namec = $(this).data('namec')+Math.random().toString(36).substring(3);
      $c = ($(this).data('c'))?$(this).data('c'):null;
      $input = $(this).data('input');
      $url= 'https://cmplr.in/run';
      $stop= $(this).data('stop');
      var editor_ = editor_array[$name];

      var code = editor_.getValue();
      $('.code_'+$qno).val(code);
      $('.codefragment_'+$qno).val(code);
      if(!$('.s'+$qno).hasClass('qblue-border'))
      $('.s'+$qno).addClass('qblue-border');
      
      $('.loading_'+$qno).show();

      if(!$('.runcode_'+$qno).hasClass('disabled')){
        $(this).addClass('disabled');
        if($testcase==3){
          for(i=1;i<=5;i++){
            ajaxrun($url,code,$lang,$c,$input,$namec,i,$test,$qslug,$qn,i);
          }
        }else{
          ajaxrun($url,code,$lang,$c,$input,$namec,i,$test,$qslug,$qn,1);
        }
        
      }

    }); 

function ajaxrun($url,code,$lang,$c,$input,$namec,$testcase,$test,$qslug,$qn,$t,$k=0){

  $.ajax({
          type : 'get',
          url : $url+'?time='+ new Date().getTime(),
          cache: false,
          data:{'code':code,'lang':$lang,'c':$c,'input':$input,'name':$namec,'testcase':$testcase,'test':$test,'qslug':$qslug},
          timeout: 8000, 
          success:function(data){
            $('.runcode_'+$qn).removeClass('disabled');
            console.log('qn'+$qn);
           
            var jso = data;
            dat = JSON.parse(data);

            console.log(jso);

                        
            if($k==1){
              $('.output_testcase_'+$qn).html('<div class="output_testcase_'+$qn+'_t1"></div><div class="output_testcase_'+$qn+'_t2"></div><div class="output_testcase_'+$qn+'_t3"></div><div class="output_testcase_'+$qn+'_t4"></div><div class="output_testcase_'+$qn+'_t5"></div>');
            }
            if(dat.response){
              data = dat.response;
            }
            data.time = parseFloat(data.time).toFixed(2);
            if(data){
              if(data.stderr && $t==1 ){
                console.log("At error place - " + $qn);
                $('.output_'+$qn).html(data.stderr);

                $('.input_'+$qn).attr('value',data.stdout);
                $('.out_'+$qn).attr('value',jso);

                $('.out_'+$qn+'_'+$t).attr('value',jso);

                

                if(dat.pass == "1")
                    $test1 = '<b>Testcase '+$t+':</b> <i class="fa fa-check-circle text-success"></i> Pass ('+data.time+' ms)</p>';
                else
                    $test1 = '<p class="mb-2"><b>Testcase '+$t+':</b> <i class="fa fa-times-circle text-danger"></i> Fail ('+data.time+' ms)</p>';

                if($k==1)
                  $test1 = $test1+'<p class="text-primary">Note that you are required to <b>submit the code</b> for each question to validate all testcases for fullmarks</p>';
                $('.output_testcase_'+$qn+'_t'+$t).html($test1);
               

              }else if(data.stderr && $t!=1){

                if(dat.pass == "1")
                    $test1 = '<b>Testcase '+$t+':</b> <i class="fa fa-check-circle text-success"></i> Pass ('+data.time+' ms)</p>';
                else
                    $test1 = '<p class="mb-2"><b>Testcase '+$t+':</b> <i class="fa fa-times-circle text-danger"></i> Fail ('+data.time+' ms)</p>';


                $('.output_testcase_'+$qn+'_t'+$t).html($test1);
                $('.out_'+$qn+'_'+$t).attr('value',jso);

              }else if(data.stdout){


                
                if($t==1){
                  $('.output_'+$qn).html(data.stdout);
                  $('.out_'+$qn).attr('value',jso);
                  $('.input_'+$qn).attr('value',data.stdout);
                }
                
                
                $('.out_'+$qn+'_'+$t).attr('value',jso);
                console.log('.out_'+$qn+'_'+$t);

                 if(dat.pass == "1")
                    $test1 = '<p class="mb-2"><b>Testcase '+$t+':</b> <i class="fa fa-check-circle text-success"></i> Pass ('+data.time+' ms)</p>';
                else
                    $test1 = '<p class="mb-2"><b>Testcase '+$t+':</b> <i class="fa fa-times-circle text-danger"></i> Fail ('+data.time+' ms)</p>';
                 if($k==1)
                  $test1 = $test1+'<p class="text-primary">Note that you are required to <b>submit the code</b> for each question to validate all testcases for fullmarks</p>';
                
                  console.log("At output place - "+$t);

                $('.output_testcase_'+$qn+'_t'+$t).html($test1);

                if(!$('.s'+$qn).hasClass('qblue-border'))
                    $('.s'+$qn).addClass('qblue-border');
                if(!$('.s'+$qn).hasClass('active'))
                    $('.s'+$qn).removeClass('active');

              }else{
                console.log("No stdout no stderr");
              }
            }else{
                $('.output_'+$qn).html("Invalid Code - ERD102 - Retry. (Testcase-"+$qn+")");
            }
            $('.loading').hide();
            $('.loading_'+$qn).hide();
          },
          error: function(jqXHR, textStatus, errorThrown) {
             $('.runcode_'+$qn).removeClass('disabled');
              if(textStatus==="timeout") {  
                $('.output_'+$qn).html("Timeout - Code execution timelimit crossed. Retry.");
              } else {
                $('.output_'+$qn).html("Invalid Code - ERX104 - Retry. (Testcase-"+$qn+")");
              }
              $('.loading').hide();
          }
        });
}

function ajaxrun2($url,code,$lang,$c,$input,$namec,$testcase,$test,$qslug,$qn){
 $.ajax({
          type : 'get',
          url : $url+'?time='+ new Date().getTime(),
          data:{'code':code,'lang':$lang,'c':$c,'input':$input,'name':$namec,'testcase':$testcase,'test':$test,'qslug':$qslug},
          timeout: 120000, 
          success:function(data){
            $('.runcode_'+$qn).removeClass('disabled');
            console.log($qn);
            //console.log(data);
            var jso = data;
            dat = JSON.parse(data);
            console.log(dat);
            
            data = dat.response_1;
            if(data){
              if(data.stderr){
                console.log("At error place - " + $qn);
                $('.output_'+$qn).html(data.stderr);
                $('.output_testcase_'+$qn).html('');

                $('.input_'+$qn).attr('value',data.stdout);
                $('.out_'+$qn).attr('value',jso);

                if(dat.pass_1 == "1")
                    $test1 = '<h4 class="mb-4 text-secondary">Code Validation:</h4><p class="mb-2"><b>Testcase 1:</b> <i class="fa fa-check-circle text-success"></i> pass</p>';
                  else
                    $test1 = '<p class="mb-2"><b>Testcase 1:</b> <i class="fa fa-times-circle text-danger"></i> fail</p>';

                 if($testcase==3){
                  if(!$('.s'+$qn).hasClass('qblue-border'))
                    $('.s'+$qn).addClass('qblue-border');
                  if(!$('.s'+$qn).hasClass('active'))
                        $('.s'+$qn).removeClass('active');

                  

                  if(dat.pass_2 == "1")
                    $test2 = '<p class="mb-2"><b>Testcase 2:</b> <i class="fa fa-check-circle text-success"></i> pass</p>';
                  else
                    $test2 = '<p class="mb-2"><b>Testcase 2:</b> <i class="fa fa-times-circle text-danger"></i> fail</p>';

                  if(dat.pass_3 == "1")
                    $test3 = '<p class="mb-2"><b>Testcase 3:</b> <i class="fa fa-check-circle text-success"></i> pass</p>';
                  else
                    $test3 = '<p class="mb-2"><b>Testcase 3:</b> <i class="fa fa-times-circle text-danger"></i> fail</p>';

                  if(dat.pass_4 == "1")
                    $test4 = '<p class="mb-2"><b>Testcase 4:</b> <i class="fa fa-check-circle text-success"></i> pass</p>';
                  else
                    $test4 = '<p class="mb-2"><b>Testcase 4:</b> <i class="fa fa-times-circle text-danger"></i> fail</p>';

                  if(dat.pass_5 == "1")
                    $test5 = '<p class="mb-0"><b>Testcase 5:</b> <i class="fa fa-check-circle text-success"></i> pass</p>';
                  else
                    $test5 = '<p class="mb-0"><b>Testcase 5:</b> <i class="fa fa-times-circle text-danger"></i> fail</p>';

                  $('.output_testcase_'+$qn).html('<div class="p-3 rounded border">'+$test1+$test2+$test3+$test4+$test5+'</div>');
                  $('.final_response_'+$qn).html(data.stdout);
                }else{
                   $('.output_testcase_'+$qn).html('<div class="output_testcase_'+$qn+'_t1"></div><div class="output_testcase_'+$qn+'_t2"></div><div class="output_testcase_'+$qn+'_t3"></div><div class="output_testcase_'+$qn+'_t4"></div><div class="output_testcase_'+$qn+'_t5"></div>');
                }

              }else if(data.stdout){
                console.log("At output place");
                $('.output_'+$qn).html(data.stdout);
                $('.input_'+$qn).attr('value',data.stdout);
                $('.out_'+$qn).attr('value',jso);

                if(dat.pass_1 == "1")
                    $test1 = '<div class="output_testcase_'+$qn+'_t1"><h4 class="mb-4 text-secondary">Code Validation:</h4><p class="mb-2"><b>Testcase 1:</b> <i class="fa fa-check-circle text-success"></i> pass</p></div>';
                  else
                    $test1 = '<div class="output_testcase_'+$qn+'_t1"><p class="mb-2"><b>Testcase 1:</b> <i class="fa fa-times-circle text-danger"></i> fail</p></div>';

                if($testcase==3){
                  if(!$('.s'+$qn).hasClass('qblue-border'))
                    $('.s'+$qn).addClass('qblue-border');
                  if(!$('.s'+$qn).hasClass('active'))
                        $('.s'+$qn).removeClass('active');

                  

                  if(dat.pass_2 == "1")
                    $test2 = '<div class="output_testcase_'+$qn+'_t2"><p class="mb-2"><b>Testcase 2:</b> <i class="fa fa-check-circle text-success"></i> pass</p></div>';
                  else
                    $test2 = '<div class="output_testcase_'+$qn+'_t2"><p class="mb-2"><b>Testcase 2:</b> <i class="fa fa-times-circle text-danger"></i> fail</p></div>';

                  if(dat.pass_3 == "1")
                    $test3 = '<div class="output_testcase_'+$qn+'_t3"><p class="mb-2"><b>Testcase 3:</b> <i class="fa fa-check-circle text-success"></i> pass</p></div>';
                  else
                    $test3 = '<div class="output_testcase_'+$qn+'_t3"><p class="mb-2"><b>Testcase 3:</b> <i class="fa fa-times-circle text-danger"></i> fail</p></div>';
                  if(dat.pass_4 == "1")
                    $test4 = '<div class="output_testcase_'+$qn+'_t4"><p class="mb-2"><b>Testcase 4:</b> <i class="fa fa-check-circle text-success"></i> pass</p></div>';
                  else
                    $test4 = '<div class="output_testcase_'+$qn+'_t4"><p class="mb-2"><b>Testcase 4:</b> <i class="fa fa-times-circle text-danger"></i> fail</p></div>';

                  if(dat.pass_5 == "1")
                    $test5 = '<div class="output_testcase_'+$qn+'_t5"><p class="mb-0"><b>Testcase 5:</b> <i class="fa fa-check-circle text-success"></i> pass</p></div>';
                  else
                    $test5 = '<div class="output_testcase_'+$qn+'_t5"><p class="mb-0"><b>Testcase 5:</b> <i class="fa fa-times-circle text-danger"></i> fail</p></div>';

                  $('.output_testcase_'+$qn).html('<div class="p-3 rounded border">'+$test1+$test2+$test3+$test4+$test5+'</div>');

                  $('.final_response_'+$qn).html(data.stdout);
                }else{
                   $('.output_testcase_'+$qn).html('');
                }
                
              }else{
                console.log("No stdout no stderr");
                $('.output_'+$qn).html("Invalid Code - ERO101 - Retry.");
              }
            }else{
                $('.output_'+$qn).html("Invalid Code - ERD102 - Retry.");
            }
            $('.loading').hide();
            $('.loading_'+$qn).hide();
          },
          error: function(jqXHR, textStatus, errorThrown) {
             $('.runcode_'+$qno).removeClass('disabled');
              if(textStatus==="timeout") {  
                $('.output_'+$qn).html("Invalid Code - ERT103 - Retry.");
              } else {
                $('.output_'+$qn).html("Invalid Code - ERX104 - Retry.");
              }
              $('.loading').hide();
          }
        });
            
}
 $('body').on('click','.runcode',function(){
      $qn = $qno = $(this).data('qno');
      $lang = $(this).data('lang');
      console.log($lang);
      $name = $(this).data('name');
      $test = $(this).data('test');
      $qslug = $(this).data('qslug');
      $testcase = parseInt($(this).data('testcase'));
      $namec = $(this).data('namec')+Math.random().toString(36).substring(3);
      $c = ($(this).data('c'))?$(this).data('c'):null;
      $input = $(this).data('input');
      $url= $(this).data('url');
      $stop= $(this).data('stop');


      var editor_ = editor_array[$name];

      var code = editor_.getValue();
      $('.code_'+$qno).val(code);
      $('.codefragment_'+$qno).val(code);
      if(!$('.s'+$qno).hasClass('qblue-border'))
      $('.s'+$qno).addClass('qblue-border');
      
      $('.loading_'+$qno).show();
      // setTimeout(function(){
      //   $.get($stop,{'name':$namec}, function(data, status){
      //   console.log(data);
      //   console.log('Code execution stopped');
      //   });
      // }, 5000);



      if(!$('.runcode_'+$qno).hasClass('disabled')){
        $(this).addClass('disabled');

        $lang = $lang.trim();
       console.log('sent-'+$lang);
        if($lang=='c'|| $lang=='cpp'|| $lang=='clang' || $lang=='csharp' || $lang=='java' || $lang=='python' || $lang=='javascript')
        {
          if($lang=='c' || $lang=='cpp')
            $lang ='clang';
          console.log('sent - '+$lang);
          $url= 'https://cmplr.in/run';
          if($testcase==3){

            for(i=1;i<=5;i++){
              ajaxrun($url,code,$lang,$c,$input,$namec,i,$test,$qslug,$qn,i,0);
            }
          }else{
            ajaxrun($url,code,$lang,$c,$input,$namec,$testcase,$test,$qslug,$qn,1,1);
          }
        }else{
          ajaxrun2($url,code,$lang,$c,$input,$namec,$testcase,$test,$qslug,$qn);
        }
        
        
      }

    }); 

  function editorValue( ed){
      return ed.getValue(); 
  }

  $('.loading').hide();
  $('.codeerror').hide();

  $('select').on('change', function() {
    $qno = $(this).data('qno');
    if(this.value=='c'){
      $('.runcode_'+$qno).data('lang','clang');
      $('.runcode_'+$qno).data('c',1);

    }else if(this.value=='cpp'){
      $('.runcode_'+$qno).data('lang','clang');
       $('.runcode_'+$qno).data('c',0);
    }else{
      $('.runcode_'+$qno).data('lang',this.value);
    }
  });

  


  // $('.btn-run').on('click',function(){
  //     $token = $(this).data('token');
  //     $url= $(this).data('url');
  //     var code = editor.getValue();
  //     var random = Math.random().toString(36).substring(7);
  //     $('.loading').show();
  //     $('.codeerror').hide();
      
  //       $.ajax({
  //         type : 'post',
  //         url : $url,
  //         data:{'testcase':'1','code':code,'_token':$token,'name':random+'_1'},
  //         success:function(data){
  //           console.log(data);
  //           if($('.output').length){
  //             $('.output').append('<p>'+data+'</p>');
  //           }

  //           data = JSON.parse(data);
            
  //           if(data.stderr){
  //             $('.codeerror').show();
  //             $('.codeerror').html("<pre><code class='text-light' >"+data.stderr+"</code></pre>");
  //             $('.in1').html('-');
  //             $('.in1-message').html('<span class="badge badge-danger">failure</span>');
  //           }else{
  //             if(data.success==1){
  //               $('.in1').html(data.stdout);
  //               $('.in1-message').html('<span class="badge badge-success">success</span>');
  //             }else{
  //               $('.in1').html(data.stdout);
  //               $('.in1-message').html('<span class="badge badge-danger">failure</span>');
  //             }
              
  //           }


            
  //         }
  //       });
  //       $.ajax({
  //         type : 'post',
  //          url : $url,
  //         data:{'testcase':'2','code':code,'_token':$token,'name':random+'_2'},
  //         success:function(data){
  //           console.log(data);

  //           if($('.output').length){
  //             $('.output').append('<p>'+data+'</p>');
  //           }
  //           data = JSON.parse(data);
  //           if(data.stderr){
  //             $('.in2').html('-');
  //             $('.in2-message').html('<span class="badge badge-danger">failure</span>');
  //           }else{
  //             if(data.success==1){
  //               $('.in2-message').html('<span class="badge badge-success">success</span>');
  //             }else{
  //               $('.in2-message').html('<span class="badge badge-danger">failure</span>');
  //             }
  //           }
  //         }
  //       });
  //       $.ajax({
  //         type : 'post',
  //          url : $url,
  //         data:{'testcase':3,'code':code,'_token':$token,'name':random+'_3'},
  //         success:function(data){
  //           console.log(data);
  //           if($('.output').length){
  //             $('.output').append('<p>'+data+'</p>');
  //           }
  //           data = JSON.parse(data);
  //           if(data.stderr){
  //             $('.in3').html('-');
  //             $('.in3-message').html('<span class="badge badge-danger">failure</span>');
  //             $('.loading').hide();
  //           }else{
  //             if(data.success==1){
  //               $('.in3-message').html('<span class="badge badge-success">success</span>');
  //             }else{
  //               $('.in3-message').html('<span class="badge badge-danger">failure</span>');
  //             }
  //             $('.loading').hide();
  //           }
  //         }
  //       });
      

  //   });  
});
</script>
@endif

@if(isset($chart))
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
<script>
if(document.getElementById("myChart")){


var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: ["Correct",  "Incorrect", "Unattempted"],
        datasets: [{
            label: ["Responses"],
            data: [{{ $details['correct']}}, {{ $details['incorrect']}}, {{ $details['unattempted']}}],
            backgroundColor: [
                'rgba(54, 167, 89, 0.7)',
                'rgba(243, 40, 60, 0.7)',
                'rgba(255, 206, 86, 0.2)'
            ],
            borderColor: [

                'rgba(54, 167, 89, 1)',
                'rgba(243, 40, 60, 1)',
                'rgba(255, 206, 86, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true,
                    steps: 10,
                    stepValue: 5,
                    max: {{ ($details['correct'] +$details['incorrect'] + $details['unattempted']) }}
                }
            }]
        }
    }
});
}
</script>

<script type="text/javascript">
  var optionsOne = {
  type: 'horizontalBar',
  data: {
    labels: ["Correct", "Incorrect", "Unattempted"],
    datasets: [{
      label: 'Colors One',
      data: [7, 11, 8],
      backgroundColor: [
                'rgba(75, 192, 192, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 206, 86, 0.2)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(255,99,132,1)',
                'rgba(255, 206, 86, 1)'
            ],
      borderWidth: 1
    }]
  },
  options: {
        title: {
            display: true,
            text: 'Chart.js Bar Chart - Stacked'
          },
        scales: {
            xAxes: [{
                ticks: {
                    beginAtZero:true,
                    steps: 10,
                    stepValue: 5,
                    max: 100
                }
            }]
        }
    }
}

if(document.getElementById('chartOneContainer')){
var ctxOne = document.getElementById('chartOneContainer').getContext('2d');
new Chart(ctxOne, optionsOne);
}
</script>




@if(isset($sections))


@if(isset($sectiondetails))
@if($sectiondetails)
<script type="text/javascript">
  var options_sections_container = {
  type: 'horizontalBar',
  data: {
    labels: [ @foreach($sectiondetails as $k=> $sd) "{{$sd['name']}} @if(isset($sd['score']))({{$sd['score']}}/{{$sd['max']}}) @endif", @endforeach],
    datasets: [{
      label:'',
      data: [@foreach($sectiondetails as $k=>$sd) "{{$sd['percent']}}", @endforeach],
      backgroundColor: [
              @foreach($sectiondetails as $k=> $sd) 
                @if($sd['percent']<30)
                  'rgba(255, 99, 132, 0.8)',
                @elseif($sd['percent']>=30 && $sd['percent']<=70)
                    'rgba(255, 159, 67,0.7)',
                @else
                'rgba(10, 189, 227,0.7)',
                @endif
              @endforeach
                
            ],
            borderColor: [
                @foreach($sectiondetails as $k=> $sd) 
                @if($sd['percent']<30)
                  'rgba(255, 99, 132, 1)',
                @elseif($sd['percent']>=30 && $sd['percent']<=70)
                    'rgba(255, 159, 67,1.0)',
                @else
                'rgba(10, 189, 227,1.0)',
                @endif
              @endforeach
            ],
      borderWidth: 1
    }]
  },
  options: {
    legend: {
        display: false
    },
        title: {
            display: true,
            text: 'Sectional Report '
          },
        scales: {
            xAxes: [{
                ticks: {
                    beginAtZero:true,
                    steps: 10,
                    stepValue: 5,
                    max: 100
                }
            }]
        }
    }
}

if(document.getElementById('SectionContainer')){
var ctx_section_container = document.getElementById('SectionContainer').getContext('2d');
new Chart(ctx_section_container,options_sections_container);
}

</script>
@endif
@endif

@foreach($sections as $sec => $section)
@if(isset($section->section_id))
<script type="text/javascript">
  var options_{{$section->section_id}} = {
  type: 'horizontalBar',
  data: {
    labels: ["Correct ({{$section->correct}})", "Incorrect ({{$section->incorrect}})", "Unattempted ({{$section->unattempted}})"],
    datasets: [{
      label:'',
      data: [{{$section->correct}}, {{$section->incorrect}}, {{$section->unattempted}}],
      backgroundColor: [
                'rgba(75, 192, 192, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                'rgba(255, 206, 86, 0.2)'
            ],
            borderColor: [
                'rgba(75, 192, 192, 1)',
                'rgba(255,99,132,1)',
                'rgba(255, 206, 86, 1)'
            ],
      borderWidth: 1
    }]
  },
  options: {
    legend: {
        display: false
    },
        title: {
            display: true,
            text: '{{ $sec }} '
          },
        scales: {
            xAxes: [{
                ticks: {
                    beginAtZero:true,
                    steps: 10,
                    stepValue: 5,
                    max: {{ ($section->correct +$section->incorrect +$section->unattempted) }}
                }
            }]
        }
    }
}

if(document.getElementById({{$section->section_id}}+'Container')){
var ctx_{{$section->section_id}} = document.getElementById({{$section->section_id}}+'Container').getContext('2d');
new Chart(ctx_{{$section->section_id}},options_{{$section->section_id}});
}

</script>
@endif
@endforeach

@endif
@endif



@if(isset($secs))

@foreach($secs as $sec => $section)
@if(isset($section->section_id))
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
<script type="text/javascript">
  var options_{{$section->section_id}} = {
  type: 'horizontalBar',
  data: {
    labels: ["{{$section->labels[0]}}", "{{$section->labels[1]}}", "{{$section->labels[2]}}","{{$section->labels[3]}}" @if(isset($section->five)),"{{$section->labels[4]}}" @endif],
    datasets: [{
      label:'',
      data: [{{$section->one}}, {{$section->two}}, {{$section->three}},{{$section->four}}  @if(isset($section->five)), {{$section->five}}@endif],
      backgroundColor: [
                '{{$section->one_color}}',
                '{{$section->two_color}}',
                '{{$section->three_color}}',
                '{{$section->four_color}}',
                 @if(isset($section->five))'{{$section->five_color}}' @endif
            ]
    }]
  },
  options: {
    legend: {
        display: false
    },
        scales: {
            xAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
}

var ctx_{{$section->section_id}} = document.getElementById({{$section->section_id}}+'Container').getContext('2d');
new Chart(ctx_{{$section->section_id}},options_{{$section->section_id}});

</script>
@endif
@endforeach
@endif

@if(isset($test_analysis))

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.js"></script>
<script>
var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
    type: 'doughnut',
    data: {
        labels: ["Excellent ({{ $details['excellent']}})",  "Good ({{ $details['good']}})", "Need to Improve ({{ $details['need_to_improve']}})"],
        datasets: [{
            label: 'Students',
            data: [{{ $details['excellent']}}, {{ $details['good']}}, {{ $details['need_to_improve']}}],
            backgroundColor: [
                'rgba(255, 206, 86, 0.2)',
                'rgba(81, 154, 218, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                
            ],
            borderColor: [
                'rgba(255, 206, 86, 1)',
                'rgba(81, 154, 218, 1)',
                'rgba(255,99,132,1)',
                
            ],
            borderWidth: 1
        }]
    },
    options: {


      
        
    }
});
</script>

<script type="text/javascript">
  var optionsOne = {
  type: 'doughnut',
  data: {
    labels: ["Excellent ", "Good", "Need to Improve "],
    datasets: [{
      label: 'Colors One',
      data: [7, 11, 8],
      backgroundColor: [
              'rgba(255, 206, 86, 0.2)',
                'rgba(81, 154, 218, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                
            ],
            borderColor: [
            'rgba(255, 206, 86, 1)',
                'rgba(81, 154, 218, 1)',
                'rgba(255,99,132,1)',
                
            ],
      borderWidth: 1
    }]
  },
  options: {
    }
}

var ctxOne = document.getElementById('chartOneContainer').getContext('2d');
new Chart(ctxOne, optionsOne);

</script>
@if(isset($sections))
@foreach($sections as $sec => $section)
<script type="text/javascript">
  var options_{{$section->id}} = {
  type: 'horizontalBar',
  data: {
    labels: ["Excellent ({{$details['section'][$section->id]['excellent']}})", "Good ({{$details['section'][$section->id]['good']}})", "Need to Improve ({{$details['section'][$section->id]['need_to_improve']}})"],
    datasets: [{
      label:'',
      data: [{{$details['section'][$section->id]['excellent']}}, {{$details['section'][$section->id]['good']}}, {{$details['section'][$section->id]['need_to_improve']}}],
      backgroundColor: [
                'rgba(255, 206, 86, 0.2)',
                'rgba(81, 154, 218, 0.2)',
                'rgba(255, 99, 132, 0.2)',
                
            ],
            borderColor: [
                'rgba(255, 206, 86, 1)',
                'rgba(81, 154, 218, 1)',
                'rgba(255,99,132,1)',
                
            ],
      borderWidth: 1
    }]
  },
  options: {
    legend: {
        display: false
    },
        title: {
            display: true,
            text: '{{ $details["section"][$section->id]["name"] }} '
          },
        scales: {
            xAxes: [{
                ticks: {
                    beginAtZero:true,
                    steps: 10,
                    stepValue: 5,
                    max: {{ ($details['section'][$section->id]['excellent'] +$details['section'][$section->id]['good'] +$details['section'][$section->id]['need_to_improve']) }}
                }
            }]
        }
    }
}

var ctx_{{$section->id}} = document.getElementById({{$section->id}}+'Container').getContext('2d');
new Chart(ctx_{{$section->id}},options_{{$section->id}});

</script>
@endforeach
@endif
@endif
@if(isset($question['dynamic']))

<script>
$(document).ready(function() {

      var v = new Object();
      var items = ['question','a','b','c','d','e','answer','explanation','passage'];
      v.number = parseInt({{(request()->get('number'))?request()->get('number'):'1'}});

      @if(isset($question['number']))
        v.number = {{ $question['number'] }};
      @endif

      //console.log('number :'+v.number);
      {!! $question['dynamic'] !!}

      items.forEach(function(element) {
        var $item = '.'+element;
        var content = $($item).html();
        for (var name in v) {
          $key = '@'+name;
          if(content){
            var re = new RegExp($key,"g");
            content = content.replace(re, v[name]);
          }
          
          //$($item).html(newstr);
        }

        // if(content){
        //   if(element =='passage')
        //   $( $item ).replaceWith( '<div class="pt-1 '+element+'" style="display:none">'+content+'</div>' );
        //   else
        //   $( $item ).replaceWith( '<div class="pt-2 '+element+'">'+content+'</div>' );
        // }

      });
      
  });
 </script>
@endif
@if(isset($jqueryui))

 <script type="text/javascript"
         src="{{asset('jquery-ui/jquery-ui.min.js')}}">
  </script>
<script src="{{ asset('js/datetime/jquery-ui-timepicker-addon.min.js')}}"></script>
<script src="{{ asset('js/datetime/jquery-ui-sliderAccess.js')}}"></script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker({dateFormat: 'yy-mm-dd'});
    $('#datetimepicker').datetimepicker({
      dateFormat:'yy-mm-dd',
      timeFormat: 'HH:mm:ss',
    });
    $('#datetimepicker2').datetimepicker({
      dateFormat:'yy-mm-dd',
      timeFormat: 'HH:mm:ss',
    });
  } );
  </script>
@endif
@if(isset($timer))

<script>
// Set the date we're counting down to
@if(!isset($time))
var countDownDate = addMinutes(new Date(),{{ count($questions) }});
@else
var countDownDate = addMinutes(new Date(),{{ ($time) }});
@endif

// Update the count down every 1 second
var x = setInterval(function() {

  // Get todays date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Display the result in the element with id="demo"
 
  document.getElementById("timer").innerHTML =  hours + "h "
  + minutes + "m " + seconds + "s ";

  
  document.getElementById("timer2").innerHTML =  hours + "h "
  + minutes + "m " + seconds + "s ";

  

  // If the count down is finished, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("timer").innerHTML = "EXPIRED";
    document.getElementById("timer2").innerHTML = "EXPIRED";

    @if(isset($tag)||isset($exam))
    alert('The Test time has expired. ');
    var qno = $('.qno').data('qqno');
      var time = $('.qset').data('counter');
      var user = $('.qset').data('user');
      var url = $('.qset').data('url');
      var opt = $('input[name=response]:checked').val();
      $('.qset').data('counter',0);

        $.get( url + "/" + qno + "/save",{'question_id':qno,'response':opt,'time':time,'user_id':user}, function( data ) {
          console.log('saved');

        });
      
      @if(isset($tag)) 
      window.location.href = "{{ route('onlinetest.submit',$tag->value) }}";
      @else
      window.location.href = "{{ route('assessment.submit',$exam->slug) }}";
      @endif
    @endif
  }
}, 1000);

function addMinutes(date, minutes) {
    return new Date(date.getTime() + minutes*60000);
}



</script>
@endif


<script type="text/javascript">
        $(function() {
            <!--  $("#keyPad").draggable({ -->
            <!--    start: function() { -->
            <!--   $(this).css({ height: "auto", width: "463px" }); -->
            <!--  }, -->
            <!-- stop: function() { -->
            <!--  $(this).css({ height: "auto", width: "463px" }); -->
            <!--  } -->
            <!--   }); -->

            $(".calc_min").on('click', function() {
                $('#mainContentArea').toggle();
                <!-- $('#keyPad_Help').hide(); -->
                <!--  $('#keyPad_Helpback').hide();  -->
                $(".help_back").hide();
                $('#keyPad').addClass("reduceWidth");
                $('#helptopDiv span').addClass("reduceHeader");
                //    $('#calc_min').toggleClass("reduceHeader");
                $(this).removeClass("calc_min").addClass('calc_max');
            });
            $(".calc_max").on('click', function() {
                $(this).removeClass("calc_max").addClass('calc_min');
                $('#mainContentArea').toggle();
                if ($("#helpContent").css('display') == 'none') {
                    $('#keyPad_Help').show();
                } else {
                    $('#keyPad_Helpback').show();
                }
                <!-- $('#keyPad_Help').show(); -->
                $('#keyPad').removeClass("reduceWidth");
                $('#helptopDiv span').removeClass("reduceHeader");
            });
        });
        $('#closeButton').click(function() {
            $('#loadCalc').hide();
        });
        /** new help changes **/
        

       

        /** new help changes **/
    </script>


@if(isset($terms))
<script type="text/javascript">
$(function(){

 var appr = 0;
 $('#terms').change(function() {
      if($(this).prop("checked")){
        $('.btn-accept').removeClass('disabled');
      }else{
        $('.btn-accept').addClass('disabled');
      }
  });

 $(document).on('click','.btn-ins-next',function(){
    $next = parseInt($(this).data('next'));
    if($next!=7){
       $('.ins_block').hide();
      $('.ins_block_'+$next).show();
    }else{

      if(!$('.ins_block_7').length){
        $link = $('.test_link').attr('href');
        window.location.replace($link);
      }else{

        
        appr = setInterval(approval, 500);
        $('.ins_block').hide();
        $('.ins_block_'+$next).show();
      }
    }
    
 });

 function starttest(){
    $link = $('.test_link').attr('href');
    console.log($link);
    window.location.href = $link;
 }

 function loadimages(){
    $username = $('#video').data('username');
    $test = $('#video').data('test');
    $name = $username+'_'+$test+'_selfie';

    $bucket = $('#photo').data('bucket');
    $region = $('#photo').data('region');
    $aws_url = 'https://'+$bucket+'.s3.'+$region+'.amazonaws.com/webcam/'+$test+'/';
    $selfie_url = $aws_url+$name+'.jpg';

    $('.selfie_img').attr('src',$selfie_url+'?time='+ new Date());
    //$('.selfie_container').html('<img src="'+$selfie_url+'?time='+ new Date()+'" class="w-100"/>');

    $c = $('#photo').data('aws_c');
    $name = $username+'_'+$test+'_idcard';
    $idcard_url = $aws_url+$name+'.jpg';
    $('.idcard_img').attr('src',$idcard_url+'?time='+ new Date());
    //$('.idcard_container').html('<img src="'+$idcard_url+'?time='+ new Date()+'" class="w-100"/>');
 }

 function approval(){
   if($('#photo').length){
    loadimages();
      $username = $('#photo').data('username');
      $bucket = $('#photo').data('bucket');
      $region = $('#photo').data('region');
      $test= $('#photo').data('test');
      $aws_url = 'https://'+$bucket+'.s3.'+$region+'.amazonaws.com/testlog/approvals/'+$test+'/';
      $url = $aws_url+$username+'.json?new='+new Date();



      $.ajax({
                type: "GET",
                url: $url
            }).done(function (result) {
              console.log(result);
              if(result.status==3)
                $('.message').html('<div class="alert alert-important alert-warning">'+result.message+'</div>');
              else if(result.status==2)
                $('.message').html('<div class="alert alert-important alert-danger"> Your request is rejected by the proctor. You are not allowed to attempt test.</div>');
              else if(result.status==1){
                  $('.message').html('<div class="alert alert-important alert-success"> Your request is accepted by the proctor. Your test will  be begin in 5 secs.</div>');
                  stopAppr();

                  //
              }
                
                
                //window.location.href = backendUrl;
            }).fail(function () {
                console.log("Sorry URL is not access able");
        });
   }
    
 }

 function stopAppr() {
  clearInterval(appr);
  console.log('stopped approval');
  var $startup = $('.testpage').data('startup');
  if(!$startup){
      $('.testpage').data('startup',1);
      setTimeout(starttest,5000);
  }
  
  console.log('test starts in 5 sec');
}


 

});
</script>

@endif

@if(isset($timer2))

<script src="{{ asset('js/screenfull.min.js')}}"></script>
@if(!$test_section)
<script src="{{ asset('js/test.js')}}?new=15"></script>
@else
<script src="{{ asset('js/test_section.js')}}?new=15"></script>
@endif
<script type="text/javascript">
$(function(){


  $(document).on('click','.qno-sub',function(){
    $qcount = $('.qset').data('lastsno');
    $notattempt = 0;
    for($i=1;$i<=$qcount;$i++){
      if(!$('.s'+$i).hasClass('qblue-border')){
        $notattempt++;
        $('.notattempt_color_'+$i).addClass('notattempted');
        $('.notattempt_message_'+$i).html('Not Attempted');
      }else{
        $('.notattempt_message_'+$i).html('Attempted');
        $('.notattempt_color_'+$i).removeClass('notattempted');
        $('.notattempt_color_'+$i).addClass('nattempted');

      }
    }
    $('.notattempt_count').html($notattempt);
    $('.attempt_count').html(($qcount-$notattempt));

  });
  
});

// $(document).on("keypress", 'form', function (e) {
//     var code = e.keyCode || e.which;
//     if (code == 13) {
//       console.log("Enter Pressed");
//         //e.preventDefault();
//         //return false;
//     }
// });


if($('.timestamp').length)
  setInterval(timestramp,1000);


function timestramp(){
  var d = new Date();
  $('.timestamp').html(d);
}
  



</script>

<script>
   // upload user responses
$(function(){
  $(document).on('click','.btn-urq',function(e){
    if($(this).prop('disabled',false)){
      $name = $(this).data('name');
      $iname = $(this).data('iname');
      console.log($iname);
      
      $user_id = $(this).data('user_id');
      $c = parseInt($(this).data('c'));
      console.log('cis-'+$c);

      if($c==6){
        $('.img_status_'+$name).html('<span class="text-danger h3"><i class="fa fa-times-circle"></i> You can upload maximum 5 images per question only.</span>');
        return 1;
      }
      $qid = $(this).data('qid');
      $url = $('.url_urq_'+$qid+'_'+$c).data('url');

      
      
      $token = $(this).data('token');

      i = $qid+'_'+Math.floor(Math.random() * 1000);
      e.preventDefault();

       var fd = new FormData();
       var files = $('.input_urq_'+$name)[0].files[0];

       var ext = $('.input_urq_'+$name).val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['jfif','png','jpg','jpeg']) == -1) {
            $('.img_status_'+$name).html('<span class="text-danger h3"><i class="fa fa-times-circle"></i> Only images with extension jpg,jpeg,png are supported. File uploaded is '+ext+'.</span>');
                return 1;
        }

       if (files.size > 20971520) { 
                $size = Math.round(files.size / Math.pow(1024,2));
                $('.img_status_'+$name).html('<span class="text-danger h3"><i class="fa fa-times-circle"></i> Image size cannot be more than 20MB. File uploaded '+$size+'MB.</span>');
                return 1;
        }

       console.log('.input_urq_'+$name);
       $(this).prop('disabled', true);
        fd.append('file',files);
        fd.append('user_id',$user_id);
        fd.append('qid',$qid);
        fd.append('_token',$token);
        fd.append('i',i);
        // Display the values
        $('.spinner_'+$name).show();

        console.log("url1 "+$url);
        resizeUpload(files,$url,$name,$c,$iname);
        // $.ajax({
        //   type : 'POST',
        //   url : $url,
        //   data:fd,
        //   cache: false,
        //   processData: false,
        //   contentType: false,
        //   beforeSend: function (request) {
        //       return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
        //   },
        //   success:function(response){
        //     if(response != 0){
        //           $(".img_c_"+$name).prepend($('<img class="w-100 py-2 "/>').attr('src',response));
        //           $(".img_container_"+$name).show(); // Display 
        //           $('.spinner_'+$name).hide();
        //           $('.img_status_'+$name).html('<span class="text-success"><i class="fa fa-check-circle"></i> Image upload successfully.</span>');
        //           $('.btn_delete_urq_'+$name).show();
        //           $(".input_urq_"+$name).val(null);

        //           if(!$('.s'+$name).hasClass('qblue-border'))
        //             $('.s'+$name).addClass('qblue-border');
        //           if(!$('.s'+$name).hasClass('active'))
        //                 $('.s'+$name).removeClass('active');


        //         }else{
        //           console.log('error');
        //           $('.img_status').text('Image upload failed. Kindly retry.');
        //         }
        //   },
          
        // });
    }
      

        
      
  });


  function resizeUpload(file,url,qno,i,name){
    console.log(i+ " i");
    const MAX_WIDTH = 1200;
    const MAX_HEIGHT = 2000;
    const MIME_TYPE = "image/jpeg";
    const QUALITY = 0.8;

    const blobURL = URL.createObjectURL(file);
    const img = new Image();
    img.src = blobURL;
    img.onerror = function () {
      URL.revokeObjectURL(this.src);
        // Handle the failure properly
        console.log("Cannot load image");
      };
      img.onload = function () {
        URL.revokeObjectURL(this.src);
        const [newWidth, newHeight] = calculateSize(img, MAX_WIDTH, MAX_HEIGHT);
        const canvas = document.createElement("canvas");
        canvas.width = newWidth;
        canvas.height = newHeight;
        const ctx = canvas.getContext("2d");
        ctx.drawImage(img, 0, 0, newWidth, newHeight);
        
        canvas.toBlob(
          (blob) => {
            // Handle the compressed image. es. upload or save in local state
            awsuploadcompressed(blob,url,qno,i,name);
          },
          MIME_TYPE,
          QUALITY
          );
        //document.getElementById("root").append(canvas);
      };
  }

  function awsuploadcompressed(blob,$url,qno,i,name){
    console.log(i+ " i");
    $name = qno;
    if($url){
        $.ajax({
                method: "PUT",
                headers: {"Content-Type": "image/jpeg"},
                processData: false,
                data: blob,
                url: $url
        })
        .done(function($u) {
          console.log('completed '+qno); 
          $c = parseInt($('.btn_urq_'+qno).data('c'));
          $('.btn_urq_'+qno).data('c',($c+1));
          $('.btn_urq_'+qno).prop('disabled', false);
          $('.spinner_'+qno).hide();

          $random = Math.random().toString(36).substring(7);
          $src = getPathFromUrl($url)+"?"+$random;
          
          console.log($('.btn_urq_'+qno).data('c'));
           $(".img_c_"+$name).prepend($('<img class="w-100 py-2 "/>').attr('src',$src));
                  $(".img_container_"+$name).show(); // Display 
                
                  $('.img_status_'+$name).html('<span class="text-success h4"><i class="fa fa-check-circle"></i> Image upload successfully. You can upload more images or proceed to the next question</span>');
                  $('.img_status2_'+$name).html('<span class="text-primary h5"><i class="fa fa-chevron-circle-down"></i>  Scroll down to see the uploaded images.</span>');
                  $('.btn_delete_urq_'+$name).show();
                  $(".input_urq_"+$name).val(null);

                  if(!$('.s'+$name).hasClass('qblue-border'))
                    $('.s'+$name).addClass('qblue-border');
                  if(!$('.s'+$name).hasClass('active'))
                        $('.s'+$name).removeClass('active');

          $urqurl = $('.url_urq_user').data('url')+'?'+$random;
          $urqurlpost = $('.url_urq_userpost').data('url');
          $qid = $('.btn_urq_'+qno).data('qid');
          $.ajax({
                type: "GET",
                url: $urqurl
            }).done(function (result) {
                Object.entries(result)
                 console.log(result[$qid]);
                if(i in result[$qid]){
                  console.log('there');
                  result[$qid][i] = $src;
                }
                else{
                  console.log('there -'+i);
                  if(i==1){

                   result[$qid] = {'a1':$src};
                  }
                  if(i==2)
                   result[$qid].a2 = $src;
                 if(i==3)
                   result[$qid].a3 = $src;
                 if(i==4)
                   result[$qid].a4 = $src;
                 if(i==5)
                   result[$qid].a5 = $src;
                }
                 var $data = JSON.stringify(result);
                 console.log($data);

                $.ajax({
                        method: "PUT",
                        headers: {"Content-Type": "application/json"},
                        processData: false,
                        data: $data,
                        url: $urqurlpost
                })
                .done(function($url) {
                        console.log('done updating --');
                });
                  
              }).fail(function () {
                  console.log("Sorry URL is not access able");
          });
        });
    }
  }

  function getPathFromUrl(url) {
    return url.split("?")[0];
  }

  function calculateSize(img, maxWidth, maxHeight) {
      let width = img.width;
      let height = img.height;

      // calculate the width and height, constraining the proportions
      if (width > height) {
        if (width > maxWidth) {
          height = Math.round((height * maxWidth) / width);
          width = maxWidth;
        }
      } else {
        if (height > maxHeight) {
          width = Math.round((width * maxHeight) / height);
          height = maxHeight;
        }
      }
      return [width, height];
    }

    function readableBytes(bytes) {
      const i = Math.floor(Math.log(bytes) / Math.log(1024)),
        sizes = ['B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB'];

      return (bytes / Math.pow(1024, i)).toFixed(2) + ' ' + sizes[i];
    }




  $(document).on('click','.btn-delete',function(e){
      $name = $(this).data('name');
      $url = $(this).data('url');
      $user_id = $(this).data('user_id');
      $qid = $(this).data('qid');
      $token = $(this).data('token');
      console.log($url);
      e.preventDefault();

       var fd = new FormData();
       console.log('.input_urq_'+$name);
        fd.append('user_id',$user_id);
        fd.append('qid',$qid);
        fd.append('_token',$token);
        // Display the values
        $('.spinner_'+$name).show();
        $.ajax({
          type : 'POST',
          url : $url,
          data:fd,
          cache: false,
          processData: false,
          contentType: false,
          beforeSend: function (request) {
              return request.setRequestHeader('X-CSRF-Token', $("meta[name='csrf-token']").attr('content'));
          },
          success:function(response){
            console.log(response);
            if(response != 0){
                  $(".img_c_"+$name).html('');
                  $(".img_container_"+$name).show(); // Display 
                  $('.spinner_'+$name).hide();
                  $('.img_status_'+$name).html('<span class="text-danger h4"><i class="fa fa-trash"></i> Images deleted successfully. Now the page will refresh.</span>');
                  $('.btn_delete_urq_'+$name).hide();
                  $('.img_status2_'+$name).hide();
                  $('.s'+$name).removeClass('qblue-border');
                  $(".input_urq_"+$name).val(null);
                  $('.btn_urq_'+$name).data('c',(1));
                  location.reload();

                }else{
                  console.log('error');
                  $('.img_status').text('Image delete failed. Kindly retry.');
                }
          },
          
        });
      
  });

});




</script>

<script>

@if(isset($question))
@if($question->type!='code')

$('body').bind('copy paste',function(e) {
    e.preventDefault(); return false; 
});

  $(document).ready(function () {
    //Disable full page
    $("body").on("contextmenu",function(e){
        return false;
    });
    
    //Disable part of page
    $("#id").on("contextmenu",function(e){
        return false;
    });
});

function copyToClipboard() {

  var aux = document.createElement("input");
  aux.setAttribute("value", "print screen disabled!");      
  document.body.appendChild(aux);
  aux.select();
  document.execCommand("copy");
  // Remove it from the body
  document.body.removeChild(aux);
  alert("Print screen disabled!");
}

$(window).keyup(function(e){
  if(e.keyCode == 44){
    copyToClipboard();
  }
});

// var btn = document.getElementById('submit_button'),
//     clicked = false;

// btn.addEventListener('click', function () {
//   clicked = true;
// });

// window.onbeforeunload = function () {
//   if(!clicked) {
//     return 'If you resubmit this page, progress will be lost.';
//   }
// };


@endif
@endif








</script>

@endif



@if(isset($window_change))
@if($window_change)
<script src="{{ asset('js/jquery.winFocus.js')}}"></script>

<script>
 
</script>
@endif
@endif


@if(!request()->is('/')) 
@if(isset($ads))
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js" type="application/javascript"></script>
@endif

@if($_SERVER['HTTP_HOST'] == 'pcode.test' || $_SERVER['HTTP_HOST'] == 'hire.packetprep.com')
@else
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-43617911-9"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-43617911-9');
</script>
@endif
@endif

@auth


@if(isset($camera))
@if($camera)
<script src="{{ asset('js/html2canvas.min.js')}}?new=09"></script>
<script>
$(function(){

  var width = 600;    // We will scale the photo width to this
  var height = 0;     // This will be computed based on the input stream

  // |streaming| indicates whether or not we're currently streaming
  // video from the camera. Obviously, we start at false.

  var streaming = false;

  // The various HTML elements we need to configure or control. These
  // will be set by the startup() function.

  var video = null;
  var canvas = null;
  var photo = null;

  var video2 = null;
  var canvas2 = null;
  var photo2 = null;
  var canvas3 = null;
  var photo3 = null;

  var startbutton = null;


  function saveTestpic($sno=null,$live=null){
        
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
        responses.old ="olds";
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


          if($('.code_'+$sno).length){
            resp.code = $('.codefragment_'+$qno).val();
            resp.out = $('.out_'+$qno).val();
            resp.out_1 = $('.out_'+$qno+'_1').val();
            resp.out_2 = $('.out_'+$qno+'_2').val();
            resp.out_3 = $('.out_'+$qno+'_3').val();
            resp.out_4 = $('.out_'+$qno+'_4').val();
            resp.out_5 = $('.out_'+$qno+'_5').val();

            if($('.preset_c_'+$qno).length){
              resp.preset_c = $('.preset_c_'+$qno).data('code');
              resp.preset_cpp = $('.preset_cpp_'+$qno).data('code');
              resp.preset_csharp = $('.preset_csharp_'+$qno).data('code');
              resp.preset_java = $('.preset_java_'+$qno).data('code');
              resp.preset_python = $('.preset_python_'+$qno).data('code');
              resp.preset_javascript = $('.preset_javascript_'+$qno).data('code');

            }
            if($('.lang_'+$qno).length)
              resp.lang = $('.lang_'+$qno).find(":selected").text();
           
          }
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
            aws_cache_pic(all_data);
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

    function aws_cache_pic($data){
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




  function dataURItoBlob(dataURI) {
    var binary = atob(dataURI.split(',')[1]);
    var array = [];
    for(var i = 0; i < binary.length; i++) {
        array.push(binary.charCodeAt(i));
    }
      return new Blob([new Uint8Array(array)], {type: 'image/jpeg'});
  }

  function uploadaws($data,$url,$screen=false,$name){

    var blob = dataURItoBlob($data);
    console.log('pictire captured');

    if($url){
        $.ajax({
                method: "PUT",
                headers: {"Content-Type": "image/jpeg"},
                processData: false,
                data: blob,
                url: $url
        })
        .done(function($url) {

           if($screen){
              // update last photo
              $bucket = $('#photo').data('bucket');
              $region = $('#photo').data('region');
              $test = $('#photo').data('test');
              $aws_url = 'https://'+$bucket+'.s3.'+$region+'.amazonaws.com/webcam/'+$test+'/';
                   
              $last_photo_url = $aws_url+$name+'.jpg';
              //console.log($last_photo_url);

              $('#photo').data('last_photo',$last_photo_url);

              saveTestpic();
           }
            
        });
    }
    

  }

  function startup() {
    video = document.getElementById('video');
    video2 = document.getElementById('video2');
    canvas = document.getElementById('canvas');
    canvas2 = document.getElementById('canvas2');
    canvas3 = document.getElementById('canvas3');
    photo = document.getElementById('photo');
    photo2 = document.getElementById('photo2');
    photo3 = document.getElementById('photo3');
    text = document.getElementById('text');
    startbutton = document.getElementById('startbutton');


    console.log('webcam started');


    try {
    navigator.mediaDevices.getUserMedia({video: true, audio: false})
    .then(function(stream) {
      video.srcObject = stream;
      video.play();


      if(video2){
        video2.srcObject = stream;
        video2.play();
      }

    }).catch(e => {
      //$('#camera_test').modal();
               $('.testpage').html('<div class="container"><div class="border border-secondary rounded p-5 m-5">You are not allowed to take the test as the camera is not accessible.</div></div>');
              
          console.log(e);
      });
    }
    catch(err) {
      $('.testpage').hide();
      console.log("An error occurred: " + err);
    }

     if(video2){

      video2.addEventListener('canplay', function(ev){
      if (!streaming) {
        height = video2.videoHeight / (video2.videoWidth/width);
      
        // Firefox currently has a bug where the height can't be read from
        // the video, so we will make assumptions if this happens.
      
        if (isNaN(height)) {
          height = width / (4/3);
        }
      
        video2.setAttribute('width', width);
        video2.setAttribute('height', height);
        canvas2.setAttribute('width', width);
        canvas2.setAttribute('height', height);
        streaming = true;
      }
    }, false);

     }

    video.addEventListener('canplay', function(ev){
      if (!streaming) {
        height = video.videoHeight / (video.videoWidth/width);
      
        // Firefox currently has a bug where the height can't be read from
        // the video, so we will make assumptions if this happens.
      
        if (isNaN(height)) {
          height = width / (4/3);
        }
      
        video.setAttribute('width', width);
        video.setAttribute('height', height);
        canvas.setAttribute('width', width);
        canvas.setAttribute('height', height);

        if($('#canvas3').length){
            canvas3.setAttribute('width', 60);
            canvas3.setAttribute('height', 60);
        }
        streaming = true;
      }
    }, false);

    
    clearphoto();
  }

  // Fill the photo with an indication that none has been
  // captured.

  function clearphoto() {
    var context = canvas.getContext('2d');
    context.fillStyle = "#AAA";
    context.fillRect(0, 0, canvas.width, canvas.height);

    var data = canvas.toDataURL('image/jpeg',0.5);

    if($('#photo').length)
      photo.setAttribute('src', data);
  }

 

  
  // Capture a photo by fetching the current contents of the video
  // and drawing it into a canvas, then converting that to a PNG
  // format data URL. By drawing it on an offscreen canvas and then
  // drawing that to the screen, we can change its size and/or apply
  // other changes before drawing it.

  function takepicture() {

    if($('.start_btn').hasClass('exam_started'))
    html2canvas(document.body, {scale:0.75}).then( function (canv) { 
        $username = $('#video').data('username');
        $test = $('#video').data('test');
        $len = $c.toString().length;
        $cc = $c;
        if($len==1)
          $cc= '00'+$c;
        else if($len==2)
          $cc = '0'+$c;
        $name = $username+'_'+$test+'_'+$cc;

        $m = parseInt($('#video').data('c'));
        $len = $m.toString().length;
        $mm = $m;
        if($len==1)
          $mm= '00'+$m;
        else if($len==2)
          $mm = '0'+$m;
        console.log('html2canvas - '+$mm);
        $url = $('.url2_'+$mm).data('url');
        var data = canv.toDataURL('image/jpeg',0.8);

        //$('#html2canvas').attr('src',data);
        uploadaws(data,$url,true,$name);
      });
    

    if(canvas){
      var context = canvas.getContext('2d');
      var $counter = parseInt($('#video').data('c'));

      if (width && height) {
   
        canvas.width = width;
        canvas.height = height;
        context.drawImage(video, 0, 0, width, height);

      
        var data = canvas.toDataURL('image/jpeg',0.5);

        if($('#photo').length)      
          photo.setAttribute('src', data);

        
        var image = $('#photo').attr('src');

        $token = $('#photo').data('token');

        // var url = $('#video').data('hred');
        // $token = $('#video').data('token');
        $c = parseInt($('#video').data('c'));
        // if(parseInt($('#video').data('c'))!=200000)
        //  $c=0;
        if($('.start_btn').hasClass('exam_started'))
        $c = parseInt($('#video').data('c'))+1;


        console.log($c+' at this point');
        console.log($('#video').data('cc'));


        $username = $('#video').data('username');
        $test = $('#video').data('test');
        $len = $c.toString().length;
        $cc = $c;
        if($len==1)
          $cc= '00'+$c;
        else if($len==2)
          $cc = '0'+$c;


        $name = $username+'_'+$test+'_'+$cc;

        $url = $('#photo').data('presigned');

        
        console.log($name);
        if($c == '200000'){

          $c = 'idcard';
          $name = $username+'_'+$test+'_'+$c;

          uploadaws(image,$url,false,$name);

          // update the approval json
          $url1 = $('.url_approval').data('url');
          $bucket = $('#photo').data('bucket');
          $region = $('#photo').data('region');
          $test = $('#photo').data('test');
          $aws_url = 'https://'+$bucket+'.s3.'+$region+'.amazonaws.com/webcam/'+$test+'/';
          $url_get = 'https://'+$bucket+'.s3.'+$region+'.amazonaws.com/testlog/approvals/'+$test+'/'+$username+'.json?new='+ new Date();
          $last_photo_url = $aws_url+$name+'.jpg';

          $.ajax({
                  type: "GET",
                  url: $url_get
            }).done(function (result) {

              console.log(result);
              result['idcard'] = $last_photo_url;
              var data =JSON.stringify(result);
              $.ajax({
                      method: "PUT",
                      headers: {"Content-Type": "application/json"},
                      processData: false,
                      data: data,
                      url: $url1
              })
              .done(function() {

                 console.log('idcard log uploaded');
                  
              });
                   
            }).fail(function () {
                  console.log("Sorry URL is not access able");
          });

        }else{
          if($('.start_btn').hasClass('exam_started') || !$('#photo').data('last_photo'))
          if($('.url_'+$cc).length){
              console.log('c is'+$c);
              $url = $('.url_'+$cc).data('url');
              $name = $username+'_'+$test+'_'+$cc;
              uploadaws(image,$url,false,$name);

              // update last photo
              $bucket = $('#photo').data('bucket');
              $region = $('#photo').data('region');
              $aws_url = 'https://'+$bucket+'.s3.'+$region+'.amazonaws.com/webcam/'+$test+'/';
                   
              $last_photo_url = $aws_url+$name+'.jpg';

              $('#photo').data('last_photo',$last_photo_url);


          }else{
            //return 1;
          }
         
        }

        if($('#photo3').length){
          var context3 = canvas3.getContext('2d');
          context3.drawImage(video, 0, 0, 60, 60);
          var data3 = canvas3.toDataURL('image/jpeg',0.5);
          $('#photo3').attr('src', data3);
        }      
          //$('#photo3').attr('src', data3);


        $counnt = 2;
        if($c!='idcard')
        if($c % $counnt == 0){
           var url = $('#photo').data('hred');
           
          if($('.start_btn').hasClass('exam_started')){
            
            if(parseInt($('.start_btn').data('face_detect')))
              $.post( url ,{'name': $name ,'username':$username,'count':$counnt,'key':$c,'test':$test,'_token':$token}, function( data ) {
                console.log('Face Detect:' + data);
              });
          }

           
        }
       
        if(Number.isInteger($c)){

          $('#video').data('c',$c);
          $cm = $('#video').data('cc');
          if($cm==0){
            $('#video').data('cc',1);
            $('.cam_spinner').hide();
            if(!$('#d').html())
              $('.start_btn').removeClass('disabled');
            $('.cam_message').html('<span class="text-success"><i class="fa fa-check-circle"></i> Camera enabled </span>');
          }
         
        }else{
          var fullname = $('#photo').data('name');
          var username = $('#photo').data('username');
          var roll = $('#photo').data('roll');
          var branch = $('#photo').data('branch');
          var college = $('#photo').data('college');
        //   $.post( url ,{'name': $name ,'fullname':fullname,'username':username,'roll':roll,'branch':branch,'college':college,'_token':$token}, function( data ) {
        //       console.log(data);
             
        // });
        }
        
      }else{
        $('.testpage').html('<div class="container"><div class="border border-secondary rounded p-5 m-5">You are not allowed to take the test as the camera is not accessible.</div></div>');
        $('.cam_spinner').hide();
        $('.cam_message').html('<span class="text-danger"><i class="fa fa-times-circle"></i> Unable to access the camera...Kindly refresh the page and allow the access to the webcamera.</span>');
      } 

    }else{
        $('.testpage').html('<div class="container"><div class="border border-secondary rounded p-5 m-5">You are not allowed to take the test as the camera is not accessible.</div></div>');
    }
    
  }

  function takepicture2() {

    if(canvas2){
      var context = canvas2.getContext('2d');
      var $counter = parseInt($('#video2').data('c'));

      if (width && height) {
   
        canvas2.width = width;
        canvas2.height = height;
        context.drawImage(video2, 0, 0, width, height);
      
        var data = canvas2.toDataURL('image/jpeg',0.5);

        if($('#photo2').length)      
          photo2.setAttribute('src', data);

        var url = $('#photo2').data('hred');
        var image = $('#photo2').attr('src');
        $token = $('#photo2').data('token');

        // var url = $('#video').data('hred');
        // $token = $('#video').data('token');
        $c = parseInt($('#video2').data('c'))+1;

        if($c == '300001')
          $c = 'selfie';

        $username = $('#video2').data('username');
        $test = $('#video2').data('test');
        $name = $username+'_'+$test+'_'+$c;

        $url = $('#photo2').data('presigned');
         uploadaws(image,$url,false,$name);

        // update the approval json

        $url1 = $('.url_approval').data('url');
        $bucket = $('#photo').data('bucket');
        $region = $('#photo').data('region');
        $test = $('#photo').data('test');
        $aws_url = 'https://'+$bucket+'.s3.'+$region+'.amazonaws.com/webcam/'+$test+'/';
        $url_get = 'https://'+$bucket+'.s3.'+$region+'.amazonaws.com/testlog/approvals/'+$test+'/'+$username+'.json?new='+ new Date();
        $last_photo_url = $aws_url+$name+'.jpg';

        $.ajax({
                type: "GET",
                url: $url_get
          }).done(function (result) {
            console.log(result);
            
            result['selfie'] = $last_photo_url;
            var data =JSON.stringify(result);
            $.ajax({
                    method: "PUT",
                    headers: {"Content-Type": "application/json"},
                    processData: false,
                    data: data,
                    url: $url1
            })
            .done(function() {

               console.log('selfie log uploaded');
                
            });
                 
          }).fail(function () {
                console.log("Sorry URL is not access able");
        });

         





      }else{
        $('.testpage').html('<div class="container"><div class="border border-secondary rounded p-5 m-5">You are not allowed to take the test as the camera is not accessible.</div></div>');
      } 

    }else{
      $('.testpage').html('<div class="container"><div class="border border-secondary rounded p-5 m-5">Unable to read the camera. Kindly refresh the page.</div></div>');
    }
    
  }
  // Set up our event listener to run the startup process
  // once loading is complete.
  window.addEventListener('load', startup, false);
  $time = @if(isset($exam->capture_frequency))@if($exam->capture_frequency){{($exam->capture_frequency*1000)}} @else 300000 @endif @else 300000 @endif;
  if(!$('.id_card_capture').length){
  setTimeout(function(){ takepicture(); }, 3000);
  setInterval(function(){ takepicture(); console.log($time); }, $time);
  }else{
      $(document).on('click','.id_capture',function(e){
          e.preventDefault();
          $(this).html('Retake');
          takepicture();
      });

      $(document).on('click','.selfie_capture',function(e){
          e.preventDefault();
          $(this).html('Retake');
          $('.selfie_next').removeClass('disabled');
          takepicture2();
      });
  }
  
});



</script>
@endif
@endif



@if(isset($cameratest))
@if($cameratest)
<script>
$(function() {


var width = 600;    // We will scale the photo width to this
  var height = 0;     // This will be computed based on the input stream

  // |streaming| indicates whether or not we're currently streaming
  // video from the camera. Obviously, we start at false.

  var streaming = false;

  // The various HTML elements we need to configure or control. These
  // will be set by the startup() function.

  var video = null;
  var canvas = null;
  var photo = null;

  var video2 = null;
  var canvas2 = null;
  var photo2 = null;

  var startbutton = null;



 function detect_mobile(){
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
      // $('.camera_message').html("This test can be attempted from desktop or laptop only. Mobile & Tablets are not allowed. Kindly contact administrator incase of any query.");
      // $('.camera_fail').show();
      // $('.camera_success').hide();
      // $('.accesscode_btn').hide();
      if($('.extra_info').length){
        $('.accesscode_btn').hide();
        $('.camera_success').hide();
        $('.camera_message').html("This test can be attempted from desktop or laptop only. Mobile & Tablets are not allowed. Kindly contact administrator incase of any query.");
      }else{
          camera_test();
      }
    }else{
      camera_test();
    }
  }


   

  // Fill the photo with an indication that none has been
  // captured.

  function clearphoto() {
    var context = canvas.getContext('2d');
    context.fillStyle = "#AAA";
    context.fillRect(0, 0, canvas.width, canvas.height);

    var data = canvas.toDataURL('image/jpeg',0.5);



    if($('#photo').length)
      photo.setAttribute('src', data);
  }

  function takepicture() {

    video = document.getElementById('video');
    canvas = document.getElementById('canvas');
    photo = document.getElementById('photo');

    var context = canvas.getContext('2d');


    var $counter = parseInt($('#video').data('c'));

    console.log(height);

    if (width && height) {

       console.log('all fine');
 
      canvas.width = width;
      canvas.height = height;
      context.drawImage(video, 0, 0, width, height);
    
      var data = canvas.toDataURL('image/jpeg',0.5);

      if($('#photo').length)      
        photo.setAttribute('src', data);

      
      var image = $('#photo').attr('src');
      $token = $('#photo').data('token');

      // var url = $('#video').data('hred');
      // $token = $('#video').data('token');
      $c = parseInt($('#video').data('c'))+1;

      $username = $('#video').data('username');
      $test = $('#video').data('test');
      $name = $username+'_'+$test+'_'+$c;

      $url = $('#photo').data('presigned');

      console.log($c);


      if($c == '200001'){
        $c = 'idcard';
        $name = $username+'_'+$test+'_'+$c;
         uploadaws(image,$url,false,$name);

        return 1;

      }else{
        if($('.url_'+$c).length){
             $url = $('.url_'+$c).data('url');
             $name = $username+'_'+$test+'_'+$c;
              uploadaws(image,$url,false,$name);

            // update last photo
            $bucket = $('#photo').data('bucket');
            $region = $('#photo').data('region');
            $aws_url = 'https://'+$bucket+'.s3.'+$region+'.amazonaws.com/webcam/'+$test+'/';
                 
            $last_photo_url = $aws_url+$name+'.jpg';

            $('#photo').data('last_photo',$last_photo_url);
        }else{

          return 1;
        }
      }

      $counnt = 2;
      if($c % $counnt == 0){
         var url = $('#photo').data('hred');
         if(parseInt($('.start_btn').data('face_detect')))
         $.post( url ,{'name': $name ,'username':$username,'count':$counnt,'key':$c,'test':$test,'_token':$token}, function( data ) {
              console.log('Face Detect:' + data);
        });
      }
     

      console.log($c);
      if(Number.isInteger($c)){

          $('#video').data('c',$c);
        console.log($name);
        console.log($c);
      }else{
        var fullname = $('#photo').data('name');
        var username = $('#photo').data('username');
        var roll = $('#photo').data('roll');
        var branch = $('#photo').data('branch');
        var college = $('#photo').data('college');
      //   $.post( url ,{'name': $name ,'fullname':fullname,'username':username,'roll':roll,'branch':branch,'college':college,'_token':$token}, function( data ) {
      //       console.log(data);
           
      // });
      }
      
    }else{

      $('.testpage').html('<div class="container"><div class="border border-secondary rounded p-5 m-5">You are not allowed to take the test as the camera is not accessible.</div></div>');
      //$('#camera_test').modal();
    } 
  }


function camera_test(){
  var width = 320;    // We will scale the photo width to this
  var height = 0;     // This will be computed based on the input stream

  var streaming = false;

  var video = null;
  var canvas = null;

  video = document.getElementById('video');
  canvas = document.getElementById('canvas');
  var isFirefox = typeof InstallTrigger !== 'undefined';
   

      
      try {

    var successCallback = function(stream) {

      var context = canvas.getContext('2d');

        video.srcObject = stream;
        video.muted = true
          video.play();

          video.addEventListener('canplay', function(ev){
            if (!streaming) {
              height = video.videoHeight / (video.videoWidth/width);
            
              // Firefox currently has a bug where the height can't be read from
              // the video, so we will make assumptions if this happens.
            
              if (isNaN(height)) {
                height = width / (4/3);
              }
            
              video.setAttribute('width', width);
              video.setAttribute('height', height);
              canvas.setAttribute('width', width);
              canvas.setAttribute('height', height);
              console.log(canvas);
              streaming = true;
              $('.camera_success_message').show();
              $('.camera_fail_message').hide();
              $('.camera_fail').hide();  
              $('.accesscode_btn').show();
            }else{
              $('.accesscode_btn').hide();
            }
          }, false);

    
          

          console.log('webcam started');



          

           
          
    };
    var errorCallback = function(error) {
      console.log(error);
      if ((error.name == 'NotAllowedError') ||
        (error.name == 'PermissionDismissedError') || (error.name == 'NotFoundError')) {

          $('.camera_fail').show();
          $('.camera_success').hide();
          $('.accesscode_btn').hide();
          console.log('PermissionDismissedError');
      }


    };

//     navigator.mediaDevices.getUserMedia({video: true, audio: false})
//     .then(successCallback,errorCallback).catch(e => {
//         $('.testpage').html('<div class="container"><div class="border border-secondary rounded p-5 m-5">No camera</div></div>');
//         stopTimer();
//     console.log(e);
// });

  
    
    navigator.mediaDevices.getUserMedia({video: true, audio: true})
    .then(successCallback, errorCallback);

    }
    catch(err) {
      console.log("An error occurred: " + err);
      $('.camera_fail').show();
      $('.camera_success').hide();
      $('.accesscode_btn').hide();
    }

    

  
}

detect_mobile();


  
});
</script>
@else
<script>
$(function() {
  $('.accesscode_btn').show();
  });
</script>
@endif
@endif
@endauth

 <script>
$(function(){
  if($(".pactive").length)
  $('html, body').animate({
        scrollTop: $(".pactive").offset().top
    }, 2000);
  
});
  </script>

@if(isset($register))
  <script>
    $(document).ready(function(){

      $('.sendsms').on('click',function(){
      $number = $('input[name=phone]').val();
      $url= $(this).data('url');
      $token= $(this).data('token');
      $code = $(this).data('code');
      if($number.length!=10){

        alert("Only valid 10 digit phone number is allowed");
      }
      else if(!Number.isInteger(parseInt($number))){
        alert("Only digits allowed");
      }else{

        $.ajax({
          type : 'post',
          url : $url,
          data:{'number':$number,'code':$code,'_token':$token},
          success:function(data){
            console.log('sent sms success');
            console.log(data);
            alert('OTP successfully sent to '+$number+'. Kindly wait for few minutes before you retry.')
          }
        });

      }

      

      });

      $('.verifycode').on('click',function(){
          $code = parseInt($(this).data('code'));
          $c = $('input[name=otp]').val();
          $code_verify = parseInt($('input[name=otp]').val());
          console.log($code+' '+$code_verify);
          if($code==$code_verify){
            $('.sms_error').remove();
            if(!$('.verified').length)
            $(this).parent().append('<div class="verified"><div class="text-success mt-2"><i class="fa fa-check-circle "></i> verified</div></div>');
          }else{
            $('.verified').remove();
            if(!$('.sms_error').length)
            $(this).parent().append('<div class="sms_error"><div class="text-danger mt-2 sms_error"><i class="fa fa-times-circle "></i> invalid code - '+$c+'</div></div>');
            else{
              $('.sms_error').remove();
              $(this).parent().append('<div class="sms_error"><div class="text-danger mt-2 sms_error"><i class="fa fa-times-circle "></i> invalid code - '+$c+'</div></div>');
            }
            }

      });

    });
  </script>


@endif





@if(isset($liveimage))
<script type="text/javascript">

  function load_newimage(){
    var i =0;
    for(i=0;i<100;i++){
      if($('.u_'+i).length){
        $name = $('.u_'+i).data('name');
        $num = parseInt($('.u_'+i).data('number'))+1;
        $new_image = "https://s3-xplore.s3.ap-south-1.amazonaws.com/webcam/"+$name+'_'+$num+'.jpg';
        $('.u_'+i).attr('src',$new_image);
        $('.u_'+i).data('number',$num);
        console.log($name);
      }
    }
  }
  //setInterval(load_newimage, 5000);

</script>
@endif
@if(isset($welcome))
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.11"></script>
<script type="text/javascript">


var options = {
  strings: ["<a href='../#'>10,00,000 graded profiles</a>",
               "<a href='../#'>60,000 programmers</a>", 
              "<a href='../#'>600+ colleges</a>"],
          typeSpeed: 100, // typing speed
            backDelay: 2500, // pause before backspacing
            loop: true, // loop on or off (true or false)
            loopCount: false, 
};

if($('.element').length)
var typed = new Typed('.element', options);
</script>
@endif
