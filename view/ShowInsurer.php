<!DOCTYPE html>
<?php
  include "../config/config.php";
  include "../model/database.php";
  $database = new Database();

  # Check form submitted?
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    # process form, validate as required then redirect
    # header('Location: ClaimDetails.php?claimID='.$currentID['claimID']);
  } else {
    # First time visitor
    $insurerArray = $database->getAllInsurer();
  }
?>
<html lang="en">
<head>
  <?php include('../includes/HeadSection.php'); ?>
  <title>Insurance Company Entries</title>    
</head>
<body>
  <div class="container">
    <?php include('../includes/SubLevelNav.php'); ?>
    <div class="row well well-sm">
      <h1>M&amp;M Insurance Company Entries</h1>
    </div><!-- end row well well-sm -->
    <div class="row insurer-header well well-sm">
      <div class="col-lg-2 insurer-name">
        Name
      </div><!-- end insurer-name -->
      <div class="col-lg-2 insurer-phone">
        Phone
      </div><!-- end insurer-phone -->         
      <div class="col-lg-2 insurer-email">
        Email
      </div><!-- end insurer-email -->
      <div class="col-lg-6 insurer-address">
        Address
      </div><!-- end insurer-address -->                        
    </div><!-- end row insurer-header -->
    <div class="row insurer-list">
      <?php 
        if (count($insurerArray) > 0) {
          # Display array contents via loop
          foreach ($insurerArray as $insurer) {
            ?>
        <div class="col-lg-2 insurer-name">
          <a href="http://localhost/mminsurance.com/view/EditInsurer.php?insurerID=<?=$insurer['insurerID']?>"><?=$insurer['insurerName']?></a>
        </div><!-- end insurer-name -->
        <div class="col-lg-2 insurer-phone">
          <?= $insurer['insurerPhone']; ?>
        </div><!-- end insurer-phone -->         
        <div class="col-lg-2 insurer-email">
          <a href="mailto:<?= $insurer['insurerEmail']; ?>"><?= $insurer['insurerEmail']; ?></a>
        </div><!-- end insurer-email -->
        <div class="col-lg-6 insurer-address">
          <?= $insurer['insurerAddress']; ?>, <?= $insurer['insurerCity']; ?>, <?= $insurer['insurerState']; ?>
        </div><!-- end insurer-address -->
      <?php
          }
        } else {
          # Nothing to see here
          echo ("<div>Zero insurer entries at this time</div>");
        }
      ?>    
      </div><!-- end insurer-list -->  
    </div><!-- end container -->
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="../js/jquery-1-11-3.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="/mminsurance.com/js/bootstrap.min.js"></script>
</body>
</html>