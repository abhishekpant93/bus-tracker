<!DOCTYPE html>
<?php
if(!isset($_SESSION)) session_start();
if(isset($_SESSION['id'])){
  header("location: main.php");
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
    <title>Busdroid | Admin</title>
    <link href="sticky-footer.css" rel="stylesheet">
    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">
    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="signin.css" rel="stylesheet">
    <script type="text/javascript" src="http://code.jquery.com/jquery-1.9.1.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.2/jquery-ui.js"></script>
    <script type="text/javascript" src="login.js"></script>
    <style>
     body {background-image:url('background.jpg');} 
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
          <a class="navbar-brand" href="#"><b>BUSDROID</b></a>
        </div>
        <div class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="Signin.php">Register Bus</a></li>
            <li><a href="ViewRequests.php">View Requests</a></li>            
            <li><a href="Signin.php">Add A New Route</a></li>
            <li><a href="Signin.php">View Routes</a></li>

          </ul>
        </div><!--/.nav-collapse -->
      </div>
    </div>

    <div class="container">

      
      <form class="form-signin text-center">
         <h2 class="form-signin-heading">ADMIN LOGIN</h2>
         <br>
         <br>
         <br>
         <br>
        <h3 class="form-signin-heading">Please Sign In</h3>
        <br />
        <input type="text" class="form-control" placeholder="Username" required id="username">
        <input type="password" class="form-control" placeholder="Password" required id="pass">
        
        <br />
        <a href="newuser.php"><h4>New to Busdroid? Create an Account</h4></a>
        <button class="btn btn-primary btn-block" type="submit" id="login-button">Sign in</button>
         
      </form>
       
    </div> <!-- /container -->

  <!--  <div id="footer">
      <p class="text-muted">&copy;2014 All rights reserved Arpit Kumar, Shrihari Bhat, Siddharth Rakesh & Sachin Kumar </p>
    </div> -->

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
  </body>
</html>
