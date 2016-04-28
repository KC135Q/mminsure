<!DOCTYPE html>
<?php
  include "../config/config.php";
  include "../model/database.php";
  $database = new Database();

  # Check form submitted?
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    # process form
    $database->addClaim($_POST);
    # Add validation later, but for now just redirect
    header('Location: ClaimAdded.php');
  } else {
    # first time visitor so show the form
    $insuredList = $database->getAllInsured();
    $insurerList = $database->getAllInsurer();
  }
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Add Claim</title>

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
            <li><a href="#">Attachment</a></li>
            <li><a href="#">Time</a></li>
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Quick Actions <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="http://localhost/mminsurance.com/view/AddClaim.php">Add Claim</a></li>
                <li><a href="#">Add Attachment</a></li>
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
      <h1>M&amp;M Add Claim</h1>
    </div><!-- end row well well-sm -->
      <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
        <div class="form-group col-lg-6">        
          <label for="insuredID">Select Insured Party</label>
          <select type="text" class="form-control" id="insuredID" name="insuredID">
            <?php
              foreach($insuredList as $insuredParty) {
                $firstName = $insuredParty['firstName'];
                if (strlen($firstName) > 0) {
                  $firstName = ", ". $firstName; 
                }
                echo("<option value='". $insuredParty['insuredID'] ."'>". $insuredParty['lastName'] . $firstName ."</option>\n");
              }
            ?>
          </select>
        </div>

        <div class="form-group col-lg-6">        
          <label for="insurerID">Select Insurance Company</label>
          <select type="text" class="form-control" id="insurerID" name="insurerID">
            <?php
              foreach($insurerList as $insurerCompany) {
                echo("<option value='". $insurerCompany['insurerID'] ."'>". $insurerCompany['insurerName'] . " ". $insurerCompany['insurerAddress'] ."</option>\n");
              }
            ?>
          </select>
        </div>
        <div class="form-group col-lg-6">
          <label for="policyNumber">Insurance Policy Number</label>
          <input type="text" class="form-control" id="policyNumber" name="policyNumber" placeholder="WDC-216-332">
        </div> 
        <div class="form-group col-lg-6">
          <label for="insurerClaimNumber">Insurance Company Claim Number</label>
          <input type="text" class="form-control" id="insurerClaimNumber" name="insurerClaimNumber" placeholder="123-12345">
        </div>
        <div class="form-group col-lg-6">
          <label for="dateOfLoss">Date of Loss</label>
          <input type="date" class="form-control" id="dateOfLoss" name="dateOfLoss" placeholder="02/22/2020">
        </div>
        <div class="form-group col-lg-6">
          <label for="dateReported">Date Reported</label>
          <input type="date" class="form-control" id="dateReported" name="dateReported" placeholder="02/25/2020">
        </div>
        <div class="form-group col-lg-6">
          <label for="timeOfLoss">Time of loss</label>
          <input type="time" class="form-control" id="timeOfLoss" name="timeOfLoss" placeholder="6:45pm">
        </div>
        <div class="form-group col-lg-6">
          <label for="grossLossValue">Gross Loss Value</label>
          <input type="text" class="form-control" id="grossLossValue" name="grossLossValue" placeholder="$2,500.00">
        </div>
        <div class="form-group col-lg-6">
          <label for="actualCashValue">Actual Cash Value</label>
          <input type="text" class="form-control" id="actualCashValue" name="actualCashValue" placeholder="$1,750.00">
        </div>
        <div class="form-group col-lg-6">
          <label for="replacementCost">Replacement Cost</label>
          <input type="text" class="form-control" id="replacementCost" name="replacementCost" placeholder="$2,750.00">
        </div>
        <div class="form-group col-lg-6">
          <label for="lossDescription">Loss description</label>
          <input type="text" class="form-control" id="lossDescription" name="lossDescription" placeholder="The loss was...">
        </div>
        <div class="form-group col-lg-6">
          <label for="lossLocation">Loss location</label>
          <input type="text" class="form-control" id="lossLocation" name="lossLocation" placeholder="The loss was located at...">
        </div>
        <div class="form-group col-lg-6">
          <label for="lossCounty">County loss occurred in</label>
          <input type="text" class="form-control" id="lossCounty" name="lossCounty" placeholder="Seminole County">
        </div>
        <div class="form-group col-lg-6">
          <label for="lossNotes">Any additional details</label>
          <input type="text" class="form-control" id="lossNotes" name="lossNotes" placeholder="Notes go here">
        </div>                     
        <div class="form-group col-lg-12">        
          <button type="submit"  class="btn btn-info">Add Claim</button>
        </div> 
      </form>    
    </div><!-- end container -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../js/jquery-1-11-3.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/mminsurance.com/js/bootstrap.min.js"></script>
  </body>
</html>