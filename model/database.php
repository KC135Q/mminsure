<?php
  class Database {
  	// Define configuration
		private $host 	= DB_HOST;
		private $user 	= DB_USER;
		private $pass 	= DB_PASS;
		private $dbname = DB_NAME;

		private $dbh;
		private $error;

		private $stmt;

		public function __construct() {
			// Set DSN
			$dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
			// Set options
			$options = array(
			    PDO::ATTR_PERSISTENT => true, 
			    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
			);
			try {
		    $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
			}
			// Catch any errors
			catch (PDOException $e) {
			    $this->error = $e->getMessage();
			}			
		}

		public function query($query){
		  $this->stmt = $this->dbh->prepare($query);
		}

		public function bind($param, $value, $type = null){
		    if (is_null($type)) {
		        switch (true) {
		            case is_int($value):
		                $type = PDO::PARAM_INT;
		                break;
		            case is_bool($value):
		                $type = PDO::PARAM_BOOL;
		                break;
		            case is_null($value):
		                $type = PDO::PARAM_NULL;
		                break;
		            default:
		                $type = PDO::PARAM_STR;
		        }
		    }
		    $this->stmt->bindValue($param, $value, $type);
		}

		public function execute(){
		    return $this->stmt->execute();
		}	

		public function resultset(){
		    $this->execute();
		    return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
		}

		public function single(){
		    $this->execute();
		    return $this->stmt->fetch(PDO::FETCH_ASSOC);
		}	

		public function rowCount(){
		    return $this->stmt->rowCount();
		}

		public function lastInsertId(){
		    return $this->dbh->lastInsertId();
		}
		public function addAttachment($claimID, $attachmentName, $attachmentDescription){
			$this->query('INSERT INTO attachment (claimID, attachmentName, attachmentDescription) VALUES (:claimID, :attachmentName, :attachmentDescription)');
			$this->bind(":claimID", $claimID);
			$this->bind(":attachmentName", $attachmentName);
			$this->bind(":attachmentDescription", $attachmentDescription);
			$this->execute();					
		}			
		public function addClaim($inputs) {
			if (strlen($inputs['timeOfLoss']) < 1) {
				$inputs['timeOfLoss'] = "13:30";
			}
			$claimArray = array("insuredID", "insurerID", "policyNumber", "insurerClaimNumber", "dateOfLoss", "dateReported", "timeOfLoss", "grossLossValue", "actualCashValue", "replacementCost", "lossDescription", "lossLocation", "lossCounty", "lossNotes");
			$this->query('INSERT INTO claim (insurerID, insuredID, policyNumber, insurerClaimNumber, dateOfLoss, dateReported, timeOfLoss, grossLossValue, actualCashValue, replacementCost, lossDescription, lossLocation, lossCounty, lossNotes) VALUES (:insurerID, :insuredID, :policyNumber, :insurerClaimNumber, :dateOfLoss, :dateReported, :timeOfLoss, :grossLossValue, :actualCashValue, :replacementCost, :lossDescription, :lossLocation, :lossCounty, :lossNotes) ');
			foreach ($claimArray as $key) {
				$this->bind(":$key", "$inputs[$key]");

			}
			$this->execute();
		}
		public function addInsured($inputs) {
			$insuredArray = array("lastName", "firstName", "phone", "cell", "email", "address", "city", "state", "county", "country", "postcode", "notes");
			$this->query('INSERT INTO insured (lastName, firstName, phone, cell, email, address, city, state, county, country, postcode, notes) VALUES (:lastName, :firstName, :phone, :cell, :email, :address, :city, :state, :county, :country, :postcode, :notes) ');
			foreach ($insuredArray as $key) {
				$this->bind(":$key", "$inputs[$key]");
			}
			$this->execute();
		}
		public function addInsurer($inputs) {
			$insuredArray = array("insurerName", "insurerRep", "insurerPhone", "insurerEmail", "insurerWebsite", "insurerAddress", "insurerCity", "insurerState", "insurerCountry", "insurerPostcode", "insurerNotes");
			$this->query('INSERT INTO insurer (insurerName, insurerRep, insurerPhone, insurerEmail, insurerWebsite, insurerAddress, insurerCity, insurerState, insurerCountry, insurerPostcode, insurerNotes) VALUES (:insurerName, :insurerRep, :insurerPhone, :insurerEmail, :insurerWebsite, :insurerAddress, :insurerCity, :insurerState, :insurerCountry, :insurerPostcode, :insurerNotes) ');
			foreach ($insuredArray as $key) {
				$this->bind(":$key", "$inputs[$key]");
			}
			$this->execute();
		}
  	public function addTime($inputs) {
  		$timeArray = array("claimID", "timeSpent", "timeActivity", "timeDisbursementAmount", "timeTaxable", "timeDisbursementType", "timeNotes", "timeBillable");
  		$this->query('INSERT INTO timesheet (claimID, timeSpent, timeActivity, timeDisbursementAmount, timeTaxable, timeDisbursementType, timeNotes, timeBillable) VALUES (:claimID, :timeSpent, :timeActivity, :timeDisbursementAmount, :timeTaxable, :timeDisbursementType, :timeNotes, :timeBillable) ');
			foreach ($timeArray as $key) {
				$this->bind(":$key", "$inputs[$key]");
			}  		
  		$this->execute();
  	}
		public function changeStatus($claimID) {
			$this->query("UPDATE claim SET status = CASE WHEN status = 'Closed' THEN 'Open' WHEN status = 'Open' THEN 'Closed' END WHERE claimID = :claimID");
			$this->bind("claimID", $claimID);
			$this->execute();
			$this->query("SELECT status FROM claim WHERE claimID = :claimID");
			$this->bind("claimID", $claimID);
			return $this->single();
		}
		public function getAllInsured() {
			$this->query('SELECT * FROM insured');
			$rows = $this->resultset();
			return $rows;			
		}
		public function getAllInsurer() {
			$this->query('SELECT * FROM insurer');
			$rows = $this->resultset();
			return $rows;
		}
		public function getAllTimes($claimID) {
			$this->query('SELECT * FROM timesheet WHERE claimID = :claimID ORDER BY timeStamp DESC');
			$this->bind(':claimID', $claimID);
			$rows = $this->resultset();
			return $rows;
		}
		public function getAttachments($claimID) {
			$this->query('SELECT * FROM attachment WHERE claimID = :claimID');
			$this->bind(':claimID', $claimID);
			$rows = $this->resultset();
			return $rows;	
		}
		public function getClaim($claimID) {
			# This only retrieves the claim info from the matching claim table
			$this->query('SELECT DISTINCT * FROM claim WHERE claimID = :claimID');
			$this->bind(':claimID', $claimID);
			$row = $this->single();
			return $row;
		}
		public function getClaimDetails($claimID) {
			# This function returns everything needed to show on the Claim Details page
			$this->query('SELECT DISTINCT * FROM claim JOIN (insured, insurer) ON (claim.insurerID = insurer.insurerID AND claim.insuredID = insured.insuredID AND claim.claimID = :claimID)');			
			$this->bind(':claimID', $claimID);
			$row = $this->single();
			return $row;
		}		
		public function getInsured($insuredID) {
			$this->query('SELECT * FROM insured WHERE insuredID = :insuredID');
			$this->bind(':insuredID', $insuredID);
			$row = $this->single();
			return $row;
		}
		public function getInsurer($insurerID) {
			$this->query('SELECT * FROM insurer WHERE insurerID = :insurerID');
			$this->bind(':insurerID', $insurerID);
			$row = $this->single();
			return $row;
		}
		public function getClaimsByStatus($status = 'All') {
			if ($status === 'All') {
				# Get all claims
				$this->query('SELECT * FROM claim, insured, insurer WHERE claim.insurerID = insurer.insurerID AND claim.insuredID = insured.insuredID ORDER BY claimID DESC');
			} else {
				# Only get claims with the status equal to what was passed in (Open or Closed) and order by newest reported on top
				$this->query('SELECT * FROM claim, insured, insurer WHERE status=:status AND claim.insurerID = insurer.insurerID AND claim.insuredID = insured.insuredID ORDER BY dateReported DESC');				
				$this->bind(':status', $status);
			}
			$rows = $this->resultset();
			return $rows;
		}
		public function getLastClaimIDEntered() {
			$this->query('SELECT claimID FROM claim ORDER BY claimID DESC LIMIT 1');
			return $this->single();
		}
		public function updateInsured($inputs) {
			$insuredArray = array("lastName", "firstName", "phone", "cell", "email", "address", "city", "state", "county", "country", "postcode", "notes");			
			$myQuery  = 'UPDATE insured SET ';
			foreach ($insuredArray as $value) {
				$myQuery .= "$value = :$value, ";
			}
			$myQuery = substr($myQuery, 0, -2); # Removes , and space from last entry
			$myQuery .= ' WHERE insuredID = :insuredID';
			$this->query($myQuery);
			foreach ($insuredArray as $value) {
				$this->bind(":$value", "$inputs[$value]");
			}
			# Add the id which isn't in the UPDATE portion
			$this->bind (":insuredID", $inputs['insuredID']);
			$this->execute();		
		}
		public function updateInsurer($inputs) {
			$insurerArray = array("insurerName", "insurerRep", "insurerPhone", "insurerEmail", "insurerWebsite", "insurerAddress", "insurerCity", "insurerState", "insurerCountry", "insurerPostcode", "insurerNotes");			
			$myQuery  = 'UPDATE insurer SET ';
			foreach ($insurerArray as $value) {
				$myQuery .= "$value = :$value, ";
			}
			$myQuery = substr($myQuery, 0, -2); # Removes , and space from last entry
			$myQuery .= ' WHERE insurerID = :insurerID';
			$this->query($myQuery);
			foreach ($insurerArray as $value) {
				$this->bind(":$value", "$inputs[$value]");
			}
			# Add the id which isn't in the UPDATE portion
			$this->bind (":insurerID", $inputs['insurerID']);
			$this->execute();		
		}		
  }