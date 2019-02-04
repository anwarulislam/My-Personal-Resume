$.get("https://ipinfo.io?token=dd0c71eaacc35a", function (response) {
    $("#details").val(JSON.stringify(response, null, 4));
}, "jsonp");


var loc = document.getElementById("location");

window.onload = function getLocation() {
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(showPosition);
    } else { 
        loc.value = "Geolocation is not supported by this browser.";
    }
}

function showPosition(position) {
    var lt = position.coords.latitude + ' |lalo| ' + position.coords.longitude;
	loc.value = lt;
	return lt;
}


function get_browser(){
    var ua = navigator.userAgent, tem,
    M=ua.match(/(opera|chrome|safari|firefox|msie|trident(?=\/))\/?\s*(\d+)/i) ||[];

    if (/trident/i.test(M[1]))
    {
        tem = /\brv[ :]+(\d+)/g.exec(ua) || [];
        return { name: 'IE', version: (tem[1] || '') };
                                                        }
        if (M[1] === 'Chrome')
        {
            tem = ua.match(/\bOPR\/(\d+)/)

            if (tem != null)
            {
                return { name: 'Opera', version: tem[1] }; 
            }
        }

    M = M[2] ? [M[1], M[2]] : [navigator.appName, navigator.appVersion, '-?'];
    if ((tem = ua.match(/version\/(\d+)/i)) != null)
    {
        M.splice(1, 1, tem[1]);
    }

    return {
        name: M[0],
        version: M[1]
    };
}

$("#anonymousMsg").submit(function(e){
    e.preventDefault();
  });

$('.getResult').on('click', function() {
	
	$('.getResult').button('loading');
	
	//passing these data to process.php
	
	var nameF = $("#name").val();
	var name;
	if(nameF != ''){
	    var name = nameF;
	}else{
	    var name = 'Anonymous';
	}
	var subject = name;
	var email = 'aib.tmkm@gmail.com';
	var message = $("#message").val();
	var phone = 'Anonym';
	
	//other info
	
	var browser = get_browser()['name'] + ' - ' + get_browser()['version'];
	var location = $("#location").val();
	var details = $("#details").val();
	
	var fullmsg = message + '\n\n\n' + browser + '\n' + location + '\n\n\n' + details;
	
	
	$.post("sendemail.php", {
		name: name,
		subject: subject,
		email: email,
		phone: phone,
		message: fullmsg,
		
	}).done(function(data){
		
		var response = data['response'];
		
		if(response == 'success'){
			$('.getResult').button('reset');
			document.getElementById("result").style.display = "block";
			document.getElementById("result").innerHTML = 'Your message successfully delivered';
			
			/*setTimeout(function(){
              $('#video').show();
			  $('#video')[0].play();
            }, 2000);*/
			
		}else{
		    $('.getResult').button('reset');
			alert('Message not successfully sent');
		}
		
	})
	
    
});