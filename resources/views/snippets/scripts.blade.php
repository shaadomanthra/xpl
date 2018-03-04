
<script src="{{ asset('js/app.js') }}"></script>
<script src="{{ asset('js/global.js')}}"></script>

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
