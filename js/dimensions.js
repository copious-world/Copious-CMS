

function live_page_height() {
	if ( window.innerHeight ) return(window.innerHeight);
	else if ( document.body.clientHeight ) return(document.body.clientHeight);
	return(null);
}


function live_page_width() {
	if ( window.innerWidth ) return(window.innerWidth);
	else if ( document.body.clientWidth ) return(document.body.clientWidth);
	return(null);
}



var g_screenHeight = screen.height;
var g_screenWidth = screen.width;

var g_screenHeight_Live = screen.availHeight;
var g_screenWidth_Live = screen.availWidth;

