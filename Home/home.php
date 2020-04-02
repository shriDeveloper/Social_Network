<?php

//INITIALIZE THE DBSERVER HERE */

include('../resoures/DBServer.php');

include('../config/dbconfig.php');

include('../utils/System.php');

include('../resoures/Recommender.php');



class SuggestFriends
{
                    
                    public function displaySuggested($search)
                    {
                        

                        
                        $newRecommend=new Recommender;


                        $newDBServer=new DBServer;

                        $newDBConfig=new dbConfig();

                        
                        //GET THE CONNECTION HANDLER//
                  

                        $newHandler=$newDBConfig->getConnection();


                        $userString=$newDBServer->select($newHandler,'AccId,Favourites','scattr_users_favourites','AccId',$_SESSION['UID'],'Favourites');


                        $userFriends=explode(',', $userString);

                        
                        $recommendedFriends=$newRecommend->recommendUser($search,$newHandler);



                        foreach($recommendedFriends as $friend)
                        {


                                if($friend==$_SESSION['UID'])
                                {
                                  //DO NOTHING//
                                }
                                else
                                {


                                      if(in_array($friend,$userFriends ))
                                      {

                                        //DO NOT DISPLAY
                                      }
                                      else
                                      {




                                            $userPic=$newDBServer->select($newHandler,'AccId,Picture','scattr_users','AccId',$friend,'Picture');

                                            $userFname=$newDBServer->select($newHandler,'AccId,FirstName','scattr_users','AccId',$friend,'FirstName');

                                            $userLname=$newDBServer->select($newHandler,'AccId,LastName','scattr_users','AccId',$friend,'LastName');



                                     echo' <div class="row">
                                <div class="col-md-12">
                                  <div class="well well-sm">
                                    
                                    <div class="row">
                                      <div class="col-md-2 col-sm-3 col-xs-3">
                                        <img src="'.$userPic.'"  width="32" height="32" class="img-circle">
                                      </div>
                                      <div class="col-md-7">
                                          <b>'.ucfirst($userFname).' '.ucfirst($userLname).'</b>            
                                      </div>

                                      <div class="col-md-3 col-sm-3 col-xs-5">
                                        <a class="btn btn-default btn-sm btn-block">Add</a>
                                      </div>
                                    </div>

                                  </div>
                                </div>
                              </div>';







                                      }
                            
                                      
                        }


                                }


                            


                    }
}
// CLASS ENDS HERE//



//THESE CLASSES REPRESENT USER AND IMAGE OBJECTS



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
  public $uploader;
  public $timestamp;
  public $comment;

  function __construct($imgid,$imgname,$time,$date,$timestamp,$uploader,$comment){
    
    $this->imgid=$imgid;
    $this->time=$time;  
    $this->imgname=$imgname;
    $this->date=$date;
    $this->uploader=$uploader;
    $this->timestamp=$timestamp;

    $this->comment=$comment;

  }


}




//A CLASS FOR THE USER HOME
class Home{


              //THESE ARE THE PRIVATE SERVER CONNECTION  VARIABLES

              private $newDBConfig;

              private $newDBServer;

              private $newHandler;


              //THESE ARE THE PRIVATE VARIABLES

              public $userPic;
              public $userId;
              public $userFname;
              public $userTags;
              public $userLname;
              public $reqCount;


              private $userFriends;
              private $userRequest;
              //ENDS HERE//



              public function getPendingRequest()
              {

                    $requestArray=array();

                    $result=mysqli_query($this->newHandler,"SELECT AccId,Request FROM scattr_users_favourites");

                    while ($row = mysqli_fetch_array($result))
                   {
                        $newTmpId=$row['AccId'];

                        $RequestBit=$this->newDBServer->select($this->newHandler,'AccId,Request','scattr_users_favourites','AccId',$newTmpId,'Request');

                        $newRequestArray=explode(',', $RequestBit);

                        if(in_array($this->userId, $newRequestArray))
                        {

                            array_push($requestArray, $newTmpId);

                        }


                   }

                   foreach($requestArray as $newUserRequest)
                   {

                           $userPic=$this->newDBServer->select($this->newHandler,'AccId,Picture','scattr_users','AccId',$newUserRequest,'Picture');

                           $userFname=$this->newDBServer->select($this->newHandler,'AccId,FirstName','scattr_users','AccId',$newUserRequest,'FirstName');

                           $userLname=$this->newDBServer->select($this->newHandler,'AccId,LastName','scattr_users','AccId',$newUserRequest,'LastName');


                          echo' <div class="row">
                                <div class="col-md-12">
                                  <div class="well well-sm">
                                    
                                    <div class="row">
                                      <div class="col-md-2 col-sm-3 col-xs-3">
                                        <img src="'.$userPic.'" class="img-responsive img-thumbnail">
                                      </div>
                                      <div class="col-md-7">
                                          <b>'.ucfirst($userFname).' '.ucfirst($userLname).'</b>            
                                      </div>

                                      <div class="col-md-3 col-sm-3 col-xs-5">
                                        <a class="btn btn-default btn-sm btn-block">Cancel</a>
                                      </div>
                                    </div>

                                  </div>
                                </div>
                              </div>';



                   }

              }

