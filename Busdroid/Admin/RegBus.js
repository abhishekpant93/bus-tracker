var dataObj;

function Register(busNo,dName,dlicNo,cap,rid){

	$.ajaxSetup({async:false});
	$.post("busRegister.php",
	    {'busNo':busNo,'dName':dName,'dlicNo':dlicNo,'cap':cap,'rid':rid},
	    function(data){
	    	dataobj = JSON.parse(data);
	    	if(dataobj.status === 'success'){
	    		alert("Bus has been successfully registered");
	    		window.location.replace("main.php");
	    	}
	    	else{
	    		alert("Bus registration could not be completed due to some error at the server. Please try again later.");
	    	}
	    });

	$.ajaxSetup({async:true});
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
	//$.ajaxSetup({async:true});
}


$(document).ready(function()
{
	GetRoutes();

	$('#regButton').click(function(){
		busNo = $('#busNo').val();
		dName = $('#dName').val();
		dlicNo = $('#dlicNo').val();
		cap = $('#cap').val();
		ridi = $('#rid :selected').index();
		rid = dataobj.list[ridi].routeID;

		if(busNo===""){
			alert("Username is required");
		}
		else if(dName===""){
			alert("Password is required");
		}
		else if(dlicNo===""){
			alert("School code is required");
		}
		else if(cap===""){
			alert("School address is required");
		}
		else if(rid===""){
			alert("School address is required");
		}
		else{
			Register(busNo,dName,dlicNo,cap,rid);
		}
	});

	$('#clear').click(function(){
		busNo = $('#busNo').val("");
		dName = $('#dName').val("");
		dlicNo = $('#dlicNo').val("");
		sid = $('#sid').val("");
		cap = $('#cap').val("");
	});
});