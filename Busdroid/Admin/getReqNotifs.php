<?php
if(!isset($_SESSION)) session_start();
	error_reporting(E_ALL); 
	ini_set( 'display_errors','1');
	define('INCLUDE_CHECK', true);

	require 'connect.php';
	require 'functions.php';

	$err = array();

	if(!count($err)){

		$schoolid = mysql_real_escape_string($_SESSION['school']);



		$query = "";
		$query .= "SELECT studentName AS NAME, studentAdmNo as ADM, busID as BUS FROM STUDENT WHERE schoolID = '".$schoolid."' AND validity=0";
		
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