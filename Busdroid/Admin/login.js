function Login(id,pass){

	$.ajaxSetup({async: false});
	$.post("check_login.php",
		     {'ID':id,'Password':pass},
		     function(data){
		     	dataobj = JSON.parse(data);
		     	if(dataobj.status === 'success'){
		     		$('#login-error').empty();
		     		window.location.replace("main.php");
		     	}
		     	else{
		     		alert("Username or password is not correct");
		     	}
		     }
		  );
	$.ajaxSetup({async: true});

}

$(document).ready(function(){

	$('#login-button').click(function(){
		var pass;
		pass = $('#pass').val();
		id = $('#username').val();
		Login(id,pass);
	});
	

});
