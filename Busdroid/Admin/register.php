<?php 
	if(!isset($_SESSION)) session_start();
	error_reporting(E_ALL); 
	ini_set( 'display_errors','1');
	define('INCLUDE_CHECK', true);


	require 'connect.php';
	require 'functions.php';
	//echo "hurray";

	$err = array();
	
	if(!isset($_POST['ID']) || !isset($_POST['pass']) || !isset($_POST['scode']) || !isset($_POST['sname']) || !isset($_POST['saddr']) ){
		$err[] = 'All the fields must be filled in';
		//$_POST['admno'] = mysql_real_escape_string($_POST['admno']);
	}

	if(!count($err)){

		$_POST['ID'] = mysql_real_escape_string($_POST['ID']);
		$_POST['pass'] = mysql_real_escape_string($_POST['pass']);
		$_POST['scode'] = mysql_real_escape_string($_POST['scode']);
		$_POST['sname'] = mysql_real_escape_string($_POST['sname']);
		$_POST['saddr'] = mysql_real_escape_string($_POST['saddr']);		

		//echo json_encode(array('status'=>checkEmail($_POST['email']))
		
		$query = "";
		$query .= "INSERT INTO SCHOOL(schoolID, schoolName, schoolAddress) VALUES('{$_POST['scode']}','{$_POST['sname']}','{$_POST['saddr']}')";
		$res = mysql_query($query,$con);
		if(!$res){
			echo json_encode(array('status'=>mysql_error()));
		}
		else{
			$query = "";
			$query .= "INSERT INTO ADMIN(username,password,schoolID) VALUES('{$_POST['ID']}','{$_POST['pass']}','{$_POST['scode']}')";
			$res = mysql_query($query,$con);
			if(!$res){
				echo json_encode(array('status'=>mysql_error()));
			}		
			else{
				echo json_encode(array('status'=>'success'));	
			}
		}

	}
			
	else{
		$_SESSION['msg']['login-err'] = implode('<br />',$err);
		echo json_encode(array('status'=>'error345'));
	}

?>	