              public function getNotificationCount($newNotification)
              {
                  
                  foreach ($newNotification as $newNotify) {
                    $this->reqCount++;
                  }

                  return $this->reqCount;


              }

              public function startUserSession(){

                //INITIALIZE HERE

                $this->reqCount=0;

                session_start();

                $this->userId=$_SESSION['UID'];

                //CONNECT TO SERVER HERE//


                $this->newDBServer=new DBServer;

                $this->newDBConfig=new dbConfig();

                    
                //GET THE CONNECTION HANDLER//
              

                $this->newHandler=$this->newDBConfig->getConnection();


              }

          public function getUserProfile()
          {
                
                
                //GET ALL USER PROPERTIES//

                $this->userPic=$this->newDBServer->select($this->newHandler,'AccId,Picture','scattr_users','AccId',$this->userId,'Picture');

                $this->userFname=$this->newDBServer->select($this->newHandler,'AccId,FirstName','scattr_users','AccId',$this->userId,'FirstName');

                $this->userLname=$this->newDBServer->select($this->newHandler,'AccId,LastName','scattr_users','AccId',$this->userId,'LastName');

                $this->userFriends=$this->newDBServer->select($this->newHandler,'AccId,Favourites','scattr_users_favourites','AccId',$this->userId,'Favourites');

                $this->userRequest=$this->newDBServer->select($this->newHandler,'AccId,Request','scattr_users_favourites','AccId',$this->userId,'Request');

                $this->userTags=$this->newDBServer->select($this->newHandler,'AccId,Tags','scattr_users_imf','AccId',$this->userId,'Tags');

          }

  //FUNCTION TO GET USER ID FROM THE REQUEST BIT

  public function getUserRequests(){

    if($this->userRequest=="DEF" || empty($this->userRequest))
    {
      
      echo '<div class="container">
            <div class="row">
            <div class="col-md-4">

            </div>
            </div>
            </div>';
      echo '<center><b>No Request Found!!!</b></center>';

    }
    else
    {

        $newRequests=explode(',', $this->userRequest);

        $this->getNotificationCount($newRequests);

        foreach ($newRequests as $request) {
      
        $pic=$this->newDBServer->select($this->newHandler,'AccId,Picture','scattr_users','AccId',$request,'Picture');

        $fname=$this->newDBServer->select($this->newHandler,'AccId,FirstName','scattr_users','AccId',$request,'FirstName');

        $lname=$this->newDBServer->select($this->newHandler,'AccId,LastName','scattr_users','AccId',$request,'LastName');

        //FINALLY DISPLAY THE REQUEST//

        $this->displayRequest($request,$pic,$fname,$lname);


    }


    }
   


    

  }

  public function getUserFavourites()
  {
     
    if($this->userFriends=="DEF" || empty($this->userFriends))
    {
      echo '<b>No Friends!!!</b>';
    }
    else
    {

             $newFavourites=explode(',', $this->userFriends);

             foreach($newFavourites as $favourite)
            {


                $pic=$this->newDBServer->select($this->newHandler,'AccId,Picture','scattr_users','AccId',$favourite,'Picture');

                $fname=$this->newDBServer->select($this->newHandler,'AccId,FirstName','scattr_users','AccId',$favourite,'FirstName');

                $lname=$this->newDBServer->select($this->newHandler,'AccId,LastName','scattr_users','AccId',$favourite,'LastName');


                //FINALLY DISPLAY THE FAVOURITE//

                $this->displayFavourites($pic,$fname,$lname);

            }



    }



  }


  //FUNCTION TO DISPLAY REQUEST//

  public function displayRequest($id,$pic,$fname,$lname){


      echo'<div class="row">
        <div class="col-md-12">
            
            <div class="well well-lg">
                  <div class="row">
                    <div class="col-md-2 col-sm-4 col-xs-3">
                      <img src="'.$pic.'" height="100%" width="100%" class="img-thumbnail">
                    </div>';

                   echo '<div class="col-md-4 col-xs-8 col-sm-5">
                      <b>'.ucfirst($fname).' '.ucfirst($lname).'</b>
                      <p><small>I do what i do</small><p>
                    </div>

                    <div class="col-md-6 col-xs-12 col-sm-2">

                    <div class="row">
                      <div class="col-md-6 col-xs-6"><a href="../resoures/Response?res_type='.$id.'&header=accpt" class="btn btn-success btn-block">Add</a></div>
                      <div class="col-md-6 col-xs-6"><a href="../resoures/Response?res_type='.$id.'&header=decline" class="btn btn-primary btn-block">Decline</a></div>
                    </div>
                      
                    </div>
                  </div>  
            </div>

        </div>
      
      </div>';


  }

  //FUNCTION TO DISPLAY FRIENDS

