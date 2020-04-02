<?php

//INITIALIZE THE DBSERVER HERE */

include('../resoures/DBServer.php');

include('../config/dbconfig.php');

include('../utils/encrypter.php');

include('../utils/System.php');

class fbPage{

  public $firstName;
  public $lastName;
  public $email;
  public $password;

  public $accid;

  public function getPassword()
  {
    $this->password=$_POST['password'];
    
  }


  public function loadBodyPage()
  {

      if(@$_POST['confirm'])
      {
          

        $this->getPassword();

        $newSystem=new System;    

        $default_picture="http://sdcrush.com/themes/sexymetro/img/no_user.jpg";


        //GENERATE ID HERE //

        $this->accid=$newSystem->generateID();


        //GENERATE A UPIC ID FOR ONLY ONE PROFILE IMAGE

        $newEncrypter=new Encrypter;

        $upic=$newEncrypter->generate();


        //ALSO GENERATE A UPIC ID AS SESSION

        $_SESSION['UPIC']=$upic;

        //GENERATE A USER SESSION ID //


        $_SESSION['UID']=$this->accid;



        //CREATE CONTAINERS HERE MAINLY FOLDERS//

        $newSystem->createAccount($this->accid);


        $newDBServer=new DBServer;

        $newDBConfig=new dbConfig();

        //GET THE CONNECTION HANDLER//
        $newHandler=$newDBConfig->getConnection();


        $newDBServer->insert($newHandler,$this->accid,$this->firstName,$this->lastName,$this->getEmail(),$this->password,$default_picture,$upic);

        $newDBServer->insertImf($newHandler,$this->accid,'DEF','DEF','DEF');


        $newDBServer->insertFavourite($newHandler,$this->accid,'DEF','DEF');


        $newDBServer->insertImgBase($newHandler,$this->accid,'DEF');  
  
        //REDIRECT TO SETUP PAGE//

        header('Location:../Setup/setup.php');

      }
      else
      {
        echo "NO confirm Request!!";
      }

  }

  public function getName()
  {
          $fullName=$_SESSION['name'];

          $newNames=explode(' ', $fullName);

          $this->firstName=$newNames[0];
          $this->lastName=$newNames[1];
  } 

  public function getEmail(){

    $this->email=$_SESSION['email'];

    return $this->email;
  }

}


session_start();

//MAIN BEGINS HERE

$newFbPage =new fbPage;

$newFbPage->getName();

$newFbPage->getPassword();

$newFbPage->loadBodyPage();

?>

<!DOCTYPE html>
<html lang="en">
  <head>
  <style type="text/css">
  
    body{
background-color: whitesmoke;
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

<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css" rel="stylesheet">

    <title>Verify Page</title>

  </head>

  <body>
  <?php  

  include("../utils/header.php");

   ?>  

<!--best sie-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<br><br><br><br><br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="well well-lg" style="background:white;">
      <div class="row">
        <div class="col-md-4">
          <h4><b>Facebook Account Details:</b></h4>
        </div>
      </div>
			</div>
		</div>
	</div>
</div>

<div class="container">
	<div class="jumbotron" style="background-color: whitesmoke">
		<form action="<?php $PHP_SELF ?>" method="POST">
    <div class="row">
			<div class="col-md-10 col-md-offset-1">
				 <div class="row">
    
    
       <div class="col-md-6">
       <label for="fname" class="control-label"><b>FirstName:</b></label>
       <input type="text" class="form-control" disabled id="fname" value="<?php echo $newFbPage->firstName;  ?>">  
       </div>


       
       <div class="col-md-6">
         <label for="lname" class="control-label"><b>LastName:</b></label>
       <input type="text" class="form-control" disabled id="lname" value="<?php echo $newFbPage->lastName;  ?>">
       </div>

      
         </div>

      <br>
         <div class="row">
           <div class="col-md-12">
         <label for="email" class="control-label"><b>Email:</b></label>
       <input type="text" class="form-control" disabled id="email" value="<?php  echo $newFbPage->getEmail(); ?>">
       </div>

         </div>
      <br>
         <div class="row">
           <div class="col-md-12">
         <label for="pass" class="control-label"><b>Choose Password</b></label>
       <input type="text" class="form-control"  id="pass" name="password">
       </div>

         </div>
<br>

         <div class="row">
           <div class="col-md-12">
         <input type="submit" class="btn btn-lg btn-primary btn-block" value="Confirm Account" name="confirm">
       </div>

         </div>

        
			</div>
		</div>
    </form>
	</div>
</div>  

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  </body>
</html>

