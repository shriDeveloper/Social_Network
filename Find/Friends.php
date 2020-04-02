<?php

//A CLASS FOR THE FRIENDS//

//INCLUSION HERE//

include('../resoures/DBServer.php');

include('../config/dbconfig.php');

include('../utils/System.php');

class InvalidSearchQueryException extends Exception{

	public function throwInvalidSearchQueryException($search)
	{
		if(isset($search))
		{
			//do nothing//
		}
		else
		{
			throw new InvalidSearchQueryException("Please specify the search Query!!");
		}
	}
}
class SessionException extends Exception{

	public function thorwInvalidSessionException($sessid){
		if(isset($sessid))
		{
			//do nothing
		}
		else
		{
			throw new SessionException("Invalid Login Detected!!!");
		}
	}
}
class Friends{

	private $search_query;

	private $accid;

	private $city;

	private $college;


	public function getQueryString(){

		session_start();

		$this->accid=$_SESSION['UID'];

	}

	public function getPageHeaders()
	{
		if(isset($_POST['btn_ser']))
		{
			$this->search_query=$_REQUEST['search_bar'];

			$this->searchFriend();
		}
		else
		{
			
			//CODE To PUMP WHEN THE FRIENDS ARE SEARCHED BY THE LOCATION

			$this->suggestFriendsByLocation();





		}

	}



	public function suggestFriendsByLocation()
	{
		

		$userArray=array();
		

		//CONNECT THE SERVER HERE


    	$newDBServer=new DBServer;

   		$newDBConfig=new dbConfig();

    	//GET THE CONNECTION HANDLER//
    	$newHandler=$newDBConfig->getConnection();

    	$newSystem=new System;


    	//GET THE CITY AND LOCATION DETAILS HERE

    	$this->city=$newDBServer->select($newHandler,'City,AccId','scattr_users_imf','AccId',$this->accid,'City');

    	
    	$this->college=$newDBServer->select($newHandler,'College,AccId','scattr_users_imf','AccId',$this->accid,'College');



    	//ENDS HERE


		 $result=mysqli_query($newHandler,"SELECT * FROM scattr_users_imf");
 		 while ($row = mysqli_fetch_array($result))
         {
				if($this->city==$row['City'] && $this->college==$row['College'])
				{

					$id=$row['AccId'];

					array_push($userArray, $id);


				}
		 }

		 //THE USERARRAY WILL CONSIST OF THE USERS BY LOCATION
		
		 $construct = "SELECT FirstName,LastName,Picture,AccId FROM scattr_users";
                    $run = mysqli_query($newHandler,$construct);


                     while( $runrows = mysqli_fetch_assoc($run) ) {
                                  
                                  
                                  $id=$runrows['AccId'];


                                  //HERES WHAT I DO 'REQUESTED' BUTTON


                                  $request=$newDBServer->select($newHandler,'Request,AccId','scattr_users_favourites','AccId',$id,'Request');

                                  $newFlag=$newSystem->filterArray($request,$this->accid);


                                  foreach($userArray as $user)
                                  {
                                  	if($id==$user)
                                  	{

                                  		$fname = ucfirst($runrows ['FirstName']);
                                  		$lname = ucfirst($runrows ['LastName']);
                                  		$pic=	$runrows['Picture'];


                                  		 //PRINTING GOES HERE


                                  $this->displayUserPageResult($fname,$lname,$pic,$id,$newFlag);


                                  	}
                                  

                                  }


          

                           }





	}

	public function searchFriend(){

		//SEARCH ALGORITHM GOES HERE

		//JUST A SYSTEM OBJECT HERE

		$newSystem=new System;



		//CONNECT THE SERVER HERE


    	$newDBServer=new DBServer;

   		$newDBConfig=new dbConfig();

    	//GET THE CONNECTION HANDLER//
    	$newHandler=$newDBConfig->getConnection();


    	//FILTER

    	$this->search_query = mysql_real_escape_string($this->search_query);
    	
		$search_exploded=explode(" ",$this->search_query);


		$x=0;

		foreach( $search_exploded as $search_each ) {
                           
                           $x++;

                           $construct = "";
                           if( $x == 1 )
                                  $construct .="FirstName LIKE '%$search_each%' OR LastName LIKE '%$search_each%'";
                           else
                                  $construct .="AND FirstName LIKE '%$search_each%' OR LastName LIKE '%$search_each%'";
                    }


                    $construct = "SELECT FirstName,LastName,Picture,AccId FROM scattr_users WHERE $construct";
                    $run = mysqli_query($newHandler,$construct);
 
                    $foundnum = mysqli_num_rows($run);

                    if ($foundnum == 0)
                           echo "<b><center>Sorry Nothing Found!!!<center></b>"; 
                    else {
                          // echo "$foundnum results found !<p>";
 

                           while( $runrows = mysqli_fetch_assoc($run) ) {
                                  
                                  $fname = ucfirst($runrows ['FirstName']);
                                  $lname = ucfirst($runrows ['LastName']);
                                  $pic=	$runrows['Picture'];
                                  $id=$runrows['AccId'];



                                  //LOOK FOR THE TAGS IN IMF TABLE/


                                 $userTags=$newDBServer->select($newHandler,'Tags,AccId','scattr_users_imf','AccId',$id,'Tags');




                                  //HERES WHAT I DO 'REQUESTED' BUTTON


                                  $request=$newDBServer->select($newHandler,'Request,AccId','scattr_users_favourites','AccId',$id,'Request');

                                  $newFlag=$newSystem->filterArray($request,$this->accid);


                                  //PRINTING GOES HERE


                                  $this->displayUserPageResult($fname,$lname,$pic,$id,$newFlag);

          

                           }




		}

			
		
	}


