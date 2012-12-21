/*
 *  $Id: demo.js,v 1.10 2007/06/26 13:35:36 source Exp $
 *
 *  This file is part of the OpenLink Software Ajax Toolkit (OAT) project.
 *
 *  Copyright (C) 2005-2007 OpenLink Software
 *
 *  See LICENSE file for details.
 */


var DEMO = {};
window.cal = false;


JSCOMPONENT = {};

JSCOMPONENT.tree = {
	panel:0,
	tab:0,
	div:"tree",
	needs:["tree"],
	cb:function() {
		var t = new OAT.Tree({imagePath:"/sharedimages/",allowDrag:0,onClick:"select",onDblClick:"toggle"});
		t.assign("tree_content",0);
	}
}






DEMO.post = {
	panel:0,
	tab:1,
	div:"post",
	needs:["window"],
	cb:function() {
		window.win = new OAT.Window({close:1,min:0,max:0,width:300,height:0,title:"Post window"},OAT.WindowData.TYPE_AUTO);
		window.win.content.appendChild($("window_content_alpha"));
		window.win.div.style.zIndex = 1000;
		document.body.appendChild(window.win.div);
		OAT.Dom.hide(window.win.div);
		window.win.onclose = function() { OAT.Dom.hide(window.win.div); OAT.Dom.show("window_launch_alpha"); }
		OAT.Dom.attach("window_launch","click",function(){ OAT.Dom.show(window.win.div); OAT.Dom.center(win.div,1,1); OAT.Dom.hide("window_launch_alpha");});
	}
}



DEMO.about = {
	panel:1,
	tab:1,
	div:"about",
	needs:[],
	cb:false
}



DEMO.date = {
	panel:1,
	tab:6,
	div:"date",
	needs:["calendar"],
	cb:function() {
		var c = new OAT.Calendar();
		window.cal = c;
		var openRef = function(event) {
			var callback = function(date) {
				$("calendar_value").innerHTML = date[0]+"/"+date[1]+"/"+date[2];
			}
			var coords = OAT.Dom.position("calendar_value");
			c.show(coords[0],coords[1]+30,callback);
		}
		OAT.Dom.attach("calendar_btn","click",openRef);
	}
}

DEMO.color = {
	panel:1,
	tab:7,
	div:"color",
	needs:["color"],
	cb:function() {
		var c = new OAT.Color();
		var colorRef = function(event) {
			var callback = function(color) { $("color_content").style.backgroundColor = color;}
			var coords = OAT.Dom.position("color_content");
			c.pick(coords[0],coords[1],callback);
		}
		OAT.Dom.attach("color_content","click",colorRef);
	}
}


DEMO.upload = {
	panel:2,
	tab:10,
	div:"upload",
	needs:["upload"],
	cb:function() {
		var ifr = OAT.Dom.create("iframe",{display:"none"});
		ifr.name="ifr";
		document.body.appendChild(ifr);
		var u = new OAT.Upload("GET","","ifr","file");
		$("upload_content").appendChild(u.div);
		u.submitBtn.value = "Upload files";
		u.form.setAttribute("onsubmit","return false;");
		OAT.Dom.attach(u.submitBtn,"click",function(){alert("In real application, clicking this button would upload files to server.");});
	}
}

DEMO.validation = {
	panel:2,
	tab:11,
	div:"validation",
	needs:["validation"],
	cb:function() {
		OAT.Validation.create("validation_numbers",OAT.Validation.TYPE_REGEXP,{regexp:/[0-9]/, min:10, max:10});
		OAT.Validation.create("validation_chars",OAT.Validation.TYPE_REGEXP,{regexp:/[a-z]/i, min:3, max:12});
		OAT.Validation.create("validation_date",OAT.Validation.TYPE_DATE,{});
	}
}

