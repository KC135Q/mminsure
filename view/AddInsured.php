<!DOCTYPE html>
<?php
  include "../config/config.php";
  include "../model/database.php";
  $database = new Database();

  # Check form submitted?
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    # process form
    $database->addInsured($_POST);
    # Add validation later, but for now just redirect
    header('Location: InsuredAdded.php');
  }
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Add Insured</title>

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
            <li><a href="#">General Claims</a></li>
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
    <div class="row well well-sm">
      <h1>M&amp;M Add Insured</h1>
    </div><!-- end row well well-sm -->
      <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
        <div class="form-group col-lg-6">
          <label for="firstName">First Name</label> (Leave blank for business entries)
          <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Jane">
        </div>     
        <div class="form-group col-lg-6">
          <label for="lastName">Last Name or Business Name</label>
          <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Doe">
        </div> 
        <div class="form-group col-lg-4">
          <label for="phone">Phone</label>
          <input type="tel" class="form-control" id="phone" name="phone" placeholder="800-555-1212">
        </div>    
        <div class="form-group col-lg-4">
          <label for="cell">Cell</label>
          <input type="cell" class="form-control" id="cell" name="cell" placeholder="800-555-1212">
        </div>             
        <div class="form-group col-lg-4">
          <label for="email">Email address</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Jane@Doe.com">
        </div>
        <div class="form-group col-lg-4">
          <label for="address">Street address</label>
          <input type="address" class="form-control" id="address" name="address" placeholder="123 Main Street">
        </div>
        <div class="form-group col-lg-4">
          <label for="city">City</label>
          <input type="city" class="form-control" id="city" name="city" placeholder="Anytown">
        </div> 
        <div class="form-group col-lg-4">
          <label for="state">State</label>
          <input type="state" class="form-control" id="state" name="state" placeholder="Florida">
        </div>
        <div class="form-group col-lg-4">
          <label for="county">County</label>
          <input type="county" class="form-control" id="county" name="county" placeholder="Seminole County">
        </div>
        <div class="form-group col-lg-4">
          <label for="country">Country</label>
          <input type="country" class="form-control" id="country" name="country" placeholder="United States">
        </div>
        <div class="form-group col-lg-4">
          <label for="postcode">Zip/Postcode</label>
          <input type="postcode" class="form-control" id="postcode" name="postcode" placeholder="12345">
        </div>                  
        <div class="form-group col-lg-12">        
          <label for="notes">Additional Details</label>
          <input type="notes" class="form-control" id="notes" name="notes" placeholder="Boots, boots, marching up and down again.">
        </div> 
        <div class="form-group col-lg-12">        
          <button type="submit" class="btn btn-default">Add Insured</button>
        </div> 
      </form>    
    </div><!-- end container -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/mminsurance.com/js/bootstrap.min.js"></script>
  </body>
</html>