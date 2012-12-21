/**********************************          GLOBAL VARIABLES***********************************/////////////	var http_request = null;

	function docsAlertContents() {
		if ( http_request.readyState == 4 ) {
			if ( http_request.status == 200 ) {
				result = http_request.responseText;
				var recepticle = document.getElementById(spanID);
				recepticle.innerHTML = result;
				secondary_http_request_response(spanID);
			} else {
				clear_server_parameters();
				alert('There was a problem with the request.');
			}
		}
	}


	function makeDocRequest(urlNparameters) {
	
		http_request = null;

		if ( window.XMLHttpRequest ) { // Mozilla, Safari,...
			http_request = new XMLHttpRequest();
			if ( http_request.overrideMimeType ) {
				http_request.overrideMimeType('text/xml');
			}
		} else if ( window.ActiveXObject ) { // IE
			try {
				http_request = new ActiveXObject("Msxml2.XMLHTTP");
			} catch (e) {
				try {
					http_request = new ActiveXObject("Microsoft.XMLHTTP");
				} catch (e) {}
			}
		}

		if ( http_request == null ) {
			alert('Cannot create XMLHTTP instance');
			return(false);
		} else {
			try {
				http_request.onreadystatechange = docsAlertContents;
				http_request.open('GET', urlNparameters, true);
				http_request.send(null);
			} catch (e) {
				clear_server_parameters();
				alert('There was trouble sending the request.');
			}
		}
		
	}
