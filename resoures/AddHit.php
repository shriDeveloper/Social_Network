<?php

//INITIALIZE THE DBSERVER HERE */

include('../resoures/DBServer.php');

include('../config/dbconfig.php');

class Hits
{
	private $imgId;

	private $userId;

	private $hitId;

	private $imgHits;


	private $newDBServer;

	private $newDBConfig;

	private $newHandler;


	public function getUserSession()
	{

		session_start();

		$this->userId=$_SESSION['UID'];

		//SET TO ZERO//

		$this->imgHits=0;

	}

	public function fetchImgId()
	{
		$this->imgId=$_REQUEST['page_id'];
	}

	public function hitLike()
	{
		
			//CONNECT TO SERVER HERE//

    		$this->newDBServer=new DBServer;

   	 		$this->newDBConfig=new dbConfig();

   	 		 //GET THE CONNECTION HANDLER//
    		
    		$this->newHandler=$this->newDBConfig->getConnection();


    		$this->hitId=$this->newDBServer->select($this->newHandler,'ImgId,likes','scattr_img_base_likes','ImgId',$this->imgId,'likes');


    		if($this->hitId=="DEF" || empty($this->hitId))
    		{
    			//UPDATE WITH LATEST ENTRY

    			$this->newDBServer->update($this->newHandler,'scattr_img_base_likes','likes',$this->userId,'ImgId',$this->imgId);

    		}
    		else
    		{
    		
    			$fetchedHits=$this->newDBServer->select($this->newHandler,'ImgId,likes','scattr_img_base_likes','ImgId',$this->imgId,'likes');


	    		$newHits=array();

	    		$newFlagBit=0;

	    		//FILTER HERE//

	    		$filterHits=explode(',', $this->hitId);

	    		foreach($filterHits as $hit)
	    		{
	    			if($hit==$this->userId)
	    			{
	    				$newFlagBit=1;
	    			}
	    			else
	    			{
	    				array_push($newHits, $hit);
	    			}
	    		}

	    		if($newFlagBit==1)
	    		{
	    			//do nothing //
	    		}
	    		else
	    		{

		    			$fetchedHits=implode(',', $newHits);

		    			//ENDS HERE//


		    			$fetchedHits=$fetchedHits.','.$this->userId;

		    			//UPDATE WITH THE ENTRY

		    			$this->newDBServer->update($this->newHandler,'scattr_img_base_likes','likes',$fetchedHits,'ImgId',$this->imgId);


	    		}


    		}

	}

	public function updateImageHits()
	{
				
				$tmpHits=$this->newDBServer->select($this->newHandler,'ImgId,likes','scattr_img_base_likes','ImgId',$this->imgId,'likes');

				$newHits=explode(',', $tmpHits);

				foreach($newHits as $hit)
				{
					$this->imgHits++;
				}

				//UPDATE THE HITS TO IMG BASE//

				$this->newDBServer->update($this->newHandler,'scattr_img_base','Hits',$this->imgHits,'ImgId',$this->imgId);


	}
}
//MAIN BEGINS 

$newHit=new Hits;


$newHit->getUserSession();

$newHit->fetchImgId();

$newHit->hitLike();

$newHit->updateImageHits();


?>