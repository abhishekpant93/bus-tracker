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

    <title>Busdroid | Add a new route</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="sticky-footer.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
    <script type="text/javascript" src="createRoute.js"></script>
	
    <style type="text/css">
    .center-table
    {
      margin: 0 auto !important;
      float: none !important;
    }
    .modal-dialog {
      background: none;
      float:left;
      width:39%;
      margin-left:7%;
      margin-top:20%;
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

    <div class="container"><form class="form-inline" role="form"><input type="text" autofocus id="routename" class="form-control" placeholder="Name of the route" style="width:100%; margin-top:2%; float:left;"></form></div>
    <div class="container" style="margin-top:2%;">
    <div  id="main" style=" width:45%; float:left;">
      <table class="table table-striped">
              <thead>
                <tr>
                  <th>Location</th>
                </tr>
              </thead>
      <tbody id="busroute">
        <tr>
          <td class="col-md-4"><input type="text" id="landmark" class="form-control" placeholder="landmark"></td>
        <tr>
          <form class="form-inline" role="form">
          <td class="col-md-4"><input type="text" id="xcoord" class="span2 form-control" placeholder="x coordinate" style="width:41%; float:left;">&nbsp;<input type="text" id="ycoord" class="span2 form-control" placeholder="y coordinate" style="width:41%; float:left;"><button type="button" id="addPoint" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span></button> <button type="button" id="done" class="btn btn-success"><span class="glyphicon glyphicon-ok"></span></button></td></form>
          
        </tr>
      </tbody>
    </table>
    </div>

    <div id="mapcontainer" style="width: 600px; height: 600px; float:right">
      <div id="map" style="width: 580px; height: 500px; padding: 2%; padding-top:10%;">
      </div>
      <div id="msg" style="text-align:right; padding-right:4%; visibility:hidden;">
        <span>Note: You will lose the data entered on pressing cancel</span>
        <div>
          <button type="button" class="btn btn-success" data-dismiss="modal" id="continueroute">Continue</button>
          <button type="button" class="btn btn-error" data-dismiss="modal" id="cancelroute">Cancel</button>
        </div>
      </div>
    </div>
  </div><!-- /container -->
     
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
