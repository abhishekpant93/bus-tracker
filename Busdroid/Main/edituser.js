var school;
var Map, icon2;
var xCoordinate,yCoordinate;
var done=0;
var marker;
var buses;

function addMarker(p) 
{
	point = new google.maps.LatLng(p[0],p[1]);
	marker = new google.maps.Marker({
    	position: point,
    	map: Map
	});

	google.maps.event.addListener(marker, "click", function () {
		marker.setMap(null);
		done=0;
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


function Edit(email, name, address, mobile, cname, schoolid, busid, admno){
	$.ajaxSetup({async:false});
	$.post("editStudentDetails.php",
		     {'email':email,'name':name,'address':address,'mobile':mobile,'cname':cname,'schoolid':schoolid,'busid':busid,'admno':admno},
		     function(data){
		     	dataobj = JSON.parse(data);
		     	if(dataobj.status === 'success'){
		     		alert("Your details have been successfully updated");
		     		window.location.replace("logout.php");
		     	}
		     	else{
		     		alert("Details updating could not be completed due to some error at the server. Please try again later.");
		     	}
		     }

		  );
	$.ajaxSetup({async:false});
	//alert("fuck off");
}
function validEmail(v) {
    var r = new RegExp("[a-z0-9!#$%&'*+/=?^_`{|}~-]+(?:\.[a-z0-9!#$%&'*+/=?^_`{|}~-]+)*@(?:[a-z0-9](?:[a-z0-9-]*[a-z0-9])?\.)+[a-z0-9](?:[a-z0-9-]*[a-z0-9])?");
    return (v.match(r) == null) ? false : true;
}

function getSchools(){
	$.ajaxSetup({async: false});
	$.post("getSchools.php",
			{},
			function(data){
				school = JSON.parse(data);
			}
		);
	$.ajaxSetup({async: true});
	//alert("sdgdsg");
	var select = $("#school");
	if(school.list.length <= 0){
		alert("There are no schools registered on the website. Please come back later");
	 	window.location.replace("Signin.php");
	}
	for (var i=0; i < school.list.length; i++){
		
	 	select.append($('<option></option>').val(school.list[i].schoolName).html(school.list[i].schoolName));
	}
}

function getInfo(){
	$.ajaxSetup({async: false});
	$.post("getStudentInfo.php",
			{},
			function(data){
				student = JSON.parse(data);
			}
		);

	$.ajaxSetup({async: true});

	$('#email').val(student.list[0].eMailID);
	$('#name').val(student.list[0].parentName);
	$('#address').val(student.list[0].homeAddress);
	$('#mobile').val(student.list[0].phoneNumber);
	$('#cname').val(student.list[0].studentName);
	$('#bus').val(student.list[0].busID);
	$('#admno').val(student.list[0].studentAdmNo);
}

function initializeMap () {
	var myMean = new google.maps.LatLng(22,87);
	Map = new google.maps.Map(document.getElementById('map')); 
	Map.setZoom(4);      // This will trigger a zoom_changed on the map
	Map.setCenter(myMean);
	Map.setMapTypeId(google.maps.MapTypeId.ROADMAP);
	icon2 = new google.maps.MarkerImage("http://maps.google.com/mapfiles/ms/micons/red.png", new google.maps.Size(32, 32), new google.maps.Point(0, 0), new google.maps.Point(16, 32));
}

function getBuses(){

	schoolind = $('#school :selected').index();
	schoolid = school.list[schoolind].schoolID;
	//alert(schoolid);
	$.ajaxSetup({async: false});
	$.post("getBuses.php",
			{'schoolid':schoolid,'xCoordinate':marker.getPosition().lat(),'yCoordinate':marker.getPosition().lng()},
			function(data){
				buses = JSON.parse(data);
			}
		);
	$.ajaxSetup({async: true});

	var select = $("#bus");
	//alert(buses);
	if(buses.list.length <= 0){
	 	alert("There are no bus routes of the school selected nearby your picking point. Please choose another picking point");
	}
	for (var i=0; i < buses.list.length; i++){
		
	  	select.append($('<option></option>').val(buses.list[i].routeName).html(buses.list[i].routeName));
	}
}

$(document).ready(function(){
	getSchools();
	getInfo();

	initializeMap();
	google.maps.event.addListener(Map, 'click', function (event) 
	{
		if(done==0){
			done=1;
			p = event.latLng;
			addMarker([p.lat(),p.lng()]);
		}
		else{
			marker.setMap(null);
			p = event.latLng;
			addMarker([p.lat(),p.lng()]);	
		}
	});
	$('#viewmap').on('shown.bs.modal', function () {
	 	lastCenter=Map.getCenter();
        google.maps.event.trigger(Map, 'resize');
        Map.setCenter(lastCenter);
        Map.setZoom(4);
	 });
	$('#editButton').click(function(){
		if(done==1)
		{
			email = $('#email').val();
			name = $('#name').val();
			address = $('#address').val();
			mobile = $('#mobile').val();
			cname = $('#cname').val();
			schoolind = $('#school :selected').index();
			admno = $('#admno').val();
			schoolid = school.list[schoolind].schoolID;
			busind = $('#bus :selected').index();
			if(busind < 0){
				alert("Since no buses are available, registration cannot be completed");
			}
			else{
				busid = buses.list[busind].routeName;
			
				if(name===""){
					alert("Name is required");
				}
				else if(cname===""){
					alert("Child's name is required");
				}
				else if(!validEmail(email)){
					alert("Email is not in correct format");
				}
				else if(admno === ""){
					alert("Admission Number of child cannot be left blank");
				}

				else{
					//alert(id+" "+email+" "+name+" "+address+" "+mobile+" "+pass+" "+age);
					Edit(email, name, address, mobile, cname, schoolid, busid, admno);
				}
			}
		}
		else
		{
			alert("You have not yet changed the picking point");

		}
	});
	$('#searchPoint').click(function(){
		landmark = $("#loc").val();
		getCoordinates(landmark);
		Map.setCenter(new google.maps.LatLng(xCoordinate,yCoordinate));
		Map.setZoom(15);
	});
	$('#fixPoint').click(function(){
		if(done==0){
			alert("Please select a location on the map first");
		}
		else{
			landmark = getLandmark([marker.getPosition().lat(),marker.getPosition().lng()]);
			$('#coordinates').html(landmark + "  ");
			$('#viewmap').modal('toggle');
			getBuses();
		}
	});
	$('#clear').click(function(){
		$('#email').val("");
		$('#name').val("");
		$('#address').val("");
		$('#mobile').val("");
		$("input:radio[name='radiogr1']").val("");
		$('#dob').val("");
		$('#admno').val("");
		$('#cname').val("");
	});
});