<!DOCTYPE html>
<?php
  include "../config/config.php";
  include "../model/database.php";
  $database = new Database();
  $strMessage = '';

  # Check form submitted?
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    # process form, validate as required then redirect
    $insuredID = $_POST['insuredID'];    
    try {
      $database->updateInsured($_POST);
      $strMessage = "Update complete!";
    } catch (Exception $e) {
      $strMessage = "Error during database update: ". $e;
      echo($strMessage);
    }
  } elseif (empty($_GET['insuredID'])) {
    header('Location: ../index.php');
  } else {
    # Sent in to edit insured
    $insuredID = $_GET['insuredID'];
  }
  $insured = $database->getInsured($insuredID);
?>
<html lang="en">
<head>
  <?php include('../includes/HeadSection.php'); ?>
  <title>Edit Insured</title>    
</head>
<body>
  <div class="container">
    <?php include('../includes/SubLevelNav.php'); ?>
    <div class="row well well-sm">
      <span class="h1">M&amp;M Edit Insured</span>
      <?php
        if (strlen($strMessage) > 0) {
          echo "<span class='string-message'>( $strMessage )</span>";
        }
      ?>
      
    </div><!-- end row well well-sm -->
      <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
        <input type="hidden" name="insuredID" value="<?= $insuredID ?>">
        <div class="form-group col-lg-6">
          <label for="firstName">First Name</label> (Leave blank for business entries)
          <input type="text" class="form-control" id="firstName" name="firstName" placeholder="Jane" value="<?= $insured['firstName']; ?>">
        </div>     
        <div class="form-group col-lg-6">
          <label for="lastName">Last Name or Business Name</label>
          <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Doe" value="<?= $insured['lastName']; ?>">
        </div> 
        <div class="form-group col-lg-4">
          <label for="phone">Phone</label>
          <input type="tel" class="form-control" id="phone" name="phone" placeholder="800-555-1212" value="<?= $insured['phone']; ?>">
        </div>    
        <div class="form-group col-lg-4">
          <label for="cell">Cell</label>
          <input type="tel" class="form-control" id="cell" name="cell" placeholder="800-555-1212" value="<?= $insured['cell']; ?>">
        </div>             
        <div class="form-group col-lg-4">
          <label for="email">Email address</label>
          <input type="email" class="form-control" id="email" name="email" placeholder="Jane@Doe.com" value="<?= $insured['email']; ?>">
        </div>
        <div class="form-group col-lg-4">
          <label for="address">Street address</label>
          <input type="text" class="form-control" id="address" name="address" placeholder="123 Main Street" value="<?= $insured['address']; ?>">
        </div>
        <div class="form-group col-lg-4">
          <label for="city">City</label>
          <input type="text" class="form-control" id="city" name="city" placeholder="Anytown" value="<?= $insured['city']; ?>">
        </div> 
        <div class="form-group col-lg-4">
          <label for="state">State</label>
          <input type="text" class="form-control" id="state" name="state" placeholder="Florida" value="<?= $insured['state']; ?>">
        </div>
        <div class="form-group col-lg-4">
          <label for="county">County</label>
          <input type="text" class="form-control" id="county" name="county" placeholder="Seminole County" value="<?= $insured['county']; ?>">
        </div>
        <div class="form-group col-lg-4">
          <label for="country">Country</label>
          <input type="text" class="form-control" id="country" name="country" placeholder="United States" value="<?= $insured['country']; ?>">
        </div>
        <div class="form-group col-lg-4">
          <label for="postcode">Zip/Postcode</label>
          <input type="text" class="form-control" id="postcode" name="postcode" placeholder="12345" value="<?= $insured['postcode']; ?>">
        </div>                  
        <div class="form-group col-lg-12">        
          <label for="notes">Additional Details</label>
          <input type="text" class="form-control" id="notes" name="notes" placeholder="Boots, boots, marching up and down again." value="<?= $insured['notes']; ?>">
        </div> 
        <div class="form-group col-lg-12">        
          <button type="submit" class="btn btn-info">Update!</button>
        </div> 
      </form>
  </div><!-- end container -->
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="../js/jquery-1-11-3.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="/mminsurance.com/js/bootstrap.min.js"></script>
</body>
</html>