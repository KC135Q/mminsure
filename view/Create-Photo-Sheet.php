<!DOCTYPE html>
<head>
	<title>M&amp;M Photo Sheet</title>
  <!-- Bootstrap -->
  <link href="/mminsurance.com/css/bootstrap.min.css" rel="stylesheet">

  <!-- Bootstrap Override -->
  <link href="/mminsurance.com/css/bootstrap-override.css" rel="stylesheet">
</head>
<body>
<?php
  include "../config/config.php";
  include "../model/database.php";
  $database = new Database();
	$imageArray = array();
	$strError = '';

	// Check claimID and imageID(s) passed as URL parameters (GET)
	// If so, then assign the imageID(s) to the tmpArray (due to empty results from explode explained below) and claimID to claimID :)  DAK 4/27/2016
	if (!empty($_GET['images'])  && !empty($_GET['claimID'])) {
		$tmpArray = explode(" ", trim($_GET['images']));
		$claimID = $_GET['claimID'];
		$sheetInfo = $database->getClaimDetails($claimID);
		$attachments = $database->getAttachments($claimID);
		// Some explosions result in empty values.  Use foreach to only recognized image IDs that are not null/empty. 
		foreach ($tmpArray as $key => $value) {
			if (strlen($value) > 0) {
				array_push ($imageArray, $value);	
			}
		}		
	} else {
		$images = "None";
		$claimID = "None";
		$strError = "Claim or attachment IDs not retrieved.  Please try again.";
	}
	$insurerString = "<span class='h3'>" . $sheetInfo['insurerName'] . "</span><br>";
  $insurerString .= $sheetInfo['insurerAddress'] . "<br>";
  $insurerString .= $sheetInfo['insurerCity'] . "," . $sheetInfo['insurerState'] . "<br>";
  $insurerString .= $sheetInfo['insurerCountry'] . " " . $sheetInfo['insurerPostcode'];
  $insuredClaim = $claimID;
  $insuredName = $sheetInfo['lastName'] . ", " . $sheetInfo['firstName'];
?>
<div id="container">
<!-- Start the sheet layout.  Top Title row, second Insured Row, then attachements  -->
	<div class="row print-title">
		<!-- Title row has a left column and right column.  Left is basically a header and the right contains the Insurance Company information -->
		<div class="col-xs-6 print-header">
			<span class='h3'>Photo Sheet</span><br>
			<span class='h3'>M&amp;M Insurance Investigation Services, LLC</span>
		</div><!-- end print-header -->
		<div class="col-xs-6 print-insurer">
			<?php echo $insurerString; ?>
		</div><!-- end print-insurer -->
	</div><!-- end print-title -->
	<div class="row print-insured well well-sm">
		<!-- setup with two columns again.  Left is Claim number (MM Internal), and name of insured -->
		<div class="col-xs-6 print-mm-claim">
  		<?php echo "Claim number: " . $insuredClaim . "<br>Insured: ". $insuredName; ?>
		</div><!-- end print-mm-claim -->
		<div class="col-xs-6 print-insurer-claim">
  		<?php echo "<p>Your Claim Number: ". $sheetInfo['insurerClaimNumber'] . "<br>Policy Number: " . $sheetInfo['policyNumber']. "</p>"; ?>
		</div><!-- end print-insurer-claim -->
	</div><!-- end print-insured -->
	<div class="row print-attachments center-block col-xs-12">
	<?php
		foreach($imageArray as $value) {
			foreach ($attachments as $attachment) {
				if ($attachment['attachmentID'] == $value) {
					echo ("<img src='/mminsurance.com/uploads/" . $claimID . "/" . $attachment['attachmentName'] . "'>");
					echo("<div class='panel panel-default pull-center'>" . $attachment['attachmentDescription'] . "</div>");
					if (strlen($attachment['attachmentDescription']) < 1) {
						echo ("<hr>");
					}
				}
			}
		}
	?>
	</div><!-- end print-attachments -->
</div><!-- end container -->
</body>