$(function  () {
	$( ".sortable" ).disableSelection();

	$('.sortable').sortable(/*{
  		  connectWith: '.sortable',
		  update: function(event, ui) {
		    var changedList = this.id;
		    var order = $(this).sortable('toArray');
		    var positions = order.join(';');

		    console.log({
		      id: changedList,
		      positions: positions
		    });
		  }
		}*/);

	var dataArray = function(item){
		item.apple = 'fruit';
		var a = item.find( "li" ).data('id');
		return a;
	}

	$(document).on('click','.order',function(){
		
		var a  = $( "ul.sortable li" ).each(function(data) {
			var val = $('#sortlist').data('value');
			console.log(val);
	    	$('#sortlist').data('value', val + '-' + $(this).data('slug') );
		});
		var value = $('#sortlist').data('value');
	});
	
	//console.log(a);	

	//$( ".sor-first" ).find( "li" ).data('id');
	//console.log(item.data('id'));
    
});
