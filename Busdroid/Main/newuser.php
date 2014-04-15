<!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="favicon.ico">
    <title>Busdroid| New Account</title>
    <link href="sticky-footer.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
    <script type="text/javascript" src="signup.js"></script>
    <script src="http://maps.google.com/maps/api/js?sensor=false" type="text/javascript"></script>
    <!-- Custom styles for this template -->
    <!-- Just for debugging purposes. Don't actually copy this line! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
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
          <a class="navbar-brand" href="main.php"><b>BUSDROID</b></a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li><a href="#">Create a new account</a></li>
          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>
    <div class="container">
      <div class="table-responsive">
            <table class="table table-striped">
              <thead>
                <tr>
                  <th></th>
                </tr>
                <tr>
                </tr>
              </thead>
              <tbody>
              <tr>
                <td>Username: </td>
                <td><input type="text" id="username"></td>
              </tr>
              <tr>
                <td>Password: </td>
                <td><input type="password" id="pass"></td>
              </tr>
              <tr>
                <td>Re-enter Password: </td>
                <td><input type="password" id="repass"></td>
              </tr>
              <tr>
                <td>Your Name: </td>
                <td><input type="text" id="name"></td>
              </tr>
              <tr>
                <td>Email: </td>
                <td><input type="text" id="email"></td>
              </tr>
              <tr>
                <td>Phone: </td>
                <td><input type="text" id="mobile"></td>
              </tr>
              <tr>
                <td>Your Child's Name: </td>
                <td><input type="text" id="cname"></td>
              </tr>
              <tr>
                <td>School: </td>
                <td>
                  <select id="school">
                  </select>
                </td>
              </tr>
              <tr>
                <td>Admission Number of Child: </td>
                <td>
                  <input type="text" id="admno">
                </td>
              </tr>
              <tr>
                <td>Residential Address: </td>
                <td><input type="text" id="address"></td>
              </tr>
              <tr>
                <td>Picking point: </td>
                <td><span id="coordinates"></span><button type="button" data-toggle="modal" data-target="#viewmap" class="btn btn-success">Select from Map</buttom></td>
              </tr>
              <tr>
                <td>Bus: </td>
                <td>
                  <select id="bus">
                  </select></td>
              </tr>
            </table>
      </div>
      <div align="center">
        <button type="button" class="btn btn-primary" id="regButton">Register</button>
        <button type="button" class="btn btn-warning" id="clear">Reset</button>
      </div>
    </div><!-- /.container -->

    <div class="modal fade" id="viewmap" tabindex="-1" role="dialog" aria-labelledby="viewofferLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
          </div>
          <div class="modal-body">
            <div id="map" style="width: 1120px; height: 400px;"></div>
            <div class="modal-footer">
              <form class="form-inline" role="form">
                <input class="span4 form-control" id="loc"/>
                <button type="button" class="btn btn-success" id="searchPoint">Search</button>
                <button type="button" class="btn btn-warning" id="fixPoint">Done</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
   <!-- <div id="footer">
      <p class="text-muted">&copy;2014 All rights reserved Arpit Kumar, Shrihari Bhat, Siddharth Rakesh & Sachin Kumar </p>
    </div> -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
