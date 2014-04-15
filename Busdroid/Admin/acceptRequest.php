<?php 
if(!isset($_SESSION)) session_start();
	error_reporting(E_ALL); 
	ini_set( 'display_errors','1');
	define('INCLUDE_CHECK', true);

	require 'connect.php';
	require 'functions.php';

	$err = array();
	if(!isset($_POST['adm']) || !isset($_POST['busid'])){
		$err[]="incomplete information";
	}

	if(!count($err)){

		$_POST['adm']=mysql_real_escape_string($_POST['adm']);
		$_POST['busid'] = mysql_real_escape_string($_POST['busid']);
		$query = "";
		$query .= "UPDATE STUDENT SET validity = 1 WHERE studentAdmNo = '{$_POST['adm']}'";
			
		//echo $query;
		$res = mysql_query($query,$con);
		if(!$res){
			echo json_encode(array('status'=>mysql_error()));
		}
				
		else{
			$query = "";
			$query .= "UPDATE BUS SET currStudents = currStudents+1 WHERE busNumber = '{$_POST['busid']}'";
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
		echo json_encode(array('status'=>'error'));
	}

?>	