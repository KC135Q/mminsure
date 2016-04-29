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
      $claimID = $_GET['claimID'];
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
  <?php include('../includes/HeadSection.php'); ?>
    <title>Claim Details</title>
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
            <li><a href="http://localhost/mminsurance.com/view/AddAttachment.php?claimID=<?= $claimID; ?>">Add Attachment</a></li>
            <li><a href="http://localhost/mminsurance.com/view/AddTime.php?claimID=<?= $claimID; ?>">Timesheet</a></li>
            <li><a href="http://localhost/mminsurance.com/view/PhotoSheet.php?claimID=<?= $claimID; ?>">Create Photo Sheet</a></li>           
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
      <div class="col-lg-5 insured-details img-rounded  claim-details">
        <h3>Insured Details
        <a href="EditInsured.php?insuredID=<?= $claim['insuredID']; ?>">(edit)</a></h3>
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
              echo ("<span class='claim-label'>Claim Number</span> ");
              echo ("<span id='claimID'>" . $claim['claimID'] . "</span>");
            ?>
            <br>
            <?php
              $rowString = '<span class="claim-label">Status</span><span id="claim-status"> ' . $claim['status'] . '</span>';
              echo $rowString;
              echo ("<span class='badge pull-right claim-status'>Change Status</span>");
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
    <div class="row insurer-details  claim-details col-lg-12 img-rounded">
      <h3>Insurer Details <a href="EditInsurer.php?insurerID=<?= $claim['insurerID']; ?>">(edit)</a></h3>
        <div class="row well">
          <div class="col-lg-6">
            <?php
              echo "<span class='h3'>". $claim['insurerName'] ."</span>";
            ?>   
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
    <div class="row loss-details col-lg-12  claim-details">
      <h3>Loss Details</h3>
        <div class="row well">
          <div class="row top-half-loss">
            <div class="col-lg-6 left-half-loss">
              <div id="loss-date-reported">
                <span class="claim-label">Date Reported:</span> 
                <?= date('m/d/Y' ,strtotime($claim['dateReported'])); ?>
              </div><!-- end loss-date-reported -->
              <div id="loss-time">
              <span class="claim-label">Time of Loss</span> <?= $claim['timeOfLoss']; ?>
              </div><!-- end loss-time -->
               <div id="loss-gross-value"><span class="claim-label">Gross Loss Value</span> <?= $claim['grossLossValue']; ?>
              </div><!-- end loss-gross-value -->
              <div id="loss-actual-value"><span class="claim-label">Actual Cash Value</span> <?= $claim['actualCashValue']; ?>
              </div><!-- end loss-actual-value -->
              <div id="loss-replacement-cost"><span class="claim-label">Replacement Cost</span> <?= $claim['replacementCost']; ?>
              </div><!-- end loss-replacement-cost -->
              <div id="loss-date"><span class="claim-label">Date of Loss</span>
                <?= date('m/d/Y' ,strtotime( $claim['dateOfLoss'])); ?>
              </div><!-- end loss-date -->
            </div><!-- end left-half-loss -->
            <div class="col-lg-6 right-half-loss">
              <div id="loss-"><span class="claim-label">Loss Location</span> <?= $claim['lossLocation']; ?>
              </div><!-- end loss- -->
              <div id="loss-"><span class="claim-label">Loss County</span> <?= $claim['lossCounty']; ?>
              </div><!-- end loss- -->
              <div id="loss-"><span class="claim-label">Loss State</span> <?= $claim['lossState']; ?>
              </div><!-- end loss- -->
            </div><!-- end right-half-loss -->
          </div><!-- end top-half-loss -->
          <div class="row bottom-half-loss">
            <div class="col-lg-12 full-bottom-half-loss">
              <div id="loss-description">             
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">Loss Description</h3>
                  </div>
                  <div class="panel-body">
                    <?= $claim['lossDescription']; ?>
                  </div>
                </div>            
              </div><!-- end loss-description -->
              <div id="loss-notes">
                <div class="panel panel-default">
                  <div class="panel-heading">
                    <h3 class="panel-title">Addtional Notes</h3>
                  </div>
                  <div class="panel-body">
                    <?= $claim['lossNotes']; ?>
                  </div>
                </div>                
              </div><!-- end loss-notes -->
            </div><!-- end full-bottom-half-loss -->
          </div><!-- end bottom-half-loss -->
        </div><!-- end row -->
    </div><!-- end row loss-details -->        
    </div><!-- end container -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../js/jquery-1-11-3.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/mminsurance.com/js/bootstrap.min.js"></script>
    <!-- Page specific javascript -->
    <script>
      $(document).ready(function() {
        $('.claim-status').on('click',  function() {
          console.log("clicked");
          var claimID = document.getElementById("claimID").textContent;
          var jqxhr = $.ajax("../controller/ChangeStatus.php?claimID="+claimID)
          .success(function() {
            console.log("Accessed the file");
            $('#claim-status').replaceWith ("<span id='claim-status'> " + (jqxhr.responseText) + "</span>");
            console.log(jqxhr.responseText);
          });
        });
      });
    </script>
  </body>
</html>

