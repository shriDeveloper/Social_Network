<?php


//require 'vendor/autoload.php';


include('../resoures/DBServer.php');

include('../config/dbconfig.php');

include('../utils/System.php');

include('../utils/AES.php');


/*
$faker=Faker\Factory::create();


//CONNECT THE SERVER HERE


        $newDBServer=new DBServer;

        $newDBConfig=new dbConfig();

        //GET THE CONNECTION HANDLER//
        $newHandler=$newDBConfig->getConnection();


foreach (range(1,2000) as $val) {
    

	$id=$faker->randomNumber(6);
	$fname=$faker->firstName;
	$lname=$faker->lastName;
	$email=$faker->email;
	$username=$faker->username;

    $newDBServer->insert($newHandler,$id,$fname,$lname,$email,$username,"http://lorempixel.com/400/200/sports/","23323");


		$newDBServer->insertImf($newHandler,$id,'DEF','DEF','DEF');


		$newDBServer->insertFavourite($newHandler,$id,'DEF','DEF');


		$newDBServer->insertImgBase($newHandler,$id,'DEF');	


		mkdir("../Public/".$id, 0, true);
		mkdir("../Public/".$id."/photos", 0, true);
		mkdir("../Public/".$id."/thumbs", 0, true);
        mkdir("../Public/".$id."/propic", 0, true);
		mkdir("../Public/".$id."/data", 0, true);



}

*/


/*

date_default_timezone_set('Asia/Kolkata');      

    for($i=0;$i<count($parserImages);$i++)
    {
      for($j=0;$j<count($parserImages)-$i-1;$j++)
      {

          $newDate1=$parserImages[$j]->ImgDate.' '.$parserImages[$j]->ImgTime;
          $newDate2=$parserImages[$j+1]->ImgDate.' '.$parserImages[$j+1]->ImgTime;
          $d1 = new DateTime($newDate1);
          $d2 = new DateTime($newDate2);

          if($d1>$d2)
          {
            $tmpDate=$parserImages[$j];
            $parserImages[$j]=$parserImages[$j+1];
            $parserImages[$j+1]=$tmpDate;
          }
      }
    }

*/





//CONNECT THE SERVER HERE


class Friend{
	public $id;
	public $imgname;
	public $imgid;

	function __construct($id,$imgid,$imgname){
		$this->id=$id;
		$this->imgid=$imgid;
		$this->imgname=$imgname;	
	}
}


class Image{
	public $imgid;
	public $imgname;
	public $hits;
	public $time;
	public $date;

	public $timestamp;

	function __construct($imgid,$imgname,$time,$date,$timestamp){
		
		$this->imgid=$imgid;
		$this->time=$time;	
		$this->imgname=$imgname;
		$this->date=$date;

		$this->timestamp=$timestamp;
	}



}



        $newDBServer=new DBServer;

        $newDBConfig=new dbConfig();

        //GET THE CONNECTION HANDLER//
        $newHandler=$newDBConfig->getConnection();


        $dlist=new SplDoublyLinkedList();


        $newImages=new SplDoublyLinkedList();

        $list=$newDBServer->select($newHandler,'Favourites,AccId','scattr_users_favourites','AccId',111110,'Favourites');


        $arrayed=explode(',', $list);


        //ALSO PUSH THE USER ID 

        array_push($arrayed, 111110);

        foreach($arrayed as $array)
        {

        	//GET IMAGE ID HERE//

        	$img=$newDBServer->select($newHandler,'ImgId,AccId','scattr_user_img_base','AccId',$array,'ImgId');

        	$dlist->push(new Friend($array,$img,"JUNK"));
        	
        }


        for($dlist->rewind();$dlist->valid();$dlist->next()){
    

        	$images=$dlist->current()->imgid;
        	$imgArray=explode(',',$images);


        	foreach($imgArray as $img)
        	{

        		//ALL IMAGE ATTRIB

        		$name=$newDBServer->select($newHandler,'ImgId,ImgName','scattr_img_base','ImgId',$img,'ImgName');

        		$hits=$newDBServer->select($newHandler,'ImgId,Hits','scattr_img_base','ImgId',$img,'Hits');
        		$time=$newDBServer->select($newHandler,'ImgId,Time','scattr_img_base','ImgId',$img,'Time');
        		$date=$newDBServer->select($newHandler,'ImgId,Date','scattr_img_base','ImgId',$img,'Date');

        		$tmpTimeStamp=$date.''.$time;

        		$TimeStamp=new DateTime($tmpTimeStamp);


        		$newImages->push(new Image($img,$name,$time,$date,$TimeStamp));


        	}

    }

    //SORT LOGIC GOE SHERE




	//PRINT IMAGES

    for($newImages->rewind();$newImages->valid();$newImages->next()){

    	echo "<h1>ImgId: ".$newImages->current()->imgid." Time: ".$newImages->current()->time."<h1>";
    	echo "<br>";

    }



?>