DEMO.dock = {
	panel:1,
	tab:12,
	div:"dock",
	needs:["dock","ws","datasource"],
	cb:function() {
		var d = new OAT.Dock("dock_content",3);
		var colors = ["#99c","#cc9","#c8c","#9c9"];
		var columns = [0,1,2,0];
		var titles = ["Welcome!","News?","Weather forecast","Google"];

		for (var i=0;i<colors.length;i++) {
			d.addObject(columns[i],"dock_"+(i+1),{color:colors[i],title:titles[i],titleColor:"#000"});
		}
		
		/* google search */
		var ds = new OAT.DataSource(OAT.DataSourceData.TYPE_SOAP)
		var wsdl = "/google/services.wsdl";
		ds.connection = new OAT.Connection(OAT.ConnectionData.TYPE_WSDL,{url:wsdl});
		var searchRecieveRef = function(data,index) {
			var cnt = Math.min(data.length,3);
			OAT.Dom.clear("dock_results");
			for (var i=0;i<cnt;i++) {
				var num = OAT.Dom.create("span");
				num.innerHTML = (i+1)+". ";
				$("dock_results").appendChild(num);
				var val = data[i];
				var a = OAT.Dom.create("a");
				a.href = val[0];
				a.innerHTML = val[1];
				$("dock_results").appendChild(a);
				var br = OAT.Dom.create("br");
				$("dock_results").appendChild(br);
			}
		}
		ds.bindPage(searchRecieveRef);
		var searchRef = function() {
			var obj = {
				doGoogleSearch:{
					key:"IGWnqjhQFHKvB8MdJlVI0GPKDJxZhwBf",
					q:$v("dock_q"),
					start:0,
					maxResults:10,
					filter:"",
					restrict:"",
					safeSearch:"",
					lr:"",
					ie:"",
					oe:""
				}
			}
			ds.options.service = "doGoogleSearch";
			ds.options.inputObj = obj;
			ds.outputFields = ["URL","title"];
			ds.reset();
			ds.advanceRecord(0);
		}
		OAT.Dom.attach("dock_search","click",searchRef);
	}
}

DEMO.ticker = {
	panel:1,
	tab:14,
	div:"ticker",
	needs:["ticker"],
	cb:function() {
		var getStartRef = function(i) { return function() { tickerArr[i].start(); }	}
		var getStopRef = function(i) { return function() { tickerArr[i].stop(); }	}
		var textArr = [
			"The United States of America is a federal republic situated primarily in North America. It is bordered on the north by Canada and to the south by Mexico. It comprises 50 states and one federal district, and has several territories with differing degrees of affiliation. It is also referred to, with varying formality, as the U.S., the U.S.A., the U.S. of A., the States, the United States, America, or (poetically) Columbia.",
			"The United Kingdom of Great Britain and Northern Ireland (usually shortened to the United Kingdom, or the UK) occupies part of the British Isles in northwestern Europe, with most of its territory and population on the island of Great Britain. It shares a land border with the Republic of Ireland on the island of Ireland and is otherwise surrounded by the North Sea, the English Channel, the Celtic Sea, the Irish Sea, and the Atlantic Ocean.",
			"The Czech Republic, is a landlocked country in Central Europe. The country has borders with Poland to the north, Germany to the northwest and west, Austria to the south, and Slovakia to the east. Historic Prague, a major tourist attraction, is its capital and largest city.",
			'Republic of Zimbabwe (formerly Rhodesia) is a landlocked country located in the southern part of the continent of Africa, between the Zambezi and Limpopo rivers. It is bordered by South Africa to the south, Botswana to the west, Zambia to the north, and Mozambique to the east. The name Zimbabwe is derived from "dzimba dzamabwe" meaning "stone buildings" in the Shona language.'
		];
		var tickerArr = [];
		for (var i=0;i<4;i++) {
			var opts = {
				loop:OAT.TickerData.LOOP_FULL,
				timing:OAT.TickerData.TIMING_PERCHAR,
				defDelay:20,
				clear:OAT.TickerData.CLEAR_END
			}
			tickerArr.push(new OAT.Ticker("ticker_content",textArr[i],opts));
			var startRef = getStartRef(i);
			var stopRef = getStopRef(i);
			OAT.Dom.attach("ticker_"+i,"mouseover",startRef);
			OAT.Dom.attach("ticker_"+i,"mouseout",stopRef);
		}
	}
}


