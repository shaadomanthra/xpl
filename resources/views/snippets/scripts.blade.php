
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/global.js')}}"></script>
<!-- include summernote css/js-->
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.9/summernote-bs4.css" rel="stylesheet">
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

<script type="text/javascript">

  $(document).ready(function() {
  	$('#search').on('keyup',function(){
  		$value=$(this).val();
  		$.ajax({
  			type : 'get',
  			url : '{{URL::to('dataentry')}}',
  			data:{'search':true,'item':$value},
  			success:function(data){
  				$('#search-items').html(data);
  			}
  		});
  	});
  });

</script>