  public function displayFavourites($pic,$fname,$lname)
  {

        echo'<div class="row">
        <div class="col-md-12">
            
            <div class="well well-lg">
                  <div class="row">
                    <div class="col-md-2 col-sm-4 col-xs-3">
                      <img src="'.$pic.'" height="100%" width="100%" class="img-thumbnail">
                    </div>';

                   echo '<div class="col-md-4 col-xs-8 col-sm-5">
                      <b>'.ucfirst($fname).' '.ucfirst($lname).'</b>
                      <p><small>I do what i do</small><p>
                    </div>

                    <div class="col-md-6 col-xs-12 col-sm-2">

                    <div class="row">
                     <!-- <div class="col-md-6 col-xs-6"><a href="#" class="btn btn-success btn-block">Add</a></div>
                      <div class="col-md-6 col-xs-6"><a href="#" class="btn btn-primary btn-block">Decline</a></div>-->
                    </div>
                      
                    </div>
                  </div>  
            </div>

        </div>
      
      </div>';



  }

  public function renderPageComment($comment,$dp)
  {
      echo '<div class="row">
                    <div class="col-md-12 col-xs-12">
                    <div class="row">
                    <div class="col-md-1 col-xs-2">
                      <img src="'.$dp.'" height="32" width="32" class="img-circle">                
                    </div>

                    <div class="col-md-11 col-xs-10 col-sm-11 overflow-texter">
                    <div class="panel text-justify"><b> '.$comment.'</b>

                    </div>

                    </div>

                    </div>
                    </div>
                    </div>
';



  }

