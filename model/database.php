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
		public function addClaim($inputs) {
			$claimArray = array("insurerID", "insuredID", "policyNumber", "insurerClaimNumber", "dateOfLoss", "dateReported", "timeOfLoss", "grossLossValue", "actualCashValue", "replacementCost", "lossDescription", "lossLocation", "lossCounty", "lossNotes");;
			$this->query('INSERT INTO claim (insurerID, insuredID, policyNumber, insurerClaimNumber, dateOfLoss, dateReported, timeOfLoss, grossLossValue, actualCashValue, replacementCost, lossDescription, lossLocation, lossCounty, lossNotes) VALUES (:insurerID, :insuredID, :policyNumber, :insurerClaimNumber, :dateOfLoss, :datereported, :timeOfLoss, :grossLossValue, :actualCashValue, :replacementCost, :lossDescription, :lossLocation, :lossCounty, :lossNotes) ');
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

		public function getInsured($insuredID) {
			$this->query('SELECT * FROM insured WHERE insuredID = :insuredID');
			$this->bind(':insuredID', $insuredID);
			$row = $this->single();
			return $row;
		}
		public function addInsurer($inputs) {
			$insuredArray = array("businessName", "repName", "phone", "email", "website", "address", "city", "state", "country", "postcode", "notes");
			$this->query('INSERT INTO insurer (businessName, repName, phone, email, website, address, city, state, country, postcode, notes) VALUES (:businessName, :repName, :phone, :email, :website, :address, :city, :state, :country, :postcode, :notes) ');
			foreach ($insuredArray as $key) {
				$this->bind(":$key", "$inputs[$key]");
			}
			$this->execute();
		}

		public function getInsurer($insurerID) {
			$this->query('SELECT * FROM insurer WHERE insurerID = :insurerID');
			$this->bind(':insurerID', $insurerID);
			$row = $this->single();
			return $row;
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
  }