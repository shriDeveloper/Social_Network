<?php

$connect = mysqli_connect("localhost", "root", "", "scattr");
$request = mysqli_real_escape_string($connect, $_POST["query"]);
$query = "
 SELECT * FROM scattr_users WHERE FirstName LIKE '%".$request."%'";

$result = mysqli_query($connect, $query);

$data = array();

if(mysqli_num_rows($result) > 0)
{
 while($row = mysqli_fetch_assoc($result))
 {
  $data[] = "  ".$row["FirstName"]." ".$row['LastName'];
 }

 echo json_encode($data);

}
?>