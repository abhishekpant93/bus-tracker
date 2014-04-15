
var Map,points=[],locations;
var path=[];
var endpoint,lastPoint,zoom;
google.maps.visualRefresh = true;

function getRoute(){
	var locations;
	$.ajaxSetup({async: false});
	$.post("getRoute.php",
			{},
			function(data){
				locations = JSON.parse(data);
			}
		);
	$.ajaxSetup({async: true});

	if(locations.list.length <= 0){
		$('#heading').append("<br /><br /><h2>No information of the bus is available right now</h2>");

	}
	else{
		$('#main').append("<table class=\"table center-table\"><thead> <tr><th class=\"text-center\">Coordinates</th><th class=\"text-center\">Landmark</th><th class=\"text-center\">Time</th></tr></thead><tbody id=\"busroute\"></tbody>");
		var select = $("#busroute");
		for (var i=locations.list.length-1;i>=0;i--){
			select.append("<tr><td class=\"text-center\">("+locations.list[i].xCoordinate+","+locations.list[i].yCoordinate+")</td><td class=\"text-center\">"+locations.list[i].landmark+"</td><td class=\"text-center\">"+locations.list[i].time+"</td></tr>");
			points[i]=new Array(2);
			points[i][0]=locations.list[i].xCoordinate;
			points[i][1]=locations.list[i].yCoordinate;
		}
		lastPoint = locations.list[locations.list.length-1].time;
	}
}

function renderDirections(result) {
  	var directionsRenderer = new google.maps.DirectionsRenderer;
  	directionsRenderer.setMap(Map);
  	directionsRenderer.setOptions({suppressMarkers: true});
 	directionsRenderer.setDirections(result);
}

var directionsService = new google.maps.DirectionsService;
function requestDirections(start, end) {
  	directionsService.route({
    	origin: start,
    	destination: end,
    	travelMode: google.maps.DirectionsTravelMode.DRIVING
  	}, function(result) {
    	renderDirections(result);
  	});
}

function initializeMap()
{
	if(points.length>0){
	 	var xMean = 0.0;
	  	var yMean = 0.0;

	  	for(var i=0;i<points.length;i++)
	  	{
	    	xMean += parseFloat(points[i][0]);
	    	yMean += parseFloat(points[i][1]);
	  	}
	  
	  	xMean = xMean/parseFloat(points.length);
	  	yMean = yMean/parseFloat(points.length);
	  	zoom=18;
	}
	else{
		var xMean = 22;
		var yMean = 87;
		zoom=5;
	}

	var myMean = new google.maps.LatLng(xMean,yMean);
  	Map = new google.maps.Map(document.getElementById('map')); 
	Map.setZoom(zoom);      // This will trigger a zoom_changed on the map
	Map.setCenter(myMean);
	Map.setMapTypeId(google.maps.MapTypeId.ROADMAP);

    for (var i = 0; i<points.length;i++) {
     	path.push(new google.maps.LatLng(points[i][0],points[i][1]));
    };
    //Displaying the markers
    var marker;
    for (var i = 0; i < path.length; i++) {  
        marker = new google.maps.Marker({
        position: path[i],
        map: Map
      });
    }

    
    //Displaying the path
    for (var i = 0; i<path.length-1; i++) {
      	var start = path[i];
      	var end = path[i+1];
      	requestDirections(start,end);
    }
}

function addNewPoint(point)
{
	path.push(new google.maps.LatLng(point[0],point[1]));
	var marker;
	marker = new google.maps.Marker({
		position: path[path.length-1],
		map: Map
	});
	var start = path[path.length-2];
	var end = path[path.length-1];
	requestDirections(start,end);
}

function addEndPoint(point)
{
	endpoint=new google.maps.LatLng(point[0],point[1]);
	var marker;
	marker = new google.maps.Marker({
		position: endpoint,
		map: Map
	});
}

function getMorePoints(){
	var point;
	$.ajaxSetup({async: false});
	$.post("getMorePoints.php",
			{'last':lastPoint},
			function(data){
				point = JSON.parse(data);
			}
		);
	$.ajaxSetup({async: true});

	if(point.list.length>0){
		lastPoint = point.list[point.list.length-1].time;
		for(var i=0;i<point.list.length;++i){
			var p = new Array(2);
			p[0] = point.list[i].xCoordinate;
			p[1] = point.list[i].yCoordinate;
			$("<tr><td class=\"text-center\">("+point.list[i].xCoordinate+","+point.list[i].yCoordinate+")</td><td class=\"text-center\">"+point.list[i].landmark+"</td><td class=\"text-center\">"+point.list[i].time+"</td></tr>").insertBefore('#busroute > tr:first');
			addNewPoint(p);




		}

	}
}
$(document).ready(function(){
	//alert("Im in");
	getRoute();
	initializeMap();
	 $('#viewmap').on('shown.bs.modal', function () {
	 	lastCenter=Map.getCenter();
        google.maps.event.trigger(Map, 'resize');
        Map.setCenter(lastCenter);
        Map.setZoom(zoom);
	 });
	 //getMorePoints();
	 setInterval(getMorePoints,10000);


});


