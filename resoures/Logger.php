<?php

//INITIALIZE THE DBSERVER HERE */

include('../resoures/DBServer.php');

include('../config/dbconfig.php');

include('../utils/System.php');


class EmailException extends Exception{
	public function throwInvalidEmailException($email){
		if(filter_var($email, FILTER_VALIDATE_EMAIL)){
			//EMAIL IS FINE
		}else{
			throw new LoginException("Please a Valid Email is Expected!!!");
		}
	}
}

class LoginException extends Exception{

	public function throwEmailNullException($email){
		if(empty($email)){

			$_SESSION['EMAIL']="false";
			throw new LoginException("Email is not filled!!");
		}else{
			//IF EMAIL IS SET
			$_SESSION['EMAIL']="true";
		}
	}
	public function throwPasswordNullException($password){
		if(empty($password)){

			$_SESSION['PASSWORD']="false";
			throw new LoginException("Password is not filled");
		}else{
			//IF PASSWORD IS ALSO SET
			$_SESSION['PASSWORD']="true";
		}
		
	}
	
}

/*  A Class Logger to get Input from Login Form */
class Logger{

	//THESE ARE THE PRIVATE VARIABLES//

	private $email;

	private $password;

	private $newLogBit;

	//ENDS HERE//
	function __construct() {
       
        $this->newLogBit=0;

   }

	public function getEmail(){
		$newLoginException=new LoginException;
		$newEmailException=new EmailException;

		$this->email=$_POST['email'];
		$newLoginException->throwEmailNullException($this->email);
		$newEmailException->throwInvalidEmailException($this->email);		
	}

	public function getPassword(){

		$newLoginException=new LoginException;
		$this->password=$_POST['pass'];
		$newLoginException->throwPasswordNullException($this->password);
	}

	public function login(){

	if($_SESSION['EMAIL']=="true" && $_SESSION['PASSWORD']=="true")
	{
			
			//CONNECT TO SERVER HERE//

			$newDBServer=new DBServer;

			$newDBConfig=new dbConfig();

			//GET THE CONNECTION HANDLER//
	
			$newHandler=$newDBConfig->getConnection();
			
			//CREATE A LOG SERVER HERE
			$newLogServer=new LogServer;
			$this->newLogBit=$newLogServer->getLoginDetails($newHandler,$this->email,$this->password);
			if($this->newLogBit==1){
				
				//REDIRECT HERE//
				header('Location: ../Home/home?page_ref=24jfsdjhfewjrwjhe');
	
			}
			else{

						//WHEN NO ACCOUNT EXISTS//
						//REDIRECT HERE//
						header('Location: ../sorry?page_ref=OAuth_failed');
						

			}

	}else{

		//IF ALL SESSION FAILS//

		echo "Please enter Valid credentials!!";

	}

	}

	
}


?>


<?php

//MAIN BEGIN HERE

$newLogger=new Logger;

try{
	$newLogger->getEmail();
}
catch(LoginException $newException){
	echo " ".$newException->getMessage();
	echo "FLAG: ".$_SESSION['EMAIL'];
}
catch(EmailException $newEmailEx){
	echo " ".$newEmailEx->getMessage();
}

try{
	$newLogger->getPassword();
}
catch(LoginException $newException){
		echo " ".$newException->getMessage();
		echo "FLAG: ".$_SESSION['PASSWORD'];
}

$newLogger->login();

?>