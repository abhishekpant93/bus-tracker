<?php
	if(!isset($_SESSION)) session_start();
	error_reporting(E_ALL); 
	ini_set( 'display_errors','1');
	define('INCLUDE_CHECK', true);

	require 'connect.php';
	require 'functions.php';

	//echo "hurray";
	$err = array();
	if(!isset($_POST['ID']) || !isset($_POST['Password'])){
		$err[] = 'All the fields must be filled in';
	}
	if(!count($err)){
		$_POST['ID'] = mysql_real_escape_string($_POST['ID']);
		$_POST['Password'] = mysql_real_escape_string($_POST['Password']);
		$query = "";
		$query .= "SELECT parentName, busID, validity FROM STUDENT WHERE username = '{$_POST['ID']}' AND password = '{$_POST['Password']}'";
			
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
			$_SESSION['username'] = $row['parentName'];
			$_SESSION['id'] = $_POST['ID'];
			$_SESSION['busid'] = $row['busID'];
			$_SESSION['validity'] = $row['validity'];
			if($_SESSION['validity'] == 2)
			{
				echo json_encode(array('status'=>'invalid'));
			}
			else if($_SESSION['validity'] == 0){	
				echo json_encode(array('status'=>'unprocessed'));
			}
			else
			{	
				echo json_encode(array('status'=>'success'));
			}
		}
	}
	
	else{
		echo json_encode(array('status'=>'error'));
	}
?>