  public function renderComponent($imgname,$owner,$imgid,$comments)
  {

  

echo '
    <div class="row ">

          <div class="col-md-12">
                <div class="well well-sm" style="background:white;">
                    <div class="row">
                      <div class="col-md-1">
                      
                          <img src="https://pbs.twimg.com/profile_images/558109954561679360/j1f9DiJi.jpeg" height="32" width="32" class="img-circle">
                        
                      </div>

                      <div class="col-md-10">
                        <div class="panel" style="padding-top:15px;">
                          <b>Bill Gates</b>&nbsp;<small>a few seconds ago</small>
                        </div>
                        <p></p>
                      </div>
                    </div>
                   
                    <!--<div class="row">
                      <div class="col-md-12 text-justify">
                        <p> <b>W</b>e spend a day at facebook headquarter and it was great please to meet them.. mark zukerberg at the facebook headquartesrs was more suurprising to me and he delievered a speech at the harvard facebook in the san diago</p>
                      </div>
                    </div>
                    <hr/>
                    -->
                    
                    <div class="row">
                          <div class="col-md-12">
                                    <div class="panel">          
                                            <img  src="http://www.straumann.be/etc/designs/straumann/images/loading.gif" alt="" data-echo="../Public/'.$owner.'/photos/'.$imgname.'" width="100%" height="100%">
                                    </div>
                          </div>
                    </div>

                    <div class="row">
                      <div class="col-md-1 col-xs-2">
                        <a class="btn btn-default" href="../resoures/AddHit?page_id= '.$imgid.'"><i class="glyphicon glyphicon-thumbs-up"></i></a>     
                      </div>

                      <div class="col-md-1 col-xs-2">
                      <a class="btn btn-default"><i class="glyphicon glyphicon-share"></i></a>
                      </div>

                      <div class="col-md-6 col-xs-6">

                      <form action="../resoures/Comment?page_ref='.$imgid.'"w method="POST">
                         <div class="input-group">
                            <input type="text" class="form-control" placeholder="Say Something!!" name="cmt" autocomplete="off" data-emojiable="true">
                              <span class="input-group-btn">
                            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-comment" style="visibility:hidden;"></i></button>
                              </span>
                          </div>

                      </form>
                      </div>

                      </div>

                      <hr>';


    //THE COMMENT EXPLORATION GOES HERE 

    if($comments=="DEF" || empty($comments))
    {
      //THIS IS AN EMPTY COMMENT
    }
    else
    {


      $newComments=explode(',', $comments);


                    foreach($newComments as $comment )
  {

    $CommentName=$this->newDBServer->select($this->newHandler,'Cid,Comment','scattr_user_comments','Cid',$comment,'Comment');

    $CommentUploader=$this->newDBServer->select($this->newHandler,'Cid,Commenter','scattr_user_comments','Cid',$comment,'Commenter');


    $CommenterDP= $this->userPic=$this->newDBServer->select($this->newHandler,'AccId,Picture','scattr_users','AccId',$CommentUploader,'Picture');

    $CommenterFirstName=$this->userPic=$this->newDBServer->select($this->newHandler,'AccId,FirstName','scattr_users','AccId',$CommentUploader,'FirstName');

    $CommeterLastName=$this->userPic=$this->newDBServer->select($this->newHandler,'AccId,LastName','scattr_users','AccId',$CommentUploader,'LastName');
    


    //RENDER THE COMMENT HERE//


    
  $this->renderPageComment($CommentName,$CommenterDP);

    

    
  }




    }




      echo'</div>
    </div>
    </div>';

  }

//FUNCTION TO RENDER THE HOME REQUEST
  public function renderHome()
  {



    //THE NEW CODE //

    //LETS GIVE IT A TRY//


        $dlist=new SplDoublyLinkedList();


        $newImages=new SplDoublyLinkedList();

        $list=$this->newDBServer->select($this->newHandler,'Favourites,AccId','scattr_users_favourites','AccId',$this->userId,'Favourites');


        if($list=="DEF"|| empty($list))
        {
          //CODE TO EXCUTE WHEN NO FRIENDS ARE IN USER BASE

          //JUST PRINT THE USER UPLOADED PHOTO LIST



          //WHEN USER HAS NO FRIENDS

            echo '<div class="row">';
            echo '<div class="col-md-12">';
            echo '<div class="alert alert-info alert-dismissable">
            <button type = "button" class = "close" data-dismiss = "alert" aria-hidden = "true">
              &times;
            </button>
            <strong><i class="glyphicon glyphicon-user"></i>   You have not  made any Friends yet!!!</strong></div>';
            echo '</div>';
            echo '</div>';


           //SELECT THE IMG_BASE OF THE USER

          $imgBase=$this->newDBServer->select($this->newHandler,'ImgId,AccId','scattr_user_img_base','AccId',$this->userId,'ImgId');

          if($imgBase=="DEF"|| empty($imgBase))
          {


              //WHEN USERBASE HAS NO IMAGES IN IT
          }
          else
          {
              $arrayed=array();


               //ALSO PUSH THE USER ID 

        array_push($arrayed, $this->userId);

        foreach($arrayed as $array)
        {

          //GET IMAGE ID HERE//

          $img=$this->newDBServer->select($this->newHandler,'ImgId,AccId','scattr_user_img_base','AccId',$array,'ImgId');

          $dlist->push(new Friend($array,$img,"JUNK"));
          
        }


        for($dlist->rewind();$dlist->valid();$dlist->next()){
    

          $images=$dlist->current()->imgid;
          $imgArray=explode(',',$images);


          foreach($imgArray as $img)
          {

            //ALL IMAGE ATTRIB

            $name=$this->newDBServer->select($this->newHandler,'ImgId,ImgName','scattr_img_base','ImgId',$img,'ImgName');

            $owner=$this->newDBServer->select($this->newHandler,'ImgId,Uploader','scattr_img_base','ImgId',$img,'Uploader');

            $hits=$this->newDBServer->select($this->newHandler,'ImgId,Hits','scattr_img_base','ImgId',$img,'Hits');
            $time=$this->newDBServer->select($this->newHandler,'ImgId,Time','scattr_img_base','ImgId',$img,'Time');
            $date=$this->newDBServer->select($this->newHandler,'ImgId,Date','scattr_img_base','ImgId',$img,'Date');


            $comments=$this->newDBServer->select($this->newHandler,'ImgId,Cid','scattr_img_base','ImgId',$img,'Cid');


            $tmpTimeStamp=$date.''.$time;

            $TimeStamp=new DateTime($tmpTimeStamp);


            $newImages->push(new Image($img,$name,$time,$date,$TimeStamp,$owner,$comments));


          }

    }

    //SORT LOGIC GOE SHERE





  //FINALLY RENDER PAGE HERE 

    for($newImages->rewind();$newImages->valid();$newImages->next()){
/*
      echo "<h1>ImgId: ".$newImages->current()->imgid." Time: ".$newImages->current()->time."<h1>";
  */    


      $this->renderComponent($newImages->current()->imgname,$newImages->current()->uploader,$newImages->current()->imgid,$newImages->current()->comment);

    }









          }




          


        }
        else
        {
            //WHEN USER HAS FRIENDS

              $arrayed=explode(',', $list);


        //ALSO PUSH THE USER ID 

        array_push($arrayed, $this->userId);

        foreach($arrayed as $array)
        {

          //GET IMAGE ID HERE//

          $img=$this->newDBServer->select($this->newHandler,'ImgId,AccId','scattr_user_img_base','AccId',$array,'ImgId');

          if($img=="DEF"||empty($img))
          {
            //do NOTHING
          }
          else
          {
              $dlist->push(new Friend($array,$img,"JUNK"));
            
          }
          
        }


        for($dlist->rewind();$dlist->valid();$dlist->next()){
    

          $images=$dlist->current()->imgid;
          $imgArray=explode(',',$images);


          foreach($imgArray as $img)
          {

            //ALL IMAGE ATTRIB

            $name=$this->newDBServer->select($this->newHandler,'ImgId,ImgName','scattr_img_base','ImgId',$img,'ImgName');

            $owner=$this->newDBServer->select($this->newHandler,'ImgId,Uploader','scattr_img_base','ImgId',$img,'Uploader');

            $hits=$this->newDBServer->select($this->newHandler,'ImgId,Hits','scattr_img_base','ImgId',$img,'Hits');
            $time=$this->newDBServer->select($this->newHandler,'ImgId,Time','scattr_img_base','ImgId',$img,'Time');
            $date=$this->newDBServer->select($this->newHandler,'ImgId,Date','scattr_img_base','ImgId',$img,'Date');

            $comments=$this->newDBServer->select($this->newHandler,'ImgId,Cid','scattr_img_base','ImgId',$img,'Cid');

            $tmpTimeStamp=$date.''.$time;

            $TimeStamp=new DateTime($tmpTimeStamp);


            $newImages->push(new Image($img,$name,$time,$date,$TimeStamp,$owner,$comments));


          }

    }

    //SORT LOGIC GOE SHERE


  //FINALLY RENDER PAGE HERE 

    for($newImages->rewind();$newImages->valid();$newImages->next()){

/*
      echo "<h1>ImgId: ".$newImages->current()->imgid." Time: ".$newImages->current()->time."<h1>";
  */    
      $this->renderComponent($newImages->current()->imgname,$newImages->current()->uploader,$newImages->current()->imgid,$newImages->current()->comment);

    }









        }






        















































































































































































































//WORST CODE I EVER WROTE

//NEEDS OPTIMIZATION AND LAZZY LOADING//

    //WILL COME BAACK ON IT


        //FINALLY APPROVED//

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

    





                            //RENDER THE IMAGE HERE//

/*


                                          echo'<div class="row ">
                            

                          <div class="col-md-12">
                            <div class="well well-sm" style="background-color: white;">
                              <div class="row">
                                            <div class="col-md-12">
                                                      <div class="panel">          
                                                              <a href="#" data-toggle="modal" data-target="#myPictureModal"><img src="../Public/'.$value->ImgOwn.'/photos/'.$value->ImgName.'" width="100%" height="100%"></a>
                                                      </div>
                                            </div>
                                      </div>

                          <div class="row">
                            <div class="col-md-12">
                                <div class="well" style="background:white;">
                                
                                      <div class="row">
                        
                                            <div class="col-md-5 col-xs-5">
                                                                                                    
                                      <div class="input-group">
                                      <input type="text" class="form-control" placeholder="Caption" name="q">
                                      <div class="input-group-btn">
                                      <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-comment"></i></button>
                                      </div>
                                      </div>

                                            </div>


                                            <div class="col-md-1">               
                                                <div class="dropdown">
                                                <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Privacy
                                                <span class="caret"></span></button>
                                                <ul class="dropdown-menu">
                                                <li><a href="#">Public</a></li>
                                                <li><a href="#">Private</a></li>
                                                
                                                </ul>
                                            </div>

                                            </div>


                                            <div class="col-md-3 col-md-offset-2  col-xs-1 col-sm-1">
                                                    <input type="button" class="btn btn-primary btn-block" value="upload" >
                                            </div>

                                      </div>

                                </div>
                              
                            </div>
                          </div>  


                            </div>
                          </div>
                    
                          </div>';


*/

}

}

