<!DOCTYPE html>
<?php
  include "../config/config.php";
  include "../model/database.php";
  $database = new Database();

  # Check form submitted?
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    # process form
    $database->addInsurer($_POST);
    # Add validation later, but for now just redirect
    header('Location: InsurerAdded.php');
  }
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Add Insurance Company</title>

    <!-- Bootstrap -->
    <link href="http://localhost/mminsurance.com//css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap Override -->
    <link href="http://localhost/mminsurance.com//css/bootstrap-override.css" rel="stylesheet">

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
            <img src="http://localhost/mminsurance.com//images/MM-Logo.png" height='30px' width='30px' alt="M&amp;M Logo">
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
    <div class="row well well-sm">
      <h1>M&amp;M Add Insurance Company</h1>
    </div><!-- end row well well-sm -->
      <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
        <div class="form-group col-lg-6">
          <label for="insurerName">Business Name</label>
          <input type="text" class="form-control" id="insurerName" name="insurerName" placeholder="Amce Insurance Company">
        </div>     
        <div class="form-group col-lg-6">
          <label for="insurerRep">Full Name of Business Representative</label>
          <input type="text" class="form-control" id="insurerRep" name="insurerRep" placeholder="Mr. John Doe">
        </div> 
        <div class="form-group col-lg-4">
          <label for="insurerPhone">Phone</label>
          <input type="tel" class="form-control" id="insurerPhone" name="insurerPhone" placeholder="800-555-1212">
        </div>          
        <div class="form-group col-lg-4">
          <label for="insurerEmail">Email Address</label>
          <input type="email" class="form-control" id="insurerEmail" name="insurerEmail" placeholder="J.Doe@AMCE.com">
        </div>
        <div class="form-group col-lg-4">
          <label for="insurerWebsite">Company Website</label>
          <input type="text" class="form-control" id="insurerWebsite" name="insurerWebsite" placeholder="www.amce.com">
        </div>        
        <div class="form-group col-lg-4">
          <label for="insurerAddress">Street Address</label>
          <input type="text" class="form-control" id="insurerAddress" name="insurerAddress" placeholder="123 Main Street">
        </div>
        <div class="form-group col-lg-4">
          <label for="insurerCity">City</label>
          <input type="text" class="form-control" id="insurerCity" name="insurerCity" placeholder="Anytown">
        </div> 
        <div class="form-group col-lg-4">
          <label for="insurerState">State</label>
          <input type="text" class="form-control" id="insurerState" name="insurerState" placeholder="Florida">
        </div>
        <div class="form-group col-lg-3">
          <label for="insurerCountry">Country</label>
          <input type="text" class="form-control" id="insurerCountry" name="insurerCountry" placeholder="United States">
        </div>
        <div class="form-group col-lg-3">
          <label for="insurerPostcode">Zip/Postcode</label>
          <input type="text" class="form-control" id="insurerPostcode" name="insurerPostcode" placeholder="12345">
        </div>
        <div class="form-group col-lg-12">        
          <label for="insurerNotes">Additional Details</label>
          <input type="text" class="form-control" id="insurerNotes" name="insurerNotes" placeholder="Boots, boots, marching up and down again.">
        </div>
        <div class="form-group col-lg-12">        
          <button type="submit" class="btn btn-info">Add Insurance Company</button>
        </div>                                       

      </form>    
    </div><!-- end container -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../js/jquery-1-11-3.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/mminsurance.com/js/bootstrap.min.js"></script>
  </body>
</html>