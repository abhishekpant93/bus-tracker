function Login(email, pass){
	$.ajaxSetup({async: false});
	$.post("check_login.php",
		     {'ID':email,'Password':pass},
		     function(data){
		     	//alert(data);
		     	dataobj = JSON.parse(data);
		     	if(dataobj.status === 'success'){
		     		$('#login-error').empty();
		     		window.location.replace("main.php");
		     	}
		     	else if(dataobj.status === 'invalid')
		     	{
		     		alert("The bus request could not be fulfilled, please edit bus request");
		     		window.location.replace("edituser.php");	
		     	}
		     	else if(dataobj.status === 'unprocessed'){
		     		alert("The bus request is not yet accepted.");
		     		window.location.replace("edituser.php");	
		     	}
		     	else{
		     		alert("Username or Password is not correct");
		     	}
		     }
		  );
	$.ajaxSetup({async: true});

}

$(document).ready(function(){

	$('#login-button').click(function(){
		var email, pass;
		email = $('#username').val();
		pass = $('#pass').val();
		Login(email,pass);
	});
	

});
