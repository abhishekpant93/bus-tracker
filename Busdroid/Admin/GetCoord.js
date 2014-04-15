var map;
var points=[];
var markers=[];
var icon1;
var icon2;

function renderDirections(result) 
{
  	var directionsRenderer = new google.maps.DirectionsRenderer;
  	directionsRenderer.setMap(map);
  	directionsRenderer.setOptions({suppressMarkers: true});
 	directionsRenderer.setDirections(result);
}

var directionsService = new google.maps.DirectionsService;
function requestDirections(start, end) 
{
  	directionsService.route({
    	origin: start,
    	destination: end,
    	travelMode: google.maps.DirectionsTravelMode.DRIVING
  	}, function(result) {
    	renderDirections(result);
  	});
}






function setAllMap(map) 
{
	for (var i = 0; i < markers.length; i++) 
	{
		markers[i].setMap(map);
	}
}



function addMarker(point) 
{
	var marker = new google.maps.Marker({
    	position: point,
    	map: map
	});

	markers.push(marker);
	google.maps.event.addListener(marker, "click", function () {
	    setAllMap(null);
	    var i;

	    if(points[points.length-1].equals(marker.getPosition()))
	    {
	    	points.splice(points.length-1,1);
	    	for(i=0;i<markers.length;i++)
	    	{
	    		if(markers[i].getPosition().equals(marker.getPosition()))
	    		{
	    			markers.splice(i,1);
	    		}
	    	}
	    }
	    setAllMap(map);

	});
}




function initialize()
{
	icon1 = new    google.maps.MarkerImage("http://maps.google.com/mapfiles/ms/micons/blue.png", new google.maps.Size(32, 32), new google.maps.Point(0, 0), new google.maps.Point(16, 32));
	icon2 = new    google.maps.MarkerImage("http://maps.google.com/mapfiles/ms/micons/red.png", new google.maps.Size(32, 32), new google.maps.Point(0, 0), new google.maps.Point(16, 32));

	map = new google.maps.Map(document.getElementById('map'), {
    	zoom: 4,
      	center: myMean,
      	mapTypeId: google.maps.MapTypeId.ROADMAP
    });

	google.maps.event.addListener(map, 'click', function (event) 
	{
		points.push(event.latLng);
		addMarker(points[points.length - 1]);
	});	
}

function finalRoute()
{
	var marker1 = new google.maps.Marker({
    	position: points[0],
    	icon: icon1,
    	map: map
	});
	var marker2 = new google.maps.Marker({
    	position: points[points.length-1],
    	icon: icon2,
    	map: map
	});
	for(var i=0;i<=points.length-1d;i++)
	{
		var start = points[i];
      	var end = points[i+1];
      	requestDirections(start,end);
	}
}


