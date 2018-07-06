<?php

use \Tila\Page;
use \Tila\Model\User;

/* Route to PageAdmin root */
/*
$app->get("/admin", function() {

	// quando for acessar a página de admin, verificar se o usuário está logado
	// e se tem acesso à administração
	User::verifyLogin();

	// __construct (header)
	$page = new PageAdmin();

	// body
	$page->setTpl("index");

});
*/
/* Route to action for login page */
$app->get("/{language}/admin/login", function($request, $response, $args) {

	// configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/admin";
	$pageConfig[4] = "/".$args["language"];

	// __construct (header)
//	$page = new PageAdmin($pageConfig);
	$page = new Page($pageConfig);
/*
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);
*/
	// Body
	$page->setTpl("login");

});

/* Route to login  */
$app->post("/{language}/admin/login", function($request, $response, $args) {

	try {
		User::login($_POST["reg-email"], $_POST["reg-password"], $args["language"]);
	} catch (Exception $e) {
    	echo 'Exceção capturada: ',  $e->getMessage(), "\n";
		header("Location: /".$args["language"]."/admin/login");
    	exit;
	}

//	header("Location: /".$args["language"]."/admin");
	header("Location: /admin/".$args["language"]);
	exit;

});

// rota de Logout
$app->get("/{language}/admin/logout", function($request, $response, $args) {

	User::Logout();

	header("Location: /".$args["language"]."/admin/login");
	exit;

});

// rota de recuperação de senha (forgot)
$app->get("/admin/forgot", function() {

	// __construct (header)
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	// body
	$page->setTpl("forgot");

});

// rota de salvar senha de recuperação no banco (forgot)
$app->post("/admin/forgot", function() {
	
	$user = User::getForgot($_POST["email"]);

	header("location: /admin/forgot/sent");
	exit;

});

// rota de janela de senha enviada (forgot)
$app->get("/admin/forgot/sent", function() {

	// __construct (header)
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	// body
	$page->setTpl("forgot-sent");

});

// rota de janela de reset de senha
$app->get("/admin/forgot/reset", function() {

	$user = User::validForgotDecrypt($_GET["code"], $_GET["iv"]);

	// __construct (header)
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	// body
	$page->setTpl("forgot-reset", array(
		"name"=>$user["desperson"],
		"code"=>$_GET["code"],
		"iv"=>$_GET["iv"]
	));

});

// rota de salvar a senha de reset no banco
$app->post("/admin/forgot/reset", function() {

	$forgot = User::validForgotDecrypt($_POST["code"], $_POST["iv"]);

	User::setForgotUsed($forgot["idrecovery"]);

	$user = new User();

	$user->get((int)$forgot["iduser"]);

	$password = password_hash($_POST["password"], PASSWORD_DEFAULT, [
		"cost"=>12
	]);

	$user->setPassword($password);

	// __construct (header)
	$page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	// body
	$page->setTpl("forgot-reset-success");

});

?>