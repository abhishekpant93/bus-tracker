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
    <link rel="shortcut icon" href="favicon.ico">
    <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>

    <title>Busdroid</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="sticky-footer.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
	
    <style type="text/css">
    .center-table
    {
      margin: 0 auto !important;
      float: none !important;
    }
    .modal-dialog {
      width: 90%;
    }
     .modal-body {
      overflow-y: auto;
    }
    </style>
    
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
            <li><a href="RegisterBus.php">Register Bus</a></li>
            <li><a href="ViewRequests.php">View Requests</a></li>
            <li><a href="NewRoute.php">Add A New Route</a></li>
            <li><a href="ViewRoute.php">View Routes</a></li>
          </ul>
          <ul class = "nav navbar-nav pull-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?php echo "Hello, ".$_SESSION['id']?><b class="caret"></b></a>
              <ul class="dropdown-menu">
                <li><a href="changepass.php">Change Password</a></li>
                <li><a href="logout.php">Logout</a></li>
              </ul>
              
            </li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container" id="main">
      <div class="starter-template" id="heading">
        <h3>Welcome to BUSDROID</h3>
      </div>
    </div><!-- /container -->

    <div class="modal fade" id="viewmap" tabindex="-1" role="dialog" aria-labelledby="viewofferLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
      </div>
      <div class="modal-body">
        <div id="map" style="width: 1120px; height: 500px;"></div>
      
    </div>
  </div>
</div>
</div>
     
    <!-- <div id="footer">
        <h5>&copy;All rights reserved 2014 Arpit Kumar, Shrihari Bhat, Siddharth Rakesh & Sachin Kumar </h5>
    </div> -->
    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
