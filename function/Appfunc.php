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


	/* Function validate user which is used by both Application and Portal to validate a user*/
	function validateUser($userCredential){
		
		$username = $userCredential["username"];
		$userPass = $userCredential["password"];

		//require_once("function/MCrypt.php");
		//$mcrypt = new MCrypt();	
		//$userPass = $mcrypt->decrypt($userCredential["password"]);

		$query = "SELECT firstName, lastName, userName FROM employee WHERE username = ? and password = ?";

		if($stmt = $this->con->prepare($query)){

			$stmt->bind_param('ss',$username,$userPass);

			$stmt->execute();

			$result = $stmt->get_result();

			if($result->num_rows == 1 ){

				$returnArray=[];

				$returnArray["flg"] =true;

				//if login from portan then return user details to store in session variable
				if($userCredential["logInType"]=="portalLogin"){
						
					$row = $result->fetch_assoc();
						
					$returnArray["userID"] = $row["userName"];
					
					$returnArray["userName"] = $row["firstName"]." ".$row["lastName"];
				}

				$stmt->close();

				return $returnArray;;
			}
 			$stmt->close();
		}
		return false;
	}

	function getDashData(){
		
		$dashboardArr = [];
		
		$dashboardArr["successFlg"] = true;

		$recentTaskQuery = "Select e.firstName, e.lastName, t.taskID, t.taskName, t.taskCreated from employee e, task t WHERE t.completionFlag= ? AND e.empID = t.empID order by taskCreated desc limit 10";

		if($stmt = $this->con->prepare($recentTaskQuery)){
			
			$dashboardArr["recentTask"] = []; 

			$completionFlg = 0;

			$stmt->bind_param('i',$completionFlg);

			$stmt->execute();

			$result = $stmt->get_result();
		
			if($result->num_rows > 1 ){
						
				while($row = $result->fetch_assoc()){
					$dashboardArr["recentTask"][$row["taskID"]] =[];

					$dashboardArr["recentTask"][$row["taskID"]]["user"] = $row["firstName"]." ".$row["lastName"];
					
					$dashboardArr["recentTask"][$row["taskID"]]["taskName"] = $row["taskName"];

					$dashboardArr["recentTask"][$row["taskID"]]["taskCreated"] = date('d-m-Y', strtotime($row["taskCreated"]));
				}
			}
			
			$stmt->close();

		}else{
			$dashboardArr["successFlg"] = false;
		}
		
		$completedTaskQuery = "Select e.firstName, e.lastName, t.taskID, t.taskName, t.taskCreated from employee e, task t WHERE t.completionFlag= ? AND e.empID = t.empID order by taskCreated desc limit 10";

		if($stmt = $this->con->prepare($completedTaskQuery)){
			$dashboardArr["completedTask"] = []; 

			$completionFlg = 1;

			$stmt->bind_param('i',$completionFlg);

			$stmt->execute();

			$result = $stmt->get_result();
		
			if($result->num_rows > 1 ){
						
				while($row = $result->fetch_assoc()){
					$dashboardArr["completedTask"][$row["taskID"]] =[];

					$dashboardArr["completedTask"][$row["taskID"]]["user"] = $row["firstName"]." ".$row["lastName"];
					
					$dashboardArr["completedTask"][$row["taskID"]]["taskName"] = $row["taskName"];

					$dashboardArr["completedTask"][$row["taskID"]]["taskCreated"] = $row["taskCreated"];
				}

			}
			$stmt->close();
		}else{
				
			$dashboardArr["successFlg"] = false;
		}

		return $dashboardArr;
	}

	/*Function to get all the user who are assigned taks(s). */
	function getUsers(){
		$query = "Select * from employee order by dateOfEntry desc";

		$userData = $con->query($query);

		if($userData->num_rows > 0){
			$returnArray = [];
			while($row = $userData->fetch_assoc()){
				$data = [];
				$data["empUserName"] = $row["userName"];
				$data["empFname"] = $row["firstName"];
				$data["empLName"] = $row["lastName"];
				$data["mobile"] = $row["mobile"];
				$data["email"] = $row["email"];
				
				array_push($returnArray,$data);
			}
		}
	}

/*Function to get tasks. */
function getTaskDetails(){
	$query = "Select * from employee order by dateOfEntry desc";

	$userData = $con->query($query);

	if($userData->num_rows > 0){
		$returnArray = [];
		while($row = $userData->fetch_assoc()){
			$data = [];
			$data["empUserName"] = $row["userName"];
			$data["empFname"] = $row["firstName"];
			$data["empLName"] = $row["lastName"];
			$data["mobile"] = $row["mobile"];
			$data["email"] = $row["email"];
			
			array_push($returnArray,$data);
		}
	}
}
	/*Fuction to add new user to the system by admin*/
	function addUser($userDetails){
		$userQuery = "Insert into employee (`firstName`, `lastName`, `userName`, `password`, `addressLine1`, ";
		$userQuery.= "`addressLine2`, `city`, `postCode`, `email`, `mobile`, `sex`, `dateOfBirth`, `designation`, `dateOfEntry`, ";
		$userQuery.= "`emergencyContactName1`, `emergencyContactNo1`, `emergencyContactName2`, `emergencyContactNo2`, `departmentID`, `teamLeaderID`) ";
		$userQuery.= " VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

		if($this->con->prepare($userQuery)){
			
			$stmt->bind_param();

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

	
	/* Function to upload code */
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

						$returnTask["error"] = false;

						$returnTask["Msg"] = "Clocked out successfully";

					}

					$stmt->close();

					return $returnTask;	
				}
				$stmt->close();
			}
		}	
	}
}

?>