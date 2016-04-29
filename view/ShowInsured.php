<!DOCTYPE html>
<?php
  include "../config/config.php";
  include "../model/database.php";
  $database = new Database();

  # Check form submitted?
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    # process form, validate as required then redirect
    header('Location: ClaimDetails.php?claimID='.$currentID['claimID']);
  } else {
    # First time visitor
    $insuredArray = $database->getAllInsured();
  }
?>
<html lang="en">
<head>
  <?php include('../includes/HeadSection.php'); ?>
  <title>Insured Entries</title>    
</head>
<body>
  <div class="container">
    <?php include('../includes/SubLevelNav.php'); ?>
    <div class="row well well-sm">
      <h1>M&amp;M Insured Entries</h1>
    </div><!-- end row well well-sm -->
    <div class="row insured-header well well-sm">
      <div class="col-lg-2 insured-name">
        Name
      </div><!-- end insured-name -->
      <div class="col-lg-2 insured-phone">
        Phone
      </div><!-- end insured-phone -->         
      <div class="col-lg-2 insured-email">
        Email
      </div><!-- end insured-email -->
      <div class="col-lg-6 insured-address">
        Address
      </div><!-- end insured-address -->                        
    </div><!-- end row insured-header -->
    <div class="row insured-list">
      <?php 
        if (count($insuredArray) > 0) {
          # Display array contents via loop
          foreach ($insuredArray as $insured) {
            ?>
        <div class="col-lg-2 insured-name">
          <a href="http://localhost/mminsurance.com/view/EditInsured.php?insuredID=<?=$insured['insuredID']?>"><?=$insured['lastName']?>, <?=$insured['firstName']?></a>
        </div><!-- end insured-name -->
        <div class="col-lg-2 insured-phone">
          <?= $insured['phone']; ?>
        </div><!-- end insured-phone -->         
        <div class="col-lg-2 insured-email">
          <a href="mailto:<?= $insured['email']; ?>"><?= $insured['email']; ?></a>
        </div><!-- end insured-email -->
        <div class="col-lg-6 insured-address">
          <?= $insured['address']; ?>, <?= $insured['city']; ?>, <?= $insured['state']; ?>
        </div><!-- end insured-address -->
      <?php
          }
        } else {
          # Nothing to see here
          echo ("<div>Zero insured entries at this time</div>");
        }
      ?>    
      </div><!-- end insured-list -->  
    </div><!-- end container -->
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="../js/jquery-1-11-3.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="/mminsurance.com/js/bootstrap.min.js"></script>
</body>
</html>