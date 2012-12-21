/*
	blockbar javascript - toggle blocks and save state in cookies
*/

function blockbar_toggle( targetId, blockId ) {
  if ( document.getElementById ) {
    var target = document.getElementById(targetId);
    var head = document.getElementById("blockbarhead_"+targetId);
    // close all other panels if unique flag set for block bar
    var bar = document.getElementById("block_bar_unique"+blockId)
    var unique = (bar.getAttributeNode("class").value)
    if (unique == "block_unique") {
      var bar2 = document.getElementById("block_bar_panel"+blockId)
      var panel_num = (+bar2.getAttributeNode("class").value)+1
      for (var i=1; i<panel_num; i++){
        block_id = "_block"+blockId+"_sub"+i
        if (document.getElementById(block_id) && (block_id != targetId )){
          if (document.getElementById(block_id).style.display!="none") { 
            var head2= document.getElementById("blockbarhead_"+block_id);
            blockbar_toggleClass(head2, 'collapse');
            document.getElementById(block_id).style.display="none" 
          }  
        }
      }
    }  
    blockbar_toggleClass(head, 'collapse');
    if ( target.style.display == "none" ) {
      target.style.display = "";
    } else {
      target.style.display = "none";
    }
  }

	blockbar_save_state();

}

function blockbar_get_cookie(name) {
  var search_value = name + "="
  var return_value = "";
  if (document.cookie.length > 0) {
    begin = document.cookie.indexOf(search_value)
    if (begin != -1) {
      begin += search_value.length
      end = document.cookie.indexOf(";", begin);
      if (end == -1) end = document.cookie.length;
      return_value=unescape(document.cookie.substring(begin, end))
    }
  }
  return return_value;
}

function blockbar_onload(){
  var bar1 = document.getElementById("block_bar_num")
  var bar_num = (+bar1.getAttributeNode("class").value)+1
  var cookie_name = "", cookie_value = ""
  for (var i=1; i<bar_num; i++){
    var bar2 = document.getElementById("block_bar_sticky"+i)
    var sticky = bar2 ? (bar2.getAttributeNode("class").value) : ""
    cookie_name = "block_bar"+i
    if (sticky == "block_sticky") {
      var cookie_value=blockbar_get_cookie(cookie_name)
      if (cookie_value.length > 0) {
        var panels = cookie_value.split('|')
        for (var j=0; j<panels.length-1; j++) {
          blockbar_toggle(panels[j], i)
        }
      }
    }
  }  
}

function blockbar_save_state(){
  var bar1 = document.getElementById("block_bar_num")
  var bar_num = (+bar1.getAttributeNode("class").value)+1
  var cookie_name = "", cookie_value = "", block_id = ""

  for (var i=1; i<bar_num; i++){
    var bar1 = document.getElementById("block_bar_panel"+i)
    var panel_num = bar1 ? ((+bar1.getAttributeNode("class").value)+1) : 0
    var bar2 = document.getElementById("block_bar_sticky"+i)
    var sticky = bar2 ? (bar2.getAttributeNode("class").value) : ""
    cookie_name = "block_bar"+i
    if (sticky == "block_sticky") {
      for (var j=1; j<panel_num; j++){
        block_id = "_block"+i+"_sub"+j
        if (document.getElementById(block_id)){
          if (document.getElementById(block_id).style.display!="none") {
            cookie_value += block_id+"|" 
          }
        }
      }
    }  
    parent.document.cookie=cookie_name+"="+cookie_value+";path=/"
    cookie_value = ""
  }
}

/*
// Global Killswitch
if (Drupal.jsEnabled) {
  $(document).ready(blockbar_onload);
  if (document.getElementById)
    window.onunload=blockbar_save_state
}
*/


function blockbar_toggleClass(node, className) {
  if (!blockbar_removeClass(node, className) && !blockbar_addClass(node, className)) {
    return false;
  }
  return true;
}

function blockbar_addClass(node, className) {
  if (blockbar_hasClass(node, className)) {
    return false;
  }
  node.className += ' '+ className;
  return true;
}

function blockbar_removeClass(node, className) {
  if (!blockbar_hasClass(node, className)) {
    return false;
  }
  // Replaces words surrounded with whitespace or at a string border with a space. Prevents multiple class names from being glued together.
  node.className = eregReplace('(^|\\s+)'+ className +'($|\\s+)', ' ', node.className);
  return true;
}

function blockbar_hasClass(node, className) {
  if (node.className == className) {
    return true;
  }
  var reg = new RegExp('(^| )'+ className +'($| )')
  if (reg.test(node.className)) {
    return true;
  }
  return false;
}

function eregReplace(search, replace, subject) {
  return subject.replace(new RegExp(search,'g'), replace);
}
