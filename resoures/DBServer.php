<?php

//INCLUSION//

include('../Exception/GeneralException.php');


//A CLASS FOR DATABASE QUERIES //

class DBServer{

	//THIS IS INSERT FUNCTION//
	
	public function insert($dbHandler,$accId,$firstName,$lastName,$email,$password,$picture,$upic){

		//This is the Query//

		mysqli_query($dbHandler,"INSERT INTO `scattr_users` (`AccId`,`FirstName`,`LastName`, `Email`,`Password`,`Picture`,`UPic`) VALUES ('$accId','$firstName','$lastName','$email','$password','$picture','$upic');");
	
	}


	public function insertImf($dbHandler,$accId,$college,$city,$about){

		mysqli_query($dbHandler,"INSERT INTO `scattr_users_imf` (`AccId`,`College`,`City`, `About`) VALUES ('$accId','$college','$city','$about');");

	}



	public function updateLocation($dbHandler,$college,$city,$where){

		//UPDATE QUERY HERE//

		 mysqli_query($dbHandler,"UPDATE `scattr_users_imf` SET `City`='$city',`College`='$college' WHERE `AccId`='$where'");
		
	}


	public function updateAbout($dbHandler,$about,$where){

		//UPDATE  ABOUT QUERY HERE//

		 mysqli_query($dbHandler,"UPDATE `scattr_users_imf` SET `About`='$about' WHERE `AccId`='$where'");
		

	}


	public function updateProfilePicture($dbHandler,$picture,$where){

		//UPDATE  ABOUT QUERY HERE//

		 mysqli_query($dbHandler,"UPDATE `scattr_users` SET `Picture`='../Public/$where/propic/$picture' WHERE `AccId`='$where'");
		
	}

	/** DOCUMENTATION  FOR THE SELECT FUNCTION */

	/*PARAMETERS USED 

	$dbHandler : handler of the database

	$select    : specifies what to select from the database

	$from      : specifies the table for selection

	$which     : specifes what to match in order to return data

	$data 	   : Input data to match	

	$return    : specfies what to return from the selection

	*/


	public function select($dbHandler,$select,$from,$which,$data,$return){

		 $result=mysqli_query($dbHandler,"SELECT $select FROM $from");
 		 while ($row = mysqli_fetch_array($result))
         {
				if($row[$which]==$data)
				{

					$returned=$row[$return];


					break;
				
				}
		 }

		 //FINALLY RETURN THE RETURNED//

		 return $returned;


	}

/*

	public function selectImage($dbHandler,$select,$from,$which,$data,$return,$date,$time){

		 $result=mysqli_query($dbHandler,"SELECT $select FROM $from ORDER BY `$date` ASC, `$time` ASC");
 		 while ($row = mysqli_fetch_array($result))
         {
				if($row[$which]==$data)
				{

					$returned=$row[$return];


					break;
				
				}
		 }

		 //FINALLY RETURN THE RETURNED//

		 return $returned;


	}

	*/


	public function insertFavourite($dbHandler,$accId,$fav,$req){

		//INSERT FAVOURITE HERE//

		mysqli_query($dbHandler,"INSERT INTO `scattr_users_favourites` (`AccId`,`Favourites`,`Request`) VALUES ('$accId','$fav','$req');");

	}

	public function update($dbHandler,$what,$set,$data,$where,$data2){

		//UPDATE  ABOUT QUERY HERE//

		 mysqli_query($dbHandler,"UPDATE $what SET $set='$data' WHERE $where='$data2'");

	}



	public function insertUploadPicture($dbHandler,$imgid,$imgname,$hits,$cid,$upid,$time,$date,$caption,$privacy)
	{

		//INSERT A PICTURE//
		
		mysqli_query($dbHandler,"INSERT INTO `scattr_img_base` (`ImgId`,`ImgName`,`Hits`,`Cid`,`Uploader`,`Time`,`Date`,`Caption`,`Privacy`) VALUES ('$imgid','$imgname','$hits','$cid','$upid','$time','$date','$caption','$privacy');");

	}

	public function insertImgBase($newHandler,$accid,$imgbase)
	{
		//INSERT INTO USER BASE

		mysqli_query($newHandler,"INSERT INTO `scattr_user_img_base` (`AccId`,`ImgId`) VALUES ('$accid','$imgbase');");

	}

	public function insertImgBaseForLike($newHandler,$imgid,$likes)
	{
		//INSERT INTO IMG  BASE FOR LIKE

		mysqli_query($newHandler,"INSERT INTO `scattr_img_base_likes` (`ImgId`,`likes`) VALUES ('$imgid','$likes');");

	}
	



}


//A CLASS FOR THE LOG DETAILS//

class LogServer{



	public function getLoginDetails($dbHandler,$email,$password){


        //THESE ARE THE STATUS VARIABLES//
        $newFlag=0;
        $newStartup=0;
        $i=0;
        $newRecentId=0;
		//ENDS HERE//

        //LOGIC GOES HERE//

		$result=mysqli_query($dbHandler,"SELECT Email,Password,AccId FROM `scattr_users`");
        
        while ($row = mysqli_fetch_array($result))
            {
				
            	//GET THE EMAIL AND PASSWORD

				$usergo=$row['Email'];
				$passgo=$row['Password'];
                                
                                
				if($email==$usergo && $password==$passgo)
				{

					$newFlag++;
					//FINALLY SAVE THE RECENT ID

                    $newRecentId=$row['AccId'];

				}


				$newStartup++;

			}


			//CHECK WHETHER FLAG IS SET//

			if($newFlag==1)
			{


			//VALID//

			//GENERATE SESSION DATA HERE //

			session_start();

			$_SESSION['UID']=$newRecentId;

			//ENDS HERE//	
				            
            }
            else
			{

				//INVALID//
                       
         		mysqli_query($dbHandler,"INSERT INTO `scattr_login_attempts` (`Email`, `Password`) VALUES ('$email','$password');");

			}

			return $newFlag;


	}
}


//A CLASS FOR COMMENT SERVER

class CommentServer
{
	//FUNCTION TO INSERT COMMENT
	public function insertComment($newHandler,$cid,$myComment,$commenter)
	{
		mysqli_query($newHandler,"INSERT INTO `scattr_user_comments` (`CID`,`Comment`,`Commenter`) VALUES ('$cid','$myComment','$commenter');");
	}
}


?>