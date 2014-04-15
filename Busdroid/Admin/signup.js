var school;

function Register(id,pass,scode,sname,saddr){

	$.ajaxSetup({async:false});
	$.post("register.php",
		     {'ID':id,'pass':pass,'scode':scode,'sname':sname,'saddr':saddr},
		     function(data){
		     	//alert(data);
		     	dataobj = JSON.parse(data);
		     	if(dataobj.status === 'success'){
		     		alert("You have been successfully registered");
		     		window.location.replace("Signin.php");
		     	}
		     	else if(dataobj.status.indexOf("Duplicate")>=0){
		     		if(dataobj.status.indexOf("PRIMARY")>=0)
		     			alert("Username already exists");
		     		else
		     			alert("This school is already registered");
		     	}
		     	else{
		     		alert("Registration could not be completed due to some error at the server. Please try again later.");
		     	}
		     }

		  );
	$.ajaxSetup({async:false});
}


$(document).ready(function(){

	$('#regButton').click(function(){
		id = $('#username').val();
		pass = $('#pass').val();
		repass = $('#repass').val();
		scode = $('#scode').val();
		//alert(scode);
		sname = $('#sname').val();
		saddr = $('#saddr').val();

		if(id===""){
			alert("Username is required");
		}
		else if(pass===""){
			alert("Password is required");
		}
		else if(pass != repass){
			alert("Password don't match");
		}
		else if(scode == ""){
			alert("School code is required");
		}
		else if(sname == ""){
			alert("School name is required");
		}
		else if(saddr == ""){
			alert("School address is required");
		}
		else{
			Register(id,pass,scode,sname,saddr);
		}
	});
	$('#clear').click(function(){
		$('#username').val("");
		$('#email').val("");
		$('#name').val("");
		$('#address').val("");
		$('#mobile').val("");
		$('#pass').val("");
		$('#repass').val("");
		$("input:radio[name='radiogr1']").val("");
		$('#dob').val("");
	});
});