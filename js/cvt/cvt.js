// ----------------------------------------------
	var JSwasLoaded = false;
	var JSnonUSwasLoaded = false; 
	var JSnon_EwasLoaded = false;  
	var ShowLic=true; 
	var ToLatin = true;
// ----------------------------------------------

	// Notice: The simple theme does not use all options some of them are limited to the advanced theme
	
	var g_lastChar = "";
	         
	function CopyText(box, parent_box) {          
		var txt = parent_box.value + box.value;
		parent_box.value = txt;
	}

	           
	function saveCaret(elem) {          
		if ( elem.isTextEdit ) {
			elem.caretPos = document.selection.createRange();
		}
	}          
	           
	function insertAtCaret(textElement, newText) {   

		if ( textElement.isTextEdit ) { 

			if ( !textElement.caretPos ) {
				saveCaret(textElement);       
			}

			var caretPos = textElement.caretPos;
			caretPos.text = newText;
			caretPos.select(); 
		} 
	}  




JSwasLoaded = true;

var Pictures = {          
	'1': 'yazhert.gif',                                     
	'2': 'yawert.gif',                                
	'3': 'yashert.gif',                                
	'4': 'yaschert.gif',                               
	'5': 'student.gif',  // AATSEEL Student            
	'6': 'yawert2.gif',                                
	'7': 'yashert2.gif',                               
	'8': 'yashert3.gif',                               
	'9': 'yazhert2.gif',                               
	'10': 'yazhert3.gif',                              
	'11': 'yayuertj.gif',                              
	'30': 'std_ru.gif',                               
	'31': 'std_rutw.gif',                              
	'32': 'alphabet.gif',                              
	'33': 'std_ukr.gif',                               
	'888': 'cyr-lat.gif'
};


      
//////////////////////////////////////////////////////////

var ListName;
        
// var KBDSymbols = "~!@#$%^&*()_+`1234567890-=QWERTYUIOP{}|qwertyuiop[]\\ASDFGHJKL:\"asdfghjkl;'ZXCVBNM<>?zxcvbnm,./";
var RUSymbols = ""; //"����������������������������";
        
var Show_ToLatin = false;


if ( typeof ToLatin != 'undefined' ) {       
  if ( ToLatin )  Show_ToLatin = true;
}       
  

/*
 * Mozilla did not let me use arrow buttons, Home/End, Fx buttons, etc.
 * The solution was for Mozilla do NOT use event.keyCode, use just event.charCode
 * or to issue
 *     if (evt.ctrlKey)		// Separate pressing 'c' from Ctrl/c
 *        return true;
 * and 
 *     if (evt.which == 0)      // To have arrows, etc. work
 *         return true;
  
  
the third argument to changeKey should be a function

   function exampleKeyChecker (keyCode, CurrentKey)
which returns an object 
  { cancelKey: boolean, replaceKey: boolean, newKeyCode: number, newKey:
    string }
Not all properties need to be present, if cancelKey is set to true the
other properties are not needed.
If replaceKey is set to true then at least newKeyCode needs to be set.

Newly found:
Gecko browsers (and many others) have boolean properties of the event
object:-

event.altKey
event.ctrlKey
event.metaKey
event.shiftKey
*/




