<!DOCTYPE html>
<?php
  include "../config/config.php";
  include "../model/database.php";
  $database = new Database();
  $strMessage = '';

  # Check form submitted?
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    # process form, validate as required then redirect
    $insurerID = $_POST['insurerID'];    
    try {
      $database->updateInsurer($_POST);
      $strMessage = "Update complete!";
    } catch (Exception $e) {
      $strMessage = "Error during database update: ". $e;
      echo($strMessage);
    }
  } elseif (empty($_GET['insurerID'])) {
    header('Location: ../index.php');
  } else {
    # Sent in to edit insurer
    $insurerID = $_GET['insurerID'];
  }
  $insurer = $database->getInsurer($insurerID);
?>
<html lang="en">
<head>
  <?php include('../includes/HeadSection.php'); ?>
  <title>Edit Insurance Company</title>    
</head>
<body>
  <div class="container">
    <?php include('../includes/SubLevelNav.php'); ?>
    <div class="row well well-sm">
      <span class="h1">M&amp;M Edit Insurance Company</span>
      <?php
        if (strlen($strMessage) > 0) {
          echo "<span class='string-message'>( $strMessage )</span>";
        }
      ?>
      
    </div><!-- end row well well-sm -->
      <form action="<?=$_SERVER['PHP_SELF']?>" method="POST">
        <input type="hidden" name="insurerID" value="<?= $insurerID ?>">
        <div class="form-group col-lg-6">
          <label for="insurerName">Business Name</label>
          <input type="text" class="form-control" id="insurerName" name="insurerName" placeholder="Amce Insurance Company" value="<?= $insurer['insurerName']; ?>">
        </div>     
        <div class="form-group col-lg-6">
          <label for="insurerRep">Full Name of Business Representative</label>
          <input type="text" class="form-control" id="insurerRep" name="insurerRep" placeholder="Mr. John Doe" value="<?= $insurer['insurerRep']; ?>">
        </div> 
        <div class="form-group col-lg-4">
          <label for="insurerPhone">Phone</label>
          <input type="tel" class="form-control" id="insurerPhone" name="insurerPhone" placeholder="800-555-1212" value="<?= $insurer['insurerPhone']; ?>">
        </div>          
        <div class="form-group col-lg-4">
          <label for="insurerEmail">Email Address</label>
          <input type="email" class="form-control" id="insurerEmail" name="insurerEmail" placeholder="J.Doe@AMCE.com" value="<?= $insurer['insurerEmail']; ?>">
        </div>
        <div class="form-group col-lg-4">
          <label for="insurerWebsite">Company Website</label>
          <input type="text" class="form-control" id="insurerWebsite" name="insurerWebsite" placeholder="www.amce.com" value="<?= $insurer['insurerWebsite']; ?>">
        </div>        
        <div class="form-group col-lg-4">
          <label for="insurerAddress">Street Address</label>
          <input type="text" class="form-control" id="insurerAddress" name="insurerAddress" placeholder="123 Main Street" value="<?= $insurer['insurerAddress']; ?>">
        </div>
        <div class="form-group col-lg-4">
          <label for="insurerCity">City</label>
          <input type="text" class="form-control" id="insurerCity" name="insurerCity" placeholder="Anytown" value="<?= $insurer['insurerCity']; ?>">
        </div> 
        <div class="form-group col-lg-4">
          <label for="insurerState">State</label>
          <input type="text" class="form-control" id="insurerState" name="insurerState" placeholder="Florida" value="<?= $insurer['insurerState']; ?>">
        </div>
        <div class="form-group col-lg-3">
          <label for="insurerCountry">Country</label>
          <input type="text" class="form-control" id="insurerCountry" name="insurerCountry" placeholder="United States" value="<?= $insurer['insurerCountry']; ?>">
        </div>
        <div class="form-group col-lg-3">
          <label for="insurerPostcode">Zip/Postcode</label>
          <input type="text" class="form-control" id="insurerPostcode" name="insurerPostcode" placeholder="12345" value="<?= $insurer['insurerPostcode']; ?>">
        </div>
        <div class="form-group col-lg-12">        
          <label for="insurerNotes">Additional Details</label>
          <input type="text" class="form-control" id="insurerNotes" name="insurerNotes" placeholder="Boots, boots, marching up and down again." value="<?= $insurer['insurerNotes']; ?>">
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