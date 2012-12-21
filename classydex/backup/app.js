
var JSCOMPONENT = {};

JSCOMPONENT.tree = {
	div:"contents",
	needs:["tree","ghostdrag"],
	drawn: false,
	cb: function() {
		try {
			var t = new OAT.Tree({imagePath:"images/",imagePrefix:"",ext:"png",poorMode:false,
								allowDrag:false,onlyOneOpened:false,onDblClick:false,onClick:"select" });
		} catch(e) {
			alert(e.message + "  classified selector");
		}
		t.assign("classified_index",true);
	}
}



function init() {
	var obname;
	for ( obname in JSCOMPONENT ) {
		var obj = JSCOMPONENT[obname];
		if (!obj.drawn ) {
			if (obj.cb) {
				OAT.Loader.loadFeatures(obj.needs,(function(job){
						var qobj = job;
						return(function(){qobj.cb();qobj.drawn=true;});
					})(obj)
				);
			} else { obj.drawn = true; }
		} /* if not yet included & drawn */
	}
////
////
	doctablesize();

}