function changeKey (textControl, evt, keyChecker) {


	if ( CyrFromKbd == 'Off' && KbdVariant != '888')  // regular latin editing
		return true;



	if ( evt.ctrlKey ) return true;
	
	//var keyChecker = eval(keyChecker1); // function name
	

	var keyCode = void 0;

	keyCode = evt.keyCode ? evt.keyCode
								: 
							evt.charCode ?	evt.charCode
												:  
											evt.which ? ( evt.which ) : ( void 0 );

	if ( evt.which == 0 ) return true;




	var CurrentKey;
	if ( keyCode ) {
		CurrentKey = String.fromCharCode(keyCode);
	}

	var keyCheck = keyChecker(keyCode, CurrentKey);
  
	if ( keyCode && window.event && !(window.opera) ) {  // IE

		if ( keyCheck.cancelKey ) {
			return false;
		} else if ( keyCheck.replaceKey ) {
			//
			window.event.keyCode = keyCheck.newKeyCode;
			if ( window.event.preventDefault ) window.event.preventDefault();
			//
			return true;
		} else {
			return true;
		}
	} else if ( typeof textControl.setSelectionRange != 'undefined' ) { // NN

		//
		if ( keyCheck.cancelKey ) {
			//
			if (evt.preventDefault) evt.preventDefault();
			return false;
			//
		} else if ( keyCheck.replaceKey ) {
			//
			// cancel the key event and insert the newKey for the current selection
			if ( evt.preventDefault ) evt.preventDefault();

			var oldSelectionStart = textControl.selectionStart;
			var oldSelectionEnd = textControl.selectionEnd;
			var selectedText = textControl.value.substring(oldSelectionStart, oldSelectionEnd);
			//
			var newText = typeof keyCheck.newKey != 'undefined' ?
											keyCheck.newKey : String.fromCharCode(keyCheck.newKeyCode);
			//
			var scrollTop, scrollLeft;                                            
			if (  ( textControl.type == 'textarea' ) && ( typeof textControl.scrollTop != 'undefined' ) ) {
				scrollTop  = textControl.scrollTop;
				scrollLeft = textControl.scrollLeft;
			}
			textControl.value =               ///    insert text                                    
					textControl.value.substring(0, oldSelectionStart)
					 + newText
					 + textControl.value.substring(oldSelectionEnd);                
			        
			if ( typeof scrollTop != 'undefined' ) {                                
				textControl.scrollTop  = scrollTop;                                 
				textControl.scrollLeft = scrollLeft;                               
			}
			
			// Adjust selection range...                                    
			textControl.setSelectionRange(oldSelectionStart + newText.length,     
										oldSelectionStart + newText.length);
			return false;
		} else return true;
		//
		//
	} else if ( keyCheck.cancelKey ) {          // Other browser:
		//
		if ( evt.preventDefault ) evt.preventDefault();
		return false;
		//
	} else return true;

}



function keyHTML(evt, keyChecker) {

	var keyCode = void 0;

	keyCode = evt.keyCode ? evt.keyCode
								: 
							evt.charCode ?	evt.charCode
												:  
											evt.which ? ( evt.which ) : ( void 0 );

	if ( evt.which == 0 ) return ("");
	/////
	var CurrentKey;
	if ( keyCode ) {
		CurrentKey = String.fromCharCode(keyCode);
	}

	var keyCheck = keyChecker(keyCode, CurrentKey);

	//
	if ( keyCheck.cancelKey ) {
		//
		return "";
		//
	} else if ( keyCheck.replaceKey ) {
		var newText = typeof keyCheck.newKey != 'undefined' ?
										keyCheck.newKey : String.fromCharCode(keyCheck.newKeyCode);
		return (newText);
	}

	return "";
}



function fIE (keyCode, CurrentKey) {
	//
	if ( CyrFromKbd == 'On' ) {
		//
		var arrayExpr = "KbdVariant" + KbdVariant + "['" + CurrentKey + "']";
		var newKeyOut = eval(arrayExpr);
		//
		if ( newKeyOut ) return { replaceKey: true, newKeyCode: newKeyOut.charCodeAt(), newKey: newKeyOut };    
		else return { cancelKey: false };
		//
	} else {
		return { cancelKey: false };
	}
}


var fNN = fIE;


function passthrough(keyCode, CurrentKey) {
	return { replaceKey: true, newKeyCode: keyCode, newKey: CurrentKey };    
}



///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////
///////////////////////////////////////////////////////////////////

