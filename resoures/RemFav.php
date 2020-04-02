<?php

// A CLASS TO REMOVE OR CANCEL REQUEST TO  FAVOURITES

//INITIALIZE THE DBSERVER HERE */

include('../resoures/DBServer.php');

include('../config/dbconfig.php');

include('../utils/System.php');


class RemFav{
	
	//THESE ALL ARE THE PRIVATE DATA VARIABLES
	private $friend_id;
	private $my_id;
	private $friend_req_list;
	//ENDS HERE

	public function getQueryString(){

		session_start();

		$this->friend_id=$_GET['fri'];

		$this->my_id=$_SESSION['UID'];
	}

	public function cancelFavouriteRequest(){

		//First GET THE FRIEND REQ LIST
		

		//JUST A SYSTEM OBJECT HERE

		$newSystem=new System;

		//INITIALIZE SERVER


		$newDBServer=new DBServer;

		$newDBConfig=new dbConfig();


		//GET THE CONNECTION HANDLER//
		$newHandler=$newDBConfig->getConnection();

		
		$this->friend_req_list=$newDBServer->select($newHandler,'Request,AccId','scattr_users_favourites','AccId',$this->friend_id,'Request');

		$newArray=explode(',', $this->friend_req_list);

		//REMOVE THE SPECIFIED ELEMENT

		if (($key = array_search($this->my_id, $newArray)) !== false) {
    		unset($newArray[$key]);
		}


		$newString=implode(',',$newArray);

		
		echo "NEw: ".$newString;

		//WRITE STRING TO DB

		$newDBServer->update($newHandler,'scattr_users_favourites','Request',$newString,'AccId',$this->friend_id);



		//REDIRECT PAGE

		header("Location: ../Find/Friends?search_bar=#");


	}

}
//MAIN BEGINS//


$newRemFav=new RemFav;

$newRemFav->getQueryString();


$newRemFav->cancelFavouriteRequest();



?>