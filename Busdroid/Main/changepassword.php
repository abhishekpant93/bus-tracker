<?php
if(!isset($_SESSION)) session_start();
	error_reporting(E_ALL); 
	ini_set( 'display_errors','1');
	define('INCLUDE_CHECK', true);

	require 'connect.php';
	require 'functions.php';

	$err = array();

	if(!isset($_POST['old']) || !isset($_POST['newp'])){
		$err[]="All values must be set";
	}
	if(!count($err)){

		$userid = mysql_real_escape_string($_SESSION['id']);

		$query = "";
		$query .= "SELECT password FROM STUDENT WHERE username='".$userid."'";
		//echo $query;
		$res = mysql_query($query,$con);
		
		if($res){
			$no = mysql_num_rows($res);
			
			if($no>0){
				$passw = mysql_fetch_assoc($res);
				
				if($passw['password'] == $_POST['old']){

					$query = "";
					$query .= "UPDATE STUDENT SET password='{$_POST['newp']}' WHERE STUDENT.username = '".$userid."'";
					
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
					echo json_encode(array('status'=>'unmatch'));
				}
			}
			else{
				echo json_encode(array('status'=>'unmatch'));
			}
		}
		else{
			echo json_encode(array('status'=>'error'));
		}

	}
			
	else{
		echo json_encode(array('status'=>'error'));
	}

?>	