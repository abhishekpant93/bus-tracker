<?php
if(!isset($_SESSION)) session_start();
	error_reporting(E_ALL); 
	ini_set( 'display_errors','1');
	define('INCLUDE_CHECK', true);

	require 'connect.php';
	require 'functions.php';

	$err = array();

	if(!isset($_POST['last'])){
		$err[] = 'All the fields must be filled in';
	}

	if(!count($err)){

		$userid = mysql_real_escape_string($_SESSION['id']);
		$lasttime = mysql_real_escape_string($_POST['last']);

		$query = "";
		$query .= "SELECT R.xCoordinate,R.yCoordinate,R.time,R.landmark FROM RUNNINGINFO AS R, STUDENT AS S WHERE S.busID = R.busID AND R.time > '".$lasttime."' ORDER BY R.time";
		
		//echo $query;
		$res = mysql_query($query,$con);
		if(!$res){
			echo json_encode(array('status'=>mysql_error()));
		}		
		else{
			$rows = array();
			while($r = mysql_fetch_assoc($res)) {
    			$rows[]=$r;
			}
			echo "{\"status\":\"success\",\"list\":".json_encode($rows)."}"; 
		}

	}
			
	else{
		echo json_encode(array('status'=>'error'));
	}

?>	