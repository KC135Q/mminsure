<!DOCTYPE html>
<?php
  include "../config/config.php";
  include "../model/database.php";
  $database = new Database();

  # Check form submitted?
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    # process form
    $database->addTime($_POST);
    try {
      $claimID = $_POST['claimID'];
      $times = $database->getAllTimes($claimID);
      if (empty($claim)) {
        throw new Exception('Claim table for claim id '. $_POST['claimID'] .' not found!');
      }
    } catch (Exception $e) {
      $strError = "Error found: ". $e;
    }
  } elseif(empty($_GET['claimID'])) {
    # Incorrect url structure so send them back to the home page
    header('Location: http://localhost/mminsurance.com/');
  } else {
    # first time visitor so show the form
    try {
      $claimID = $_GET['claimID'];
      $times = $database->getAllTimes($claimID);
      if (empty($claim)) {
        throw new Exception('Claim table for claim id '. $_GET['claimID'] .' not found!');
      }
    } catch (Exception $e) {
      $strError = "Error found: ". $e;
    }
  }
?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Claim Timesheet</title>

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
          </ul>
          <ul class="nav navbar-nav navbar-right">
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Quick Actions <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="http://localhost/mminsurance.com/view/AddClaim.php">Add Claim</a></li>
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
      <h1>M&amp;M Timesheet</h1>
      <h3>Claim Number: <?= $claimID; ?></h3>
    </div><!-- end row well well-sm -->
    <!-- The data encoding type, enctype, MUST be specified as below -->
    <form action="AddTime.php" method="POST">
      <input type="hidden" name="claimID" value="<?= $claimID ?>">
      <div class="row whole-form">
        <div class="form-group col-lg-4">
          <label for="timeSpent">Time Spent</label>
          <input type="text" class="form-control" id="timeSpent" name="timeSpent" placeholder="1.0">
          <label for="timeDisbursementAmount">Disbursement Amount</label>
          <input type="text" class="form-control" id="timeDisbursementAmount" name="timeDisbursementAmount" placeholder="$60.00">

          <label for="timeDisbursementType">Disbursement Type</label>
          <select type="text" class="form-control" id="timeDisbursementType" name="timeDisbursementType">
            <option value="Public Records">Public records</option>
            <option value="Mileage">Mileage @ IRS Rate</option>
            <option value="File note">Postage</option>     
            <option value="File note">Photographs</option>
            <option value="Medical Records">Medical Records</option>
            <option value="Miscellaneous">Miscellaneous</option>            
          </select>          
          <label for="timeTaxable">Disbursement Taxable?</label>
          <input type="checkbox" name="timeTaxable" id="timeTaxable" value="true" checked>
          <br>
        </div>

        <div class="form-group col-lg-6 col-offset-2">
          <label for="timeActivity">Activity</label>
          <select type="text" class="form-control" id="timeActivity" name="timeActivity">
            <option value="File note">File note</option>
            <option value="Reviewed loss material">Reviewed loss material</option>
            <option value="Site inspection">Site inspection</option>     
            <option value="Email correspondence">Email correspondence</option>
            <option value="Phone call">Phone call</option>
          </select>

          <label for="timeNotes">Comments</label>
          <textarea name="timeNotes" class="form-control" placeholder="Put your comments here..."></textarea>
          <label for="timeBillable">Activity Billable?</label>
          <input type="checkbox" name="timeBillable" id="timeBillable" value="true" checked>    
        </div><!-- end col-offset-2 -->      
      </div><!-- end row whole-form --> 
      <input type="submit" value="Add to Timesheet" class="btn btn-info"/>
    </form>
    <h3>Timesheet</h3>     
    <div class="row time-list well well-lg">
      <div class="row heading-row col-lg-12 panel">
        <div class="col-lg-2 time-stamp">
          <span class="h4">Time Stamp</span>
        </div><!-- end time-stamp -->
        <div class="col-lg-2 time-spent">
          <span class="h4">Time Spent</span>
        </div><!-- time-spent -->
        <div class="col-lg-8 time-spent">
          <span class="h4">Activity</span>
        </div><!-- time-spent -->        
      </div><!-- end heading-row -->
      <?php
        if (!empty($times)) {
          foreach($times as $timesheet) {
      ?>
        <div class="row timesheet-top">
          <div class="col-lg-2 time-stamp">
            <?= date('m/d/y' ,strtotime($timesheet['timeStamp'])); ?>
          </div><!-- end time-stamp -->
          <div class="col-lg-2 time-spent">
            <?= number_format($timesheet['timeSpent'], 1, '.', ','); ?>
          </div><!-- time-spent -->
          <div class="col-lg-8 time-spent">
            <?= $timesheet['timeActivity']; ?>
          </div><!-- time-spent -->               
        </div><!-- end timesheet-top -->
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Comments</h3>
          </div>
          <div class="panel-body">
            <?= $timesheet['timeNotes']; ?>
          </div>
        </div>
        <div id="rectangle"></div>
      <?php
          } # end foreach
        } else {
          echo("<div class='col-lg-12'>Zero activity logged.</div>");
        }
      ?>
    </div><!-- end time-list --> 
    </div><!-- end container -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../js/jquery-1-11-3.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/mminsurance.com/js/bootstrap.min.js"></script>
  </body>
</html>