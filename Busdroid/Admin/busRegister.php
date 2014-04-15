<?php 
	if(!isset($_SESSION)) session_start();
	error_reporting(E_ALL); 
	ini_set( 'display_errors','1');
	define('INCLUDE_CHECK', true);

	require 'connect.php';
	require 'functions.php';
	
	if(!isset($_POST['QUERY']))
	{
		$err = array();
		if(!isset($_POST['busNo']) || !isset($_POST['dName']) || !isset($_POST['dlicNo']) || !isset($_POST['cap']) || !isset($_POST['rid'])){

			$err[] = 'All the fields must be filled in';
			//$_POST['admno'] = mysql_real_escape_string($_POST['admno']);
		}

		if(!count($err)){

			$_POST['busNo'] = mysql_real_escape_string($_POST['busNo']);
			$_POST['dName'] = mysql_real_escape_string($_POST['dName']);
			$_POST['dlicNo'] = mysql_real_escape_string($_POST['dlicNo']);
			$sid = $_SESSION['school'];
			$_POST['cap'] = mysql_real_escape_string($_POST['cap']);		
			$_POST['rid'] = mysql_real_escape_string($_POST['rid']);
			//echo json_encode(array('status'=>checkEmail($_POST['email']))
			
			$query = "";
			$query .= "INSERT INTO BUS(busNumber, driverName, driverLicNumber, schoolID, capacity, currStudents, routeID) VALUES('{$_POST['busNo']}','{$_POST['dName']}','{$_POST['dlicNo']}','".$sid."','{$_POST['cap']}',0,'{$_POST['rid']}')";
			$res = mysql_query($query,$con);
			if(!$res){
				echo json_encode(array('status'=>mysql_error()));
			}
			else{
				echo json_encode(array('status'=>'success'));
			}

		}
				
		else{
			json_encode(array('status'=>'error345'));
		}
	}
	else
	{

		$query = "";
		$query.= "SELECT * FROM ROUTEID WHERE 1";

		$res = mysql_query($query,$con);
		$rows = array();

		while($r = mysql_fetch_assoc($res)) {
   	 		$rows[]=$r;
		}
		echo "{\"status\":\"success\",\"list\":".json_encode($rows)."}"; 
	}
?>
