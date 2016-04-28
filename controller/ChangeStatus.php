<?php
	// setup database, call database conditional change status
  include "../config/config.php";
  include "../model/database.php";

  if (!empty($_GET['claimID'])) {
  	$claimID = trim($_GET['claimID']);
    $database = new Database();
	  $strError = '';
	  if ($newStatus = $database->changeStatus($claimID)) {
	  	echo($newStatus['status']);
	  }

  } else {
  	// Do nothing :()
  }
