<?php

define('DB_SERVER', 'localhost'); // db server</p>
define('DB_USER', 'root'); // db user<br>
define('DB_PASSWORD', ''); // db password (mention your db password here)<br>
define('DB_NAME', 'test'); // database name<br>
  
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