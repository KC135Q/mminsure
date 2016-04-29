<!DOCTYPE html>
<?php
  include "../config/config.php";
  include "../model/database.php";
  $database = new Database();

  # Check form submitted?
  if($_SERVER['REQUEST_METHOD'] == 'POST') {
    /**
    * Builds a file path with the appropriate directory separator.
    * @param string $segments,... unlimited number of path segments
    * @return string Path
    */
    function file_build_path(...$segments) {
        return join(DIRECTORY_SEPARATOR, $segments);
    }
    if (empty ($_POST['claimID'])) {
      $claimID = '111';
    } else {
      $claimID = $_POST['claimID'];
    }
    $uploaddir = file_build_path("C:", "xampp", "htdocs", "mminsurance.com", "uploads", $claimID);
    try {
      mkdir($uploaddir, 7777);      
    } catch (Exception $e) {
      # Directory already exists - OK then
    }

    $uploadfile = ($uploaddir. '\\'. basename($_FILES['userfile']['name']));

    try {
      move_uploaded_file($_FILES['userfile']['tmp_name'], $uploadfile);
      $attachmentName = basename($_FILES['userfile']['name']);
      $attachmentDescription = $_POST['attachmentDescription'];
      $database->addAttachment($claimID, $attachmentName, $attachmentDescription);
      header('Location: AttachmentAdded.php?claimID='. $claimID);      
    } catch (Exception $e) {
      $strError = "File upload error ". $e;
    }    
  } elseif(empty($_GET['claimID'])) {
    # Incorrect url structure so send them back to the home page
    header('Location: http://localhost/mminsurance.com/');
  } else {
    # first time visitor so show the form
    try {
      $claim = $database->getClaim($_GET['claimID']);
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
    <title>Add Attachment</title>

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
      <h1>M&amp;M Add Attachment</h1>
      <h3>Claim Number: <?= $claim['claimID'] ?></h3>
    </div><!-- end row well well-sm -->
    <!-- The data encoding type, enctype, MUST be specified as below -->
    <form enctype="multipart/form-data" action="AddAttachment.php" method="POST">
      <!-- MAX_FILE_SIZE must precede the file input field -->
      <input type="hidden" name="MAX_FILE_SIZE" value="500000" />
      <!-- Keep track of the claim id to associate the attachment with -->
      <input type="hidden" name="claimID" value="<?=$claim['claimID']?>">
      <!-- Name of input element determines name in $_FILES array -->
      <div class="row">
        <div class="form-group col-lg-4">
          <label for="userfile">Attachment File</label>    
          <input name="userfile" type="file" class="form-control" id="userfile">
        </div>
      </div><!-- end row -->
      <div class="row">
        <div class="form-group col-lg-4">
          <label for="attachmentDescription">Attachment Description</label>
          <input type="text" class="form-control" id="attachmentDescription" name="attachmentDescription" placeholder="Damaged area taken from the North.">
        </div>
      </div><!-- end row --> 
      <input type="submit" value="Send File" class="btn btn-info"/>
    </form>  
    </div><!-- end container -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="../js/jquery-1-11-3.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="/mminsurance.com/js/bootstrap.min.js"></script>
  </body>
</html>