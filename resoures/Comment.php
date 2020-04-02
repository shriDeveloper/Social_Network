<?php

//INCLUSION GOES HERE//

include('../resoures/DBServer.php');

include('../config/dbconfig.php');

include('../utils/System.php');

class CommentException extends Exception
{
    public function throwNullCommentException($comment)
    {
        if(isset($comment))
        {
            //do nothing//
        }
        else
        {
            throw new CommentException("Please enter a valid Comment!!");
        }
    }
}


class Comment
{
	private $newComment;

	private $newCommentId;

	private $newAccId;

	private $newImageBase;


	//PUBLIC FUNCTION TO UPDATE IMG BASE HERE 

	public function updateImgBase()
	{

		//SERVER CONNECTION HERE//

        $newDBServer=new DBServer;

       	//A SYSTEM OBJECT HERE

        $newSystem=new System;

        $newDBConfig=new dbConfig();

        //GET THE CONNECTION HANDLER//
        $newHandler=$newDBConfig->getConnection();


        //GET THE IMAGE BASE//


        $this->newImageBase=$newDBServer->select($newHandler,'ImgId,Cid','scattr_img_base','ImgId',$this->imgId,'Cid');


        if($this->newImageBase=="DEF" || empty($this->newImageBase))
        {
        	//THIS IS THE CODE WHEN NO COMMENT IS FILLED
        

        	//UPDATE THE SAME HERE

        	$newDBServer->update($newHandler,'scattr_img_base','Cid',$this->newCommentId,'ImgId',$this->imgId);

        }
        else
        {
        	//CONSIST PRE_EXISTING COMMENTS

        	$newImgBaseFormed=$this->newImageBase.','.$this->newCommentId;

        	//UPDATE THE ENTRY HERE //

            $newDBServer->update($newHandler,'scattr_img_base','Cid',$newImgBaseFormed,'ImgId',$this->imgId);

        }



	}


	public function getActiveUser()
	{
		session_start();

		$this->newAccId=$_SESSION['UID'];

		$this->imgId=$_GET['page_ref'];

	}

	public function CommentOnPage()
	{
		$this->newComment=$_REQUEST['cmt'];

        if(empty($this->newComment))
        {
            echo "Please Comment!!";


        }
        else
        {
            //Comment Specified!!

            $this->postComment();


            $this->updateImgBase();

        }

	}

	public function postComment()
	{
		
		//GET THE COMMENTER USER//

		$this->getActiveUser();


		//SERVER CONNECTION HERE//

        $newDBServer=new CommentServer;

       	//A SYSTEM OBJECT HERE

        $newSystem=new System;

        $newDBConfig=new dbConfig();

        //GET THE CONNECTION HANDLER//
        $newHandler=$newDBConfig->getConnection();

        //GENERATE A COMMENT ID HERE//

        $this->newCommentId=$newSystem->generateID();

        $newDBServer->insertComment($newHandler,$this->newCommentId,$this->newComment,$this->newAccId);



	}
}


/* TRIGGER CODE HERE */

/*

CREATE TRIGGER user_trig AFTER INSERT ON users FOR EACH ROW 

INSERT INTO trigger_time VALES(NOW());



SHOW TRIGGERS;


*/

//MAIN BECOMES HERE//

$newCommentObject=new Comment;


$newCommentObject->CommentOnPage();


echo "Comment SucessFully Done!!";


?>