<?php

/* A CLASS TO REGISTER AND UPDATE THE DETAILS OF USER */

//INITIALIZE THE DBSERVER HERE */

include('../resoures/DBServer.php');

include('../config/dbconfig.php');


class AddImformation{

	/* THESE ARE THE PRIVATE DATA VARIABLES */

	private $college;
	private $accid;
	private $request;

	private $city;
	private $about;
	private $pro_pic;
	private $search_tags;

	/* ENDS HERE */


	public function startUserSession(){

		session_start();

		$this->accid=$_SESSION['UID'];

	}


	public function getQueryString(){


		$newDBServer=new DBServer;

		$newDBConfig=new dbConfig();


		//GET THE CONNECTION HANDLER//
		$newHandler=$newDBConfig->getConnection();


		$this->request=$_GET['src'];


		if($this->request=='basic-info'){


			//BASIC-INFO REQUEST //

			$this->getCollege();

			$this->getCity();


			$newDBServer->updateLocation($newHandler,$this->college,$this->city,$this->accid);

			echo 'Basic-Info successfully updated!!';

		}
		else if($this->request=="abt"){

			
			$this->getAbout();


			//ABOUT REQUEST//

			$newDBServer->updateAbout($newHandler,$this->about,$this->accid);
			
			echo 'Status successfully updated!!';

		}
		else if($this->request=="tags")
		{

				//WHEN TO SAVE TAGS//

			$this->search_tags=$_GET['q'];
	
			
			if(isset($this->search_tags))
			{
		
			$newDBServer->update($newHandler,'scattr_users_imf','Tags',$this->search_tags,'AccId',$this->accid);

			echo "Search Tags successfully specified!!";

			}
			else
			{
				//TAGS ARE NOT SPECIFIED HER
			}

			
		}


		
	}

	public function getCollege(){

		$this->college=$_GET['clg'];
	}

	public function getCity(){

		$this->city=$_GET['cty'];

	}

	public function getAbout(){

		$this->about=$_GET['abt'];
	}



}

//MAIN BEGINS//

$newAddImf =new AddImformation;


$newAddImf->startUserSession();


$newAddImf->getQueryString();





?>