$(document).ready(function() {	
		getPushNotification(order_beep_url);
		setInterval(function(){ getPushNotification(order_beep_url); }, 20000);
        var beepAudio = document.getElementById('beepAudio');
});

// var audioContext = new (window.AudioContext || window.webkitAudioContext)();
$('#playBeepButton').on('click', function () {
    var beepAudio = document.getElementById('beepAudio');
    beepAudio.play();
});

function getPushNotification(order_beep_url) {	

	if (!Notification) {
		$('body').append('<h4 style="color:red">*Browser does not support Web Notification</h4>');
		return;
	}
	if (Notification.permission !== "granted") {		
		Notification.requestPermission();
	}

	$.ajax({
        url : order_beep_url,
        type: "get",
        dataType : 'json',
        data: {
        //   '_token' : csrf_for_noti,
          },
        success: function(response) {
            if(response.notify) {
                $('#orderBeepModal').modal('show'); 
                // Use the Web Audio API to play the audio without user interaction
                // var source = audioContext.createBufferSource();
                // source.buffer = audioContext.createBuffer(1, 1, 22050);
                // source.connect(audioContext.destination);
                // source.start(0);

                // Trigger a click on the playBeepButton to initiate the playback
                $('#playBeepButton').trigger('click');

                //Notification
                if (Notification.permission == "granted") {	
                    var notificationObj = new Notification('New Order Arrvied!', {
                        icon: '<i class="fa fa-clock"></i>',
                        body: 'New Order Arrvied!',
                    });
                    setTimeout(function(){
                        notificationObj.close();
                    }, 10000);
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown)	{}
    });
    
		
};