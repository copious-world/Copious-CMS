
var centerLatitude = "38.425";
var centerLongitude = "-122.959";

/*
var centerLatitude = "37.4419";
var centerLongitude = "-122.1419";
*/

var gMap;


function addMarker(map,lat,long,message) {
	var loc = new GLatLng(lat, long);
	var marker = new GMarker(loc);

	GEvent.addListener(marker,'click', 
		function() {
			marker.openInfoWindowHtml(message);
		}
	);

	map.addOverlay(marker);
}

var startMapType = G_MAP_TYPE;

function set_page_map_type(mtype) {
	startMapType = mtype;
}

function mapManagerStart(divname,centerLatitude, centerLongitude, startZoom) {
	if ( GBrowserIsCompatible() ) {
		gMap = new GMap2($(divname));
		gMap.addControl(new GSmallMapControl());

		var views = new GMapTypeControl('Map');
		gMap.addControl(views);
		var loc = new GLatLng(centerLatitude, centerLongitude);
		gMap.setCenter(loc, startZoom,startMapType);
		/////////////////
		GEvent.addListener(gMap,"click",function(overlay,latlng) {
			var marker = new GMarker(latlng);
			var message = "You a clicking at: <BR> " + latlng.lat() + "N, " + latlng.lng() + " E";
			GEvent.addListener(marker,'click', 
				function() {
					marker.openInfoWindowHtml(message);
/*
					var zoom = gMap.getZoom() + 1;
					marker.showMapBlowup(zoom,G_SATELLITE_TYPE);
*/
				}
			);
			gMap.addOverlay(marker);
		});
		////
	}
	////
	window.onunload = GUnload;
}