//MAIN BEGINS


// tell the browser we're going to be using Unicode characters
header('Content-type text/html; charset=UTF-8');

$newHome=new Home;

$newHome->startUserSession();

$newHome->getUserProfile();

?>

<!DOCTYPE html>
<html lang="en">
    <head>
    <style type="text/css">
      body{
        background-color: whitesmoke;
      }
      .file {
  visibility: hidden;
  position: absolute;
}

#hearts { color: #FF0000;cursor: pointer;}
#hearts-existing { color: #87bad7;}


.txt-format{
font-size: 80%;
}


.overflow-texter {
   -moz-hyphens:auto;
   -ms-hyphens:auto;
   -webkit-hyphens:auto;
   hyphens:auto;
   word-wrap:break-word;
}


    </style>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <link rel="stylesheet" href="css/footer.css">
    <!-- Latest compiled and minified CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">


    <!-- Begin emoji-picker Stylesheets -->
    <link href="../css/emoji.css" rel="stylesheet">

    <!--J127689-->


    <title>Homepage Page</title>

    </head>

    <body style="background-color: whitesmoke;">





      <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
      
<script type="text/javascript" src="../scripts/echo.js"></script>


 <!-- Begin emoji-picker JavaScript -->
    <script src="../scripts/config.js"></script>
    <script src="../scripts/util.js"></script>
    <script src="../scripts/jquery.emojiarea.js"></script>
    <script src="../scripts/emoji-picker.js"></script>
    <!-- End emoji-picker JavaScript -->


<script>
    echo.init({
      offset: 100,
      throttle: 250,
      unload: false,
      callback: function (element, op) {
        console.log(element, 'has been', op + 'ed')
      }
    });
    </script>
    

 <script>
      $(function() {
        // Initializes and creates emoji set from sprite sheet
        window.emojiPicker = new EmojiPicker({
          emojiable_selector: '[data-emojiable=true]',
          assetsPath: '../img/',
          popupButtonClasses: 'fa fa-smile-o'
        });
        // Finds all elements with `emojiable_selector` and converts them to rich emoji input fields
        // You may want to delay this step if you have dynamically created input fields that appear later in the loading process
        // It can be called as many times as necessary; previously converted input fields will not be converted again
        window.emojiPicker.discover();
      });
    </script>






<script>

var __slice = [].slice;

