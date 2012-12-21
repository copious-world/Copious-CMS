
	function languageChange(ll) {
		//
		g_sec_lang = 2;
		if ( ll == "Russian" ) {
			fName = saveName;
			CyrFromKbd = 'On';
		} else {
			fName = passthrough;
			CyrFromKbd = 'Off';
			g_sec_lang = 1;
		}
		//
	}

	function initLangchoice() {
		$('langchoice').value = "English";
		languageChange($('langchoice').value);
	}

	if ( !JSwasLoaded ) {
		alert("Error! Included JS file not found ...");
	}


	var CyrFromKbd = 'Off';
	var interfaceLanguage = 'E';
	var KbdVariant = '5';

	var KbdPhysical = "EN";

	var fName;
	var WrongBr=false;

	if ( Br == "IE" ) fName=fIE;
	else if ( Br == "NN" ) fName=fNN;
	else {
		WrongBr = true;
		fName="fOther";
	}


	if ( ( Br == "IE" ) && !Opera ) {
	}
	
	var saveName = fName;
	fName = passthrough;


