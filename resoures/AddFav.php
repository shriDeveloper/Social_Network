<?php

// A CLASS TO AFF FRIENDS TO FAVOURITES

//INITIALIZE THE DBSERVER HERE */

include('../resoures/DBServer.php');

include('../config/dbconfig.php');

include('../utils/System.php');


class AddFav{

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


	public function sendFavouriteRequest(){

		//First GET THE FRIEND REQ LIST


		//JUST A SYSTEM OBJECT HERE

		$newSystem=new System;

		//INITIALIZE SERVER


		$newDBServer=new DBServer;

		$newDBConfig=new dbConfig();


		//GET THE CONNECTION HANDLER//
		$newHandler=$newDBConfig->getConnection();


		$this->friend_req_list=$newDBServer->select($newHandler,'Request,AccId','scattr_users_favourites','AccId',$this->friend_id,'Request');


			if($this->friend_req_list=="DEF" || empty($this->friend_req_list)){

			//IF REQUEST IS SEND FOR FIRSTTIME//

			$newDBServer->update($newHandler,'scattr_users_favourites','Request',$this->my_id,'AccId',$this->friend_id);

			}
			else
			{

				$newFlag=$newSystem->filterArray($this->friend_req_list,$this->my_id);

				if($newFlag==1)
				{
					//DO NOTHING//
					echo 'Duplicate';
				}
				else
				{

					//CONSTRUCT THE  NEW STRING

					$newFriend=$this->friend_req_list.','.$this->my_id;


					//IF REQUEST IS OTHER THAN   FIRSTTIME//

					$newDBServer->update($newHandler,'scattr_users_favourites','Request',$newFriend,'AccId',$this->friend_id);


				}


			}


				//REDIRECT PAGE

				header("Location: ../Find/Friends?search_bar=#");

		
	}



}

//MAIN BEGINS HERE


$newAddFav= new AddFav;

$newAddFav->getQueryString();

$newAddFav->sendFavouriteRequest();


?>