	public function displayUserPageResult($fname,$lname,$pic,$id,$newFlag)
	{


                       			echo '<div class="well well-lg" style="background:white;" >';
								echo '<div class="row">';
								echo '<div class="col-md-1">';
								echo '<img class="img-circle" src="'.$pic.'" height="50" width="50">';		
								echo '</div>';
								echo '<div class="col-md-4 col-md-offset-1">';
								echo '<h4>
<a href="../Profile?src='.$id.'" data-toggle="popover" title="Popover Header" data-content="Some content inside the popover">
<b>'.$fname.'</b>&nbsp;<b>'.$lname.'</b></a></h4>';
								echo '</div>';
								echo '<div class="col-md-5 col-md-offset-1" >';
								if($this->accid==$id)
								{
									echo '<a href="#"  class="btn btn-info btn-block">MyProfile</a>';	
								}
								else
								{
									if($newFlag==1)
									{
										//IF ENTRY EXISTS
										
										echo '<div class="col-md-6">';
										echo '<a href="#"  class="btn btn-default btn-block">Requested</a>';
										echo '</div>';
										echo'<div class="col-md-6">';
										echo '<a href="../resoures/RemFav?fri='.$id.'" class="btn btn-default btn-block">Cancel</a>';
										echo '</div>';
										
									}
									else
									{
										//IF ENTRY DOESNT EXIST
										echo '<a href="../resoures/AddFav?fri='.$id.'" class="btn btn-primary btn-block">Add</a>';
									}
								
								}
								echo '</div>';
								echo'</div>';
								echo '</div>'; 


	}


}



?>


<!DOCTYPE html>
<html lang="en">
  <head>
  <style type="text/css">

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

    <title>Search for Friends!!!</title>

  </head>

  <body>
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

</nav>
<!-- ENDS HERE -->

<!--best sie-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<br><br><br><br>
<div class="container">
	<div class="row">
		<div class="col-md-12">
			<div class="well well-sm" style="background:white;">
				<h4><center><b>Add them to Your Favourites!!</b></center></h4>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
</script>
<div class="container">
	<div class="row">
		<div class="col-md-8">
			
		
					<?php

					$newFriend = new Friends;

					$newFriend->getQueryString();

					$newFriend->getPageHeaders();


					//$newFriend->searchFriend();


				?>
				

				
		</div>


	<div class="col-md-4">
		
<div class="row">
<div class="col-md-12 well well-sm">
		
			<form action="<?php  echo $_SERVER['PHP_SELF'];  ?>" method="POST">
				<div class="form-group">
					<label for="Search" >Search</label>
					<input type="text" name="search_bar" class="form-control" placeholder="Search for Friends">
				</div>
				<input type="submit" value="Search" class="btn btn-primary btn-block" name="btn_ser">
			</form>
		
		</div>
	</div>

	<div class="row">
		<div class="col-md-12 well">
			<div class="row">
				<div class="col-md-4">
					
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<a href="../Home/home" class="btn btn-block btn-lg btn-warning">Go to Profile!</a>
				</div>
			</div>
		</div>
	</div>

	</div>

	
	</div>
</div>


<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

 <!-- A PROFILE CARD 
<div class="container">
	<div class="row">
		<div class="col-md-8 well">
		<div class="row">
			<div class="col-md-12 panel">
				<img src="http://sdcrush.com/themes/sexymetro/img/no_user.jpg" class="img-responsive" >
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<blockquote><b>Shriniket Deshmukh<b></blockquote>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<input type="button" value="Add" class="btn btn-block btn-success btn-lg">
			</div>
		</div>
		</div>
	</div>
</div>
-->


  </body>
</html>


















