
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/global.js')}}"></script>

<!-- include summernote css/js-->
<script src="{{asset('js/summernote/summernote-bs4.js')}}"></script>    
<script src="{{asset('js/jquery.form.js')}}"></script>  

<!-- Codemirror-->
<script src="{{asset('js/codemirror/lib/codemirror.js')}}"></script>  
<script src="{{asset('js/codemirror/mode/xml/xml.js')}}"></script>  
<script src="{{asset('js/codemirror/mode/javascript/javascript.js')}}"></script>  
<script src="{{asset('js/codemirror/addon/display/autorefresh.js')}}"></script>  
<script src="{{asset('js/codemirror/mode/markdown/markdown.js')}}"></script>  
<script src="{{asset('js/highlight/highlight.pack.js')}}"></script>  

@if(isset($chart))
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.2/Chart.min.js"></script> 

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

@endif



 
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

        if(document.getElementById("code"))
        var editor = CodeMirror.fromTextArea(document.getElementById("code"), {
          lineNumbers: true,
          styleActiveLine: true,
          matchBrackets: true,
          autoRefresh:true,
          mode:  'javascript',
          indentUnit: 4
        });
</script>

<script>
  $(document).ready(function() {

      $(document).on('click','.view',function(){
          $item = '.'+$(this).data('item');
          if($($item).is(":visible")){
            $($item).slideUp();
          }
          else{
            $($item).slideDown();
          }
      });

       $(document).on('click','.btn-attach',function(){
          $id= $(this).data('id');
          $data = $('.passage_'+$id).html();
          $('input[name="passage_id"]').val($id);
          $('.passage').html($data);

      });

       $(document).on('click','.btn-dettach',function(){
          $('input[name="passage_id"]').val('');
          $('.passage').html('');
      });

  });
</script>
<script>hljs.initHighlightingOnLoad();</script>

@if(isset($question['dynamic']))
<script>
$(document).ready(function() {

      var v = new Object();
      var items = ['question','a','b','c','d','e','answer','explanation','passage'];
      v.number = parseInt({{(request()->get('number'))?request()->get('number'):'1'}});
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

<script>
  $(document).ready(function() {

     $('form#uploadimage').ajaxForm({
        beforeSend:function(){

        },
        uploadProgress:function(event,position,total,percentComplete){
        },
        success:function(){
        },
        complete:function(response){
          var rooturl = $('.root').data('rooturl');
          $( ".image_container" ).replaceWith("<div class='image_container'><img src='"+rooturl+'/'+response.responseText+"'  class='image' width='25%'/></div>");
          $('.formimage').val(response.responseText);
         
        }
       });

     $(document).on('click','.btn-remove',function(){
        var rooturl = $('.root').data('rooturl')+'/social/imageremove';
        var image = $('.formimage').val();
        $.get(rooturl,{'image':image},function(data){
            $( ".image_container" ).replaceWith("<div class='image_container'></div>");
            $('.formimage').val(' ');
        });
     });
  });
      

</script>

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

<script type="text/javascript">

  $(document).ready(function() {
  	$('#search').on('keyup',function(){
  		$value=$(this).val();
      $url = $(this).data('url');
  		$.ajax({
  			type : 'get',
  			url : $url,
  			data:{'search':true,'item':$value},
  			success:function(data){
  				$('#search-items').html(data);
  			}
  		});
  	});

    $('.btn-close').on('click',function(){
      var video = $('#intro').attr("src");
      $("#intro").attr("src","");
      $("#intro").attr("src",video);
    });

  });

  

  

</script>


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
