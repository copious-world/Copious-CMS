/* Cyrillic Virtual (on-screen) keyboard - JavaScript file
   Copyright (c) 2005  Paul Gorodyansky
  
  Implementation: http://Kbd.RusWin.net (http://ourworld.compuserve.com/homepages/PaulGor/onscreen.htm)
     or Russian interface version: 
  http://Klava.RusWin.net (http://ourworld.compuserve.com/homepages/PaulGor/screen_r.htm)

  Author's site - "Cyrillic (Russian): instructions for Windows and Internet": 
  http://ourworld.compuserve.com/homepages/PaulGor/
  ( same as http://RusWin.net )
   
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.    
 *  
 *      This JavaScript code is for
 *
 *      Virtual Cyrillic Keyboard - with standard and phonetic layouts -
 *      works with MS Internet Explorer, Opera 8 and newer and with
 *      Mozilla software:
 *      Mozilla ver. 1.3 or higher, Netscape 7.1 or newer, FireFox
 *
 *
 *      Mode: 'as at home with MS Word' - input/edit text normally using 
 *      physical keyboard.
 *      In addition, one can use a mouse with a layout picture to place a
 *      letter into needed position.
 *
 *
 *  This is the first Vurtual Keyboard (that provides physical keyboard input)
 *  with a programming code suitable for all three browser brands:
 *  Internet Explorer, Opera and Mozilla
 *
 *  That is, this code for such "on-the-fly" input/editing is *original* -
 *  both keyboard-based and mouse-based parts -
 *  I could not use any code of older Virtual Keyboards because their programming
 *  code was working only under Internet Explorer.
 *  Also older mouse-based Keyboards were not suitable for normal text input/editing -
 *  they placed a new letter only at the end of the text, thus no text
 *  editing/correction was possible.
 *
 */

alert("LOADING");


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
var RUSymbols = "ÀÁÂÃÄÅ¨ÆÇÈÉÊËÌÍÎÏĞÑÒÓÔÕÖ×ØÙÚÛÜİŞßàáâãäå¸æçèéêëìíîïğñòóôõö÷øùúûüışÿ";
        
