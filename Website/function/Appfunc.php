<?php
	
	Class DBFunction {
		
		private $con, $mcryptConn;
		
		
		//will be called when object of this class is created
		function __construct(){
			
			require_once("conn/conn.php");
			
			$db = new configDB();
			$this->con = $db->connect();
			
			
			require_once("function/MCrypt.php");
			$mcrypt = new MCrypt();				
			
		}
		
		
		/* Function validate user */
		function validateUser($userCredential){
		
			$username = $userCredential["username"];
			$userPass = $userCredential["password"];
			//require_once("function/MCrypt.php");
			//$mcrypt = new MCrypt();	
			//$userPass = $mcrypt->decrypt($userCredential["password"]);


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
		
		/* Function get Task Names */
		function getTask($empID){
		
			$empID = $empID;
			$query = "SELECT t.taskID, t.taskName, t.taskDetail FROM task as t, employee as e WHERE e.userName  = ? and t.empID = e.empID ";

			if($stmt = $this->con->prepare($query)){
				$stmt->bind_param('s',$empID);
				$stmt->execute();
				$result = $stmt->get_result();
				
				if($result->num_rows>0){
					
					$returnTask =[];
					
					while($row = $result->fetch_assoc()){
						$returnTask[$row["taskID"]]["TaskName"] =$row["taskName"]."#".$row["taskID"];
					}
					$stmt->close();
					return $returnTask;	
					
				}
				$stmt->close();
			}

			return false;
		}
		
		//Function to get task details
		function getTaskDescription($userName, $taskID){
			
			$query = "SELECT t.taskID, t.taskName, t.taskDetail FROM task as t, employee as e WHERE t.taskID= ? and e.userName  = ? and t.empID = e.empID ";

			if($stmt = $this->con->prepare($query)){
				$stmt->bind_param('ss', $taskID, $userName);
				$stmt->execute();
				$result = $stmt->get_result();
				
				if($result->num_rows>0){
					
					$returnTaskDetails =[];
					while($row = $result->fetch_assoc()){
						
						$returnTask[$row["taskID"]]["TaskName"] =$row["taskName"]."#".$row["taskDetail"];
					}
					$stmt->close();
					return $returnTask;	
					
				}
				$stmt->close();
			}
			return false;	
		}
		
		
		function updateLocationFlg($taskID, $userName){
			
			$userID="";
			$selectUser = "Select * from employee where userName= ?";
			
			if($stmt = $this->con->prepare($query)){
				$stmt->bind_param('s',$userName);
				$stmt->execute();
				$result = $stmt->get_result();
				
				if($result->num_rows=1){
					
					$returnTaskDetails =[];
					$userID = $result->fetch_assoc();															
					$stmt->close();
					
				}else{
					$stmt->close();
					return false;	
				}
				
			}
			
			if($userID!=""){
				
				$CurrentTimeStamp = date('Y-m-d H:i:s');

				$updateQuery = "update task set = ? WHERE empID =? ";

				if($stmt = $this->con->prepare($query)){
					$stmt->bind_param('ss',$CurrentTimeStamp, $userID);
					$stmt->execute();
					$result = $stmt->get_result();

					if($result->num_rows>0){

						$returnTaskDetails =[];
						while($row = $result->fetch_assoc()){
							$returnTask["erroe"] = false;
							$returnTask["Msg"] = "Clocked out successfully";
						}
						$stmt->close();
						return $returnTask;	

					}
					$stmt->close();
				}
			}	
		}
		
		//
	}
?>