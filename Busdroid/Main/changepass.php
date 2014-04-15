<!DOCTYPE html>
<?php
if(!isset($_SESSION)) session_start();
if(!isset($_SESSION['id'])){
  header("location: Signin.php");
}
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="../../assets/ico/favicon.ico">

    <title>Starter Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="sticky-footer.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">
	   <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
    <script type="text/javascript">
      function changePass(){
        old = $('#opass').val();
        newp = $('#npass1').val();
        newrp = $('#npass2').val();
        if(!(newp === newrp)){
          alert("Passwords don't match"+newp+newrp);
        }
        else{
          $.post("changepassword.php",{'old':old,'newp':newp},function(data){
            
            dataobj = JSON.parse(data);
            if(dataobj.status === 'success')
            {
              alert("Password has been successfully changed");
              window.location.replace("Signin.php");
            }
            else
            {
              alert("Password could not be changed. Please try again.");
            }
          });
        }
      }
    </script>
    
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>


    <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="main.php">BUSDROID</a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
          </ul>
          <ul class = "nav navbar-nav pull-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo "Hello, ".$_SESSION['username']." " ?><b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="logout.php">Logout</a></li>
              </ul>
              
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">

      <div class="starter-template">
        <h1>Change Password</h1>
      </div>

	<div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th></th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Old Password</td>
                  <td><input type="password" id="opass"></td>
                </tr>
                <tr>
                  <td>New Password</td>
                  <td><input type="password" id="npass1"></td>
                </tr>
			           <tr>
                  <td>Confirm New Password</td>
                  <td><input type="password" id="npass2"></td>
                </tr>
              </tbody>
            </table>
			
	     <div align="center">
          <button type="button" class="btn btn-danger" id="Change" onclick="changePass()">Reset</button>
      </div><!-- /.container -->
	   </div>
   </div>
   <div id="footer">
    <style>
    h5 {color:white;
      text-align:center;}
    </style>
      <p class="text-muted"><h5>&copy;2014 All rights reserved Arpit Kumar, Shrihari Bhat, Siddharth Rakesh & Sachin Kumar</h5></p>
    </div>
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
