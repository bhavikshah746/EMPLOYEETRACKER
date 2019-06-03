<?php 

require_once("function/Appfunc.php");

$responseArr = array();


if($_SERVER['REQUEST_METHOD']=='POST'){
	
	$db = new DBFunction();
	
	if($_POST["ActionType"] && $_POST["ActionType"]=="checkLogIn"){
		
		if(isset($_POST['username']) && isset($_POST['password']) ){
			

			$userArr["username"] = $_POST['username'];
			$userArr["password"] = $_POST['password'];

			if($db->validateUser($userArr)){
				$responseArr["error"]=true;
				$responseArr["Msg"]="Valid User";
			}else{
				$responseArr["error"]=false;
				$responseArr["Msg"]="Issue while validating user. Please contact administrator";
			}
		}
		
	}else if($_POST["ActionType"] && $_POST["ActionType"]=="getTask"){
		if(isset($_POST["username"]) && $_POST["username"]!=""){
			$username = $_POST["username"];
			if($db->validateUser($userArr)){
				$responseArr["error"]=true;
				$responseArr["Msg"]="Valid User";
			}else{
				$responseArr["error"]=false;
				$responseArr["Msg"]="Issue while validating user. Please contact administrator";
			}
		}
	}
	else{
		$responseArr["error"]=false;
		$responseArr["Msg"]="Invalid parameters given.";
		
	}
	echo json_encode($responseArr);
}
?>