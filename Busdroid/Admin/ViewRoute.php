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
    <title>Busdroid | View Route</title>
    <link href="sticky-footer.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
    <script type="text/javascript" src="viewRoutes.js"></script>
    <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>

    <!-- Custom styles for this template -->
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

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
          <a class="navbar-brand" href="main.php"><b>BUSDROID</b></a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="#">View Route</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    <div class="container" style="width:80%; padding-top:2%">
      <div class="table-responsive">
        <table class="table table-striped">
          <tr>
            <td class="col-md-3">Select Route to view: </td>
            <td class="inputfield">
              <select class="form-control" id="rid"></select>
            </td>
            <td>
              <button type="button" class="btn btn-primary" id="viewButton" style="float:right">View</button>
            </td>
          </tr>
        </table>
      </div>
    <div class="container" id="mapcontainer" style="width:100%; height: 600px;">
      <div id="map" style="width:100%; height: 500px; padding: 2%; padding-top:8%;">
      </div>
    </div>
    </div>
    <!-- /.container -->
   <!-- <div id="footer">
      <p class="text-muted">&copy;2014 All rights reserved Arpit Kumar, Shrihari Bhat, Siddharth Rakesh & Sachin Kumar </p>
    </div> -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