var Show_ToLatin = false;
if (typeof ToLatin != 'undefined')
{       
  if (ToLatin)  Show_ToLatin = true;
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


function changeKey (textControl, evt, keyChecker1)
{

alert( keyChecker1);

	if ( CyrFromKbd == 'Off' && KbdVariant != '888')  // regular latin editing
		return true;
		
	if ( evt.ctrlKey ) return true;
	


	var keyChecker = eval(keyChecker1); // function name
	var keyCode = void 0;

	keyCode = evt.keyCode ? 
						(	evt.keyCode
						 : 
							( evt.charCode ? 
								(	evt.charCode
								:  
									( evt.which ? ( evt.which ) 
												: ( void 0 )
									)
							)
						);   

alert(keyCode + "   " + keyChecker1);

	if ( evt.which == 0 ) return true;
			
	var CurrentKey;
	if ( keyCode ) {
		CurrentKey = String.fromCharCode(keyCode);
	}

	var keyCheck = keyChecker(keyCode, CurrentKey);
  
	if ( keyCode && window.event && !window.opera ) {  // IE
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
	} else if ( keyCheck.cancelKey ) {          // Other browser:
		//
		if ( evt.preventDefault ) evt.preventDefault();
		return false;
		//
	} else return true;

}


function fIE (keyCode, CurrentKey) {
 
  if (KbdVariant == '888')  // To Translit
  {
      if (RUSymbols.indexOf(CurrentKey) != -1)
      {
         if ( txtControl.isTextEdit )
         {
             var newString = KbdVariant888[CurrentKey];
             insertAtCaret(txtControl, newString);
         }
         return { cancelKey: true };         
      }
      else
         return { cancelKey: false };
  }
  else       // Regular           
  {
   if (CyrFromKbd == 'On')
   {
       var newKeyOut = eval("KbdVariant" + KbdVariant)[CurrentKey];
       if (newKeyOut)
         return { replaceKey: true, newKeyCode: newKeyOut.charCodeAt(), newKey: newKeyOut };    
       else
         return { cancelKey: false };
   }
   else
      return { cancelKey: false };
  }   
}
  // Copyright (c) 2005  Paul Gorodyansky http://RusWin.net http://Klava.RusWin.net
function fNN (keyCode, CurrentKey) {

  if (KbdVariant == '888')  // To Translit
  {
      if (RUSymbols.indexOf(CurrentKey) != -1)
      {
          return { replaceKey: true, newKeyCode: keyCode, newKey:
                   KbdVariant888[CurrentKey] };
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
         return { replaceKey: true, newKeyCode: keyCode, newKey: newKeyOut };
       else
         return { cancelKey: false };
   }
   else 
      return { cancelKey: false };
  } 
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



/************ End of main, typing related code *************************************/
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




 
var Mouse30 = "¨!\"¹;%:?*()_+ÉÖÓÊÅÍÃØÙÇÕÚ/ÔÛÂÀÏĞÎËÄÆİ/|ß×ÑÌÈÒÜÁŞ,¸1234567890-=éöóêåíãøùçõú\\ôûâàïğîëäæı\\\\ÿ÷ñìèòüáş.";
var Mouse31 = "+1234567890=\\ÉÖÓÊÅÍÃØÙÇÕÚ(ÔÛÂÀÏĞÎËÄÆİ(|ß×ÑÌÈÒÜÁŞ¨|¹-/\":,._?%!;éöóêåíãøùçõú)ôûâàïğîëäæı)\\ÿ÷ñìèòüáş¸";
var Mouse32 = "~!@#$%^&*()_+ÀÁÂÃÄÅ¨ÆÇÈÉÊ|ËÌÍÎÏĞÑÒÓÔÕ||Ö×ØÙÚÛÜİŞß`1234567890-=àáâãäå¸æçèéê\\ëìíîïğñòóôõ\\\\ö÷øùúûüışÿ";
var Mouse33 = "¨!\"¹;%:?*()_¥ÉÖÓÊÅÍÃØÙÇÕ¯/Ô²ÂÀÏĞÎËÄÆª/¥ß×ÑÌÈÒÜÁŞ,¸1234567890-´éöóêåíãøùçõ¿\\ô³âàïğîëäæº\\´ÿ÷ñìèòüáş.";
var Mouse34 = "¨!\"¹;%:?*()_+ÉÖÓÊÅÍÃØÙÇÕÚ/ÔÛÂÀÏĞÎËÄÆİ/>ß×ÑÌÈÒÜÁŞ,¸1234567890-=éöóêåíãøùçõú\\ôûâàïğîëäæı\\<ÿ÷ñìèòüáş.";

var Mouse1  = "Ş!úÚ$%¸¨*()_ÜßÆÅĞÒÛÓÈÎÏØÙİÀÑÄÔÃ×ÉÊË:\"İ|ÇÕÖÂÁÍÌ<>?ş1234567890-üÿæåğòûóèîïøùıàñäôã÷éêë;'ı\\çõöâáíì,./";
var Mouse2  = "Ş!úÚ$%¸¨*()_ÜßÂÅĞÒÛÓÈÎÏØÙİÀÑÄÔÃ×ÉÊË:\"İ|ÇÕÖÆÁÍÌ<>?ş1234567890-üÿâåğòûóèîïøùıàñäôã÷éêë;'ı\\çõöæáíì,./";
var Mouse3  = "Ş!úÚ$%¸¨*()_ÜßØÅĞÒÛÓÈÎÏÆÙİÀÑÄÔÃ×ÉÊË:\"İ|ÇÕÖÆÁÍÌ<>?ş1234567890-üÿøåğòûóèîïæùıàñäôã÷éêë;'ı\\çõöæáíì,./";
var Mouse4  = "Ş!úÚÜ%¸¨*()_+ßÙÅĞÒÛÓÈÎÏÆØİÀÑÄÔÃ×ÉÊË:\"İ|ÇÕÖÂÁÍÌ<>?ş1234567890-=ÿùåğòûóèîïæøıàñäôã÷éêë;üı\\çõöâáíì,./";
var Mouse5  = "¨!@#\":^&*()_ÚßØÅĞÒÛÓÈÎÏŞÙİÀÑÄÔÃ×ÉÊËÜÆİ|ÇÕÖÂÁÍÌ<>?¸1234567890-úÿøåğòûóèîïşùıàñäôã÷éêëüæı\\çõöâáíì,./";
var Mouse6  = "Ş!@úÚ%¸¨*()_×ßÂÅĞÒÛÓÈÎÏØÙİÀÑÄÔÃÕÉÊË:\"İ|ÇÜÖÆÁÍÌ<>?ş1234567890-÷ÿâåğòûóèîïøùıàñäôãõéêë;'ı\\çüöæáíì,./";
var Mouse7  = "¨!-#$%^&*()İÙßØÅĞÒÛÓÈÎÏŞÚ|ÀÑÄÔÃÕÉÊË×Æ||ÇÜÖÂÁÍÌ<>?¸1234567890ıùÿøåğòûóèîïşú\\àñäôãõéêë÷æ\\\\çüöâáíì,./";
var Mouse8  = "Ú!\"¹=%'+*()_ÙßØÅĞÒÛÓÈÎÏŞİ¨ÀÑÄÔÃÕÉÊË×Ü¨|ÇÆÖÂÁÍÌ;:?ú1234567890-ùÿøåğòûóèîïşı¸àñäôãõéêë÷ü¸\\çæöâáíì,./";
var Mouse9  = "Ş!@úÚ%¸¨*()_×ßÆÅĞÒÛÓÈÎÏØÙİÀÑÄÔÃÕÉÊË:\"İ|ÇÜÖÂÁÍÌ<>?ş1234567890-÷ÿæåğòûóèîïøùıàñäôãõéêë;'ı\\çüöâáíì,./";
var Mouse10  = "Ş!\"#?%\\/*()_ÚßÆÅĞÒÛÓÈÎÏØÙİÀÑÄÔÃÕÉÊË×¨İ|ÇÜÖÂÁÍÌ;:Úş1234567890-úÿæåğòûóèîïøùıàñäôãõéêë÷¸ı\\çüöâáíì,.ú";
var Mouse11 = "¨!\"#;%:?*()_+ßŞÅĞÒÉÓÈÎÏÛÚ|ÀÑÄÔÃÕÆÊË×Ö||ÇÙØÂÁÍÌÜ,İ¸1234567890-=ÿşåğòéóèîïûú\\àñäôãõæêë÷ö\\\\çùøâáíìü.ı";

              

function fromAlphabet(LetNumber, evt)
{
  var CurrentKey; 
  if (  KbdVariant != 888  )
  {
    var ListName;
    if (KbdVariant < 60 && KbdVariant > 40)  // non-US: std_ru layout for larger physical keyboard is the same for every language
    {
      if (KbdPhysical == "UK")       // |\ on the button in the bottom left
         ListName = Mouse30;
      else                           // <> on the button in the bottom left
         ListName = Mouse34;
    } 
    else
     ListName = eval("Mouse" + KbdVariant);
     
    var ShiftNum = 49;
        
    if (evt.shiftKey)
        CurrentKey =  ListName.charAt(LetNumber);
    else
        CurrentKey =  ListName.charAt(LetNumber+ShiftNum);
    
    txtControl.focus();

    if (Br == "NN")
    {
       if (typeof txtControl.setSelectionRange != 'undefined')
       {
         var oldSelectionStart = txtControl.selectionStart;
         var oldSelectionEnd = txtControl.selectionEnd;
         var selectedText = txtControl.value.substring(oldSelectionStart, oldSelectionEnd);
         var newText = CurrentKey;
         
         var scrollTop, scrollLeft;                                            
         if (txtControl.type == 'textarea' &&                                  
             typeof txtControl.scrollTop != 'undefined')                       
         {                                                                     
            scrollTop  = txtControl.scrollTop;                                 
            scrollLeft = txtControl.scrollLeft;  
         }                                                                     
         txtControl.value =                                                                                 
                  txtControl.value.substring(0, oldSelectionStart) +                                        
                  newText +                                                                                 
                  txtControl.value.substring(oldSelectionEnd);                                              
                                                                                                            
         if (typeof scrollTop != 'undefined')                                                               
         {                                                                                                  
            txtControl.scrollTop  = scrollTop;                                                              
            txtControl.scrollLeft = scrollLeft;                                                            
         }                                                                                                  
         txtControl.setSelectionRange(oldSelectionStart + newText.length,                                   
                                      oldSelectionStart + newText.length);                                  
       }
    }
    else if (Br == "IE")
         { 
            insertAtCaret(txtControl,CurrentKey);
         }
         else
            txtControl.value += CurrentKey;
   } 
}


/* Paul Gorodyansky, author of the site
   "Cyrillic (Russian): instructions for Windows and Internet": 
   http://ourworld.compuserve.com/homepages/PaulGor/
   same as http://RusWin.net
*/