function fOther( keyCode, CurrentKey ) {
//
	alert(keyCode + "   " + CurrentKey);
//
  if ( KbdVariant == '888' )  // To Translit
  {
      if (RUSymbols.indexOf(CurrentKey) != -1)
      {
         var newString = KbdVariant888[CurrentKey];
         txtControl.value += newString;
         return { cancelKey: true };         
      }
      else
         return { cancelKey: false };
  }
  else
  {
   if (CyrFromKbd == 'On')
   {
      var newKeyOut = eval("KbdVariant" + KbdVariant)[CurrentKey];
      if (newKeyOut)
      {
         txtControl.value += newKeyOut;
         return { cancelKey: true };
      }
      else
         return { cancelKey: false };
   }
   else
      return { cancelKey: false };
  }   
}



///// ************ End of main, typing related code ******************************
                        // 17 - Ctrl, 123 - F12, 117 - F6, ESC - 27        
                        // IE - standard behavior for TEXTAREA - 
                        // remove all text if press Esc. Can be overridden, unlike Firefox and Opera 9:
                        // Firefox does the same, but only in <input type='text' and not in <textarea          
                        // Opera - since ver 9 - Esc: a) "deselect all" b) input field looses focus   
                        // Opera 7 - can not use F6. So in Opera 7 - use Esc, then from ver 8 - F6
                        
                        
function switchMode(form) {
	//
	if (CyrFromKbd == 'Off') {
		CyrFromKbd = 'On';
		form.fromKbd[0].checked = true; // "On"
	} else {
		CyrFromKbd = 'Off';
		form.fromKbd[1].checked = true;  // "Off"
	}
	txtControl.focus();

}


function ModeSwitchKeyPressed(ev) {
	if ( window.event ) return window.event.keyCode
	else if ( ev ) return ev.which
	else return null;
}


function Kbd_OnOff(form,ev) {
	//
	var mKey = ModeSwitchKeyPressed(ev);

	var swKeyPressed = false;
	if ( Opera ) {
		if ( OperaVer < 8 ) {
			if ( mKey == 27 ) swKeyPressed = true;
		} else {
			if ( mKey == 117 ) swKeyPressed = true;
		}     
	} else {
		if ( mKey == 27 || mKey == 123 ) swKeyPressed = true;
	} 

	if ( swKeyPressed ) {
		if ( typeof UseVirtKbd != 'undefined' ) {
			if ( UseVirtKbd ) switchMode(form);   
		} else {
			switchMode(form);   
		}
	            
		if ( Br == "IE" ) ev.returnValue=false;
	}    
}





function NewKbdPic(name,picture) {
  if (KbdVariant == "888" && interfaceLanguage == 'E') picture = 'cyr-late.gif'; 
  if (window.document.images) window.document.images[name].src = picture;
}

function SetVariant(myForm, sName, variant, PicTagName)
{
  var pic;
  if (variant.value == "0") {variant.value = KbdVariant; txtControl.focus(); return false;}
  
  variant.selected = true;  KbdVariant = variant.value;  txtControl.focus();

  if (KbdPhysical != "EN") // non-US
  {
     if (typeof JSnonUSwasLoaded != 'undefined')
       if (JSnonUSwasLoaded) nonUS_SetVariant(myForm, KbdVariant, PicTagName);
  }
  else
  { 
     pic = Pictures[KbdVariant];
     NewKbdPic(PicTagName, pic);
  }   

  if (sName == "Slayouts")
  {        
     myForm.Flayouts.options[0].selected = true;   
     if (Show_ToLatin)  myForm.Latin.options[0].selected = true;
  }        
  else if (sName == "Flayouts")
  {        
     myForm.Slayouts.options[0].selected = true;   
     if (Show_ToLatin) myForm.Latin.options[0].selected = true;   
  }        
  else     
  {        
        // "Latin" then:
        myForm.Flayouts.options[0].selected = true;
        myForm.Slayouts.options[0].selected = true;
  }        
           
}          



