<?php 
	if(!isset($_SESSION)) session_start();
	error_reporting(E_ALL); 
	ini_set( 'display_errors','1');
	define('INCLUDE_CHECK', true);

	require 'connect.php';
	require 'functions.php';
	//echo "hurray";

	$query = "";
	$query .= "SELECT * FROM STUDENT WHERE STUDENT.username = '{$_SESSION['id']}'";
				
			//echo $query;
	$res = mysql_query($query,$con);
	$rows = array();

	while($r = mysql_fetch_assoc($res)) {
	 		$rows[]=$r;
	}
	echo "{\"status\":\"success\",\"list\":".json_encode($rows)."}";
?>	