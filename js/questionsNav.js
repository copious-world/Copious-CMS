
	////

 	var formSubFieldsObj = null;
	var button_disfunction = false;
	////
	var QStack = [ "a",  "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a"];
	var valueHolderArray = [ "source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id" ];


	var nq = 1;
	var atend = false;
	var nextEnabled = true;
	var g_qdivnum = 1;
	var g_currentDiv = 1;

	var gCompletionSpan = "completion";
	var gFirstQuestion = "q1";
	var gDefaultFirstAnswer = 'Qurl';
	var gQuestionaireServerLocus = './storequestionaire.php'
	var gNavNextName = "nextbutton";


	function firstInitializer(firstQuestion,completionSpan,defaultFirstAnswer,questionaireServerLocus,navNextName) {

		gFirstQuestion = firstQuestion;
		gCompletionSpan = completionSpan;
		gDefaultFirstAnswer = defaultFirstAnswer;
		gQuestionaireServerLocus = questionaireServerLocus;
		gNavNextName = navNextName;
		////
		//
		QStack[0] = gFirstQuestion;
		QStack[1] = gFirstQuestion;
		var formnext = $(gFirstQuestion + "_form");
	
		var gNavNextObj = null;
	}



	function initial_conditions() {
		nq = 1;
		atend = false;
		g_qdivnum = 1;
		g_currentDiv = 1;
		button_disfunction = false;
		QStack = [ "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a", "a"];
		valueHolderArray = [ "source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id","source_id" ];
		formnext = $(gFirstQuestion + "_form");
		QStack[0] = gFirstQuestion;
		QStack[1] = gFirstQuestion;
		enableNext();

		$(formSubFieldsObj[gFirstQuestion].valueHolder).value = gDefaultFirstAnswer;
		$hide(gCompletionSpan);
	}

	//////
	function assert_button_disfunction() {
		button_disfunction = true;
	}

	function asert_at_end() { atend = true; }
	


	function resetpath(n) {
		nq = n;
		atend = false;
	}


	function processQ(qdivnum) {
		var qdiv = appNamer(qdivnum);
		var qobj = $(qdiv);
		////
		g_qdivnum = qdivnum;
		g_currentDiv = qdivnum + 1
		////
		var qdivnext = appNamer(qdivnum + 1);
		var qobjnext = $(qdiv);
		//
		QStack[g_qdivnum] = qdiv;
		QStack[g_currentDiv] = qdivnext;
		//
		$hide(qdiv);
		hideRelevant(qdiv);
		if ( qobjnext != null ) {
			$show(qdivnext);
			var q1 = $(gLocusRefObj);
			if ( Br != "IE" ) {
				$(qdivnext).style.top = q1.offsetTop + q1.offsetParent.offsetTop + q1.offsetParent.offsetParent.offsetTop + "px";
				$(qdivnext).style.left = q1.offsetLeft + q1.offsetParent.offsetLeft + q1.offsetParent.offsetParent.offsetLeft +  "px";
				$(qdivnext).style.width = q1.offsetWidth - 22 + "px";
				$(qdivnext).style.height = q1.offsetHeight - 22 + "px";
			} else {
				var vv = 4;
				vv += eval(q1.offsetTop + q1.offsetParent.offsetTop + q1.offsetParent.offsetParent.offsetTop
							 + q1.offsetParent.offsetParent.offsetParent.offsetTop 
							 + q1.offsetParent.offsetParent.offsetParent.offsetParent.offsetTop 
							 + q1.offsetParent.offsetParent.offsetParent.offsetParent.offsetParent.offsetTop
							 + q1.style.padding );
				$(qdivnext).style.top = vv + "px";
				$(qdivnext).style.left = q1.offsetLeft + q1.offsetParent.offsetLeft + q1.offsetParent.offsetParent.offsetLeft  + 14 + "px";
				$(qdivnext).style.width = q1.offsetWidth - 22 + "px";
				$(qdivnext).style.height = q1.offsetHeight - 22 + "px";
			}
		} else {

			makeDocRequest(url);
		}
	} 
	
	function resizer() {
		processQ(g_qdivnum);
		$hide(actionFramer);
	}
	
	
	function prevpanel() {
		if  ( !nextEnabled ) {
			initial_conditions();
		}
		if ( g_currentDiv > 0 ) {
			var qdiv = QStack[g_currentDiv];
			$hide(qdiv);

			if ( g_currentDiv > 1 ) g_currentDiv--;
			
			var qdivnext = QStack[g_currentDiv];
			$show(qdivnext);
			showRelevant(qdivnext);
			g_qdivnum = g_currentDiv - 1;
			formnext = $(qdivnext + "_form");
		}
	}
	
	function nextpanel() {
		if ( nextEnabled ) {
			if ( g_currentDiv >= 0 ) {
				var qdiv = QStack[g_currentDiv];
				formnext = $(qdiv + "_form");
				if ( formnext != null ) formnext.submit();
				if ( g_currentDiv < nq ) $hide(qdiv);
			}
		}
	}

	////////////////////////////////////////////////////
	
	function disableNext() {
		gNavNextObj.style.backgroundColor = "gray";
		nextEnabled = false;
	}
	function enableNext() {
		gNavNextObj.style.backgroundColor = "darkgreen";
		nextEnabled = true;
	}
	function form_value(stepN,valueHolder) {
		var vv = $(valueHolder).value;
		valueHolderArray[stepN-1] = vv;
		if( !atend ) nq++;
	}
	
	
	function appNamer(dnum) {
		//
		var nn = gLocusRefObj;
		if ( dnum != 1 ) {
			nn = valueHolderArray[dnum-2];
		}
		return(nn);
	}
	
	function form_path(arclink) {
		form_value(g_currentDiv,arclink);
		processQ(g_currentDiv);
	}


	function hideRelevant(formid) {
		var formInfoObj = formSubFieldsObj[formid];
		if ( formInfoObj != null ) {
			var hideArray = formInfoObj.initialHider;
			if ( hideArray != null ) {
				var n = hideArray.length;
				for ( var i = 0; i < n; i++ ) {
					$hide(hideArray[i]);
				}
			}
		}
	}


	function showRelevant(formid) {
	//
		var formObj = formSubFieldsObj[formid]; // The object that contains relevant subpanels.
		if ( formObj == null ) return;
		/////
		var valRep = formObj.valueHolder;		// The name of the field that holds the selector value that id's the subpanel
		var abc = $(valRep).value;
		var fldObj = formObj[abc];				// The information about the subcomponents.

		var n = 0;
		var i = 0;
		
		fieldsArray = formObj.initialHider;		// Hide objects initially hidden.
		if ( fieldsArray != null ) {
			n = fieldsArray.length;
			for ( i = 0; i < n; i++ ) {
				$hide(fieldsArray[i]);
			}
		}

		fieldsArray = fldObj.hider;		// Hide objects specifically hidden by this object.
		if ( fieldsArray != null ) {
			n = fieldsArray.length;
			for ( i = 0; i < n; i++ ) {
				$show(fieldsArray[i]);
			}
		}

		fieldsArray = fldObj.shower;	// Show objects specifically for this information path...
		if ( fieldsArray != null ) {
			n = fieldsArray.length;
			for ( i = 0; i < n; i++ ) {
				$show(fieldsArray[i]);
			}
		}
	}


	function QsendData(finaldiv) {
		var serverops = gQuestionaireServerLocus;
		var appender = '?';
		for ( var i = 1; i <= nq; i++ ) {
			//
			var frm_obj = $((QStack[i] + "_form"));
			var n = frm_obj.length;
			var subserverOps = '';

			for ( var j = 0; j < n; j++ ) {
				var frmel = frm_obj.elements[j];
//
				var anspart = appender;
				var vv = "default";
				if ( frmel.value != null ) {
					vv = frmel.value;
				}
				if ( vv.length == 0 ) vv = "default";
				anspart += frmel.name + '=' + encodeURI(vv);
				appender = '&';
				//
				subserverOps += anspart;
			}
			serverops += subserverOps;
		}

		sendQServerOps(serverops);
	}


	function sendQServerOps(serverops) {
		spanID = gCompletionSpan;
		makeDocRequest(serverops);
	}


