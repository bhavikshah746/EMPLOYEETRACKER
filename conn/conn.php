<?php

//Live credentials 
/*
define('DB_SERVER', 'localhost'); // db server

define('DB_USER', 'ictatjcu_emptrac'); // db user

define('DB_PASSWORD', '123zxc'); // db password 

define('DB_NAME', 'ictatjcu_emptrack'); // database name
*/

//Local credentials

define('DB_SERVER', 'localhost'); // db server

define('DB_USER', 'root'); // db user

define('DB_PASSWORD', ''); // db password 

define('DB_NAME', 'employeetracker'); // database name

class configDB{

	private $con;

	function __construct(){

	}

	function connect(){
		$this->con = new MySQLi(DB_SERVER,DB_USER,DB_PASSWORD,DB_NAME);

		if(mysqli_connect_errno()){

			echo "Failed to connect with database".mysqli_connect_errno();
		} 
		return $this->con;
	}	
}

?>