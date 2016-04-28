<!DOCTYPE html>
<?php
  include "../config/config.php";
  include "../model/database.php";
  $database = new Database();
  $strError = '';

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
    <!-- HTML5 shim and Respond.js for I8 support of HTML5 elements and media queries -->
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
            <li><a href="http://localhost/mminsurance.com/view/AddAttachment.php?claimID=<?=$claim['claimID']?>">Add Attachment</a></li>
            <li><a href="#">Time</a></li>
            <li><a href="http://localhost/mminsurance.com/view/PhotoSheet.php?claimID=<?=$claim['claimID']?>">Photo Sheet</a></li>           
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

    <h1><a href="http://localhost/mminsurance.com/view/PhotoSheetTest.php?claimID=243">M&amp;M Photo Sheet</a></h1>    
      <div class="row well well-sm">
        <div class="row col-lg-12">
          <button class="btn btn-primary" type="button">
            Image Order: <div class="btn-badge"></div>
          </button>
          <button class="btn btn-success process-sheet" type="button" name="process-sheet">
            Process Sheet
          </button>
          <span class="pull-right">Click on photos to add.  Refresh page to start over.</span>
        </div>      
        <div class="image-list col-lg-3">

        </div>
        <div class="sheet-prep col-lg-9"  >

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