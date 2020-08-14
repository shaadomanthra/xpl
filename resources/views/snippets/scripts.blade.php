<script src="{{ asset('js/script.js')}}?new=17"></script>
<script src="{{ asset('js/jquery.ui.min.js')}}?new=09"></script>
<script src="{{ asset('js/osc.js')}}?new=09"></script>

 @if($_SERVER['HTTP_HOST'] == 'eamcet.xplore.co.in' )
  <script>
    function blink_text() {
      if($('.blink').length){
        $('.blink').fadeOut(500);
    $('.blink').fadeIn(500);
      }
    
}
setInterval(blink_text, 1000);

// Set the date we're counting down to
var countDownDate = new Date("July 19, 2020 09:00:00").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

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
  if(document.getElementById("d"))
  document.getElementById("d").innerHTML = days + "days " + hours + "hours "
  + minutes + "min " + seconds + "sec ";
    
  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    if(document.getElementById("d"))
    document.getElementById("d").innerHTML = "";
  }
}, 1000);

  </script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
@endif

 @if($_SERVER['HTTP_HOST'] == 'bfs.piofx.com' || $_SERVER['HTTP_HOST'] == 'piofx.com' || $_SERVER['HTTP_HOST'] == 'corporate.onlinelibrary.test')
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



});
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
            if(json.status==0){
              $('.under_review_main').hide();
              $('.score_main').html("<div class='display-4'>"+json.score+"</div>");
            }
            
            $('.review_'+$id).removeClass('badge-warning').html('evaluated').addClass('badge-success');
            $('.box_'+$id).removeClass('qyellow').addClass('qgreen');
            if($comment)
            $('.score_entry_'+$id).html('<div>'+$score+'</div><div class="my-2"><b>Feedback</b></div><p>'+$comment+'</p>');
            else
            $('.score_entry_'+$id).html('<div>'+$score+'</div>');
            $('.score_save_'+$id).hide();
            $('.loading_'+$id).hide();
            $('.qno_'+$id).removeClass('qyellow').addClass('qgreen');
            
            
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



  </script>

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
          console.log(id+' '+imgurl);
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
          $('.save_image').data('imgurl',$(this).data('imgurl'));

          console.log($('.save_image').data('height'));
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

    data['student'] = $(this).data('student');
    canvas = document.getElementById('sketchpad');
    data['image'] = canvas.toDataURL("image/png");
    //redirectPost(url,data);

    $('#exampleModal').modal('hide');

    $('.img_loading_'+$id).show();
      $.ajax({
          type : 'post',
          url : url,
          data:{'imgurl':data['imgurl'],'name':data['name'],'width':data['width'],'height':data['height'],'user_id':data['user_id'],'slug':data['slug'],'qid':data['qid'],'_token':data['_token'],'student':data['student'],'image':data['image'],'ajax':1},
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
          ['fontsize', ['fontsize']],
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
                },
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
@if(isset($code))
<!-- Codemirror-->
<script src="{{asset('js/codemirror/lib/codemirror.js')}}"></script>  
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

 $('.runcode').on('click',function(){
      $qno = $(this).data('qno');
      $lang = $(this).data('lang');
      $name = $(this).data('name');
      $namec = $(this).data('namec')+Math.random().toString(36).substring(3);
      $c = ($(this).data('c'))?$(this).data('c'):null;
      $input = $(this).data('input');
      $url= $(this).data('url');
      $stop= $(this).data('stop');

      var editor_ = editor_array[$name];

      var code = editor_.getValue();
      $('.code_'+$qno).val(code);
      console.log($('.code_'+$qno).val());
      
      $('.loading').show();
      setTimeout(function(){
        $.get($stop,{'name':$namec}, function(data, status){
        console.log(data);
        console.log('Code execution stopped');
        });
      }, 5000);

        $.ajax({
          type : 'get',
          url : $url,
          data:{'testcase':'1','code':code,'lang':$lang,'c':$c,'input':$input,'name':$namec},
          timeout: 10000, 
          success:function(data){
            console.log(data);
            data = JSON.parse(data);
   
            if(data){
              if(data.stderr){
                $('.output_'+$qno).html(data.stderr);
              }else if(data.stdout){
                $('.output_'+$qno).html(data.stdout);
                $('.input_'+$qno).attr('value',data.stdout);
                if(!$('.s'+$qno).hasClass('qblue-border'))
                  $('.s'+$qno).addClass('qblue-border');
                if(!$('.s'+$qno).hasClass('active'))
                      $('.s'+$qno).removeClass('active');
                $('.final_response_'+$qno).html(data.stdout);
              }else{
                $('.output_'+$qno).html("No Result - Code execution time exceeded - Retry.");
              }
            }else{
                $('.output_'+$qno).html("No Data - Code execution time exceeded - Retry.");
            }
            $('.loading').hide();
          },
          error: function(jqXHR, textStatus, errorThrown) {
              if(textStatus==="timeout") {  
                $('.output_'+$qno).html("Timeout(10s) - Code execution time exceeded - Retry.");
              } else {
                $('.output_'+$qno).html("Server Error - Code execution time exceeded - Retry.");
              }
              $('.loading').hide();
          }
        });

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

  


  $('.btn-run').on('click',function(){
      $token = $(this).data('token');
      $url= $(this).data('url');
      var code = editor.getValue();
      var random = Math.random().toString(36).substring(7);
      $('.loading').show();
      $('.codeerror').hide();
      
        $.ajax({
          type : 'post',
          url : $url,
          data:{'testcase':'1','code':code,'_token':$token,'name':random+'_1'},
          success:function(data){
            console.log(data);
            if($('.output').length){
              $('.output').append('<p>'+data+'</p>');
            }

            data = JSON.parse(data);
            
            if(data.stderr){
              $('.codeerror').show();
              $('.codeerror').html("<pre><code class='text-light' >"+data.stderr+"</code></pre>");
              $('.in1').html('-');
              $('.in1-message').html('<span class="badge badge-danger">failure</span>');
            }else{
              if(data.success==1){
                $('.in1').html(data.stdout);
                $('.in1-message').html('<span class="badge badge-success">success</span>');
              }else{
                $('.in1').html(data.stdout);
                $('.in1-message').html('<span class="badge badge-danger">failure</span>');
              }
              
            }


            
          }
        });
        $.ajax({
          type : 'post',
           url : $url,
          data:{'testcase':'2','code':code,'_token':$token,'name':random+'_2'},
          success:function(data){
            console.log(data);

            if($('.output').length){
              $('.output').append('<p>'+data+'</p>');
            }
            data = JSON.parse(data);
            if(data.stderr){
              $('.in2').html('-');
              $('.in2-message').html('<span class="badge badge-danger">failure</span>');
            }else{
              if(data.success==1){
                $('.in2-message').html('<span class="badge badge-success">success</span>');
              }else{
                $('.in2-message').html('<span class="badge badge-danger">failure</span>');
              }
            }
          }
        });
        $.ajax({
          type : 'post',
           url : $url,
          data:{'testcase':3,'code':code,'_token':$token,'name':random+'_3'},
          success:function(data){
            console.log(data);
            if($('.output').length){
              $('.output').append('<p>'+data+'</p>');
            }
            data = JSON.parse(data);
            if(data.stderr){
              $('.in3').html('-');
              $('.in3-message').html('<span class="badge badge-danger">failure</span>');
              $('.loading').hide();
            }else{
              if(data.success==1){
                $('.in3-message').html('<span class="badge badge-success">success</span>');
              }else{
                $('.in3-message').html('<span class="badge badge-danger">failure</span>');
              }
              $('.loading').hide();
            }
          }
        });
      

    });  
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
            label: 'Responses',
            data: [{{ $details['correct']}}, {{ $details['incorrect']}}, {{ $details['unattempted']}}],
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
@foreach($sections as $sec => $section)
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
@endforeach
@endif

@endif



@if(isset($secs))
@foreach($secs as $sec => $section)
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

      console.log('number :'+v.number);
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



@if(isset($timer2))
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

$(document).on("keypress", 'form', function (e) {
    var code = e.keyCode || e.which;
    if (code == 13) {
        e.preventDefault();
        return false;
    }
});

</script>

<script>
   // upload user responses
$(function(){
  $(document).on('click','.btn-urq',function(e){
      $name = $(this).data('name');
      $url = $(this).data('url');
      $user_id = $(this).data('user_id');
      $qid = $(this).data('qid');
      $token = $(this).data('token');

      i = $qid+'_'+Math.floor(Math.random() * 1000);
      e.preventDefault();

       var fd = new FormData();
       var files = $('.input_urq_'+$name)[0].files[0];

       var ext = $('.input_urq_'+$name).val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['jfif','png','jpg','jpeg']) == -1) {
            $('.img_status_'+$name).html('<span class="text-danger"><i class="fa fa-times-circle"></i> Only images with extension jpg,jpeg,png are supported. File uploaded is '+ext+'.</span>');
                return 1;
        }

       if (files.size > 20971520) { 
                $size = Math.round(files.size / Math.pow(1024,2));
                $('.img_status_'+$name).html('<span class="text-danger"><i class="fa fa-times-circle"></i> Image size cannot be more than 20MB. File uploaded '+$size+'MB.</span>');
                return 1;
        }

       console.log('.input_urq_'+$name);
        fd.append('file',files);
        fd.append('user_id',$user_id);
        fd.append('qid',$qid);
        fd.append('_token',$token);
        fd.append('i',i);
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
            if(response != 0){
                  $(".img_c_"+$name).prepend($('<img class="w-100 py-2 "/>').attr('src',response));
                  $(".img_container_"+$name).show(); // Display 
                  $('.spinner_'+$name).hide();
                  $('.img_status_'+$name).html('<span class="text-success"><i class="fa fa-check-circle"></i> Image upload successfully.</span>');
                  $('.btn_delete_urq_'+$name).show();
                  $(".input_urq_"+$name).val(null);

                  if(!$('.s'+$name).hasClass('qblue-border'))
                    $('.s'+$name).addClass('qblue-border');
                  if(!$('.s'+$name).hasClass('active'))
                        $('.s'+$name).removeClass('active');


                }else{
                  console.log('error');
                  $('.img_status').text('Image upload failed. Kindly retry.');
                }
          },
          
        });

        // $.ajax({
        //     url: $url,
        //     type: 'GET',
        //     data: fd,
        //     contentType: false,
        //     processData: false,
        //     success: function(response){
        //         if(response != 0){
        //           console.log('done'+response);
        //             $(".img_".$name).attr("src",response); 
        //             $(".img_container_".$name).show(); // Display image element
        //         }else{
        //           console.log('error');
        //             //alert('file not uploaded');
        //         }
        //     },
        //     error: function(e){
        //       console.log(e)
        //     },
        // });
      
  });


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
                  $('.img_status_'+$name).html('<span class="text-danger"><i class="fa fa-trash"></i> Images deleted successfully.</span>');
                  $('.btn_delete_urq_'+$name).hide();
                  $('.s'+$name).removeClass('qblue-border');
                  $(".input_urq_"+$name).val(null);

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

  if(hours==0 && minutes==5 && seconds==1)
    $('#timer_alert').modal();

  $tcount = parseInt($('.timer_count').data('value'))-1;
  $('.timer_count').data('value',$tcount);
  // if(seconds==56)
  //   $('#timer_alert').modal();

  // If the count down is finished, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("timer").innerHTML = "EXPIRED";
    document.getElementById("timer2").innerHTML = "EXPIRED";

    @if(isset($exam))
      alert('The Test time has expired. ');
      document.getElementById("assessment").submit();
      
    @endif
  }
}, 1000);

