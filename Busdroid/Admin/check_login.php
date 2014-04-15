<?php
	if(!isset($_SESSION)) session_start();
	error_reporting(E_ALL); 
	ini_set( 'display_errors','1');
	define('INCLUDE_CHECK', true);

	require 'connect.php';
	require 'functions.php';

	//echo "hurray";
	$err = array();
	if(!isset($_POST['Password']) || !isset($_POST['ID'])){
		$err[] = 'All the fields must be filled in';
		$_POST['ID'] = mysql_real_escape_string($_POST['ID']);
		$_POST['Password'] = mysql_real_escape_string($_POST['Password']);
	}
	if(!count($err)){
		$_POST['ID'] = mysql_real_escape_string($_POST['ID']);
		$_POST['Password'] = mysql_real_escape_string($_POST['Password']);

		$query = "";
		$query .= "SELECT * FROM ADMIN WHERE username= '{$_POST['ID']}' AND password = '{$_POST['Password']}'";
			
		//echo $query;
		$res = mysql_query($query,$con);
		

		if(!$res){
			echo json_encode(array('status'=>'error1'));
		}
		elseif(mysql_num_rows($res)==0){
			$err[] = "Wrong credentials";
			echo json_encode(array('status'=>'error2'));
		}
		else{
			$row = mysql_fetch_assoc($res);
			$_SESSION['id'] = $row['username'];
			$_SESSION['school'] = $row['schoolID'];
			echo json_encode(array('status'=>'success'));	
		}
	}
	
	else{
		echo json_encode(array('status'=>'error'));
	}
?>