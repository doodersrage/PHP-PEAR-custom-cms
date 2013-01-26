
    //<![CDATA[

    function load() {
      if (GBrowserIsCompatible()) {
      	
		// A TextualZoomControl is a GControl that displays textual "Zoom In"
// and "Zoom Out" buttons (as opposed to the iconic buttons used in
// Google Maps).
function TextualZoomControl() {
}
TextualZoomControl.prototype = new GControl();

// Creates a one DIV for each of the buttons and places them in a container
// DIV which is returned as our control element. We add the control to
// to the map container and return the element for the map class to
// position properly.
TextualZoomControl.prototype.initialize = function(map) {
  var container = document.createElement("div");

  map.getContainer().appendChild(container);
  return container;
}

// By default, the control will appear in the top left corner of the
// map with 7 pixels of padding.
TextualZoomControl.prototype.getDefaultPosition = function() {
  return new GControlPosition(G_ANCHOR_TOP_LEFT, new GSize(7, 7));
}

		var map = new GMap2(document.getElementById("map"));
		map.addControl(new GSmallMapControl());
		map.addControl(new GMapTypeControl());
		map.addControl(new TextualZoomControl());
        map.setCenter(new GLatLng(38.92493,-77.22496), 13);
		var point = new GPoint(parseFloat(-77.22496),parseFloat(38.92493));
        var marker = new GMarker(point);
		map.addOverlay(marker);
		
		var map = new GMap2(document.getElementById("map1"));
		map.addControl(new GSmallMapControl());
		map.addControl(new GMapTypeControl());
		map.addControl(new TextualZoomControl());
        map.setCenter(new GLatLng(39.92045,-75.003103), 13);
		var point = new GPoint(parseFloat(-75.003103),parseFloat(39.92045));
        var marker = new GMarker(point);
		map.addOverlay(marker);

		var map = new GMap2(document.getElementById("map2"));
		map.addControl(new GSmallMapControl());
		map.addControl(new GMapTypeControl());
		map.addControl(new TextualZoomControl());
        map.setCenter(new GLatLng(37.97575, 23.75250), 13);
		var point = new GPoint(parseFloat(23.75250),parseFloat(37.97575));
        var marker = new GMarker(point);
		map.addOverlay(marker);

// Place a marker in the center of the map and open the info window
// automatically
var marker = new GMarker(map.getCenter());
GEvent.addListener(marker, "click", function() {
  marker.openInfoWindowTabsHtml(infoTabs);
});
map.addOverlay(marker);
marker.openInfoWindowTabsHtml(infoTabs);
	  }
    }

    //]]>

