var xCoordinate;
var yCoordinate;
var Map,points=[],markers=[];
var icon1;
var icon2;
var done=0;
function renderDirections(result) 
{
  	var directionsRenderer = new google.maps.DirectionsRenderer;
  	directionsRenderer.setMap(Map);
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


function getCoordinates(landmark)
{
  var landmarkElements = landmark.split(" ");

  var str = landmarkElements[0];

  for(var i = 1;i<landmarkElements.length;i++)
  {
    str+="+";
    str+=landmarkElements[i];
  }

  $.ajaxSetup({async: false});
  $.getJSON("https://maps.googleapis.com/maps/api/geocode/json?address="+str+"&sensor=true&key=AIzaSyCfAM0LMerGH_Srit5N-1yw1LAuDIjx_aA" , function(data) {
    xCoordinate = data.results[0].geometry.location.lat;
    yCoordinate = data.results[0].geometry.location.lng;
  });
  $.ajaxSetup({async: true});
}

function getLandmark(coordinates)
{
  var landmark;
  $.ajaxSetup({async: false});
  $.getJSON("https://maps.googleapis.com/maps/api/geocode/json?latlng="+coordinates[0]+","+coordinates[1]+"&sensor=true&key=AIzaSyCfAM0LMerGH_Srit5N-1yw1LAuDIjx_aA" , function(data) {
    landmark = data.results[0].formatted_address;
  });
  $.ajaxSetup({async: true});
  return landmark;
}

function initializeMap(){
	var myMean = new google.maps.LatLng(22,87);
	Map = new google.maps.Map(document.getElementById('map')); 
	Map.setZoom(4);      // This will trigger a zoom_changed on the map
	Map.setCenter(myMean);
	Map.setMapTypeId(google.maps.MapTypeId.ROADMAP);

	icon1 = new    google.maps.MarkerImage("http://maps.google.com/mapfiles/ms/micons/blue.png", new google.maps.Size(32, 32), new google.maps.Point(0, 0), new google.maps.Point(16, 32));
	icon2 = new    google.maps.MarkerImage("http://maps.google.com/mapfiles/ms/micons/red.png", new google.maps.Size(32, 32), new google.maps.Point(0, 0), new google.maps.Point(16, 32));

}

function resetRow(){
	$('#landmark').val("");
	$('#xcoord').val("");
	$('#ycoord').val("");
}

function addMarker(p) 
{
	point = new google.maps.LatLng(p[0],p[1]);
	var marker = new google.maps.Marker({
    	position: point,
    	map: Map
	});
	markers.push(marker);
	google.maps.event.addListener(marker, "click", function () {
		if(done==0){
		    var i;
		    for (i = points.length - 1; i >= 0; i--) {
		    	if(points[i].equals(marker.getPosition())){
		    		points.splice(i,1);
		    		var nth = 2*i+1;
		    		var n1th = 2*i+2;
		    		$('#busroute tr:nth-child('+nth+')').remove();
		    		$('#busroute tr:nth-child('+nth+')').remove();
		    		break;
		    	}
		    	
		    }
		    for(i=0;i<markers.length;i++)
	    	{
	    		if(markers[i].getPosition().equals(marker.getPosition()))
	    		{
	    			markers.splice(i,1);
	    			break;
	    		}
	    	}
	    	marker.setMap(null);
	    }
	});
}

function finalRoute()
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
	for(var i=0;i<points.length-1;i++)
	{
		var start = points[i];
      	var end = points[i+1];
      	requestDirections(start,end);
	}
}

function removeEntry (x,y) {
	point = new google.maps.LatLng(x,y);
	var i;
    for (i = points.length - 1; i >= 0; i--) {
    	if(points[i].equals(point)){
    		points.splice(i,1);
    		var nth = 2*i+1;
    		var n1th = 2*i+2;
    		$('#busroute tr:nth-child('+nth+')').remove();
    		$('#busroute tr:nth-child('+nth+')').remove();
    		break;
    	}
    	
    }
    for(i=0;i<markers.length;i++)
	{
		if(markers[i].getPosition().equals(point))
		{
			markers[i].setMap(null);
			markers.splice(i,1);
			
			break;
		}
	}
	
}

