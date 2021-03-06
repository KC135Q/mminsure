<!DOCTYPE html>
<?php
  include "../config/config.php";
  include "../model/database.php";
  $database = new Database();
  $addedID = $database->lastInsertId();
  $insured = $database->getInsured($addedID);
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Insured Added</title>

    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Override -->
    <link href="../css/bootstrap-override.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>
    <div class="container">
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="http://localhost/mminsurance.com/index.php">
            <img src="../images/MM-Logo.png" height='30px' width='30px' alt="M&amp;M Logo">
          </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li><a href="http://localhost/mminsurance.com/view/AllClaims.php">All Claims</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Quick Actions <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="http://localhost/mminsurance.com/view/AddClaim.php">Add Claim</a></li>
                <li><a href="http://localhost/mminsurance.com/view/AddInsured.php">Add Insured</a></li>
                <li><a href="http://localhost/mminsurance.com/view/AddInsurer.php">Add Insurance Company</a></li>
              </ul>
            </li>          
            <form class="navbar-form navbar-left" role="search">
              <div class="form-group">
                <input type="text" class="form-control" placeholder="Search">
              </div>
              <button type="submit" class="btn btn-default">Search</button>
            </form>  
          </ul>
        </div><!-- /.navbar-collapse -->
      </div><!-- /.container-fluid -->
    </nav>

    <!-- End Nav Section -->

    <div class="row well well-sm">
      <h1>M&amp;M Insured Added</h1>
    </div><!-- end row well well-sm -->
      <ul class="list-group col-lg-6">
        <li class="list-group-item">
          <span class="badge">Name</span>
          <?php
            if (strlen($insured["firstName"]) > 0) {
              echo ($insured["firstName"].' ');    
            }
            echo ($insured["lastName"]);
           ?>
        </li>
        <li class="list-group-item">
          <span class="badge">Phone</span>
          <?=$insured["phone"]?>
        </li>
        <li class="list-group-item">
          <span class="badge">Cell</span>
          <?=$insured["cell"]?>
        </li>
        <li class="list-group-item">
          <span class="badge">Email address</span>
          <?=$insured["email"]?>
        </li>
        <li class="list-group-item">
          <span class="badge">Address</span>
          <?php 
            echo ($insured["address"].' '.$insured["city"].', '.$insured["state"].', '.$insured["postcode"]);
           ?>
        </li>
        <li class="list-group-item">
          <span class="badge">County</span>
          <?=$insured["county"]?>
        </li>
        <li class="list-group-item">
          <span class="badge">Country</span>
          <?=$insured["country"]?>
        </li>
        <li class="list-group-item">
          <span class="badge">Notes</span>
          <?=$insured["notes"]?>
        </li>        
      </ul>
    </div><!-- end container -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../js/jquery-1-11-3.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/mminsurance.com/js/bootstrap.min.js"></script>
  </body>
</html>