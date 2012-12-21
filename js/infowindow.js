////
var featureList=["dialog"];
var popRef = "urlselections";
var INFOGROUP = {};
var session_id = 0;

var JSLATECOMPONENT = {};


var window_refocus_operation = null;


function clear_late_components() {
	JSLATECOMPONENT = {};
}



function universalWindow(owner,titlestr,substance,effector,eventname) {

	var targetdiv = $("urlselections");	

	var xv = targetdiv.offsetLeft;
	var yv = targetdiv.offsetTop;
	var ww = targetdiv.offsetWidth;

	var win = new OAT.Window({close:1,min:0,max:0,x:xv,y:yv,width:ww,height:-1,title:titlestr,viz:0},OAT.WindowData.TYPE_AUTO);
	win.content.appendChild($(substance));
	win.div.style.zIndex = 1000;
	win.content.style.zIndex = 1001;

	OAT.Dom.applyStyleString(win.move,"height:20px;border: 1px solid gold;backgroundColor:darkgreen;color:gold;");
	document.body.appendChild(win.div);
	OAT.Dom.hide(win.div);

	owner.wind = win;

	owner.wind.onclose = function() {
						var holdW = owner.wind.div.offsetWidth;
						if ( owner.hasOwnProperty('save_width') ) {
							owner.save_width = holdW;
						}
						OAT.Dom.hide(owner.wind.div);
					}

	if ( effector != null ) {
		var repsonder = function(){ 
			var targetdiv = document.getElementById(popRef);
			var win = owner.wind;

			var xv = targetdiv.offsetLeft;
			var yv = targetdiv.offsetTop;
			var ww = targetdiv.offsetWidth;

			if ( owner.hasOwnProperty('save_width') ) {
				if ( owner.save_width > 0 ) ww = owner.save_width;
			}
			if ( owner.hasOwnProperty('app_action') ) {
				if ( owner.app_action != null ) owner.app_action();
				//
				if ( owner.hasOwnProperty('dontOpen') ) { // usually, the last action may determine that this can't procede.
					if ( owner.dontOpen ) {
						owner.dontOpen = false;
						return;
					}
				}
			}

			win.div.style.left = xv + "px";
			win.div.style.top = yv + "px";
			win.div.style.width = ww + "px";
			win.move.style.width = ww + "px";

			win.div.style.zIndex = OAT.Dom.maxZ(win.div.style.zIndex);
			win.content.childNodes[0].className = "topicclass-viz";
			////
			OAT.Dom.show(win.div);

		}
		if ( effector.constructor.toString().indexOf("Array") > -1 ) {
			var n = effector.length;
			for ( var i = 0; i < n; i++ ) {
				var addeffector = effector[i];
				OAT.Dom.attach(addeffector,eventname,repsonder);
			}
		} else {
			OAT.Dom.attach(effector,eventname,repsonder);
		}
	}
	return(win);
}






var popperFuncts = new Object();

