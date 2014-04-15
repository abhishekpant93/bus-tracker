var noreq=1,err,list1,Reqnotifs;
function getReqNotifications(){
	err=2;
	$.ajaxSetup({async: false});
	$.post("getReqNotifs.php",
		{},
		function(data){
			//alert(data);
			Reqnotifs = JSON.parse(data);

			if(!(Reqnotifs.status==='success')){
				err = 1;
			}
		} 
	);
	$.ajaxSetup({async: true});
	if(err == 2){
		if(parseInt(Reqnotifs.list.length)==0){
			noreq=1;
		}
		else{
			noreq=2;
		}

	}
	else{
		alert("Some error occured on the server. Please try again later")
	}

}

function acceptRequest(i){
	//alert(Reqnotifs.list[i]);
	$.post("acceptRequest.php",
		{'adm':Reqnotifs.list[i].ADM,'busid':Reqnotifs.list[i].BUS},
		function(data){
			//alert(data);
			window.location.reload(true);

		}  //display data here
	);
}
function rejectRequest(i){
	$.post("rejectRequest.php",
		{'adm':i},
		function(data){

			window.location.reload(true);

		}  //display data here
	);
}
$(document).ready(function(){
	getReqNotifications();

	if(noreq==1){
		$('#ReqHead').append("<h2>You have no new requests</h2>");
	}
	else{
		$('#ReqHead').append("<h1>You have pending requests</h1>");
			$('#ReqHeaders').append("<th>Student Name</th><th>Admission Number</th><th>Bus Number</th>");
			list1 = Reqnotifs.list;

			for(var i in list1){
				$('#ReqTab').append("<tr><td>"+list1[i].NAME+"</td><td>"+list1[i].ADM+"</td><td>"+list1[i].BUS+"</td><td><button type=\"button\" onclick=\"acceptRequest("+i+")\" class=\"btn btn-success\">Approve</button> <button type=\"button\" onclick=\"rejectRequest('"+list1[i].ADM+"')\" class=\"btn btn-success\">Deny</button></td></tr>");
			}
	}
});