function addMinutes(date, minutes) {
    return new Date(date.getTime() + minutes*60000);
}

function stopTimer() {
  clearInterval(x);
}




</script>

@endif



@if(isset($window_change))
@if($window_change)
<script src="{{ asset('js/jquery.winFocus.js')}}"></script>

<script>
 // window change events

 function stopTimer() {
  var count = parseInt(document.getElementById("window_change").value) +1;
  var message = '';
  @if(isset($exam->window_swap))
    @if($exam->window_swap)

      @if($exam->auto_terminate==0)
      var message = 'We have noticed a window swap ('+count+'). Kindly note that numerous swaps will lead to cancellation of the test.'; 
      @else
      if(count =={{$exam->auto_terminate}})
      var message = 'We have noticed {{$exam->auto_terminate}} window swaps. Next swap will lead to termination of the test.';
      else if(count>{{$exam->auto_terminate}})
      var message = 'You have reached the {{$exam->auto_terminate}} swap limit. The test will be terminated here.';
      else 
      var message = 'We have noticed a window swap ('+count+'). Kindly note that {{$exam->auto_terminate}} swaps will lead to cancellation of the test.';
      @endif
      
    @endif
  @endif
  

  $('.swap-message').html(message);
  $('#exampleModalCenter').modal();
  document.getElementById("window_change").value = count;

  @if(isset($exam->window_swap))
    @if($exam->window_swap)
      if(count=={{$exam->auto_terminate}}){
        setTimeout(function(){ 
          $('#exampleModalCenter').modal('toggle');
          $("form")[0].submit();
        }, 3000);
      }
    @endif
  @endif
  
  console.log("Blured");
 }