DEMO.crypto = {
	panel:3,
	tab:16,
	div:"crypto",
	needs:["crypto"],
	cb:function() {
		var cryptoRef = function() {
			var text = $v("crypto_input");
			$("crypto_base64").innerHTML = OAT.Crypto.base64e(text);
			$("crypto_md5").innerHTML = OAT.Crypto.md5(text);
			$("crypto_sha").innerHTML = OAT.Crypto.sha(text);

		}
		OAT.Dom.attach("crypto_input","keyup",cryptoRef);
	}
}

DEMO.stats = {
	panel:3,
	tab:17,
	div:"stats",
	needs:["statistics"],
	cb:function() {
		var statsRef = function() {
			OAT.Dom.clear("stats_content");
			var value = parseInt($v("stats_count"));
			var count = (isNaN(value) ? 20 : value);
			value = parseInt($v("stats_maximum"));
			var max = (isNaN(value) ? 10 : value);
			var data = [];
			for (var i=0;i<count;i++) { data.push(Math.round(Math.random()*(max-1))+1); }
			$("stats_data").innerHTML = data.join(", ");
			/* dynamically walk through all available stats functions */
			for (var i=0;i<OAT.Statistics.list.length;i++) {
				var item = OAT.Statistics.list[i];
				var div = OAT.Dom.create("div");
				var val = OAT.Statistics[item.func](data);
				div.innerHTML = item.longDesc+": "+val;
				$("stats_content").appendChild(div);
			}
		}
		OAT.Dom.attach("stats_btn","click",statsRef);
		statsRef();
	}
}

DEMO.quickedit = {
	panel:2,
	tab:18,
	div:"quickedit",
	needs:["quickedit"],
	cb:function() {
		OAT.QuickEdit.assign("qe_1",OAT.QuickEdit.SELECT,["sir","madam"]);
		OAT.QuickEdit.assign("qe_2",OAT.QuickEdit.STRING,[]);
		OAT.QuickEdit.assign("qe_3",OAT.QuickEdit.SELECT,["information","money","monkey"]);
		OAT.QuickEdit.assign("qe_4",OAT.QuickEdit.STRING,[]);
		OAT.QuickEdit.assign("qe_5",OAT.QuickEdit.STRING,[]);
	}
}

DEMO.combolist = {
	panel:2,
	tab:19,
	div:"combolist",
	needs:["combolist"],
	cb:function() {
		var cl = new OAT.Combolist(["red","green","blue"],"pick your color");
		cl.addOption("your own?","custom");
		$("combolist_content").appendChild(cl.div)
	}
}

DEMO.combobox = {
	panel:2,
	tab:20,
	div:"combobox",
	needs:["combobox"],
	cb:function() {
		var cbx = new OAT.ComboBox("Your browser");
		cbx.addOption("opt_1","Firefox");
		cbx.addOption("opt_2","MSIE");
		cbx.addOption("opt_3","Opera");
		cbx.addOption("opt_4","Netscape");
		$("combobox_content").appendChild(cbx.div);
	}
}

DEMO.combobutton = {
	panel:2,
	tab:21,
	div:"combobutton",
	needs:["combobutton"],
	cb:function() {
		var cb = new OAT.ComboButton();
		cb.addOption("images/cb_1.gif","Down",function(){alert("Down clicked");})
		cb.addOption("images/cb_2.gif","Up",function(){alert("Up clicked");})
		cb.addOption("images/cb_3.gif","Stop",function(){alert("Stop clicked");})
		$("combobutton_content").appendChild(cb.div);
	}
}

