<?php

//A CLASS FOR THE HOMEPAGE

class HomePage{


  public $loginUrl;

  //THESE FUNCTION LOADS API
  public function loadAPI(){

        session_start();
        require_once __DIR__ . '/Facebook/autoload.php';

        $fb = new \Facebook\Facebook([
        'app_id' => '244700449366526',
        'app_secret' => '8bb6230e78d8acefec6b4eff46b76ee3',
        'default_graph_version' => 'v2.9',
        ]);

        $permissions = []; // optional
        $helper = $fb->getRedirectLoginHelper();
        $accessToken = $helper->getAccessToken();


        
        if (isset($accessToken)) {
    
    //FUCK CODE IS HERE
        
/*
          if (isset($_SESSION['facebook_access_token'])) {
    $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
  } else {
    $_SESSION['facebook_access_token'] = (string) $accessToken;
      // OAuth 2.0 client handler
    $oAuth2Client = $fb->getOAuth2Client();
    // Exchanges a short-lived access token for a long-lived one
    $longLivedAccessToken = $oAuth2Client->getLongLivedAccessToken($_SESSION['facebook_access_token']);
    $_SESSION['facebook_access_token'] = (string) $longLivedAccessToken;
    $fb->setDefaultAccessToken($_SESSION['facebook_access_token']);
  }


    // validating the access token
  try {
    $request = $fb->get('/me');
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    if ($e->getCode() == 190) {
      unset($_SESSION['facebook_access_token']);
      $helper = $fb->getRedirectLoginHelper();
      $loginUrl = $helper->getLoginUrl('https://apps.facebook.com/APP_NAMESPACE/', $permissions);
      echo "<script>window.top.location.href='".$loginUrl."'</script>";
      exit;
    }
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }


  // getting basic info about user
  try {
    $profile_request = $fb->get('/me?fields=name,first_name,last_name,birthday,website,location');
    $profile = $profile_request->getGraphNode()->asArray();
  } catch(Facebook\Exceptions\FacebookResponseException $e) {
    // When Graph returns an error
    echo 'Graph returned an error: ' . $e->getMessage();
    session_destroy();
    // redirecting user back to app login page
    header("Location: ./");
    exit;
  } catch(Facebook\Exceptions\FacebookSDKException $e) {
    // When validation fails or other local issues
    echo 'Facebook SDK returned an error: ' . $e->getMessage();
    exit;
  }
  
  // printing $profile array on the screen which holds the basic info about user
  echo $profile['email'];
  



*/



        $url = "https://graph.facebook.com/v2.9/me?fields=id,name,email,picture,gender&access_token={$accessToken}";
        
        $headers = array("Content-type: application/json");
        
        //CURL REQUEST AND RESPONSE JSON

         $ch = curl_init();
         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
         curl_setopt($ch, CURLOPT_URL, $url);
         curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);  
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
         curl_setopt($ch, CURLOPT_COOKIEJAR,'cookie.txt');  
         curl_setopt($ch, CURLOPT_COOKIEFILE,'cookie.txt');  
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);  
         curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.3) Gecko/20070309 Firefox/2.0.0.3"); 
         curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); 
           
         $st=curl_exec($ch); 
         $result=json_decode($st,TRUE);

         $picture=array();

         $id=$result['id'];
         $name=$result['name'];
         $email=$result['email'];
         $gender=$result['gender'];
         $picture=print_r($result['picture']);

         //create Session Variables for them//
         $_SESSION['id']=$id;
         $_SESSION['name']=$name;
         $_SESSION['email']=$email;
         $_SESSION['gender']=$gender;
         $_SESSION['pic']=$picture;

     
         header('Location: setup/fbpage?ref_type=facebooklogin');


    } 
    else 
    {

      $this->loginUrl = $helper->getLoginUrl('http://localhost/scattr/index.php', $permissions);
   
    }


  }



}

?>

<?php

//MAIN BEGINS HERE 

$newHomePage=new HomePage;

$newHomePage->loadAPI();

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

    <title>Mocial.com</title>

  </head>

  <body>
  <?php  

  include("utils/header.php");

   ?>  

<!-- CLEAR FIX EXXAMPLE -->

<!-- <div class="clearfix hidden-lg hidden-sm"-->
<!--best site-->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<br><br><br><br><br>

<!--
<script>
  window.fbAsyncInit = function() {
    FB.init({
      appId      : '244700449366526',
      cookie     : true,
      xfbml      : true,
      version    : 'v2.8'
    });
    FB.AppEvents.logPageView();   
  };

  (function(d, s, id){
     var js, fjs = d.getElementsByTagName(s)[0];
     if (d.getElementById(id)) {return;}
     js = d.createElement(s); js.id = id;
     js.src = "//connect.facebook.net/en_US/sdk.js";
     fjs.parentNode.insertBefore(js, fjs);
   }(document, 'script', 'facebook-jssdk'));
</script>
-->

<script type="text/javascript">
  
FB.getLoginStatus(function(response) {
    statusChangeCallback(response);
});
</script>

