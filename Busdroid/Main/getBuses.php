<?php
if(!isset($_SESSION)) session_start();
	error_reporting(E_ALL); 
	ini_set( 'display_errors','1');
	define('INCLUDE_CHECK', true);

	require 'connect.php';
	require 'functions.php';

	$err = array();

	if(!isset($_POST['schoolid']) || !isset($_POST['xCoordinate']) || !isset($_POST['yCoordinate'])){
		$err[] = "All fields must be set in";
	}

	if(!count($err)){

		$schoolid = mysql_real_escape_string($_POST['schoolid']);
		$x = mysql_escape_string($_POST['xCoordinate']);
		$y = mysql_escape_string($_POST['yCoordinate']);


		$query = "";
		$query .= "SELECT BUS.routeID as routeID, BUS.busNumber as routeName FROM BUS, ROUTEID, ROUTE WHERE  BUS.schoolID = '".$schoolid."' AND BUS.routeID = ROUTEID.routeID AND ROUTE.routeID = ROUTEID.routeID AND ABS(ROUTE.xCoordinate-".$x.")<0.001 AND ABS(ROUTE.yCoordinate-".$y.")<0.001";
		
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