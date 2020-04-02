<?php

//A CLASS FOR THE LOGIN EXCEPTIONS

class LoginException extends Exception{

	private $newMsg;

	function __construct($msg) {
       
        $this->newmsg=$msg;
   }

}


?>