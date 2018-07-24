<?php
require_once("../../../vendor/autoload.php");

use \Tila\Model\User;

if (User::login($_POST["email"], $_POST["password"], $_POST["language"]) === false){
	print "false";
}else{

	if ($_POST["newUser"] === true){
		print "false";
	} else {
		print "true";
	}
}
?>