function quickPopup(owner,titlestr,substance,effectorList,eventname) {

	var xv = 0;
	var yv = 0;
	var ww = "200";

	var win = new OAT.Window({close:1,min:0,max:0,x:xv,y:yv,width:ww,height:-1,title:titlestr,viz:0},OAT.WindowData.TYPE_AUTO);
	win.content.appendChild($(substance));
	win.div.style.zIndex = 1000;

	OAT.Dom.applyStyleString(win.move,"height:20px;border: 1px solid gold;backgroundColor:darkgreen;color:gold;")
	document.body.appendChild(win.div);
	OAT.Dom.hide(win.div);

	owner.wind = win;

	owner.wind.onclose = function() { OAT.Dom.hide(owner.wind.div); }

	var n = effectorList.length;
	if ( n ) {
		var targetdiv = $(effectorList[0]);	
		var ww = (targetdiv.offsetWidth)*2;

		for ( var i = 0; i < n; i++ ) {
			(function(){
				var effector = effectorList[i];
				popperFuncts[effector] = function(event){
					//
					targetdiv = $(effector);
						//var tObj = event.relatedTarget;
					try {
						var abc = targetdiv.innerHTML;

						var c = '"';
						if ( MSIE ) {
							c = "=";
						}
						abc = abc.split(c,2);
						abc = abc[1];

						if ( MSIE ) {
							abc = abc.substring(0,3);
							var p = abc.lastIndexOf('>');
							if ( p > 0 ) {
								abc = abc.substring(0,p);
							}
						}

						var daySpan = $(abc);
						var seldate = daySpan.innerHTML;

						var eventPos = seldate.indexOf("E");

						if ( eventPos > 0 ) {
							var tmp = seldate.split(" ");
							seldate = tmp[0];
							var win = owner.wind;

							//
							var xv = event.clientX;
							var yv = event.clientY;
		
							win.div.style.left = ( xv - 2 ) + "px";
							win.div.style.top = yv + "px";
							var ww = OAT.Dom.getWH(win.div);
							win.move.style.width = ww[0] + "px";

							win.content.innerHTML = eventDescription(seldate);

							win.caption.innerHTML = winShade_dateTitle(seldate);
							//$(substance).className = "topicclass-viz";
							//$(substance).style.width = "90%";
							//$(substance).style.height = "95%";
	
							win.div.style.zIndex = OAT.Dom.maxZ(win.div.style.zIndex);
							win.content.childNodes[0].className = "topicclass-viz";
							////
							OAT.Dom.show(win.div);

						}
					} catch ( e ) {
						alert(e.message);
					}
				}
				OAT.Dom.attach(effector,eventname,popperFuncts[effector]);
			})();
		}

	}

	return(win);
}


var showWindowOperationLoc = true;

function showWindowProc(vardata) {
	if ( showWindowOperationLoc ) {
		var targetdiv = document.getElementById(popRef);
	
		var owner = INFOGROUP[vardata];
		var win = owner.wind;
	
		var xv = targetdiv.offsetLeft;
		var yv = targetdiv.offsetTop;
		var ww = targetdiv.offsetWidth;
	
		if ( owner.hasOwnProperty('save_width') ) {
			if ( owner.save_width > 0 ) ww = owner.save_width;
		}
		if ( owner.hasOwnProperty('app_action') ) {
			if ( owner.app_action != null ) owner.app_action();
			//
			if ( owner.hasOwnProperty('dontOpen') ) { // usually, the last action may determine that this can't procede.
				if ( owner.dontOpen ) {
					owner.dontOpen = false;
					return;
				}
			}
		}

		win.div.style.left = xv + "px";
		win.div.style.top = yv + "px";
		win.div.style.width = ww + "px";
		win.move.style.width = ww + "px";

		win.div.style.zIndex = OAT.Dom.maxZ(win.div.style.zIndex);
		win.content.childNodes[0].className = "topicclass-viz";
		////
		OAT.Dom.show(win.div);
	} else {
		if ( window_refocus_operation != null ) {
			window_refocus_operation(vardata);
		}
	}
}


function hideWindowProc(vardata) {
	var owner = INFOGROUP[vardata];
	var win = owner.wind;
	OAT.Dom.hide(win.div);
}


function info_window_init() {
	var obname;
	for ( obname in INFOGROUP ) {
		var obj = INFOGROUP[obname];

		if (!obj.drawn) {
			if (obj.cb) {
				OAT.Loader.loadFeatures(obj.needs,(function(job){
						var qobj = job;
						return(function(){qobj.cb();qobj.drawn=true;});
					})(obj)
				);
			} else { obj.drawn = true; }
		} /* if not yet included & drawn */
	}
}


function late_info_window_init() {
	var obname;
	for ( obname in JSLATECOMPONENT ) {
		var obj = JSLATECOMPONENT[obname];
		/*
		if (!obj.drawn) {
			if (obj.cb) {
				OAT.Loader.loadFeatures(obj.needs,(function(job){
						var qobj = job;
						return(function(){qobj.cb();qobj.drawn=true;});
					})(obj)
				);
			} else { obj.drawn = true; }
		}  if not yet included & drawn */

		obj.cb();
	}
}


var init_list_all = {};
init_list_all["info_window_init"] = info_window_init;

function init() {
	for ( init in init_list_all ) {
		var initfunc = init_list_all[init];
		initfunc();
	}
}

