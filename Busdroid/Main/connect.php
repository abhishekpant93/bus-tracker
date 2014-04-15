<?php
if(!defined('INCLUDE_CHECK')){
	die('You are not allowed to access this file directly');
}
	$con = mysql_connect("10.5.18.71","11CS10007","mantu");
	mysql_select_db("11CS10007");
	if(mysqli_connect_errno($con)){
		die("Failed to connect to MySQL: ".mysqli_connect_error());
	}
	mysql_query("SET names UTF8");
?>