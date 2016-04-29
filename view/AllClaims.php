<!DOCTYPE html>
<?php
  include "../config/config.php";
  include "../model/database.php";
  $database = new Database();
?>
<html lang="en">
<head>
  <?php include('../includes/HeadSection.php'); ?>
  <title>M&amp;M Show Claims</title>    
</head>

  <body>
    <div class="container">
     <?php include('../includes/SubLevelNav.php'); ?>
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