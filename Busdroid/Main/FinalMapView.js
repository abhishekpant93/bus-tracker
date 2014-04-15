var path=[];
var map;
var endpoint;

function renderDirections(result) {
  	var directionsRenderer = new google.maps.DirectionsRenderer;
  	directionsRenderer.setMap(map);
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


function initializeMap(points)
{
 	var xMean = 0;
  	var yMean = 0;

  	for(var i=0;i<points.length;i++)
  	{
    	xMean += points[i][0];
    	yMean += points[i][1];
  	}
  
  	xMean /= points.length;
  	yMean /= points.length;

    var myMean = new google.maps.LatLng(xMean, yMean);
  	var map = new google.maps.Map(document.getElementById('map'), {
      	zoom: 15,
      	center: myMean,
      	mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    for (var i = 0; i<points.length;i++) {
     	path.push(new google.maps.LatLng(points[i][0],points[i][1]));
    };

    //Displaying the markers
    var marker;
    for (var i = 0; i < path.length; i++) {  
        marker = new google.maps.Marker({
        position: path[i],
        map: map
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
		map: map
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
		map: map
	});
}