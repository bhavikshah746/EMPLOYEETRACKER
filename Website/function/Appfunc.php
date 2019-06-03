<?php
	Class DBFunction{
		
		private $con;
		
		//will be called when object of this class is created
		function __construct(){
			
			require_once("conn/conn.php");
			$db = new configDB();
			
			$this->con = $db->connect();
		}
		
		
		function validateUser($userCredential){
		
			$username = $userCredential["username"];
			$userPass = $userCredential["password"];

			$query = "SELECT * FROM employee WHERE username = ? and password = ?";

			if($stmt = $this->con->prepare($query)){
				$stmt->bind_param('ss',$username,$userPass);
				$stmt->execute();
				$stmt->store_result();
				$stmt->fetch();
				
				if($stmt->num_rows == 1){
					$stmt->close();
					return true;
				}
				$stmt->close();
			}

			return false;
		}
		
		
		function getTask($TaskDetails){
				
		}
		
		
		function getTaskDescription($DescDetails){
				
		}
	}
?>