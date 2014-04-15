<?php 
if(!isset($_SESSION)) session_start();
	error_reporting(E_ALL); 
	ini_set( 'display_errors','1');
	define('INCLUDE_CHECK', true);

	require 'connect.php';
	require 'functions.php';

	$err = array();
	if(!isset($_POST['adm'])){
		$err[]="incomplete information";
	}

	if(!count($err)){

		$_POST['adm']=mysql_real_escape_string($_POST['adm']);
		$query = "";
		$query .= "UPDATE STUDENT SET validity = 2 WHERE studentAdmNo = '{$_POST['adm']}'";
			
		//echo $query;
		$res = mysql_query($query,$con);
		if(!$res){
			echo json_encode(array('status'=>mysql_error()));
		}
				
		else{
			echo json_encode(array('status'=>'success'));
		}

	}
			
	else{
		echo json_encode(array('status'=>'error'));
	}

?>	