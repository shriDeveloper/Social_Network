<?php


//INCLUSION


class User{
	public $firstName;
	public $lastName;
	public $picture;
	public $tags; 
}

class Recommender
{


	//ALGORITHM REQUIRES A LOT IMPROVEMENT
	public function recommendUser($search,$newHandler)
	{
		
        	$userTags=explode(',',$search);

        	$count=count($userTags);

        	$userArray=array();

        	foreach($userTags as $tag)
        	{
        			$construct = "SELECT Tags,AccId FROM scattr_users_imf";
                    
                    $run = mysqli_query($newHandler,$construct);

                    while( $runrows = mysqli_fetch_array($run) )
                    {
                    		$tags=$runrows['Tags'];

                    		$newTags=explode(',', $tags);

                    		if(in_array($tag, $newTags))
                    		{
                   			
	                   			array_push($userArray, $runrows['AccId']);
                    		}

                    }
 
        	}  

      
       				$userFinals=array();

				       foreach($userArray as $val)
				       {
				       		for($i=0;$i<count($userArray);$i++)
				            {
				            	if($userArray[$i]==$val)
				            	{
				            		$count++;
				            	}
				            }

				            $string=" ".$val;

				            array_push($userFinals,$string);

				            $count=0;
				       }

				       $userFinals=array_unique($userFinals);

				       return $userFinals; 
	}



}





?>