$(function(){

	function toDateTime(secs) {
	    var t = new Date(1970, 0, 1); // Epoch
	    t.setSeconds(secs);
	    
		t.setHours(t.getHours() + 5); 
		t.setMinutes(t.getMinutes() + 30);
		datetext = t.toTimeString();
		datetext = datetext.split(' ')[0];

	    return datetext;
	}

	$('.user_log').on('click',function(e){
		console.log('log check');
		$url = $(this).data('url');
		$.ajax({
                type: "GET",
                url: $url
            }).done(function (result) {
            	console.log(result);
                $('.timeline').html('');
                $('.log_name').html(result.uname);
                $('.log_rollnumber').html(result.rollnumber);
                $('.log_os').html(result.os_details);
                $('.log_browser').html(result.browser_details);
                $('.log_ip').html(result.ip_details);
                $('.log_swaps').html(result.window_change);
                if(result.last_photo){
                	$('.log_pic').show();
                	$('.log_pic').attr('src',result.last_photo);
                }
                else
                	$('.log_pic').hide();
                Object.keys(result.activity).forEach(function(k){
                	var ele = '<div class="timeline-item align-items-start">\
                            <div class="timeline-label font-weight-bolder text-dark-75 font-size-lg">'+toDateTime(k)+'</div>\
                            <div class="timeline-badge">\
                              <i class="fa fa-genderless text-warning icon-xl"></i>\
                            </div>\
                            <div class="font-weight-mormal font-size-lg timeline-content text-primary pl-3">'+result.activity[k]+'</div>\
                          </div>'
                	
              		$('.timeline').append(ele);
				});
                $('#logs').modal();

                //window.location.href = backendUrl;
            }).fail(function () {
                console.log("Sorry URL is not access able");
        });

	    
	 });

});