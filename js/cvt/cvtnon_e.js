/* Russian Virtual (on-screen) keyboard - 

  JavaScript file for non-US physical keyboards - addition for English-UI version of the page
                      =========================
                       
  Copyright (c) 2005  Paul Gorodyansky
  
  Implementation: http://Kbd.RusWin.net (http://ourworld.compuserve.com/homepages/PaulGor/onscreen.htm)
  or Russian interface version: 
  http://Klava.RusWin.net (http://ourworld.compuserve.com/homepages/PaulGor/screen_r.htm)

  Paul Gorodyansky - paulgor@compuserve.com, author of the site
  "Cyrillic (Russian): instructions for Windows and Internet": 
  http://ourworld.compuserve.com/homepages/PaulGor/
  ( same as http://RusWin.net )
   
 * This program is distributed in the hope that it will be useful, but
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY
 * or FITNESS FOR A PARTICULAR PURPOSE.    
 *  
 */


JSnon_EwasLoaded = true;


function chgKeyboardE(myForm, k, SelValue, SelIndex, PicTagName)  
{
  //    myForm.Flayouts.options.length=0;
    
    myForm.Keyboards.options[0].text="US English";
    myForm.Keyboards.options[0].value="EN";
    
    myForm.Keyboards.options[SelIndex].selected = true;
    KbdPhysical = SelValue;     
  
    switch (KbdPhysical)                                                        
    {                                                                           
      case "DE":                                                                
          myForm.Flayouts.options.length=3;
          myForm.Slayouts.options.length=2;
          
          myForm.Slayouts.options[0].text="Choose";
          myForm.Slayouts.options[0].value="0";
          myForm.Slayouts.options[1].text="Russian";
          myForm.Slayouts.options[1].value="41";
          
          myForm.Flayouts.options[0].text="Choose";
          myForm.Flayouts.options[0].value="0";
          myForm.Flayouts.options[1].text="German-1";
          myForm.Flayouts.options[1].value="61";          
          myForm.Flayouts.options[2].text="German-2";
          myForm.Flayouts.options[2].value="62";          

          myForm.Flayouts.options[0].selected=true;
          myForm.Slayouts.options[1].selected=true;
          
        break;                                                                  
      case "SV":  // Swedish                                                    
          myForm.Flayouts.options.length=4;
          myForm.Slayouts.options.length=2;
          
          myForm.Slayouts.options[0].text="Choose";
          myForm.Slayouts.options[0].value="0";
          myForm.Slayouts.options[1].text="Russian";
          myForm.Slayouts.options[1].value="42";
          
          myForm.Flayouts.options[0].text="Choose";
          myForm.Flayouts.options[0].value="0";
          myForm.Flayouts.options[1].text="Swedish-1";
          myForm.Flayouts.options[1].value="71";          
          myForm.Flayouts.options[2].text="Swedish-2";
          myForm.Flayouts.options[2].value="72";                    
          myForm.Flayouts.options[3].text="Swedish-3";
          myForm.Flayouts.options[3].value="73";                              

          myForm.Flayouts.options[0].selected=true;
          myForm.Slayouts.options[1].selected=true;
          
        break;                                                                  
      case "FR":                                                                
          myForm.Flayouts.options.length=2;
          myForm.Slayouts.options.length=2;
          
          myForm.Slayouts.options[0].text="Choose";
          myForm.Slayouts.options[0].value="0";
          myForm.Slayouts.options[1].text="Russian";
          myForm.Slayouts.options[1].value="43";
          
          myForm.Flayouts.options[0].text="Choose";
          myForm.Flayouts.options[0].value="0";
          myForm.Flayouts.options[1].text="French-1";
          myForm.Flayouts.options[1].value="81";          

          myForm.Flayouts.options[0].selected=true;
          myForm.Slayouts.options[1].selected=true;
          
        break;                                                                  
      case "IT":  // Italian                                                    
          myForm.Flayouts.options.length=2;
          myForm.Slayouts.options.length=2;
          
          myForm.Slayouts.options[0].text="Choose";
          myForm.Slayouts.options[0].value="0";
          myForm.Slayouts.options[1].text="Russian";
          myForm.Slayouts.options[1].value="44";
          
          myForm.Flayouts.options[0].text="Choose";
          myForm.Flayouts.options[0].value="0";
          myForm.Flayouts.options[1].text="Italian-1";
          myForm.Flayouts.options[1].value="91";          

          myForm.Flayouts.options[0].selected=true;
          myForm.Slayouts.options[1].selected=true;
          
        break;                                                                  
      case "ES":  // Spanish                                                    
          myForm.Flayouts.options.length=2;
          myForm.Slayouts.options.length=2;
          
          myForm.Slayouts.options[0].text="Choose";
          myForm.Slayouts.options[0].value="0";
          myForm.Slayouts.options[1].text="Russian";
          myForm.Slayouts.options[1].value="45";
          
          myForm.Flayouts.options[0].text="Choose";
          myForm.Flayouts.options[0].value="0";
          myForm.Flayouts.options[1].text="Spanish-1";
          myForm.Flayouts.options[1].value="101";          

          myForm.Flayouts.options[0].selected=true;
          myForm.Slayouts.options[1].selected=true;
          
        break;                                                                  
      case "UK":                                                                
          myForm.Flayouts.options.length=2;
          myForm.Slayouts.options.length=2;
          
          myForm.Slayouts.options[0].text="Choose";
          myForm.Slayouts.options[0].value="0";
          myForm.Slayouts.options[1].text="Russian";
          myForm.Slayouts.options[1].value="46";
          
          myForm.Flayouts.options[0].text="Choose";
          myForm.Flayouts.options[0].value="0";
          myForm.Flayouts.options[1].text="British-1";
          myForm.Flayouts.options[1].value="111";          

          myForm.Flayouts.options[0].selected=true;
          myForm.Slayouts.options[1].selected=true;
          
        break;                                                                                                                                                  

      case "IL":                                                                
          myForm.Flayouts.options.length=3;
          myForm.Slayouts.options.length=2;
          
          myForm.Slayouts.options[0].text="Choose";
          myForm.Slayouts.options[0].value="0";
          myForm.Slayouts.options[1].text="Russian";
          myForm.Slayouts.options[1].value="47";
          
          myForm.Flayouts.options[0].text="Choose";
          myForm.Flayouts.options[0].value="0";
          myForm.Flayouts.options[1].text="Hebrew-1";
          myForm.Flayouts.options[1].value="121";          
          myForm.Flayouts.options[2].text="Hebrew-2";
          myForm.Flayouts.options[2].value="122";          

          myForm.Flayouts.options[0].selected=true;
          myForm.Slayouts.options[1].selected=true;
          
        break;                                                                  
                                                                                
      case "EN":                                                                
      default:                                                                  
          myForm.Flayouts.options.length=12;
          myForm.Slayouts.options.length=5;
          
          myForm.Slayouts.options[0].text="Choose from 4";
          myForm.Slayouts.options[0].value="0";
          myForm.Slayouts.options[1].text="Russian";
          myForm.Slayouts.options[1].value="30";
          myForm.Slayouts.options[2].text="Russian (typewriter)";
          myForm.Slayouts.options[2].value="31";
          myForm.Slayouts.options[3].text="Alphabet order";
          myForm.Slayouts.options[3].value="32";
          myForm.Slayouts.options[4].text="Ukrainian";
          myForm.Slayouts.options[4].value="33";          
          
          myForm.Flayouts.options[0].text="Choose from 11";
          myForm.Flayouts.options[0].value="0";
          myForm.Flayouts.options[1].text="YaZHert";
          myForm.Flayouts.options[1].value="1";
          myForm.Flayouts.options[2].text="YaWert";
          myForm.Flayouts.options[2].value="2";
          myForm.Flayouts.options[3].text="YaSHert";
          myForm.Flayouts.options[3].value="3";
          myForm.Flayouts.options[4].text="YaSCHert";
          myForm.Flayouts.options[4].value="4";
          myForm.Flayouts.options[5].text="AATSEEL Student";
          myForm.Flayouts.options[5].value="5";
          myForm.Flayouts.options[6].text="YaWert2";
          myForm.Flayouts.options[6].value="6";
          myForm.Flayouts.options[7].text="YaSHert2";
          myForm.Flayouts.options[7].value="7";
          myForm.Flayouts.options[8].text="YaSHert3";
          myForm.Flayouts.options[8].value="8";          
          myForm.Flayouts.options[9].text="YaZHert2";
          myForm.Flayouts.options[9].value="9";                                                                                
          myForm.Flayouts.options[10].text="YaZHert3";
          myForm.Flayouts.options[10].value="10";
          myForm.Flayouts.options[11].text="YaYuert";
          myForm.Flayouts.options[11].value="11";                    

          myForm.Flayouts.options[5].selected=true;
          myForm.Slayouts.options[0].selected=true;
          
        break;                                                                  
    }
    
    if ( KbdPhysical == "EN" ) {
		
		if ( Show_ToLatin1 ) {
			myForm.Latin.options[0].selected = true;
			myForm.Latin.disabled = false;
		}        
               
       SetVariant(myForm, "Flayouts", myForm.Flayouts.options[5], PicTagName);
		//
    } else {
    
       if (Show_ToLatin1) {
          myForm.Latin.options[0].selected = true;
          myForm.Latin.disabled = true;
       }        
       
       // nonUS_SetVariant(myForm, "init", PicTagName);
       SetVariant(myForm, "Slayouts", myForm.Slayouts.options[1], PicTagName);       
    }
    
    
}       
// Copyright (c) 2005  Paul Gorodyansky http://RusWin.net http://Kbd.RusWin.net


function SelectNonUSkeyboardsE(myForm) {
  myForm.Keyboards.options.length=8;
  
  myForm.Keyboards.options[1].text="German";
  myForm.Keyboards.options[1].value="DE";
  myForm.Keyboards.options[2].text="Swedish";
  myForm.Keyboards.options[2].value="SV";
  myForm.Keyboards.options[3].text="French";
  myForm.Keyboards.options[3].value="FR";
  myForm.Keyboards.options[4].text="Italian";
  myForm.Keyboards.options[4].value="IT";
  myForm.Keyboards.options[5].text="Spanish";
  myForm.Keyboards.options[5].value="ES";
  myForm.Keyboards.options[6].text="Hebrew";
  myForm.Keyboards.options[6].value="IL";  
  myForm.Keyboards.options[7].text="British";
  myForm.Keyboards.options[7].value="UK";  
}


/* Paul Gorodyansky, author of the site
   "Cyrillic (Russian): instructions for Windows and Internet": 
   http://ourworld.compuserve.com/homepages/PaulGor/
   same as http://RusWin.net
*/

