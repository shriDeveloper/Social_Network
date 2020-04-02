<?php

/* THE DBCONFIG CLASS FOR THE CONNECTION */

class dbConfig{

	/* THESE ARE ALL DB VARIABLES */

	private $userName;
	private $password;
	private $host;
	private $dbName;
	private $connection;

	/* ENDS HERE */


	function __construct() {
       
        /* SETTING UP THE PROPERTIES */

         $this->userName="root";
	 	 $this->password="";
	     $this->host="localhost";
	     $this->dbName="scattr";
   
	   
   }

   public function getConnection(){

   	 $this->connection = mysqli_connect($this->host,$this->userName,$this->password,$this->dbName);

   	 return $this->connection;

   }


}




?>