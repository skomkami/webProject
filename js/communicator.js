var timer;

window.onload = function(e) {
	var active_box = document.getElementById("active_box");
	active_box.setAttribute("onclick", "chatt('true')");

}

function chatt(get_now) {
	var active_box = document.getElementById("active_box");
	if(active_box.checked) {
		var xmlhttp = new XMLHttpRequest();
    		xmlhttp.onreadystatechange = function() {
	            	if (this.readyState == 4 && this.status == 200) {
    	        		document.getElementById("messages_field").innerHTML = this.responseText;
						console.log("odebrano wiadomości");
						console.log("wysyłam kolejne żądanie "+get_now);
						chatt('false');
            		}
    		};
        	xmlhttp.open("GET", "communicator.php?getnow=" + get_now, true);
	    	xmlhttp.send();
	} else {
		document.getElementById("messages_field").innerHTML = "";
	}

}


function send() {

	var active = document.getElementById("active_box").checked;

	if(!active) return;

	var nick = document.getElementById("nick_field").value;
	var message_field = document.getElementById("message_field");
	
	if (message_field.value.length == 0 || nick.length ==0) { 
        	alert("Wpisz nick i wiadomość!!");
	        return;
	} else {
        	var xmlhttp = new XMLHttpRequest();
        	xmlhttp.onreadystatechange = function() {
	            if (this.readyState == 4 && this.status == 200) {
					if(this.response == "failure")
						alert("Nie udało się wysłać wiadomości");
		    		
		    		message_field.value = "Wpisz wiadomość..";
		        }
        	};
	        xmlhttp.open("GET", "add_message.php?user=" + nick + "&message=" + message_field.value, true);
        	xmlhttp.send();
	}

}
