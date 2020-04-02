<?php

/*  A Class Logger to get Input from Login Form */

//INITIALIZE THE DBSERVER HERE */

include('../resoures/DBServer.php');

include('../config/dbconfig.php');

include('../utils/encrypter.php');

include('../utils/System.php');


class Signer{
	
	/* THESE ARE THE PRIVATE DATA VARIABLES */

	private $accid;
	private $firstName;
	private $lastName;
	private $email;
	private $password;

	/* ENDS HERE */


	public function getFirstName(){

		//SANITIZE THE INPUT HERE */

		$this->firstName=$_POST['FirstName'];
	}

	public function getLastName(){

		$this->lastName=$_POST['LastName'];
	}
	public function getEmail(){

		$this->email=$_POST['Email'];
	}
	public function getPassword(){

		$this->password=$_POST['Password'];
	}

	public function signup(){

		$newFlag=0;


		$newSystem=new System;

		$newUtilities=new MyUtilities;


		//CONNECT SERVER HERE

		$newDBServer=new DBServer;

		$newDBConfig=new dbConfig();

		//GET THE CONNECTION HANDLER//
		$newHandler=$newDBConfig->getConnection();


		//CHECK ACCOUNT REDUNDANCY
		
		$newFlag=$newUtilities->checkAccount($newHandler,$this->email);


		if($newFlag==1)
		{
			//IF DUPLICACY FOUND

			//REDIRECT TO SETUP PAGE//

			header('Location:../AccExist?page_ref=error_dup_account');

		}
		else
		{
			//IF NOT FOUND

		$default_picture="http://sdcrush.com/themes/sexymetro/img/no_user.jpg";


		//GENERATE ID HERE //

		$this->accid=$newSystem->generateID();

		//GENERATE A UPIC ID FOR ONLY ONE PROFILE IMAGE

		$newEncrypter=new Encrypter;


		$upic=$newEncrypter->generate();


		session_start();

		//ALSO GENERATE A UPIC ID AS SESSION

		$_SESSION['UPIC']=$upic;

		//GENERATE A USER SESSION ID //


		$_SESSION['UID']=$this->accid;



		//CREATE CONTAINERS HERE MAINLY FOLDERS//

		$newSystem->createAccount($this->accid);


		$newDBServer->insert($newHandler,$this->accid,$this->firstName,$this->lastName,$this->email,$this->password,$default_picture,$upic);

		$newDBServer->insertImf($newHandler,$this->accid,'DEF','DEF','DEF');


		$newDBServer->insertFavourite($newHandler,$this->accid,'DEF','DEF');


		$newDBServer->insertImgBase($newHandler,$this->accid,'DEF');	


	
		//REDIRECT TO SETUP PAGE//

		header('Location:../Setup/setup.php');

		}



	}
}

/* MAIN START HERE */

 $newSigner=new Signer;


$newSigner->getFirstName();

$newSigner->getLastName();

$newSigner->getEmail();

$newSigner->getPassword();

$newSigner->signup();


?>