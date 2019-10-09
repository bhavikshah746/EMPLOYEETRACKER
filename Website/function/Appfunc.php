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
	function getEmpData($action,$userID ="",  $userStatus="active"){
		
		$returnArr =[];
		$returnArr["successFlg"] = true;
		$where = "";  $selectStr = "*"; $queryStr ="";
		
		$userType = $this->check_user_type($_SESSION["userID"]);
		
		$archiveQry ="";
		
		if($userStatus == "active")
			$archiveQry = " and archivedFlg = 0 ";
		
		else if($userStatus == "archived")
			$archiveQry = " and archivedFlg = 1 ";

		if($userType==2){//for teamLeader
			$queryStr = " and teamLeaderID = ?";
		}

		//If action is to get user profile then we will add this to the SQL query
		($action == "getProfile")?$where=" where userName = ? ":$where = " where employee_type != ? ".$queryStr;
		


		$empDataQry = "Select ".$selectStr." from employee ".$where." ".$archiveQry." ".$queryStr." order by dateOfJoining desc";;
		
		if($stmt = $this->con->prepare($empDataQry)){
			
			$empDataArr = [];
			$userType = 1;
			if($action == "getProfile"){
				$stmt->bind_param('s',$userID);
			}else{
				if($userType==2 && $queryStr!="")
					$stmt->bind_param('ii',$userType,$_SESSION["userID"]);
				else
					$stmt->bind_param('i',$userType);
			}
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
		
		$userType = $this->check_user_type($_SESSION["userID"]);

		if($userType == "1"){
			$flg= 1;
			$deleteQry = "UPDATE employee SET archivedFlg = ? WHERE empID =?";
			
			if($stmt = $this->con->prepare($deleteQry)){
				
				$stmt->bind_param('ii', $flg, $id);

				if($stmt->execute()){

					if($stmt->affected_rows==1 || $stmt->affected_rows==0){
						$returnArr["error"]= false;				
						
						$returnArr["msg"]="Deleted Successfully";
					}
				}
			}
		}else {
			
			$returnArr["error"] = true;
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
		$userType = $this->check_user_type($userName);

		if($userType=="" || $userType == false)	
			header("Location: error.php");

		$where = "";
		if($userType == "1"){ //usertype 1 for Super Admin
			$where = " and t.is_deleted = ? "	;

		}else if ($userType == 2){ //usertype 2 for Team Leader
			$where = "and t.is_deleted = ? and t.teamLeaderID = ?";
			
		}else{ //Otherwise just an employee
			$where = "and t.is_deleted = ? and t.empID = ?";
		}

		$query = "SELECT t.taskID, t.taskName,t.empID, t.teamLeaderID, t.taskCreated, t.taskStarted, t.taskDetail, e.firstName, e.lastName FROM task as t, employee as e WHERE t.empID = e.empID ".$where. " and t.completionFlag = ? ";
//echo $query;die;
		if($stmt = $this->con->prepare($query)){
							
			$is_deleted = $taskCompleted = 0;
			
			if($userType == 1){
				$stmt->bind_param('ii',$is_deleted, $completionFlg);

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
	function check_user_type($userName){
		
		if($userName==""){
			return false;

		}else{
			$query = "SELECT employee_type FROM employee WHERE userName = ?";
			
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
	function getEmpName($empID=""){

		$userType = $this->check_user_type($empID);
		$where="";

		if($userType!=3){
			if($userType==2){
				$where = " WHERE teamLeaderID = ?";
			}else 
				$where = " WHERE employee_type!=1";

			$query = "SELECT empID, firstName, lastName FROM employee ".$where;

			if($stmt = $this->con->prepare($query)){
				if($userType==2){
					$stmt->bind_param("i",$empID);
				}	

				$stmt->execute();

				$result = $stmt->get_result();

				if($result->num_rows>0){
				
					if($empID!=""){
						$row = $result->fetch_assoc();
						return $row["firstName"]." ".$row["lastName"]; 
					}else{	
						$userArr = [];
						while($row = $result->fetch_assoc()){
							$userArr[$row["empID"]] = $row["firstName"]." ".$row["lastName"]; 
						}
						return $userArr;
					}
				}else{
					return false;
				}
			}
		}
	}

	//function add new task in tbl sitedetails and task
	function addTaskData($dataArr){
		
		$streetAddress = $suburb = $area1 = $area2 = $postCode = $lat = $lng = "" ;

		if(isset($dataArr["streetAddress"]) && $dataArr["streetAddress"]!=""){
			$streetAddress = $dataArr["streetAddress"];
		}

		if(isset($dataArr["suburb"]) && $dataArr["suburb"]!=""){
			$suburb = $dataArr["suburb"];
		}

		if(isset($dataArr["city"]) && $dataArr["city"]!=""){
			$city = $dataArr["city"];
		}

		if(isset($dataArr["State"]) && $dataArr["State"]!=""){
			$state = $dataArr["State"];
		}

		if(isset($dataArr["postal_code"]) && $dataArr["postal_code"]!="" && is_numeric($dataArr["postal_code"])){
			$postCode = $dataArr["postal_code"];
		}

		if(isset($dataArr["lat"]) && $dataArr["lat"]!="" && isset($dataArr["lng"]) && $dataArr["lng"]!=""){
			$lat = $dataArr["lat"];
			$lng = $dataArr["lng"];
		}

		//Query to insert site details in the sitedetail table
		$site_query = "INSERT INTO `sitedetail`(`streetAddress`, `siteSuburb`, `siteCity`, `siteState`, `siteLongitude`, `siteLatitude`, `siteCityPostcode`) VALUE (?,?,?,?,?,?,?)";
		if($stmt = $this->con->prepare($site_query)){

			$stmt->bind_param("ssssssi",$streetAddress,$suburb, $city,$state, $lng, $lat, $postCode);
			
			$stmt->execute();

			$siteID = $stmt->insert_id;
			
		}else{
			return false;
		}

		if($siteID!="" && is_numeric($siteID)){
			
			$task_name = $task_details = $userID ="";

			if(!isset($dataArr["taskName"]) || $dataArr["taskName"]=="")
				header("Location: error.php");			
			else
				$task_name = $dataArr["taskName"];

			if(!isset($dataArr["taskDetails"]) || $dataArr["taskDetails"]=="")
				header("Location: error.php");			
			else	
				$task_details = $dataArr["taskDetails"];

			if(!isset($dataArr["userID"]) || $dataArr["userID"]=="")
				header("Location: error.php");			
			else	
				$userID = $dataArr["userID"];


			$temLeaderID = $this->getTeamLeader($userID);
			if($temLeaderID==""){
				//super admin
				$temLeaderID = 1;
			}

			$task_query = "INSERT INTO `task`(`taskName`, `taskDetail`, `empID`, `teamLeaderID`, `siteID`) VALUES (?,?,?,?,?)";

			if($stmt = $this->con->prepare($task_query)){
				
				$stmt->bind_param("ssiii",$task_name , $task_details, $userID, $temLeaderID, $siteID);
					
				$stmt->execute();
				
				if($stmt->insert_id!="" || $stmt->insert_id!=0)
					return true;
			}
			return false;
		}else{
			header("Location: error.php");			
		}
	}

	//function to get team leader ID
	function getTeamLeader($empID){
		
		if($empID!=""){

			$query = "SELECT * FROM employee WHERE empID = ?";
			
			if($stmt = $this->con->prepare($query)){
				
				$stmt->bind_param("i",$empID);

				$stmt->execute();

				$result = $stmt->get_result();
				
				if($result->num_rows>0){
					$row = $result->fetch_assoc();
					
					return $row["teamLeaderID"]; 

				}else{
				
					return false;
				}
			}
		}
	}
}

?>
