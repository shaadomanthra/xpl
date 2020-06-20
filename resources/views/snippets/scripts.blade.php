<script src="{{ asset('js/script.js')}}?new=12"></script>
<script src="{{ asset('js/jquery.ui.min.js')}}?new=12"></script>
<script src="{{ asset('js/osc.js')}}?new=12"></script>


  <script>
$(function(){

  /* profile completion page */
  if($('.screen').length){
    $('.screen').hide();
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
      $('.screen').hide();
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

  </script>

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

  $('.runcode').on('click',function(){
      $qno = $(this).data('qno');
      $lang = $(this).data('lang');
      $name = $(this).data('name');
      $c = ($(this).data('c'))?$(this).data('c'):null;
      $input = $(this).data('input');
      $url= $(this).data('url');
      $url_stop= $(this).data('url_stop');
      $url_remove= $(this).data('url_remove');
      
      $random = Math.random().toString(36).substring(7);
   

      var editor_ = editor_array[$name];

      var code = editor_.getValue();
      
      $('.loading').show();

        $.ajax({
          type : 'get',
          url : $url_remove,
          success:function(data){
          }
        });

        $.ajax({
          type : 'get',
          url : $url,
          data:{'testcase':'1','code':code,'lang':$lang,'c':$c,'input':$input,'name':$random},
          success:function(data){
            console.log(data);
            data = JSON.parse(data);
   
            if(data){
              if(data.stderr){
                $('.output_'+$qno).html(data.stderr);
              }else{
                $('.output_'+$qno).html(data.stdout);
                $('.input_'+$qno).attr('value',data.stdout);
              }
            }else{
               $('.output_'+$qno).html("Data not compiled");
            }
            
            $('.loading').hide();
          }
        });

        setTimeout( function(){ 
        $.ajax({
          type : 'get',
          url : $url_stop,
          data:{'name':$random},
          success:function(data){
          }
        });
        }  , 3000 );
        

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

var ctxOne = document.getElementById('chartOneContainer').getContext('2d');
new Chart(ctxOne, optionsOne);

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

var ctx_{{$section->section_id}} = document.getElementById({{$section->section_id}}+'Container').getContext('2d');
new Chart(ctx_{{$section->section_id}},options_{{$section->section_id}});

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

        if(content){
          if(element =='passage')
          $( $item ).replaceWith( '<div class="pt-1 '+element+'" style="display:none">'+content+'</div>' );
          else
          $( $item ).replaceWith( '<div class="pt-2 '+element+'">'+content+'</div>' );
        }

      });
      
  });
 </script>
@endif
@if(isset($jqueryui))
 <script type="text/javascript"
         src="{{asset('jquery-ui/jquery-ui.min.js')}}">
  </script>
  <script>
  $( function() {
    $( "#datepicker" ).datepicker({dateFormat: 'yy-mm-dd'});
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

var btn = document.getElementById('submit_button'),
    clicked = false;

btn.addEventListener('click', function () {
  clicked = true;
});

window.onbeforeunload = function () {
  if(!clicked) {
    return 'If you resubmit this page, progress will be lost.';
  }
};


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

 




</script>

@endif



@if(isset($window_change))
@if($window_change)
<script src="{{ asset('js/jquery.winFocus.js')}}"></script>

<script>
 // Inactive
 // window.addEventListener('blur', stopTimer);

 // Stop timer
 function stopTimer() {
  var count = parseInt(document.getElementById("window_change").value) +1;

  
  if(count ==3)
  var message = 'We have noticed 3 window swaps. Next swap will lead to termination of the test.';
  else if(count>3)
  var message = 'You have reached the 3 swap limit. The test will be terminated here.';
  else 
  var message = 'We have noticed a window swap ('+count+'). Kindly note that 3 swaps will lead to cancellation of the test.';

  @if(isset($exam))
  @if($exam->status==1)
  var message = 'We have noticed a window swap ('+count+'). Kindly note that too many swaps will lead to cancellation of the test.';
  @endif
  @endif

  $('.swap-message').html(message);
  $('#exampleModalCenter').modal();
  document.getElementById("window_change").value = count;

  @if(isset($exam))
  @if($exam->status!=1)
  if(count==4){
    setTimeout(function(){ 
      $('#exampleModalCenter').modal('toggle');
      $("form")[0].submit();
    }, 3000);
  }
  @endif
  @endif
  console.log("Blur");
 }


function win_focus(){
  console.log('started focus events');
  var window_focus;

  $(window).focus(function() {
    window_focus = true;
    console.log("Focus");
  }).blur(function() {
    if(parseInt($('.timer_count').data('value'))>5)
        stopTimer();
        
    });
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
<script src="{{ asset('js/capture.js') }}">
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
  try {

    var successCallback = function(stream) {
        video.srcObject = stream;
          video.play();
          $('.camera_fail').hide();
          $('.camera_success').show();
          $('.accesscode_btn').show();
    };
    var errorCallback = function(error) {
      if ((error.name == 'NotAllowedError') ||
        (error.name == 'PermissionDismissedError')) {
          $('.camera_fail').show();
          $('.camera_success').hide();
          $('.accesscode_btn').hide();
        console.log('PermissionDismissedError');
      }
    };

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