DEMO.ajax = {
	panel:3,
	tab:22,
	div:"ajax",
	needs:["ajax2"],
	cb:function() {
		OAT.AJAX.startRef = function(){$("ajax_input").style.backgroundImage = "url(images/progress.gif)";}
		OAT.AJAX.endRef = function(){$("ajax_input").style.backgroundImage = "none";}
		var ajaxBack = function(data) {
			var approx = (data == "0" ? "" : "approximately ");
			$("ajax_output").innerHTML = "Google found "+approx+data+" results matching your query";
		}
		var ajaxRef = function(event) {
			var value = $v("ajax_input");
			if (value.length < 5) { return; }
			OAT.AJAX.GET("ajax.php?q="+value,false,ajaxBack);
		}
		OAT.Dom.attach("ajax_input","keyup",ajaxRef);
	}
}

DEMO.fisheye = {
	panel:1,
	tab:23,
	div:"fisheye",
	needs:["fisheye"],
	cb:function() {
		var fe = new OAT.FishEye("fisheye_content",{bigSize:70,limit:100});
		fe.addImage("images/fe_img1.png");
		fe.addImage("images/fe_img2.png");
		fe.addImage("images/fe_img3.png");
		fe.addImage("images/fe_img4.png");
		fe.addImage("images/fe_img5.png");
		fe.addImage("images/fe_img6.png");
		fe.addImage("images/fe_img7.png");
		fe.addImage("images/fe_img8.png");
		fe.addImage("images/fe_img9.png");
		fe.addImage("images/fe_img10.png");
	}
}

DEMO.ghostdrag = {
	panel:3,
	tab:24,
	div:"gd",
	needs:["ghostdrag"],
	cb:function() {
		var gd = new OAT.GhostDrag();
		gd.addTarget("gd_cart");
		var ids = ["banana","cherry","strawberry","lemon"];
		var names = ["Bananas","Cherries","Strawberries","Lemons"];
		var contents = [0,0,0,0];
		function gdRefresh() {
			OAT.Dom.clear("gd_cart");
			for (var i=0;i<names.length;i++) {
				if (contents[i]) {
					$("gd_cart").innerHTML += names[i]+": "+contents[i]+"<br/>";
				}
			}
		}
		var getGDref = function(index) {
			return function(target,x,y) {
				contents[index]++;
				gdRefresh();
			}
		}
		for (var i=0;i<ids.length;i++) {
			var elm = $("cart_"+ids[i]);
			gd.addSource(elm,function(){},getGDref(i));
		}
		OAT.Dom.attach("gd_clear","click",function(){contents=[0,0,0,0];gdRefresh();});
	}
}

DEMO.window = {
	panel:3,
	tab:25,
	div:"window",
	needs:["window"],
	cb:function() {
		window.win = new OAT.Window({close:1,min:0,max:0,width:300,height:0,title:"Demo window"},OAT.WindowData.TYPE_AUTO);
		window.win.content.appendChild($("window_content"));
		window.win.div.style.zIndex = 1000;
		document.body.appendChild(window.win.div);
		OAT.Dom.hide(window.win.div);
		window.win.onclose = function() { OAT.Dom.hide(window.win.div); OAT.Dom.show("window_launch"); }
		OAT.Dom.attach("window_launch","click",function(){ OAT.Dom.show(window.win.div); OAT.Dom.center(win.div,1,1); OAT.Dom.hide("window_launch");});
	}
}

DEMO.docs = {
	panel:1,
	tab:26,
	div:"docs",
	needs:[],
	cb:false
}
// 

DEMO.mashups = {
	panel:4,
	tab:30,
	div:"out_maps",
	needs:[],
	cb:false
}

DEMO.pivots = {
	panel:4,
	tab:31,
	div:"out_pivot",
	needs:[],
	cb:false
}

DEMO.cursors = {
	panel:4,
	tab:32,
	div:"out_cursors",
	needs:[],
	cb:false
}


