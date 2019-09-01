<?php 
session_start();
require_once("function/Appfunc.php");

$responseArr = array();

if($_SERVER['REQUEST_METHOD']=='POST'){

	$db = new DBFunction();

	if(isset($_POST["ActionType"]) && $_POST["ActionType"]=="checkLogIn"){	

		if(isset($_POST['username']) && isset($_POST['password']) && $_POST['username'] && $_POST['password']){
			
			$userArr["username"] = $_POST['username'];

			$userArr["password"] = $_POST['password'];

			if(isset($_POST['logInType']))
				$userArr["logInType"] = $_POST['logInType'];
				
			$resultArr = $db->validateUser($userArr);

			if($resultArr["flg"]==true){
 
				if($_POST['logInType']=="portalLogin"){

					$_SESSION["userID"] = $resultArr["userID"];
					$_SESSION["userName"] = $resultArr["userName"];
					header('Location:dashboard.php');
				}

				$responseArr["error"]=false;
				$responseArr["Msg"]="Valid User";

			}else{
				session_destroy();
				$responseArr["error"]=true;
				$responseArr["Msg"]="Issue while validating user. Please contact administrator";
			}

		}
	
	}else if(isset($_POST["ActionType"]) && $_POST["ActionType"]=="getDashboardData"){

		$dahsboardData = [];

		$dahsboardData = $db->getDashData();
		
		if($dahsboardData["successFlg"]==true){

			$responseArr["Data"] = $dahsboardData;

			$responseArr["error"]=false;

		}else{

			$responseArr["error"]=true;

			$responseArr["Msg"]="Issue while loading Tasks. Please contact administrator";
		}
		

	}else if(isset($_POST["ActionType"]) && $_POST["ActionType"]=="getTask"){

		if(isset($_POST["username"]) && $_POST["username"]!=""){

			$taskName = [];

			$taskName = $db->getTask($_POST["username"]);
			

			if(!empty($taskName)){

				$responseArr["TaskData"] = $taskName;

				$responseArr["error"]=false;

			}else{

				$responseArr["error"]=true;

				$responseArr["Msg"]="Issue while loading Tasks. Please contact administrator";
			}

		}

	}else if(isset($_POST["ActionType"]) && $_POST["ActionType"]=="getTaskDetails"){

		if(isset($_POST["username"]) && $_POST["username"]!=""){


			$taskDetails = [];

			$username = $_POST["username"];

			$taskID = $_POST["taskID"];

			$taskDetails = $db->getTaskDescription($username,$taskID);


			if(!empty($taskDetails)){

				$responseArr["TaskData"] = $taskDetails;

				$responseArr["error"]=false;

			}else{

				$responseArr["error"]=true;

				$responseArr["Msg"]="Issue while loading Tasks. Please contact administrator";

			}

		}

	}else if(isset($_POST["ActionType"]) && $_POST["ActionType"]=="ClockOut"){

		if(isset($_POST["username"]) && $_POST["username"]!=""){
		

			$taskDetails = [];

			$username = $_POST["username"];

			$taskDetails = $db->checkLocation($username);
			

			if(!empty($taskDetails)){

				$responseArr = $taskDetails;

				$responseArr["error"]=false;

			}else{

				$responseArr["error"]=true;

				$responseArr["Msg"]="Issue while loading Tasks. Please contact administrator";

			}

		}

	}

	else{

		$responseArr["error"]=true;

		$responseArr["Msg"]="Invalid parameters given.";


	}

	echo json_encode($responseArr);
}

?>