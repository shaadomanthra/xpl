

<script src="{{ asset('js/script.js')}}"></script>


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
              });
          });

        
</script>

@endif


@if(isset($code))
<!-- Codemirror-->
<script src="{{asset('js/codemirror/lib/codemirror.js')}}"></script>  
<script src="{{asset('js/codemirror/mode/xml/xml.js')}}"></script>  
<script src="{{asset('js/codemirror/mode/javascript/javascript.js')}}"></script>  
<script src="{{asset('js/codemirror/addon/display/autorefresh.js')}}"></script>  
<script src="{{asset('js/codemirror/mode/markdown/markdown.js')}}"></script>  
<script src="{{asset('js/highlight/highlight.pack.js')}}"></script>  
<script>hljs.initHighlightingOnLoad();</script>
<script type="text/javascript">
$(document).ready(function() {
  if(document.getElementById("code"))
        var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
          lineNumbers: true,
          styleActiveLine: true,
          matchBrackets: true,
          autoRefresh:true,
          mode:  'javascript',
          indentUnit: 4
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
                    beginAtZero:true
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
                    beginAtZero:true
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
    labels: ["Correct", "Incorrect", "Unattempted"],
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
    labels: ["Excellent", "Good", "Need to Improve"],
    datasets: [{
      label:'',
      data: [{{$details['section'][$section->id]['excellent']}}, {{$details['section'][$section->id]['good']}}, {{$details['section'][$section->id]['need_to_improve']}}],
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
            text: '{{ $details["section"][$section->id]["name"] }} '
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