function win_focus(){
  console.log('started focus events');
  var window_focus;

  @if(isset($exam->window_swap))
    @if($exam->window_swap)
    $(window).focus(function() {
      window_focus = true;
      console.log("Focused");
      }).blur(function() {
        if(parseInt($('.timer_count').data('value'))>5)
          stopTimer();
    });
    @endif
  @endif
}

setTimeout(win_focus,5000);
 
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
<script>
$(function(){

  var width = 320;    // We will scale the photo width to this
  var height = 0;     // This will be computed based on the input stream

  // |streaming| indicates whether or not we're currently streaming
  // video from the camera. Obviously, we start at false.

  var streaming = false;

  // The various HTML elements we need to configure or control. These
  // will be set by the startup() function.

  var video = null;
  var canvas = null;
  var photo = null;
  var startbutton = null;

  function startup() {
    video = document.getElementById('video');
    canvas = document.getElementById('canvas');
    photo = document.getElementById('photo');
    text = document.getElementById('text');
    startbutton = document.getElementById('startbutton');
    console.log('webcam started');
    try {
    navigator.mediaDevices.getUserMedia({video: true, audio: false})
    .then(function(stream) {
      video.srcObject = stream;
      video.play();
    }).catch(e => {
      $('#camera_test').modal();
        // $('.testpage').html('<div class="container"><div class="border border-secondary rounded p-5 m-5">Camera not accessible.</div></div>');
        
    console.log(e);
});
    }
    catch(err) {
      $('.testpage').hide();
      console.log("An error occurred: " + err);
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
    photo.setAttribute('src', data);
  }
  
  // Capture a photo by fetching the current contents of the video
  // and drawing it into a canvas, then converting that to a PNG
  // format data URL. By drawing it on an offscreen canvas and then
  // drawing that to the screen, we can change its size and/or apply
  // other changes before drawing it.

  function takepicture() {

    var context = canvas.getContext('2d');

    var $counter = parseInt($('#video').data('c'));

    if (width && height) {
 
      canvas.width = width;
      canvas.height = height;
      context.drawImage(video, 0, 0, width, height);
    
      var data = canvas.toDataURL('image/jpeg',0.5);

      photo.setAttribute('src', data);

      var url = $('#photo').data('hred');
      var image = $('#photo').attr('src');
      $token = $('#photo').data('token');

      // var url = $('#video').data('hred');
      // $token = $('#video').data('token');
      $c = parseInt($('#video').data('c'))+1;
      $username = $('#video').data('username');
      $test = $('#video').data('test');
      $name = $username+'_'+$test+'_'+$c;

      $.post( url ,{'name': $name ,'image':image,'_token':$token}, function( data ) {
            console.log(data);

      });

      $('#video').data('c',$c);
      console.log($name);
      console.log($c);
    }else{
      $('#camera_test').modal();
    } 
  }
  // Set up our event listener to run the startup process
  // once loading is complete.
  window.addEventListener('load', startup, false);
  $time = @if(isset($exam->capture_frequency))@if($exam->capture_frequency){{($exam->capture_frequency*1000)}} @else 300000 @endif @else 300000 @endif;
  setTimeout(function(){ takepicture(); }, 5000);
  setInterval(function(){ takepicture(); console.log($time); }, $time);
});
</script>
@endif
@endif

@if(isset($cameratest))
@if($cameratest)
<script>
$(function() {

 function detect_mobile(){
    if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
      $('.camera_message').html("This test can be attempted from desktop or laptop only. Mobile & Tablets are not allowed. Kindly contact administrator incase of any query.");
      $('.camera_fail').show();
      $('.camera_success').hide();
      $('.accesscode_btn').hide();
    }else{
      camera_test();
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


    
    console.log('webcam started');
    var successCallback = function(stream) {
        video.srcObject = stream;
          video.play();
          console.log('webcam started');
          $('.camera_fail').hide();
          $('.camera_success').show();
          $('.accesscode_btn').show();
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

    navigator.mediaDevices.getUserMedia({video: true, audio: false})
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
