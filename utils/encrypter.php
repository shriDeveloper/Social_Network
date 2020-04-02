<?php
//A CLASSS FOR ENCRYPTING IDS//

class Encrypter
{

//this function to return  uniqid()//

public function generate()
{

//generate a unique id//

$unique=uniqid();

$mesadig=crypt($unique,rand());
//encrypt with the salt//

//FILETER FOR THE /

$mesadig=str_replace('/', 'ssd', $mesadig);

return $mesadig;

}
//ends here//




}





?>