(function($, window) {
  var Starrr;

  Starrr = (function() {
    Starrr.prototype.defaults = {
      rating: void 0,
      numStars: 5,
      change: function(e, value) {}
    };

    function Starrr($el, options) {
      var i, _, _ref,
        _this = this;

      this.options = $.extend({}, this.defaults, options);
      this.$el = $el;
      _ref = this.defaults;
      for (i in _ref) {
        _ = _ref[i];
        if (this.$el.data(i) != null) {
          this.options[i] = this.$el.data(i);
        }
      }
      this.createStars();
      this.syncRating();
      this.$el.on('mouseover.starrr', 'span', function(e) {
        return _this.syncRating(_this.$el.find('span').index(e.currentTarget) + 1);
      });
      this.$el.on('mouseout.starrr', function() {
        return _this.syncRating();
      });
      this.$el.on('click.starrr', 'span', function(e) {
        return _this.setRating(_this.$el.find('span').index(e.currentTarget) + 1);
      });
      this.$el.on('starrr:change', this.options.change);
    }

    Starrr.prototype.createStars = function() {
      var _i, _ref, _results;

      _results = [];
      for (_i = 1, _ref = this.options.numStars; 1 <= _ref ? _i <= _ref : _i >= _ref; 1 <= _ref ? _i++ : _i--) {
        _results.push(this.$el.append("<span class='glyphicon .glyphicon-heart-empty'></span>"));
      }
      return _results;
    };

    Starrr.prototype.setRating = function(rating) {
      if (this.options.rating === rating) {
        rating = void 0;
      }
      this.options.rating = rating;
      this.syncRating();
      return this.$el.trigger('starrr:change', rating);
    };

    Starrr.prototype.syncRating = function(rating) {
      var i, _i, _j, _ref;

      rating || (rating = this.options.rating);
      if (rating) {
        for (i = _i = 0, _ref = rating - 1; 0 <= _ref ? _i <= _ref : _i >= _ref; i = 0 <= _ref ? ++_i : --_i) {
          this.$el.find('span').eq(i).removeClass('glyphicon-heart-empty').addClass('glyphicon-heart');
        }
      }
      if (rating && rating < 5) {
        for (i = _j = rating; rating <= 4 ? _j <= 4 : _j >= 4; i = rating <= 4 ? ++_j : --_j) {
          this.$el.find('span').eq(i).removeClass('glyphicon-heart').addClass('glyphicon-heart-empty');
        }
      }
      if (!rating) {
        return this.$el.find('span').removeClass('glyphicon-heart').addClass('glyphicon-heart-empty');
      }
    };

    return Starrr;

  })();
  return $.fn.extend({
    starrr: function() {
      var args, option;

      option = arguments[0], args = 2 <= arguments.length ? __slice.call(arguments, 1) : [];
      return this.each(function() {
        var data;

        data = $(this).data('star-rating');
        if (!data) {
          $(this).data('star-rating', (data = new Starrr($(this), option)));
        }
        if (typeof option === 'string') {
          return data[option].apply(data, args);
        }
      });
    }
  });
})(window.jQuery, window);

$(function() {
  return $(".starrr").starrr();
});

