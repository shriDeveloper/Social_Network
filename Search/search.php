<?php

//A CLASS FOR THE FRIENDS//


//INCLUSION HERE//

include('../resoures/DBServer.php');

include('../config/dbconfig.php');

include('../utils/System.php');

include('../utils/AES.php');

require_once 'vendor/autoload.php';

use \FluidXml\FluidXml;
use \FluidXml\FluidNamespace;

 session_start();
 
class Search
{

    private $search_query;

    public $resultsCount;


    public function getQueryString()
    {

     

        $this->search_query=$_GET['q'];

        //XML PARSING HERE//

        $history = new FluidXml(null,['root' => 'history']);

        $history->addChild('search','myfirstsearch!!')
                ->addChild('date','Date is here')
                ->addChild('time','time is here')
                ->addChild('results',true)
                ->addChild('result','Page result 1')
                ->addChild('result','Page Result 2');

         $history->save('../Public/'.$_SESSION['UID'].'/data/history.xml');       




        echo "history: ".$history;
    }

    public function getResults()
    {


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
        
      //  $search_exploded=explode(" ",$this->search_query);

/*
        $x=0;

        foreach( $search_exploded as $search_each ) {
                           

                           $x++;

                           $construct = "";
                           if( $x == 1 )
                                  $construct .="FirstName LIKE '%$search_each%' OR LastName LIKE '%$search_each%'";
                           else
                                  $construct .="AND FirstName LIKE '%$search_each%' OR LastName LIKE '%$search_each%'";


  ALGO NEED SOME FUCKIN SHIT


                    }

*/
                    $construct = "SELECT `FirstName`,`LastName`,`Picture`,`AccId` FROM `scattr_users` WHERE FirstName like '%$this->search_query%' OR LastName like '%$this->search_query%'";

                    $run = mysqli_query($newHandler,$construct);

                    $foundnum = mysqli_num_rows($run);


                    if ($foundnum == 0)
                           echo "<b><center>Sorry Nothing Found!!!<center></b>"; 
                    else {
                          // echo "$foundnum results found !<p>";
 

                           while( $runrows = mysqli_fetch_assoc($run) ) {
                                  
                                  $this->resultsCount++;


                                  $fname = ucfirst($runrows ['FirstName']);
                                  $lname = ucfirst($runrows ['LastName']);
                                  $pic= $runrows['Picture'];
                                  $id=$runrows['AccId'];

                               
                                 echo '<article class="search-result row">
                                 <div class="col-xs-12 col-sm-12 col-md-3">
                                 <a href="#" title="Lorem ipsum" class="thumbnail"><img src="'.$pic.'" alt="Lorem ipsum"  height="100%" width="100%"/></a>
                                  </div>
                                 <div class="col-xs-12 col-sm-12 col-md-2">
                                 <ul class="meta-search">
                                 <li><i class="glyphicon glyphicon-calendar"></i> <span>02/15/2014</span></li>
                                 <li><i class="glyphicon glyphicon-time"></i> <span>4:28 pm</span></li>
                                 <li><i class="glyphicon glyphicon-tags"></i> <span>People</span></li>
                                 </ul>
                                 </div>
                                 <div class="col-xs-12 col-sm-12 col-md-7 excerpet">
                                 <h3><a href="#" title="">'.$fname.'  '. $lname.'</a></h3>
                                 <p>I m a fucking shit!!!!</p>                        
                                 <span class="plus"><a href="#" title="Lorem ipsum"><i class="glyphicon glyphicon-plus"></i></a></span>
                                  </div>
                                <span class="clearfix borda"></span>
                                </article><hr>';



                           }




        }




    }


}


?>
<!DOCTYPE html>
<html lang="en">
  <head>
  <style type="text/css">
      @import "http://fonts.googleapis.com/css?family=Roboto:300,400,500,700";

.container { margin-top: 20px; }
.mb20 { margin-bottom: 20px; } 

hgroup { padding-left: 15px; border-bottom: 1px solid #ccc; }
hgroup h1 { font: 500 normal 1.625em "Roboto",Arial,Verdana,sans-serif; color: #2a3644; margin-top: 0; line-height: 1.15; }
hgroup h2.lead { font: normal normal 1.125em "Roboto",Arial,Verdana,sans-serif; color: #2a3644; margin: 0; padding-bottom: 10px; }

.search-result .thumbnail { border-radius: 0 !important; }
.search-result:first-child { margin-top: 0 !important; }
.search-result { margin-top: 20px; }
.search-result .col-md-2 { border-right: 1px dotted #ccc; min-height: 140px; }
.search-result ul { padding-left: 0 !important; list-style: none;  }
.search-result ul li { font: 400 normal .85em "Roboto",Arial,Verdana,sans-serif;  line-height: 30px; }
.search-result ul li i { padding-right: 5px; }
.search-result .col-md-7 { position: relative; }
.search-result h3 { font: 500 normal 1.375em "Roboto",Arial,Verdana,sans-serif; margin-top: 0 !important; margin-bottom: 10px !important; }
.search-result h3 > a, .search-result i { color: #248dc1 !important; }
.search-result p { font: normal normal 1.125em "Roboto",Arial,Verdana,sans-serif; } 
.search-result span.plus { position: absolute; right: 0; top: 126px; }
.search-result span.plus a { background-color: #248dc1; padding: 5px 5px 3px 5px; }
.search-result span.plus a:hover { background-color: #414141; }
.search-result span.plus a i { color: #fff !important; }
.search-result span.border { display: block; width: 97%; margin: 0 15px; border-bottom: 1px dotted #ccc; }
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

    <title>Search Results!!! </title>

  </head>

  <body>
  

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<?php

include('../utils/header.php');


?>    
<br><br><br>

<?php

     //MAIN BEGINS


    $newSearch =new Search;

?>

<div class="container-fluid">
<div class="container">

    <hgroup class="mb20">
        <h1>Search Results</h1>
        <h2 class="lead"><strong class="text-danger"><?php  echo " ".$newSearch->resultsCount; ?></strong> results were found for the search for <strong class="text-danger">Lorem</strong></h2>                               
    </hgroup>

    <section class="col-xs-12 col-sm-6 col-md-9">
        

    <?php

   

    $newSearch->getQueryString();

    $newSearch->getResults();


    ?>
        
    </section>
</div>
</div>



<!-- Latest compiled and minified JavaScript -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>


    
  </body>
</html>