<!DOCTYPE html>
<?php
  include "../config/config.php";
  include "../model/database.php";
  $database = new Database();
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>M&amp;M All Claims</title>

    <!-- Bootstrap -->
    <link href="/mminsurance.com/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Override -->
    <link href="/mminsurance.com/css/bootstrap-override.css" rel="stylesheet">

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
                <li role="separator" class="divider"></li>                
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
    <!--++++++++++++++++++++++++++++++++++++++++-->
    <!--                                        -->
    <!--            End Nav Section             -->
    <!--                                        -->
    <!--++++++++++++++++++++++++++++++++++++++++-->
    <div class="row well well-sm">
      <h1>M&amp;M All Claims</h1>
    </div><!-- end row well well-sm -->
      <div class="row claim-list">
        <h3>All Claims</h3>
        <div class="row open-claims well well-sm">
          <div class="col-lg-1 claim-number">
            <p>Number</p>
          </div>
          <div class="col-lg-1 date-of-loss">
            <p>Loss date</p>
          </div>
          <div class="col-lg-1 date-claimed">
            <p>Claim date</p>
          </div>
          <div class="col-lg-2 insured">
            <p>Insured</p>
          </div>                          
          <div class="col-lg-2 insurer">
            <p>Insurer</p>
          </div>
          <div class="col-lg-2 claim-status">
            <p>Status</p>
          </div>
          <div class="col-lg-2 claim-age">
            <p>Claim age</p>
          </div>                   
        </div><!-- end row open-claims -->
        <?php
          $allClaims = $database->getClaimsByStatus();
          if (empty ($allClaims)) {
          ?>
            <div class="row no-claims col-lg-12">
              <h3>No claims at this time.</h3>
            </div>
          <?php 
          }
          foreach ($allClaims as $claim) {
        ?>
        <div class="row claims-list ">
          <div class="col-lg-1 claim-number">
            <p><a href="http://localhost/mminsurance.com/view/ClaimDetails.php?claimID=<?=$claim['claimID']?>"><?= $claim['claimID'] ?></a></p>
          </div>
          <div class="col-lg-1 date-of-loss">
            <p><?= date('m/d/Y' ,strtotime($claim['dateOfLoss'])) ?></p>
          </div>
          <div class="col-lg-1 date-claimed">
            <p><?= date('m/d/Y' ,strtotime($claim['dateReported'])) ?></p>
          </div>
          <div class="col-lg-2 insured">
            <p><?= $claim['lastName'] . ' ' . $claim['firstName'] ?></p>
          </div>                           
          <div class="col-lg-2 insurer">
            <p><?= $claim['insurerName'] ?></p>
          </div>
          <div class="col-lg-2 claim-status">
            <p><?= $claim['status'] ?></p>
          </div>
          <div class="col-lg-2 claim-age">
            <p><?php
                $now = new DateTime();
                $oldDate = new DateTime($claim['dateReported']);
                echo ($now->diff($oldDate)->days . ' Days');
                ?></p>
          </div>                          
        </div><!-- end row claims-list -->        
        <?php
          }
         ?>
      </div><!-- end row claim-list">
    </div><!-- end container -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../js/jquery-1-11-3.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="../js/bootstrap.min.js"></script>
  </body>
</html>