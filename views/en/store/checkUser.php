<?php
//header("Content-Type: text/html; charset=ISO-8859-1",true);

require_once("../../../vendor/autoload.php");

use \Tila\Model\User;

if (User::login($_POST["email"], $_POST["password"], $_POST["language"]) === true){

	if ($_POST["newUser"] === true){
		print "false";
	} else {
		print "true";
	}
}else{
	print "false";
}
?>