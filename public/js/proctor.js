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
		$url = $(this).data('url')+"?time="+$.now();
       
        if($(this).data('selfie_url'))
        $('.log_selfie_pic').attr('src',$(this).data('selfie_url'));

        $(this).data('idcard_url')
        $('.log_idcard_pic').attr('src',$(this).data('idcard_url'));
		console.log($url);
		$.ajax({
                type: "GET",
                url: $url
            }).done(function (result) {
            	console.log(result);
            	var username = result.username;
            	var link = $('.link_snaps').data('url');
                $('.timeline').html('');
                $('.log_name').html(result.uname);
                $('.log_rollnumber').html(result.rollnumber);
                $('.log_os').html(result.os_details);
                $('.log_browser').html(result.browser_details);
                $('.log_ip').html(result.ip_details);
                $('.log_swaps').html(result.window_change);
                $('.link_snaps').attr('href',link+'?username='+username+'&type=snaps');
                $('.link_screens').attr('href',link+'?username='+username+'&type=screens');
              
                if(result.last_photo){
                	$('.log_pic').show();
                	$('.log_pic').attr('src',result.last_photo);
                }
                else
                	$('.log_pic').hide();

                

                

                //console.log(objDiv.scrollTop);
                
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
                // $('#logs').animate({ scrollTop: $('#logs .chats').height()+2000 }, 'slow');
                $('#logs').modal();
                $('.chats').animate({scrollTop: 5000},400);
                

                //window.location.href = backendUrl;
            }).fail(function () {
                console.log("Sorry URL is not access able");
        });

	    
	 });


    $('.user_terminate').on('click',function(e){

        $url = $(this).data('url')+"?time="+$.now();
        $username = $(this).data('username');
        $name = $(this).data('name');
        $('.terminate_name').html($name);
        $('.termination_confirm').data('username',$username);
        $('#terminate').modal();

     });


    $('.camera360').on('click',function(e){
        
        $url = $(this).data('url')+"?time="+$.now();
        console.log($url);
        var video = videojs("my-video");
        video.src({
  type: 'video/webm',
  src: $url
});
        $('#camera360').modal();

     });


   

    


    $('.termination_confirm').on('click',function(e){

        $username = $(this).data('username');
        $url = $('.user_terminate_'+$username).data('url');
        $urlpost = $('.user_terminate_'+$username).data('urlpost');

        $.ajax({
                type: "GET",
                url: $url
            }).done(function (result) {
                console.log(JSON.stringify(result));
                result['terminated'] = 1;
                var $data = JSON.stringify(result);

                 $.ajax({
                      method: "PUT",
                      headers: {"Content-Type": "application/json"},
                      processData: false,
                      data: $data,
                      url: $urlpost
              })
              .done(function($url) {
                      console.log('terminated');
                      $('#terminate').modal('hide');
              });
                
            }).fail(function () {
                console.log("Sorry URL is not access able");
        });

       

     });


});