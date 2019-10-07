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


	/*Function to get all details of all the employees  */
	function getEmpData($action, $userID =""){
		
		$returnArr =[];
		$returnArr["successFlg"] = true;
		$where = "";  $selectStr = "*"; $queryStr ="";

		//If action is to get user profile then we will add this to the SQL query
		($action == "getProfile")?$where=" where userName = ? ":$queryStr = "order by dateOfJoining desc";


		$empDataQry = "Select ".$selectStr." from employee ".$where." ".$queryStr;
		
		if($stmt = $this->con->prepare($empDataQry)){
			
			$empDataArr = [];
		
			($action == "getProfile") ?$stmt->bind_param('s',$userID):"";
			
			if($stmt->execute()){

				$result = $stmt->get_result();
				
				if($result->num_rows >= 1 ){
								
					while($row = $result->fetch_assoc()){
						
						$empDataArr[$row["empID"]] =[];
	
						$empDataArr[$row["empID"]]["fName"] = $row["firstName"];

						$empDataArr[$row["empID"]]["lName"] = $row["lastName"];

						$empDataArr[$row["empID"]]["uName"] = $row["userName"];

						$empDataArr[$row["empID"]]["addr1"] = $row["address 1"];

						$empDataArr[$row["empID"]]["addr2"] = $row["address 2"];

						$empDataArr[$row["empID"]]["city"] = $row["city"];

						$empDataArr[$row["empID"]]["state"] = $row["state"];

						$empDataArr[$row["empID"]]["pCode"] = $row["postCode"];

						$empDataArr[$row["empID"]]["mailID"] = $row["email"];
	
						$empDataArr[$row["empID"]]["mobile"] = $row["mobile"];

						$empDataArr[$row["empID"]]["gender"] = $row["sex"];

						$empDataArr[$row["empID"]]["DOB"] = date('d-m-Y', strtotime($row["dateOfBirth"]));

						$empDataArr[$row["empID"]]["desg"] = $row["designation"];

						$empDataArr[$row["empID"]]["joinData"] = date('d-m-Y', strtotime($row["dateOfJoining"]));

						$empDataArr[$row["empID"]]["emergencyContact1Name"] = $row["emergencyContactName1"];

						$empDataArr[$row["empID"]]["emergencyContact1Num"] = $row["emergencyContactNo1"];

						$empDataArr[$row["empID"]]["emergencyContact2Name"] = $row["emergencyContactName2"];

						$empDataArr[$row["empID"]]["emergencyContact2Num"] = $row["emergencyContactNo2"];

						$empDataArr[$row["empID"]]["dept"] = $row["departmentID"];

						$empDataArr[$row["empID"]]["teamLead"] = $row["teamLeaderID"];

					}
					
					$returnArr["empData"] = $empDataArr;
				}
				
				$stmt->close();
			}else{
				$returnArr["successFlg"] = false;
			}
		}else{
			$returnArr["successFlg"] = false;
		}
		
		return $returnArr;
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

	
	function deleteEmp($id){
		
		if($_SESSION["userType"] == "admin"){

			$deleteQry = "update employee SET archivedFlg = ?";
			
			if($stmt = $this->con->prepare($deleteQry)){
				
				$stmt->bind_param('i',0);

				if($stmt->execute()){
					$result = $stmt->get_result();
				
					if($result->num_rows()==1){
						
						$returnArr["error"]="";
						
						$returnArr["msg"]="";
					}
				}
			}
		}else {
			
			$returnArr["error"] = "true";

			$returnArr["msg"] = "Not authorise to perform this operation";
		}
		return $returnArr;
	}

	function getTasks($userName, $taskStatus="ongoing"){
		
		//to select ongoing or compelted tasks
		if($taskStatus=="ongoing")
			$completionFlg = 0;
		else
			$completionFlg = 1;

		if($userName==""){	
			header("Location: error.php");
		}

		$empID = $this->getEmpID($userName);
		$userType = $this->check_is_admin($userName);
		
		if($userType=="" || $userType = false)	
			header("Location: error.php");

		$where = "";
		if($userType == 1){ //usertype 1 for Super Admin
			$where = " and t.is_delete = ? "	;

		}else if ($userType == 2){ //usertype 2 for Team Leader
			$where = "and t.is_deleted = ? and t.teamLeaderID = ?";
			
		}else{ //Otherwise just an employee
			$where = "and t.is_deleted = ? and t.empID = ?";
		}

		$query = "SELECT t.taskID, t.taskName,t.empID, t.teamLeaderID, t.taskCreated, t.taskStarted, t.taskDetail, e.firstName, e.lastName FROM task as t, employee as e WHERE t.empID = e.empID ".$where. " and t.completionFlag = ? ";
		
		if($stmt = $this->con->prepare($query)){
							
			$is_deleted = $taskCompleted = 0;
			
			if($userType == 1){
				$stmt->bind_param('ii',0, $completionFlg);

			}else{
				$stmt->bind_param('iii', $is_deleted, $empID, $completionFlg);

			}

			$stmt->execute();

			$result = $stmt->get_result();
			
			if($result->num_rows>0){

				$returnTaskDetails =[];
				
				while($row = $result->fetch_assoc()){
					
					$returnTask[$row["taskID"]] = [];
					$returnTask[$row["taskID"]]["taskname"]=$row["taskName"];
					$returnTask[$row["taskID"]]["task_assigned_to"] = $row["firstName"]." ".$row["lastName"];
					$returnTask[$row["taskID"]]["task_assigned_by"]= $this->getEmpName($row["teamLeaderID"]);
					$returnTask[$row["taskID"]]["date_created"]=date('d-M-Y', strtotime($row["taskCreated"]));
					$taskStarted = ($row["taskStarted"] == '0000-00-00 00:00:00' || $row["taskStarted"]=="")? "Not Started Yet" : date('d-M-Y', strtotime($row["taskStarted"]));
					$returnTask[$row["taskID"]]["task_started_date"]= $taskStarted;
					$returnTask[$row["taskID"]]["task_detail"]=$row["taskDetail"];
				
				}
				
				return $returnTask;	
			}
			$stmt->close();
		}
		return false;			
	}

	//to check if the logged in user is admin or not
	function check_is_admin($userName){
		
		if($userName==""){
			return false;

		}else{
			$query = "SELECT * FROM employee WHERE userName = ?";
			
			if($stmt = $this->con->prepare($query)){
				
				$stmt->bind_param("s",$userName);

				 $stmt->execute();

				$result = $stmt->get_result();

				if($result->num_rows>0){
					$row = $result->fetch_assoc();

					return $row["employee_type"]; 

				}else{
					return false;
				}
			}
		}
	}

	//function to get employee ID from userName
	function getEmpID($userName){

		$query = "SELECT empID FROM employee WHERE userName = ?";
			
		if($stmt = $this->con->prepare($query)){
			
			$stmt->bind_param("s",$userName);

				$stmt->execute();

			$result = $stmt->get_result();

			if($result->num_rows>0){
				$row = $result->fetch_assoc();
				return $row["empID"]; 

			}else{
				return false;
			}
		}
	}

	//function to get employee name from employeeID
	function getEmpName($empID){

		$query = "SELECT firstName, lastName FROM employee WHERE empID = ?";
			
		if($stmt = $this->con->prepare($query)){
			
			$stmt->bind_param("i",$empID);

				$stmt->execute();

			$result = $stmt->get_result();

			if($result->num_rows>0){
				
				$row = $result->fetch_assoc();
				
				return $row["firstName"]." ".$row["lastName"]; 

			}else{
				return false;
			}
		}
	}
}

?>
