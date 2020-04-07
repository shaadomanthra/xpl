<script src="{{ asset('js/script.js')}}?new=12"></script>


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
      $('.loading').show();
      $('.codeerror').hide();
      
        $.ajax({
          type : 'post',
          url : $url,
          data:{'testcase':'1','code':code,'_token':$token},
          success:function(data){
            data = JSON.parse(data);
            
            if(data.stderr){
              $('.codeerror').show();
              $('.codeerror').html("<pre><code>"+data.stderr+"</code></pre>");
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
          data:{'testcase':'2','code':code,'_token':$token},
          success:function(data){
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
          data:{'testcase':3,'code':code,'_token':$token},
          success:function(data){
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

@if(isset($timer2))
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

var btn = document.getElementById('submit'),
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

  // If the count down is finished, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("timer").innerHTML = "EXPIRED";
    document.getElementById("timer2").innerHTML = "EXPIRED";

    @if(isset($exam))
      alert('The Test time has expired. ');
      $('.assessment').submit();
    @endif
  }
}, 1000);

function addMinutes(date, minutes) {
    return new Date(date.getTime() + minutes*60000);
}

 

 // Inactive
 window.addEventListener('blur', stopTimer);



 // Stop timer
 function stopTimer() {
  var count = parseInt(document.getElementById("window_change").value) +1;
  alert('We have noticed a window swap ('+count+'). Kindly note that multiple swaps will lead to cancellation of the test.');
  document.getElementById("window_change").value = count;
 }

</script>

@endif


@if(!request()->is('/')) 
@if(isset($ads))
<script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js" type="application/javascript"></script>
@endif

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-43617911-9"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-43617911-9');
</script>
@endif

@if(isset($welcome))
<script src="https://cdn.jsdelivr.net/npm/typed.js@2.0.11"></script>
<script type="text/javascript">


var options = {
  strings: ["<a href='../#'>35,000 graded profiles</a>",
               "<a href='../#'>6,000 programmers</a>", 
              "<a href='../#'>80+ colleges</a>"],
          typeSpeed: 100, // typing speed
            backDelay: 2500, // pause before backspacing
            loop: true, // loop on or off (true or false)
            loopCount: false, 
};

if($('.element').length)
var typed = new Typed('.element', options);
</script>
@endif