<script type="text/javascript">

  function validateLogin()
{
  var email=document.forms["logform"]["email"].value;
  var pass=document.forms["logform"]["pass"].value;

  //LOAD ALERTS 
  var newEmailAlert=document.getElementById('logEmailAlert');
  var newPassAlert=document.getElementById('logPassAlert');

  if(email=="")
  {
    newEmailAlert.classList.add('visible');
    newEmailAlert.classList.remove('hidden');
    return false;
  }
  else
  {
    newEmailAlert.classList.add('hidden');
    newEmailAlert.classList.remove('visible');
  }
  if(pass=="")
  { 

    newPassAlert.classList.add("visible");
    newPassAlert.classList.remove("hidden");
    return false;
  }
  else
  {

    newPassAlert.classList.add("hidden");
    newPassAlert.classList.remove("visible");

  }

}







</script>



<script type="text/javascript">

  function validate(){
    var firstName=document.forms["sigform"]["FirstName"].value;
    var lastName=document.forms["sigform"]["LastName"].value;
    var email=document.forms["sigform"]["Email"].value;
    var password=document.forms["sigform"]["Password"].value;
    
    //LOAD ALERTS TOO
    var firstAlert=document.getElementById('firstNameAlert');
    var lastAlert=document.getElementById('lastNameAlert');
    var mailAlert=document.getElementById('emailAlert');
    var passAlert=document.getElementById('passwordAlert');
    //ENDS HERE//

    if(firstName==""){
    firstAlert.classList.add('visible');
    firstAlert.classList.remove('hidden');
      return false;
    }
    else
    {

      firstAlert.classList.add('hidden');
      firstAlert.classList.remove('visible');
    }
    if(lastName==""){
      
      lastAlert.classList.add('visible');
      lastAlert.classList.remove('hidden');
      return false;
    }
    else
    {
      lastAlert.classList.add('hidden');
      lastAlert.classList.remove('visible');
    }
    if(email==""){
      mailAlert.classList.add('visible');
      mailAlert.classList.remove('hidden');
      return false;
    }
    else
    {
      mailAlert.classList.add('hidden');
      mailAlert.classList.remove('visible');
    }
    if(password==""){
      passAlert.classList.add('visible');
      passAlert.classList.remove('hidden');
      return false;
    }
    else
    {
      passAlert.classList.add('hidden');
      passAlert.classList.remove('visible');
    }
  }
</script>

<div class="container">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      
    <div class="panel">
      <ul class="nav nav-tabs">
      <li class="active">
        <a  href="#1" data-toggle="tab">Login</a>
      </li>
      <li><a href="#2" data-toggle="tab">Sign Up</a>
      </li>
    </ul>
    </div>
    <div class="well"  style="background:white">
      <div class="tab-content ">
        <div class="tab-pane active" id="1">
        <br/>

        <form action="resoures/Logger.php" method="POST" enctype="multipart/form-data" name="logform">
          <div class="form-group">
            <label for="Email">Email</label>
            <input type="email" class="form-control" placeholder="Email" name="email" id="myemail">
          </div>
          <div class="row hidden" id="logEmailAlert">
            <div class="col-md-12">
              <div class="alert alert-danger "><strong>Please enter a valid Email address!</strong></div>
            </div>
          </div>
          <div class="form-group">
            <label for="Password">Password</label>
            <input type="password" class="form-control" placeholder="Password" name="pass">
          </div>
          <div class="row hidden" id="logPassAlert">
            <div class="col-md-12">
              <div class="alert alert-danger "><strong>Please enter a valid password !</strong> </div>
            </div>
          </div>
          <input type="submit" value="Login" class="btn btn-primary btn-block" id="btnlog" onclick="return validateLogin()">
        </form>
          
        </div>


        <div class="tab-pane" id="2">
        <br/>
        <form action="resoures/Signer?ref_type=normallogin" method="POST" name="sigform">
          <div class="form-group">
            <label for="First Name">
              First Name
            </label>
            <input type="text" placeholder="First Name" class="form-control" name="FirstName">
          </div>

          <div class="row hidden" id="firstNameAlert">
            <div class="col-md-12">
              <div class="alert alert-danger" ><strong>Please fill  FirstName !</strong> </div>
            </div>
          </div>

          <div class="form-group">
            <label for="Last Name">
              Last Name
            </label>
            <input type="text" placeholder="Last Name" class="form-control" name="LastName">
          </div>

          <div class="row hidden" id="lastNameAlert" >
            <div class="col-md-12">
              <div class="alert alert-danger " ><strong>Please fill LastName !</strong> </div>
            </div>
          </div>

          <div class="form-group">
            <label for="Email">
              Email
            </label>
            <input type="Email" placeholder="Email" class="form-control" name="Email">
          </div>

          <div class="row hidden" id="emailAlert">
            <div class="col-md-12">
              <div class="alert alert-danger" ><strong>Please fill email !</strong></div>
            </div>
          </div>

          <div class="form-group">
            <label for="Password">
              Password
            </label>
            <input type="Password" placeholder="Password" class="form-control" name="Password">
          </div>



          <div class="row hidden" id="passwordAlert">
            <div class="col-md-12">
              <div class="alert alert-danger " ><strong>Please fill password !</strong></div>
            </div>
          </div>


          <input type="submit" value="Sign Up" class="btn btn-primary btn-block" onclick="return validate()">
          </form>
          <h3><center>Or</center></h3>
         <a href=" <?php   echo $newHomePage->loginUrl;    ?> " class="btn btn-block" style="background-color: #3b5998;color: white;">Sign up with Facebook</a>
      
        </div>
        
      </div>
      </div>
    </div>
  </div>
</div>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

  </body>
</html>