<?php
	if(!isset($_SESSION)) session_start();
	error_reporting(E_ALL); 
	ini_set( 'display_errors','1');
	define('INCLUDE_CHECK', true);

	require 'connect.php';
	require 'functions.php';

	//echo "hurray";
	$err = array();
	if(!isset($_POST['routename']) || !isset($_POST['points'])){
		$err[] = 'All the fields must be filled in';
	}
	if(!count($err)){
		$_POST['routename'] = mysql_real_escape_string($_POST['routename']);
		$points = $_POST['points'];
		$query = "";
		$query .= "INSERT INTO ROUTEID(routeName) VALUES('{$_POST['routename']}')";
			
		//echo $query;
		$res = mysql_query($query,$con);
		

		if(!$res){
			echo json_encode(array('status'=>'error1'));
		}
		else{
			$query="";
			$query.="SELECT MAX(routeID) AS routeID FROM ROUTEID";
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
				$routeid = $row['routeID'];
				$query = "";
				$query .= "INSERT INTO ROUTE(sequence, routeID, xCoordinate, yCoordinate) VALUES";
				for ($i=0; $i < sizeof($points); $i++) { 
					$query .= "(".$i.",".$routeid.",".$points[$i][0].",".$points[$i][1].")";
					if($i < sizeof($points)-1){
						$query.=",";
					}
				}
				$res = mysql_query($query,$con);
				if(!$res){
					echo json_encode(array('status'=>mysql_error()));
				}
				else{
					echo json_encode(array('status'=>'success'));	
				}
			}

		}
	}
	
	else{
		echo json_encode(array('status'=>'error'));
	}
?>