DEMO.timeline = {
	panel:1,
	tab:34,
	div:"timeline",
	needs:["timeline","ajax2","xml"],
	cb:function() {
		var tl = new OAT.Timeline("timeline_content",{});
		tl.addBand("JFK","rgb(255,204,153)");
		var callback = function(xmlDoc) {
			var events = OAT.Xml.xpath(xmlDoc,"//event",{});
			for (var i=0;i<events.length;i++)  {
				var e = events[i];

				var a = OAT.Dom.create("div",{left:"-7px"});
				var ball = OAT.Dom.create("div",{width:"16px",height:"16px",cssFloat:"left",styleFloat:"left"});
				ball.style.backgroundImage = "url(/DAV/JS/images/Timeline_circle.png)";
				var t = OAT.Dom.create("span");
				var time = e.getAttribute("title");
				t.innerHTML = time;
				a.appendChild(ball);
				a.appendChild(t);
				var start = e.getAttribute("start");
				var end = e.getAttribute("end");

				tl.addEvent("JFK",start,end,a,"#ddd");
			}
			tl.draw();
			tl.slider.slideTo(0,1);
		}
		OAT.AJAX.GET("jfk.xml",false,callback,{type:OAT.AJAX.TYPE_XML});
		OAT.Dom.attach(window,"resize",tl.sync);
	}
}



DEMO.anchor = {
	panel:1,
	tab:39,
	div:"anchor",
	needs:["anchor","datasource","timeline","ajax2","grid","xmla","sparql","form"],
	cb:function(){
	}
}

DEMO.rss = {
	panel:1,
	tab:40,
	div:"rss",
	needs:["rssreader","ajax2"],
	cb:function() {
		var rss1 = new OAT.RSSReader("rss_content_rss");
		var rss2 = new OAT.RSSReader("rss_content_rdf");
		var ref1 = function(xmlText) { rss1.display(xmlText); }
		var ref2 = function(xmlText) { rss2.display(xmlText); }
		OAT.AJAX.GET("feed_rss.xml",false,ref1);
		OAT.AJAX.GET("feed_rdf.xml",false,ref2);
	}
}



DEMO.tagcloud = {
	panel:2,
	tab:46,
	div:"tagcloud",
	needs:["tagcloud"],
	cb:function() {
		var data = [
			["OAT",13],["Internet",8],["Visualization",3],["Frequency",12],["Hello world!",6],
			["OpenLink",10],["Tag Cloud",5],["Web 2.0",8],["SPARQL",7],["Testing message",4]
		];
		var tc1 = new OAT.TagCloud("tc_1",{});
		var tc2 = new OAT.TagCloud("tc_2",{separator:", ",colorMapping:OAT.TagCloudData.COLOR_CYCLE});
		var tc3 = new OAT.TagCloud("tc_3",{colorMapping:OAT.TagCloudData.COLOR_RANDOM,sizes:["100%"]});
		var tmp = OAT.Dom.create("span");
		tmp.innerHTML = " &bull; ";
		var tc4 = new OAT.TagCloud("tc_4",{sizes:["100%"],separator:tmp.innerHTML});
		for (var i=0;i<data.length;i++) {
			tc1.addItem(data[i][0],"",data[i][1]);
			tc2.addItem(data[i][0],"",data[i][1]);
			tc3.addItem(data[i][0],"",data[i][1]);
			tc4.addItem(data[i][0],"",data[i][1]);
		}
		tc1.draw();
		tc2.draw();
		tc3.draw();
		tc4.draw();
	}
}



function init() {
	var obname;
////
	for ( obname in JSCOMPONENT ) {
		var obj = JSCOMPONENT[obname];
		if (!obj.drawn ) {
			if (obj.cb) {
				OAT.Loader.loadFeatures(obj.needs,(function(job){
						var qobj = job;
						return(function(){qobj.cb();qobj.drawn=true;});
					})(obj),obname
				);
			} else { obj.drawn = true; }
		} /* if not yet included & drawn */
	}


}
