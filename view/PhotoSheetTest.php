<!DOCTYPE html>
<?php
  include "../config/config.php";
  include "../model/database.php";
  $database = new Database();
  $strError = '';
  $phpImageArray = '[';

  # Check form submitted?
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    # Process form submission
    echo ("FORM SUBMITTED");
  } elseif(empty($_GET['claimID'])) {
    # Incorrect url structure so send them back to the home page
    header('Location: http://localhost/mminsurance.com/');
  } else {
    # first time visitor so show the form
    try {
    	$claimID = $_GET['claimID'];
      $claim = $database->getClaimDetails($claimID);
			$attachments = $database->getAttachments($claimID);
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Photo Sheet</title>

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
		<style>
		a.test {
		    background-color: yellow;
		}
		a.not-a-test {
		    background-color: blue;
		}		
		</style>    
  </head>

  <body>
    <div class="container">

    <h1><a href="http://localhost/mminsurance.com/view/PhotoSheetTest.php?claimID=243">M&amp;M Photo Sheet</a></h1>    
      <div class="row well well-sm">
		    <div class="row col-lg-12">
	    		<button class="btn btn-primary" type="button">
					  Image Order: <div class="btn-badge"></div>
					</button>
					<button class="btn btn-success process-sheet" type="button" name="process-sheet">
					  Process Sheet
					</button>
	    	</div>      
	      <div class="image-list col-lg-3">

			  </div>
			  <div class="sheet-prep col-lg-9"  >
			  	<h3>Click on photos to add.  Refresh page to clear order.</h3>
			  </div>

    	</div><!-- end row well well-sm -->
    </div><!-- end container -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!--     <script src="../js/jquery-1-11-3.min.js"></script> -->
		<script src="/mminsurance.com/js/external/jquery/jquery.js"></script>
		<script src="/mminsurance.com/js/jquery-ui.min.js"></script>
		<script type="text/javascript">
			$(document).ready(function() {			

				// Store image name in array called images - Check for empty array to prevent errors
				var images = <?php echo json_encode($attachments); ?>;
				var claimID = <?= $claimID;?>;
				for (var i=0; i < images.length; i++) {
					var photo = $('<photo>');
					photo.addClass('photo-sheet');
					photo.attr('attachmentID', i);
					photo.attr('claimID', claimID);
					var titleSRC = "/mminsurance.com/uploads/" + claimID + "/" + images[i]['attachmentName'];
					console.log(titleSRC);
					$(".image-list").append("<div class='photo-sheet'><img src='" + titleSRC + "' title='"+ images[i]['attachmentName'] +"' alt='"+ images[i]['attachmentID'] +"'></div>");
				};

				$('.process-sheet').on('click', function() {
					console.log("Processing! "+ $( ".btn-badge" ).text() +" Claim: " + claimID);

					window.open("Create-Photo-Sheet.php?claimID="+ claimID + "&images="+ $( ".btn-badge" ).text() +"");
				});
				$('.photo-sheet img').on('click', showID);
				function showID (eventObject) {
					console.log (eventObject.target.title);
					var fileName = "/mminsurance.com/uploads/" + claimID + "/" + eventObject.target.title;
					console.log (fileName);
					$( ".sheet-prep" ).append ("<img src='"+fileName+"' title='"+eventObject.target.title+"' alt='"+eventObject.target.alt+"' class='center-block'/>");
					$( ".btn-badge" ).append(" <span class='badge'>"+ eventObject.target.alt +"</span> ");
				};

				$('.sheet-prep img').on('click', removeID);
				function removeID (eventObject) {
					console.log (eventObject.target.title);
					var fileName = "/mminsurance.com/uploads/" + claimID + "/" + eventObject.target.title;
					console.log (fileName);
					$( ".sheet-prep" ).remove ( 'img' );
				};				
			});
		</script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/mminsurance.com/js/bootstrap.min.js"></script>
  </body>
</html>    