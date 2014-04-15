<?php 
	if(!isset($_SESSION)) session_start();
	error_reporting(E_ALL); 
	ini_set( 'display_errors','1');
	define('INCLUDE_CHECK', true);


	require 'connect.php';
	require 'functions.php';
	//echo "hurray";

	$err = array();
	
	if(!isset($_POST['ID']) || !isset($_POST['address']) || !isset($_POST['email']) || !isset($_POST['name']) || !isset($_POST['mobile']) || !isset($_POST['pass']) || !isset($_POST['cname']) || !isset($_POST['schoolid']) || !isset($_POST['busid'])  || !isset($_POST['admno']) || !isset($_POST['xCoordinate']) || !isset($_POST['yCoordinate'])){
		$err[] = 'All the fields must be filled in';
		//$_POST['admno'] = mysql_real_escape_string($_POST['admno']);
	}

	if(!count($err)){

		$_POST['ID'] = mysql_real_escape_string($_POST['ID']);
		$_POST['pass'] = mysql_real_escape_string($_POST['pass']);
		$_POST['name'] = mysql_real_escape_string($_POST['name']);
		$_POST['address'] = mysql_real_escape_string($_POST['address']);
		$_POST['email'] = mysql_real_escape_string($_POST['email']);
		$_POST['mobile'] = mysql_real_escape_string($_POST['mobile']); 
		$_POST['cname'] = mysql_real_escape_string($_POST['cname']);
		$_POST['schoolid'] = mysql_real_escape_string($_POST['schoolid']);
		$_POST['busid'] = mysql_real_escape_string($_POST['busid']);
		$_POST['admno'] = mysql_real_escape_string($_POST['admno']);
		$_POST['xCoordinate'] = mysql_real_escape_string($_POST['xCoordinate']);
		$_POST['yCoordinate'] = mysql_real_escape_string($_POST['yCoordinate']);


		//echo json_encode(array('status'=>checkEmail($_POST['email']))
		
			$query = "";
			$query .= "INSERT INTO STUDENT(username, studentName, studentAdmNo, schoolID, parentName, password, busID, homeAddress, eMailID, phoneNumber, xCoordinate, yCoordinate) VALUES('{$_POST['ID']}','{$_POST['cname']}','{$_POST['admno']}','{$_POST['schoolid']}','{$_POST['name']}','{$_POST['pass']}','{$_POST['busid']}','{$_POST['address']}','{$_POST['email']}','{$_POST['mobile']}','{$_POST['xCoordinate']}','{$_POST['yCoordinate']}')";
				
			//echo $query;
			$res = mysql_query($query,$con);
			if(!$res){
				echo json_encode(array('status'=>mysql_error()));
			}
					
			else{
				//send_email();
				echo json_encode(array('status'=>'success'));	
			}

	}
			
	else{
		$_SESSION['msg']['login-err'] = implode('<br />',$err);
		echo json_encode(array('status'=>'error345'));
	}

?>	