$( document ).ready(function() {

  $('#hearts').on('starrr:change', function(e, value){
    $('#count').html(value);
  });

  $('#hearts-existing').on('starrr:change', function(e, value){
    $('#count-existing').html(value);

  });
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.2/bootstrap3-typeahead.min.js"></script>  

<!--NAV BAR -->

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="#">Mocial</a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        
        <div class="col-sm-3 col-md-3 col-md-offset-1 ">
            <form class="navbar-form" role="search" action="../Search/search" method="GET" autocomplete="off">
                <div class="input-group">
                    <input type="text" class=" form-control" placeholder="Search" name="country" id="users">
                    <div class="input-group-btn">
                        <button class="btn btn-success" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                    </div>
                </div>
            </form>
        </div>        
    </div>
</nav>
<!-- ENDS HERE -->



<script>
$(document).ready(function(){
  $('#users').typeahead({

    source: function(query, result){
      $.ajax({
        url:"Suggest.php",
        method:"POST",
        data:{query:query},
        dataType:"json",
        success:function(data){
          result($.map(data, function(item){
            return item;
          }));
        }
      });
    }
  });
  
});
</script>


<script type="text/javascript">



  
</script>
  <br><br><br><br>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-2">
            <div class="well well-sm" style="background:white;">
                <div class="row">
                    <div class="col-md-12">
                        <div class="well well-sm">
                            <img src="<?php   echo $newHome->userPic;  ?>" width="100%" height="100%"> 
                        </div>
                    </div>  
                </div>

            <div class="row">
                <div class="col-md-12">
                    <div class="panel text-center">
                        <b><?php   echo ucfirst($newHome->userFname); echo '   ';     echo ucfirst($newHome->userLname); ?></b>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table type="hidden" class="table">
                        <tr>
                            <td><a href="#" class="btn btn-default btn-block">My Profile</a></td>
                        </tr>
                  
                        <tr>
                            <td><a href="#" class="btn btn-default btn-block" data-toggle="modal" data-target="#myModalFavourite">My Favourites</a></td>
                        </tr>
                        
                        <tr>
                            <td><a href="#" class="btn btn-default btn-block" data-toggle="modal" data-target="#myModalRequest">My Request's&nbsp;<?php     

                            if($newHome->reqCount==0)
                            {
                              //DO NOTHING
                            }
                            else
                            {
                              echo "Hello";
                              echo '<span class="badge">'.$newHome->reqCount.'</span>';
                            }

                            ?></a></td>
                        </tr>
                  
                        <tr>
                            <td><a  class="btn btn-default btn-block" data-toggle="modal" data-target="#myModalSettings">Settings</a></td>
                        </tr>

                        <tr>
                            <td><a href="#" class="btn btn-default btn-block" data-toggle="modal" data-target="#myModalLogout">Logout</a></td>
                        </tr>

                    </table>
                </div>
            </div>
       </div>

    </div>

    <div class="col-md-5">
        <div class="row">
            <div class="col-md-12">
                <div class="well well-lg" style="background:white;">
        

        <center><b>Whats your today's post??</b></center>

        <br>
<!--UPLOADER HERE-->

<div class="form-group">

<form action="../resoures/Process" method="POST" enctype="multipart/form-data">
  
<div class="form-group">

    <input type="file" name="myfile" class="file">
    <div class="input-group col-xs-12">
      <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
      <input type="text" class="form-control input-md" disabled placeholder="Upload Image">
      <span class="input-group-btn">
        <button class="browse btn btn-success input-md" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
      </span>
    </div>
  </div>

  <div class="form-group">
      <input type="submit" value="Post" class="btn btn-primary" name="myupload">
    </div>
</form>

  </div>

                </div>
            </div>
        </div>


        <!-- IMG CONTAINER -->

       <?php

$newHome->renderHome();

        ?>



<!--RENDERING HOME STARTS HERE -->


    






<!--SAMPLE TEMPLATE FOR A IMAGE CARD-->

<!--
    <div class="row ">

          <div class="col-md-12">
                <div class="well well-sm" style="background:white;">
                    <div class="row">
                      <div class="col-md-2">
                      
                          <img src="https://res.cloudinary.com/crunchbase-production/image/upload/v1448830269/gzcifut4c2xah95x0ewd.jpg" class="img-responsive img-circle img-thumbnail">
                        
                      </div>

                      <div class="col-md-10">
                        <div class="panel" style="padding-top:15px;">
                          <b>Mark Zukerberg</b>&nbsp;<small>a few seconds ago</small>
                        </div>
                        <p></p>
                      </div>
                    </div>
                   
                    <div class="row">
                      <div class="col-md-12 text-justify">
                        <p> <b>W</b>e spend a day at facebook headquarter and it was great please to meet them.. mark zukerberg at the facebook headquartesrs was more suurprising to me and he delievered a speech at the harvard facebook in the san diago</p>
                      </div>
                    </div>
                    <hr/>
                    <div class="row">
                          <div class="col-md-12">
                                    <div class="panel">          
                                            <img src="https://fbnewsroomus.files.wordpress.com/2015/05/gensler_facebook_0994.jpg?w=960" width="100%" height="100%">
                                    </div>
                          </div>
                    </div>




                    <div class="row">
                      <div class="col-md-2">
                        <a href="#" class="btn btn-default"><i class="glyphicon glyphicon-thumbs-up"></i></a>
                      </div>
                    </div>




<!--

    <div class="row">
          <div class="col-md-12">
              <div class="well well-sm" style="background:white;">
              
                    <div class="row">
        
                          <div class="col-md-1 col-xs-1 col-sm-1">
                                  <i class="fa fa-share fa-2x" aria-hidden="true"></i>
                          </div>

                          <div class="col-md-7 col-xs-8">
                                <form class="form-group">
                                        <input type="text" class="form-control" placeholder="Comment">
                                </form>
                          </div>


                          <div class="col-md-3">
                                        <input type="button" class="btn btn-default btn-block" value="Post">
                          </div>

                    </div>

              </div>
            
          </div>
        </div> 

        -->       


<!--
      </div>
    </div>
    </div>
-->

  
























<!--RENDERING HOME ENDS HERE -->







    </div>
    

<div class="col-md-3">
  

<div class="row">
<!-- COLUMN SIDE !-->
  <div class="col-md-12 well well-sm" style="background: white;">
    
  <!--STARTS HERE -->
      
     <!-- Nav tabs --><div class="card">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#home" aria-controls="home" role="tab" data-toggle="tab">News</a></li>
                                        <li role="presentation"><a href="#messages" aria-controls="messages" role="tab" data-toggle="tab">Trending</a></li>
                                    
                                    </ul>

<br>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="home">
                                        



                                          <div class="row">
  <div class="col-md-12">
    <div class="panel text-justify">
     <blockquote>Rahul posted a video.</blockquote>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel">
      i just waited for the moment and that totally shook me downmi just waited for the moment and that totally shook me downmi just waited for the moment and that totally shook me downmi just waited for the moment and that totally shook me downm
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel">
      for the moment and that totally shook me downmi just waited for the moment and that totally shook me downmi just waited for the moment 
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel">
     new 1
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel">
      Panel here
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="panel">
      Panel here
    </div>
  </div>
</div>



<!--


                                            <form class="form-horizontal" action="/action_page.php">

    <div class="form-group">
      <label class="control-label col-sm-3" for="pwd">Name </label>
      <div class="col-sm-7">          
        <input type="text" class="form-control" id="email" placeholder="Team Name" name="email">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-3" for="pwd">Description </label>
      <div class="col-sm-7">          
        <input type="text" class="form-control" id="email" placeholder="Team description" name="email">
      </div>
    </div>
    <div class="form-group">
    <label class="control-label col-sm-3" for="pwd">Team Icon </label>
    <input type="file" name="img[]" class="file">
    <div class="input-group col-xs-12 col-md-5 col-md-offset-4 ">
      <span class="input-group-addon"><i class="glyphicon glyphicon-picture"></i></span>
      <input type="text" class="form-control input-md" disabled placeholder="Upload">
      <span class="input-group-btn">
        <button class="browse btn btn-success input-md" type="button"><i class="glyphicon glyphicon-search"></i> Browse</button>
      </span>
    </div>
  </div>
    <br>
    <div class="form-group">        
      <div class="col-sm-offset-5 col-sm-10">
        <button type="submit" class="btn btn-primary">Post</button>
      </div>
    </div>
  </form>

-->
                                        </div>



                                        <div role="tabpanel" class="tab-pane" id="messages">
                                            

<form class="form-horizontal" action="/action_page.php">

    <div class="form-group">
      <label class="control-label col-sm-4" for="pwd">Keep Public: </label>
      <div class="col-sm-7">          
        <input type="checkbox" checked data-toggle="toggle">
      </div>
    </div>
    <div class="form-group">
      <label class="control-label col-sm-4" for="pwd">Allow users to Join: </label>
      <div class="col-sm-7">          
        <input type="checkbox" checked data-toggle="toggle">
      </div>
    </div>
    
    </form>

                                        </div>
                                        
                                  </div>
                                  
                                </div>
                                <!--ENDS HERE -->
  </div>

<div class="row">
  <div class="col-md-12" >

  <div class="well well-sm" style="background: white;">
    <div class="row">
      <div class="col-md-12">
        <div class="well well-sm text-center"><b>Suggested Friends</b></div>
      </div>
    </div>

 <?php

 $newSuggester=new SuggestFriends;

 $newSuggester->displaySuggested($newHome->userTags);

 ?>


<div class="row">
    <div class="col-md-12">
      <a class="btn btn-default btn-block text-center"><b>see more..<b></a>
    </div>
  </div>



  </div>


    
  </div>
</div>


</div>
  
</div>


<div class="col-md-2">

<div class="row">
  <div class="col-md-12">
    <div class="well well-lg text-center">
  <b>Ads here</b>

  </div>
      
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="well well-lg text-center">
  <b>Ads here </b>

  </div>
     
  </div>
</div>

<div class="row">
  <div class="col-md-12">
    <div class="well well-sm">
      <table class="table" type="hidden">

        <tr>
          <div class="well well-sm text-center" >
                  
          </div>
        </tr>

        <tr>
          <td>
            <a href="#" class="btn btn-default btn-block"></a>
          </td>
        </tr>

        <tr>
          <td>
            <a href="#" class="btn btn-default btn-block"></a>
          </td>
        </tr>

        <tr>
       <td>
            <a href="#" class="btn btn-default btn-block"></a>
          </td>
        </tr>

      </table>
    </div>
  </div>
</div>

</div>

  </div>
</div>

<!--best sie-->


<script type="text/javascript">
  $(document).on('click', '.browse', function(){
  var file = $(this).parent().parent().parent().find('.file');
  file.trigger('click');
});
$(document).on('change', '.file', function(){
  $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
});
</script>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

   
<!-- Modal REQUEST -->
<div id="myModalRequest" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"><b>Favourite Request's</b></h4>
      </div>


      <div class="modal-body">



        <!--STARTS HERE -->
      
     <!-- Nav tabs --><div class="card">
                                    <ul class="nav nav-tabs" role="tablist">
                                        <li role="presentation" class="active"><a href="#request" aria-controls="home" role="tab" data-toggle="tab">Favourite Request's</a></li>
                                        <li role="presentation"><a href="#pending" aria-controls="messages" role="tab" data-toggle="tab">Pending Request's</a></li>
                                    
                                    </ul>

<br>
                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <div role="tabpanel" class="tab-pane active" id="request">
                                        
               

                                          <?php


                                          $newHome->getUserRequests();



                                          
                                          ?>


                                        </div>
                                        <div role="tabpanel" class="tab-pane" id="pending">

                                          <?php


                                          $newHome->getPendingRequest();



                                          
                                          ?>


                                        </div>
                                        
                                  </div>
                                </div>
                                <!--ENDS HERE -->


     
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal UPLOAD -->
<div id="myModalUpload" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"><b>Upload</b></h4>
      </div>


      <div class="modal-body">

  <!--THESE FOR THE FAVOURITE-->        
  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!-- ends here -->



<!--THE PICTURE BOX-->

  <div id="myPictureModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>


      <div class="modal-body">

  <!--THESE FOR THE PICTURE BOX-->        

<?php





?>



  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>











<!-- ENDS HRE-->






















<!-- Modal Favourite -->
<div id="myModalFavourite" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"><b>Favourite List</b></h4>
      </div>


      <div class="modal-body">

  <!--THESE FOR THE FAVOURITE-->        
  <?php

  $newHome->getUserFavourites();

      
  ?>
  
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>



<!-- Modal Settings -->
<div id="myModalSettings" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title text-center"><b>Settings</b></h4>
      </div>


      <div class="modal-body">

  <!--SETTINGS GOES HERE-->
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<!--END OF SETTINGS-->

<!-- LOGOUT DIALOG -->

<div id="myModalLogout" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-body">

      <div class="row">
        <div class="col-md-12 text-center">
          <b><big>Do you really want to logout????</big></b>
        </div>
      </div>

      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<!-- ENDS HERE-->

  </body>
</html>

