<!DOCTYPE html>
<?php
  include "../config/config.php";
  include "../model/database.php";
  $database = new Database();
  $strError = '';

  # Check form submitted?
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Process form submission
  } elseif(empty($_GET['claimID'])) {
    # Incorrect url structure so send them back to the home page
    header('Location: http://localhost/mminsurance.com/');
  } else {
    # first time visitor so show the form
    try {
      $claim = $database->getClaimDetails($_GET['claimID']);
      if (empty($claim)) {
        throw new Exception('Claim, insured, or insurer not found!');
      }
    } catch (Exception $e) {
      $strError = "Error found: ". $e;
    }
  }
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Claim Details</title>

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
          <a class="navbar-brand" href="/mminsurance.com/index.php">
            <img src="../images/MM-Logo.png" height='30px' width='30px' alt="M&amp;M Logo">
          </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
          <ul class="nav navbar-nav">
            <li><a href="http://localhost/mminsurance.com/view/AllClaims.php">All Claims</a></li>
            <li><a href="http://localhost/mminsurance.com/view/AddAttachment.php?claimID=<?=$claim['claimID']?>">Add Attachment</a></li>
            <li><a href="#">Time</a></li>
            <li><a href="http://localhost/mminsurance.com/view/PhotoSheet.php?claimID=<?=$claim['claimID']?>">Photo Sheet</a></li>           
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Quick Actions <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="http://localhost/mminsurance.com/view/AddClaim.php">Add Claim</a></li>
                <li><a href="http://localhost/mminsurance.com/view/AddAttachment.php?claimID=<?=$claim['claimID']?>">Add Attachment</a></li>
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
      <h1>M&amp;M Claim Details</h1>
    </div><!-- end row well well-sm -->
    <div class="row insured-claim-details">
      <div class="col-lg-5 insured-details img-rounded">
        <h3>Insured Details</h3>
          <div class="row well">
            <?php
              $rowString = $claim['lastName'];
              if (!empty($claim['firstName'])) {
                $rowString .= ", ". $claim['firstName'];
              }
              echo $rowString;
            ?>
            <br>
            <?php
              $rowString = '<span class="claim-label">Phone</span> ' . $claim['phone'];
              echo $rowString;
            ?>
            <br>
            <?php
              $rowString = '<span class="claim-label">Cell</span> ' . $claim['cell'];
              echo $rowString;
            ?>
            <br>
            <?php
              $rowString = $claim['address'];
              echo $rowString;
            ?>
            <br>
            <?php
              $rowString = $claim['city']. ", ". $claim['state'];
              echo $rowString;
            ?>
            <br>
            <?php
              $rowString = $claim['country']. ', '. $claim['postcode'];
              echo $rowString;
            ?>
            <br>       
          </div><!-- end row -->
      </div><!-- end insured-details -->
      <div class="col-lg-5 claim-details col-lg-offset-1 img-rounded">
        <h3>Claim Details</h3>
          <div class="row well">
            <?php
              $rowString = "<span class='claim-label'>Claim Number</span> ". $claim['claimID'];
              echo $rowString;
            ?>
            <br>
            <?php
              $rowString = '<span class="claim-label">Status</span> ' . $claim['status'];
              echo $rowString;
            ?>
            <br>
            <?php
              $rowString = '<span class="claim-label">Received</span> ';
              $rowString .= date('m/d/Y' ,strtotime($claim['dateReported']));
              echo $rowString;
            ?>
            <br>
            <?php
              $rowString = '<span class="claim-label">Adjuster</span> ' . "Rick Makowski";
              echo $rowString;
            ?>
            <br>
            <?php
              $rowString = '<span class="claim-label">Age</span> ';
              $now = new DateTime();
              $oldDate = new DateTime($claim['dateReported']);
              $rowString .= $now->diff($oldDate)->days . ' Days';
              echo $rowString;
            ?>    
          </div><!-- end row -->
      </div><!-- end insured-details -->      
    </div><!-- end row insured-claim-details -->
    <div class="row insurer-details col-lg-12 ">
      <h3>Insurer Details</h3>
        <div class="row well">
          <div class="col-lg-6">
            <?php
              $rowString = "<h3><a href='". $claim['insurerWebsite'] ."' target='_blank'>". $claim['insurerName'] ."</a></h3>";
              echo $rowString;
            ?>
            <br>
          </div><!-- end column -->
          <div class="col-lg-6">
            <?php
              $rowString = "<span class='claim-label'>Rep</span> ". $claim['insurerRep'];
              echo $rowString;
            ?>
            <br>
            <?php
              $rowString = "<span class='claim-label'>Phone</span> ". $claim['insurerPhone'];
              echo $rowString;
            ?>
            <br>
            <?php
              $rowString = "<span class='claim-label'>Email</span> ";
              $rowString .= "<a href='mailto:".$claim['insurerEmail']."'>" . $claim['insurerEmail'] ."</a>";
              echo $rowString;
            ?>
            <br>
          </div><!-- end column -->   
       </div><!-- end row -->
    </div><!-- end row insurer-details -->
    <div class="row loss-details col-lg-12">
      <h3>Loss Details</h3>
        <div class="row well">
          <?php
            $rowString = "<span class='claim-label'>Claim Number</span> ". $claim['claimID'];
            echo $rowString;
          ?>
          <br>     
        </div><!-- end row -->
    </div><!-- end row loss-details -->        
    </div><!-- end container -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../js/jquery-1-11-3.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/mminsurance.com/js/bootstrap.min.js"></script>
  </body>
</html>