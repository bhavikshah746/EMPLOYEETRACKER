<?php 

require_once("function/func.php");

$responseArr = array();


if($_SERVER['REQUEST_METHOD']=='POST'){
	
	if(isset($_POST['username']) && isset($_POST['password']) && $_POST["operation"]){
		
		$db = new DBFunction();
		
		$userArr["username"] = $_POST['username'];
		$userArr["password"] = $_POST['password'];
		
		if($db->validateUser($userArr)){
			$responseArr["error"]=false;
			$responseArr["Msg"]="Valid User";
		}else{
			$responseArr["error"]=true;
			$responseArr["Msg"]="Issue while validating user. Please contact administrator";
		}
		
	}else{
		$responseArr["error"]=true;
		$responseArr["Msg"]="Invalid parameters given.";
		
	}
	echo json_encode($responseArr);
}
?>