var dataobj;
var dataobj2;

var xCoordinate;
var yCoordinate;
var Map,points=[],markers=[];
var icon1;
var icon2;
var i;
var markers;

function renderDirections(result) 
{
  	var directionsRenderer = new google.maps.DirectionsRenderer;
  	directionsRenderer.setMap(Map);
  	directionsRenderer.setOptions({suppressMarkers: true});
 	directionsRenderer.setDirections(result);
}

var directionsService;
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

function addMarker(p)
{
	var marker = new google.maps.Marker({
    	position: points[i],
    	map: Map
		});
		markers.push(marker);
}

function getRoute()
{
	var marker1 = new google.maps.Marker({
    	position: points[0],
    	icon: icon1,
    	map: Map
	});
	var marker2 = new google.maps.Marker({
    	position: points[points.length-1],
    	icon: icon2,
    	map: Map
	});

	for(i=0;i<points.length-1;i++)
	{
		var start = points[i];
      	var end = points[i+1];
      	requestDirections(start,end);
	}
	//var marker=new Array(size-2);
	for(i=1;i<points.length-1;i++)
	{
		addMarker(points[i]);
	}
}



function initializeMap(){
	var myMean = new google.maps.LatLng(22,87);
	Map = new google.maps.Map(document.getElementById('map')); 
	Map.setZoom(4);      // This will trigger a zoom_changed on the map
	Map.setCenter(myMean);
	Map.setMapTypeId(google.maps.MapTypeId.ROADMAP);

	directionsService = new google.maps.DirectionsService;
	icon1 = new    google.maps.MarkerImage("http://maps.google.com/mapfiles/ms/micons/blue.png", new google.maps.Size(32, 32), new google.maps.Point(0, 0), new google.maps.Point(16, 32));
	icon2 = new    google.maps.MarkerImage("http://maps.google.com/mapfiles/ms/micons/red.png", new google.maps.Size(32, 32), new google.maps.Point(0, 0), new google.maps.Point(16, 32));

}


function GetRoutes()
{
	var noRoutes="send";
	var $select = $("#rid");
	$.ajaxSetup({async:false});
	$.post("busRegister.php",
	    {'QUERY':noRoutes},
	    function(data)
	    {
		    dataobj = JSON.parse(data);

		    if(dataobj.status === 'success')
		    {
			    for(var i=0;i<dataobj.list.length;i++)
			    {
			    	$select.append($('<option></option>').val(dataobj.list[i].routeName).html(dataobj.list[i].routeName));
			    }
		    }
	    });
	$.ajaxSetup({async:true});
}

function getPoints (rid) 
{
	$.ajaxSetup({async:false});
	$.post("viewRoute2.php",
	    {'rid':rid},
	    function(data){
	    	dataobj2 = JSON.parse(data);
	    	if(dataobj2.status === 'success'){
	    		points=[];
	    		markers=[]
	    		for(var i=0;i<dataobj2.list.length;i++)
	    		{
	    			var point = new google.maps.LatLng(dataobj2.list[i].xCoordinate,dataobj2.list[i].yCoordinate);
	    			points.push(point);
	    		}

	    		getRoute();
	    	}
	    	else{
	    		alert("No coordinates to display");
	    	}
	    });

	$.ajaxSetup({async:true});
}


$(document).ready(function()
{
	GetRoutes();
	initializeMap();

	$('#viewButton').click(function()
	{
		Map = new google.maps.Map(document.getElementById('map'));
		Map.setZoom(4);      // This will trigger a zoom_changed on the map
		//Map.setCenter(myMean);
		Map.setMapTypeId(google.maps.MapTypeId.ROADMAP); 
		var ridi = $('#rid :selected').index();
		var rid = dataobj.list[ridi].routeID;
		getPoints(rid);
	});
});