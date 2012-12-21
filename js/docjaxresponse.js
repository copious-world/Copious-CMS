	var spanID = "sectionplacer";
	var handleMLO_response = null;;

	var special_ops = {};
	var special_ops_key = "";


	function secondary_http_request_response(spanLabel,response) {
	//
		if ( spanLabel == "authUserName" ) {
			if ( handleMLO_response != null ) handleMLO_response(response);
		} else {
			if ( special_ops_key.length > 0 ) {
				var f = special_ops[special_ops_key];
				if ( f != null ) {
					f(response);
				}
			}
		}
	//
	}

	function clear_server_parameters() {
		spanID = "";
	}
 
