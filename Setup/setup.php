<?php

//INCLUSION HERE//

include('../resoures/DBServer.php');

include('../config/dbconfig.php');

//A CLASS TO UPLOAD PROFILE PHOTO//

class UploadProfilePicture{

  private $mypath;
  private $accid;
  private $upic;

  public function getRequest(){
 
    
     //CONNECT SERVER HERE//


    $newDBServer=new DBServer;

    $newDBConfig=new dbConfig();

    //GET THE CONNECTION HANDLER//
    $newHandler=$newDBConfig->getConnection();


    session_start();

    $this->accid=$_SESSION['UID'];

    $this->upic=$_SESSION['UPIC'];


    $this->mypath="../Public/".$this->accid."/propic/";

    //WHEN POST//

    if(@$_POST['btn_upload']){


        //THESE ALL ARE THE FILE VARIABLES//
        $file=$_FILES['myfile'];

        $file_name=$file['name'];
        $file_type=$file['type'];
        $file_size=$file['size'];
        $file_path=$file['tmp_name'];

        //ENDS HERE//


        //RESTRICT FILE//

        if($file_name!="" &&($file_type="images/jpeg"||$file_type="images/png"||$file_type="image/gif")&& $file_size<=13048576)

        if(move_uploaded_file($file_path,"../Public/$this->accid/propic/$this->upic")){

          //IF FILE MOVES SUCCESSFULLY


          //UPDATE THE PROFILE PICTURE//

          $newDBServer->updateProfilePicture($newHandler,$this->upic,$this->accid);

        }


    }

  }

  public function getProfilePicture(){

 //CONNECT SERVER HERE//

    $newDBServer=new DBServer;

    $newDBConfig=new dbConfig();

    //GET THE CONNECTION HANDLER//
    $newHandler=$newDBConfig->getConnection();


    $pic=$newDBServer->select($newHandler,'Picture,AccId','scattr_users','AccId',$this->accid,'Picture');

    return $pic;
  }

}


$newUpload=new UploadProfilePicture;


$newUpload->getRequest();


?>


<!DOCTYPE html>
<html lang="en">
  <head>
  <style type="text/css">
    
.fade {
opacity: 0;
-webkit-transition: opacity 2.25s linear;
  -moz-transition: opacity 2.25s linear;
   -ms-transition: opacity 2.25s linear;
  -o-transition: opacity 2.25s linear;
     transition: opacity 2.25s linear;
}


