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

		public function addInsured($inputs) {
			$insuredArray = array("lastName", "firstName", "phone", "cell", "email", "address", "city", "state", "county", "country", "postcode");
			$this->query('INSERT INTO insured (lastName, firstName, phone, cell, email, address, city, state, county, country, postcode) VALUES (:lastName, :firstName, :phone, :cell, :email, :address, :city, :state, :county, :country, :postcode) ');
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
  }