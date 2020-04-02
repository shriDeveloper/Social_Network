<?php

//INCLUSION GOES HERE

include('../resoures/DBServer.php');

include('../config/dbconfig.php');

include('../utils/System.php');

class Response
{
	private $newFriend;
	private $newUser;

	private $friendFavourites;
	private $userFavourites;

	private $header;

	private $userRequest;

	//SERVER VARIABLES

	private $newDBConfig;

	private $newHandler;

	private $newDBServer;




	function __construct() {
    
    	//CONNECT THE SERVER HERE


    	$this->newDBServer=new DBServer;

   		$this->newDBConfig=new dbConfig();

    	//GET THE CONNECTION HANDLER//
    	$this->newHandler=$this->newDBConfig->getConnection();
   
       
   }


	public function getQueryString()
	{
		session_start();

		$this->header=$_GET['header'];
		$this->newFriend=$_GET['res_type'];
		$this->newUser=$_SESSION['UID'];
	}


	public function checkHeaders()
	{


		$this->getFavourites();


		//IF ACCPT
		if($this->header=="accpt")
		{

			echo "Request Accepted!!";

				
				$this->acceptFavourite();

				$this->disposeRequest($this->newFriend,$this->userRequest,$this->newUser);

		}
		//IF DECLINE
		else if($this->header=="decline")
		{
			
				echo "Request Revoked!!";
			
		
				$this->disposeRequest($this->newFriend,$this->userRequest,$this->newUser);
		}
		else
		{
			//SECURITY ISSUE
		}
	}

	public function getFavourites()
	{


		$this->userRequest=$this->newDBServer->select($this->newHandler,'Request,AccId','scattr_users_favourites','AccId',$this->newUser,'Request');		

		$this->friendFavourites=$this->newDBServer->select($this->newHandler,'Favourites,AccId','scattr_users_favourites','AccId',$this->newFriend,'Favourites');

		$this->userFavourites=$this->newDBServer->select($this->newHandler,'Favourites,AccId','scattr_users_favourites','AccId',$this->newUser,'Favourites');

	}	

	public function acceptFavourite()
	
	{

		//LOGIC BEGINS HERE//

		if($this->friendFavourites=="DEF" && $this->userFavourites=="DEF")
		{
			$this->newDBServer->update($this->newHandler,'scattr_users_favourites','Favourites',$this->newFriend,'AccId',$this->newUser);

			$this->newDBServer->update($this->newHandler,'scattr_users_favourites','Favourites',$this->newUser,'AccId',$this->newFriend);
				
		}
		else if($this->friendFavourites!="DEF" && $this->userFavourites=="DEF")
		{
			
			$this->friendFavourites=$this->friendFavourites.','.$this->newUser;

			$this->newDBServer->update($this->newHandler,'scattr_users_favourites','Favourites',$this->friendFavourites,'AccId',$this->newFriend);


			$this->newDBServer->update($this->newHandler,'scattr_users_favourites','Favourites',$this->newFriend,'AccId',$this->newUser);
			

		}
		else if($this->friendFavourites=="DEF" && $this->userFavourites!="DEF")
		{
			$this->userFavourites=$this->userFavourites.','.$this->newFriend;

			$this->newDBServer->update($this->newHandler,'scattr_users_favourites','Favourites',$this->userFavourites,'AccId',$this->newUser);


			$this->newDBServer->update($this->newHandler,'scattr_users_favourites','Favourites',$this->newUser,'AccId',$this->newFriend);
				
		}
		else
		{
			$this->friendFavourites=$this->friendFavourites.','.$this->newUser;

			$this->userFavourites=$this->userFavourites.','.$this->newFriend;

			$this->newDBServer->update($this->newHandler,'scattr_users_favourites','Favourites',$this->userFavourites,'AccId',$this->newUser);

			$this->newDBServer->update($this->newHandler,'scattr_users_favourites','Favourites',$this->friendFavourites,'AccId',$this->newFriend);
				
		}
	
	}


	public function disposeRequest($newFriendId,$newRequest,$newUserId)
	{

		$i=0;

		$newRequest=explode(',', $newRequest);

		$newFinalRequest=array();

		foreach($newRequest as $request)
		{
			if($request==$this->newFriend)
			{
				//DO NOTHING//
			}
			else
			{
				$newFinalRequest[$i]=$request;

				$i++;
			}
		}

	

		//FINALLY IMPLODE

		$newUpdatedRequest=implode(',', $newFinalRequest);

		$this->newDBServer->update($this->newHandler,'scattr_users_favourites','Request',$newUpdatedRequest,'AccId',$this->newUser);


	}	





}

//MAIN BEGINS HERE

$newResponse=new Response;

$newResponse->getQueryString();

$newResponse->checkHeaders();

?>