.file {
  visibility: hidden;
  position: absolute;
}
.bootstrap-tagsinput {
    width: 100%;
}
.label {
    line-height: 2 !important;
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

<link rel="stylesheet" href="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.css" />
<link rel="stylesheet" href="../css/tagscss.css">
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" type="text/css" rel="stylesheet">

    <title>Setup Profile</title>

  </head>

  <body>

<?php   

include('../utils/header.php');

?>
  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="../scripts/custom.js"></script>
<script type="text/javascript" src="../scripts/tags.js"></script>

<script type="text/javascript">
  function validateDetails(){

     

  }
</script>

<script type="text/javascript">
  function validateDetails(){
    var clg=document.forms["sigform"]["FirstName"].value;
    var city=document.forms["sigform"]["FirstName"].value;
  }
</script>

<script type="text/javascript">
  $(document).on('click', '.browse', function(){
  var file = $(this).parent().parent().parent().find('.file');
  file.trigger('click');
});
$(document).on('change', '.file', function(){
  $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
});
</script>
 
<br><br><br><br>

<div class="container">
  <div class="row">
    <div class="well well-sm" style="background: whitesmoke;">
        <h3><center><b>Let's get started!! </b></center></h3>
    </div>
  </div>
</div>

 <div class="container">
   <div class="well" style="background: white;">
   <div class="row">
   <div class="col-md-3">
       <img src="<?php    echo $newUpload->getProfilePicture();    ?>" class="img-responsive img-thumbnail">
     
     </div>
     </div>

     <div class="row">
     <div class="col-md-4">
   
<div class="form-group">

<form action="<?php $PHP_SELF ?>" method="POST" enctype="multipart/form-data">
        <label class="control-label">Select File</label>
    <input name="myfile" type="file" >
<br>
    <div class="row">
      <div class="col-md-9">
        <input type="submit" name="btn_upload" value="Upload" class="btn btn-success btn-block">
      </div>
    </div>

    </form>
  </div>

  </div> 
     </div>
   </div>
 </div>

<script type="text/javascript">
  $('document').ready(function(){


$('#searchTag').click(function()
{

saveTags();

});

$('#sav_btn').click(function(){

     var college=document.forms["mydetails"]["college"].value;
     var city=document.forms["mydetails"]["city"].value;

     var flag1=0;
     var flag2=0;

     //load alerts//
     var collegeAlert=document.getElementById('clgAlert');
     var cityAlert=document.getElementById('ctyAlert');

     var successBar=document.getElementById('sucssbar');

     if(college==""){
      //display college alert
       collegeAlert.classList.add('visible');
       collegeAlert.classList.remove('hidden');
     }else{
      collegeAlert.classList.add('hidden');
      collegeAlert.classList.remove('visible');

      flag1=1;
     }
     if(city=="")
     {
      cityAlert.classList.add('visible');
      cityAlert.classList.remove('hidden');
     }else{
      cityAlert.classList.add('hidden');
      cityAlert.classList.remove('visible');

      flag2=1;

     }

     if(flag1==1 && flag2==1){
      sucssbar.classList.add('visible');
      sucssbar.classList.remove('hidden');
      saveDetails();
     }
     else{
      sucssbar.classList.add('hidden');
      sucssbar.classList.remove('visible');
     }


});

$('#abt_btn').click(function(){




saveAboutDetails();


});



  })
</script>

<!--THE ALERT -->
<div class="container">
  <div class="row hidden" id="sucssbar">
    <div class="col-md-12">
      <div class="alert alert-success"><b id="result"></b></div>
    </div>
  </div>
</div>
<!--ENDS HERE-->
<div class="container">
<div class="well well-sm" style="background:white;">
  <div class="row">
    <div class="col-md-7">
       <ul class="nav nav-tabs">
  <li class="active"><a href="#tab_a" data-toggle="tab">Basic Info</a></li>
  <li><a href="#tab_b" data-toggle="tab">About</a></li>
  <li><a href="#tab_d" data-toggle="tab">Others</a></li>
</ul>
<div class="tab-content">
        <div class="tab-pane fade in active" id="tab_a">
        <br>
<form class="form-horizontal"  name="mydetails">
    
    <div class="form-group">
      <label class="control-label col-sm-2" for="clg">College/High School</label>
      <div class="col-sm-7">
        <input type="text" class="form-control" id="clg" placeholder="College" name="college">
      </div>
    </div>

    <div class="row hidden" id="clgAlert">
      <div class="col-md-7 col-md-offset-2">
        <div class="alert alert-danger"><strong>Please fill the College Details!</strong></div>
      </div>
   </div>
    
      
    <div class="form-group">
      <label class="control-label col-sm-2" for="cty">City</label>
      <div class="col-sm-7">          
        <input type="text" class="form-control" id="cty" placeholder="City" name="city">
      </div>
    </div>

        <div class="row hidden" id="ctyAlert">
      <div class="col-md-7 col-md-offset-2">
        <div class="alert alert-danger"><strong>Please fill the City Details!!</strong></div>
      </div>
   </div>


    <div class="form-group">        
      <div class="col-sm-offset-2 col-sm-10">
        <button type="button" class="btn btn-default" id="sav_btn">Save</button>
      </div>
    </div>
  </form>

        </div>
        <div class="tab-pane fade" id="tab_b">
            <br>
            <form action="#" method="#">

              <div class="form-group">
                <textarea class="form-control" rows="5" placeholder="About Me" name="abt" id="abt"></textarea>
              </div>
              <input type="button" name="abt" value="Save" class="btn btn-default" id="abt_btn">
            </form>
        </div>

        <script>
$(document).ready(function(){
    $('[data-toggle="popover"]').popover();   
});
</script>
        
        <div class="tab-pane fade" id="tab_d">
              <br>

              <div class="form-group">
                <label for="tags" class="control-label" >Search Tags</label>
                <input type="text" class="form-control" data-role="tagsinput" id="search_tag"><a data-toggle="popover" title="What are search tags??" data-content="ss">Whats this?</a>
              </div>
          
              <input type="button" class="btn btn-default" value="Save" id="searchTag">


        </div>
</div><!-- tab content -->



    </div>
  </div>
</div>
 
</div><!-- end of container -->


<div class="container">
  <div class="row">
    <div class="col-md-2 col-md-offset-10">
      <a class="btn btn-success btn-block" href="../Find/Friends.php?search_bar=#" >I m Done!!!</a>
      </div>
    </div>
  </div>
<br><br><br>

<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

<script src="//cdn.jsdelivr.net/bootstrap.tagsinput/0.4.2/bootstrap-tagsinput.min.js"></script>
    
  </body>
</html>