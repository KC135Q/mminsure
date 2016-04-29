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
    # First time
  }
?>
<html lang="en">
<head>
  <?php include('../includes/HeadSection.php'); ?>
  <title>Add Claim</title>    
</head>
<body>
  <div class="container">
    <?php include('../includes/SubLevelNav.php'); ?>
    <div class="row well well-sm">
      <h1>M&amp;M Add Claim</h1>
    </div><!-- end row well well-sm -->

  </div><!-- end container -->
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="../js/jquery-1-11-3.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="/mminsurance.com/js/bootstrap.min.js"></script>
</body>
</html>