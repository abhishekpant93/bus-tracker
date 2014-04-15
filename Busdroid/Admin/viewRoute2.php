<?php 
	if(!isset($_SESSION)) session_start();
	error_reporting(E_ALL); 
	ini_set( 'display_errors','1');
	define('INCLUDE_CHECK', true);

	require 'connect.php';
	require 'functions.php';

	
	if(isset($_POST['rid']))
	{
		$query = "";
		$query .= "SELECT xCoordinate,yCoordinate FROM ROUTE WHERE routeID='{$_POST['rid']}' ORDER BY sequence";
		$res = mysql_query($query,$con);
		$rows = array();
		while($r = mysql_fetch_assoc($res)) {
   	 		$rows[]=$r;
		}
		echo "{\"status\":\"success\",\"list\":".json_encode($rows)."}";
	}
	else
	{

	}

?>
