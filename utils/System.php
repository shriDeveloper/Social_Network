<?php

//A CLASS FOR SYSTEM UTIL

class System{


	public function filterArray($newRequested,$newInput){

		$flag=0;

		$newArray=explode(',',$newRequested);
		
		foreach($newArray as $val){

			if($val==$newInput)
			{
				$flag=1;
				break;
			}

		}

		return $flag;

	}

	public function getSystemDateTime()
	{

			// set default timezone
			date_default_timezone_set('Asia/Kolkata');

			$info = getdate();
			$date = $info['mday'];
			$month = $info['mon'];
			$year = $info['year'];
			$hour = $info['hours'];
			$min = $info['minutes'];
			$sec = $info['seconds'];

			$current_date = "$year-$month-$date";
			$current_time="$hour:$min:$sec";

			return $current_date.'&'.$current_time;

	}


	public function generateID(){

		$id=substr(number_format(time() * rand(),0,'',''),0,6);

		return $id;
	}


	public function createAccount($id){

        //creates a directory//
		mkdir("../Public/".$id, 0, true);
		mkdir("../Public/".$id."/photos", 0, true);
		mkdir("../Public/".$id."/thumbs", 0, true);
        mkdir("../Public/".$id."/propic", 0, true);
        mkdir("../Public/".$id."/data",0,true);
	}




}


//ANOTHER CLASS FOR DUPLICATE EMAIL

class MyUtilities
{
	public function checkAccount($dbHandler,$email)
	{
		$flag=0;

		$result=mysqli_query($dbHandler,"SELECT Email FROM scattr_users");
 		 while ($row = mysqli_fetch_array($result))
         {
				if($row['Email']==$email)
				{

					$flag=1;
					break;
				
				}
		 }

		 return $flag;
	}
}



?>