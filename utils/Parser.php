<?php

//A CLASS FOR PARSING CONTENT

//INCLUSION 

include('../utils/AES.php');

include('../utils/encrypter.php');

class Parser
{	
	private $query;

	public function parseFunction()
	{
		$this->query=$_GET['q'];

	}
	public function encodeAES()
	{
			   
				$newEncrypted=new encrypter;


			   //CRYPT THE QUERY HERE

				/*$inputText=$this->query.''.$newEncrypted->generate();
				$inputKey="shriniketdeshmukh111@gmail.com97";
				$blockSize=256;


				$newAes = new AES($inputText, $inputKey, $blockSize);
				$newTmpEnc = $newAes->encrypt();

				$newTmpEnc=str_replace('/', 'loc',$newTmpEnc);
				*/

				header("Location: ../Search/search?q= ".$this->query);

	}
}

//MAIN BEGINS HERE//

$newParser=new Parser;

$newParser->parseFunction();

$newParser->encodeAES();

?>