
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/global.js')}}"></script>

<!-- include summernote css/js-->
<link href="{{asset('js/summernote/summernote-bs4.css')}}" rel="stylesheet">
<script src="{{asset('js/summernote/summernote-bs4.js')}}"></script>    
 
 <script>
        $(document).ready(function() {
            $('.summernote').summernote({
        placeholder: 'Hello ! Write something...',
        tabsize: 2,
        height: 300
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
  });

</script>
