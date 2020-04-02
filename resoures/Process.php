 <?php

//INCLUSION GOES HERE


//INITIALIZE THE DBSERVER HERE */

include('../resoures/DBServer.php');

include('../config/dbconfig.php');

include('../utils/System.php');

include('../utils/AES.php');


include('../utils/encrypter.php');




//A CLASS FOR THE UPLOADER


class Process 
{
	
	//THESE ARE THE PRIVATE SERVER CONNECTION  VARIABLES

  	private $newDBConfig;

  	private $newDBServer;

  	private $newHandler;

  	private $userId;


  	private $newImgEncrypted;

  	private $userImages;


	function __construct()
	{
			//ALSO GET ID HERE//

			session_start();

			$this->userId=$_SESSION['UID'];

			//CONNECT TO SERVER HERE//

    		$this->newDBServer=new DBServer;

   	 		$this->newDBConfig=new dbConfig();

   	 		 //GET THE CONNECTION HANDLER//
    		
    		$this->newHandler=$this->newDBConfig->getConnection();

 
	}


	public function getImgId()
	{
		$id=substr(number_format(time() * rand(),0,'',''),0,6);

		return $id;
	}

	public function uploadPicture()
	{

		$newEncrypted=new encrypter;

		$newSystem=new System;

		//REQUEST FOR POST

		if(@$_POST['myupload'])
		{
				

			//TIME HERE//

			$returnedTime=$newSystem->getSystemDateTime();
			
			$timeArray=explode('&', $returnedTime);



			//STORE FROM ARRAY
			$current_date=$timeArray[0];


			$current_time=$timeArray[1];



				//THESE ALL ARE THE FILE VARIABLES//
        		$file=$_FILES['myfile'];

		        $file_name=$file['name'];
		        $file_type=$file['type'];
		        $file_size=$file['size'];
		        $file_path=$file['tmp_name'];

		        //ENDS HERE//



				$inputText=$file_name.''.$newEncrypted->generate();
				$inputKey="shriniketdeshmukh111@gmail.com97";
				$blockSize=256;



				$newAes = new AES($inputText, $inputKey, $blockSize);
				$newTmpEnc = $newAes->encrypt();


				$this->newImgEncrypted=str_replace('/', 'shri', $newTmpEnc);


		        //RESTRICT FILE//

		        if($file_name!="" &&($file_type="images/jpeg"||$file_type="images/png"||$file_type="image/gif")&& $file_size<=13048576)

		        if(move_uploaded_file($file_path,"../Public/$this->userId/photos/$this->newImgEncrypted")){

		          //IF FILE MOVES SUCCESSFULLY

		        	$imgId=$this->getImgId();

		        	$newFlag=$this->newDBServer->insertUploadPicture($this->newHandler,$imgId,$this->newImgEncrypted,0,"DEF",$this->userId,$current_time,$current_date,"DEF","DEF");


		        	//ALSO UPDATE THE IMG LIKE BASE


		        	$this->newDBServer->insertImgBaseForLike($this->newHandler,$imgId,"DEF");


		        	//FINALLY UPDATE THE USER IMG BASE


		        	$this->userImages=$this->newDBServer->select($this->newHandler,'ImgId,AccId','scattr_user_img_base','AccId',$this->userId,'ImgId');


					
		        	if($this->userImages=="DEF" || empty($this->userImages))
		        	{

		        		$this->newDBServer->update($this->newHandler,'scattr_user_img_base','ImgId',$imgId,'AccId',$this->userId);
		        	}
		        	else
		        	{
		        			$this->userImages=$this->userImages.','.$imgId;

		        			$this->newDBServer->update($this->newHandler,'scattr_user_img_base','ImgId',$this->userImages,'AccId',$this->userId);

		        	}

        			}
        			else
        			{
        				echo "Cant Upload!!!";
        			}


        			//CREATE A IMG SESSION HERE
        			

        			$_SESSION['IMG']=$imgId
        			;


        			header("Location:../Home/home");

		}
		else
		{
			echo 'NO post at all';
		}
	
	}


}

//MAIN BEGINS HERE

$newProcess=new Process();

$newProcess->uploadPicture();


 ?>