function addRoute(routename){
	var pointjson={};
	pointjson['routename'] = routename;
	pointjson['points']=[];
	for (var i = points.length - 1; i >= 0; i--) {
		pointjson.points.push([points[i].lat(),points[i].lng()]);
	};
	$.ajaxSetup({async: false});
	$.post("addRoute.php",
			pointjson,
			function(data){
				dataobj = JSON.parse(data);
				if(dataobj.status==="success"){
					alert("The route has been added successfully");
				}
				else{
					alert("Some error has occured at the database. Please try again later");
				}
			}
		);
	$.ajaxSetup({async: true});

}

$(document).ready(function(){

	//alert("Im in");
	initializeMap();
	google.maps.event.addListener(Map, 'click', function (event) 
	{
		if(done==0){
			p = event.latLng;
			landmark = getLandmark([p.lat(),p.lng()]);
			$("<tr><td class=\"col-md-10\" id=\"rem\">"+landmark+"</td></tr><tr><td class=\"col-md-1\">"+p.lat()+", "+p.lng()+"<button class=\"btn btn-danger\" style=\"float:right\" onclick=\"javascript:removeEntry("+p.lat()+","+p.lng()+")\"><span class=\"glyphicon glyphicon-remove\"></span></button></td></tr>").insertBefore('#busroute > tr:nth-last-child(2)').fadeIn('500');
			points.push(p);
			addMarker([p.lat(),p.lng()]);
		}
	});
	$('#addPoint').click(function(){
		flag=0;
		landmark = $('#landmark').val();
		xCoordinate = $('#xcoord').val();
		yCoordinate = $('#ycoord').val();
		if(landmark===""){
			if(xCoordinate==="" || yCoordinate===""){
				alert("Incomplete Information is provided!");
				flag=1;
			}
			else{
				coordinates = [xCoordinate,yCoordinate];
				landmark = getLandmark(coordinates);
			}
		}
		else{
			getCoordinates(landmark);
			coordinates = [xCoordinate,yCoordinate];
			landmark = getLandmark(coordinates);
		}
		if(flag==0){
			$("<tr><td class=\"col-md-10\" id=\"rem\">"+landmark+"</td></tr><tr><td class=\"col-md-1\">"+xCoordinate+", "+yCoordinate+"<button class=\"btn btn-danger\" style=\"float:right\" onclick=\"javascript:removeEntry("+xCoordinate+","+yCoordinate+")\"><span class=\"glyphicon glyphicon-remove\"></span></button></td></tr>").insertBefore('#busroute > tr:nth-last-child(2)').fadeIn('500');
			points.push(new google.maps.LatLng(xCoordinate,yCoordinate));
			addMarker([xCoordinate,yCoordinate]);
			resetRow();
		}
	});
	$('#done').click(function(){
		routename = $('#routename').val();
		if(routename === ""){
			alert("Route name is required");
		}
		else{
			if(points.length<2){
				alert("Atleast two points are required to create a route");
			}
			else{
				var didConfirm = confirm("Are you sure? You cannot make any changes afterwards");
			  	if (didConfirm == true) {
			  		$("#busroute").find("input,button,textarea").attr("disabled", "disabled");
			    	finalRoute();
			    	$('#msg').css('visibility','visible');
			    	done=1;
			    	$('#continueroute').click(function(){
			    		addRoute(routename);
			    		window.location.reload();

			    	});
			    	$('#cancelroute').click(function(){
			    		window.location.reload();
			    	});
			    	//addRoute(routename);
			  	}
			}
		}
	});

	 //getMorePoints();
	 //setInterval(getMorePoints,10000);


});