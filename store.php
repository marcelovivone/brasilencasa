<?php

use \Tila\Page;
//use \Tila\PageAdmin;
use \Tila\Model\Address;
use \Tila\Model\Cart;
use \Tila\Model\Category;
use \Tila\Model\Order;
use \Tila\Model\OrderStatus;
use \Tila\Model\Product;
use \Tila\Model\Recipe;
use \Tila\Model\SubCategory;
use \Tila\Model\User;
use \Tila\Model\WishList;

function mainMenu ($language, &$menu = [], &$filter = [], &$pageConfig = []) {

	/*
		function: product engine for get and post
		Arguments:
			- language: current language (chosen by user)
			- menu: array used in html to configure the page
			- filter: array used in Products to filter data 
			- pageConifg = array used to configure the page to be open
	*/

	/* menu setting */
	// __construct (header)
	$category = new Category($language);
	$subCategory = new SubCategory($language);

	// Loading categories 
	$catList = $category->listAll();
	
	$i = 0;
	
   	// Categories array iteration
	foreach ($catList as $catKey => $catValue) {
   		
		// Add category id and name to menu array
   		$menu["category-name"][$catKey] = $catValue["nmcategory"];
   		$menu["category-id"][$catKey] = $catValue["idcategory"];

		// if user's choice was category all
		if (in_array($catValue["idcategory"]."#", $_POST) && !in_array($catValue["idcategory"]."@", $_POST)) {

			// Add category id to filter array
   			$filter["idcategory$catKey"] = $catValue["idcategory"];
  		}

		// loading subcagegories
		$subCatList = $subCategory->listByCategory($catValue["idcategory"]);

		// Category doesn't have subcategory
    	if (!$subCatList) {
    		continue;
    	}

    	// Subcategories array iteration
		foreach ($subCatList as $subKey => $subValue) {

			// Add subcategory id and name to array menu
	   		$menu["subCategory-name"][$catKey][$subKey] = $subValue["nmsubcategory"];
	   		$menu["subCategory-id"][$catKey][$subKey] = $subValue["idsubcategory"];

	   		// category and subcategory in $_POST (meaning they were selected to filter the page)
			if (in_array($catValue["idcategory"]."#@".$subValue["idsubcategory"], $_POST)) {

		   		// Add subcategory name to menu array
		   		$menu["checkbox"][$catKey][$subKey] = $subValue["nmsubcategory"];

				// Add category and subcategory to filter array
				$filter["idcategory$catKey"] = $catValue["idcategory"];
			   	$filter["idsubcategory$i"] = $subValue["idsubcategory"];

		   		$i++;

		   		// TODO: loop to find others categories with the same name
		   		// example: guarana under beverage and featured

			} else {
		    	$menu["checkbox"][$catKey][$subKey] = "";
			}
		}
	}

	/* Page configuration */
	$pageConfig[2] = $language;
	$pageConfig[3] = $menu;
}

/* Route to root page */
$app->get("/", function() {

	// set default language
	$language = "en";

	// configure products page
	mainMenu($language, $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $language;
	$pageConfig[4] = $language;

	// __construct (header)
	$page = new Page($pageConfig);

	// Tpl configuration and drawning
	$page->setTpl("index", [
		'menu'=>$menu
	]);

});

/* Route to language page */
$app->get("/{language}", function($request, $response, $args) {

	// configure products page
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"];
	$pageConfig[4] = "/".$args["language"];

	// __construct (header)
	$page = new Page($pageConfig);

	// Tpl configuration and drawning
	$page->setTpl("index", [
		'menu'=>$menu
	]);

});

/* Route to about page */
$app->get("/{language}/about", function($request, $response, $args) {

	// configure products page
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/about";
	$pageConfig[4] = "/".$args["language"];

	// __construct (header)
	$page = new Page($pageConfig);

	// Tpl configuration and drawning
	$page->setTpl("about", [
		'menu'=>$menu
	]);

});

/* Route to contact page */
$app->get("/{language}/contact", function($request, $response, $args) {

	// configure products page
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/contact";
	$pageConfig[4] = "/".$args["language"];

	// __construct (header)
	$page = new Page($pageConfig);

	// Tpl configuration and drawning
	$page->setTpl("contact", [
		'menu'=>$menu
	]);

});

/* Route to recipe page */
$app->get("/{language}/recipes", function($request, $response, $args) {

	// configure products page
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/recipe";
	$pageConfig[4] = "/".$args["language"];

	// __construct (header)
	$page = new Page($pageConfig);

	$recipe = new Recipe($args["language"]);

	// Tpl configuration and drawning
	$page->setTpl("recipe", [
		'recipes'=>$recipe
	]);

});

/* Route to recipe page by product */
$app->get("/{language}/recipes/{dsurl}", function($request, $response, $args) {

	// configure products page
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/recipe";
	$pageConfig[4] = "/".$args["language"];

	// __construct (header)
	$page = new Page($pageConfig);

	/* Loading products */
	$product = new Product($args["language"]);

	$product->getFromURL($args["dsurl"],10);

	$recipe = new Recipe($args["language"]);

	$recipe->setData([
		"idproduct"=>$product->getidproduct()
	]);

	;

	$page->setTpl("recipes", [
		'recipes'=>$recipe->getByProduct()
	]);

});

/* Route to products page */
$app->get("/{language}/products", function($request, $response, $args) {

	// configure products page
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* setting the default order */
	$order = "AZ";

	// loading products
	$product = new Product($args["language"]);

	/* Page configuration */
	$pageConfig[0] = "header-compact";
	$pageConfig[1] = $args["language"]."/product";
	$pageConfig[4] = "/".$args["language"]."/products";

	// __construct (header)
	$page = new Page($pageConfig);

	// Tpl configuration and drawning
	$page->setTpl("product-list", [
		"menu"=>$menu,
		"sort"=>$order,
		"products"=>$product->listAll()
	]);

});

/* Route to action for products page */
$app->post("/{language}/products", function($request, $response, $args) {

	// configure products page
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Loading products */
	$product = new Product($args["language"]);

	/* Sort configuration */
	// used in Product to order data
	$order = "t.nmproduct ASC";

	if (isset($_POST["sort"])) {

		Switch ($_POST["sort"]) {

			Case 'AZ':
				$order = "t.nmproduct ASC";
				break;

			Case 'ZA':
				$order = "t.nmproduct DESC";
				break;

			Case 'LP':
				$order = "p.vlprice ASC";
				break;

			Case 'HP':
				$order = "p.vlprice DESC";
				break;

			Case 'BS':
				$order = "p.qtvenda DESC";
				break;

			Case 'LS':
				$order = "p.qtvenda ASC";
				break;

			default:
				$order = "l.nmproduct ASC";
		}
	}


	/* Page configuration */
	$pageConfig[0] = "header-compact";
	$pageConfig[1] = $args["language"]."/product";
	$pageConfig[4] = "/".$args["language"]."/products";

	// __construct (header)
	$page = new Page($pageConfig);

	// Tpl configuration and drawning
	$page->setTpl("product-list", [
		"menu"=>$menu,
		"sort"=>isset($_POST["sort"]) ? $_POST["sort"] : "AZ",
		"products"=>$product->listByArgs($filter,$order)
	]);

});

// detail product page route
$app->get("/{language}/products/{dsurl}", function($request, $response, $args) {

	// configure products page
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Loading products */
	$product = new Product($args["language"]);

	$product->getFromURL($args["dsurl"]);

	/* Page configuration */
	$pageConfig[0] = "header-compact";
	$pageConfig[1] = $args["language"]."/product";
	$pageConfig[4] = "/".$args["language"]."/products";

	// __construct (header)
	$page = new Page($pageConfig);

	$page->setTpl("product-detail", [
		'product'=>$product->getValues(),
		'categories'=>$product->getCategories()
	]);

});

// login page route
$app->get("/{language}/login", function($request, $response, $args) {

	// configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/store";
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	$page->setTpl("login", [
		'error'=>User::getError(),
		'errorRegister'=>User::getErrorRegister(),
		'registerValues'=>isset($_SESSION['registerValues']) ? $_SESSION['registerValues'] : [
			'name'=>'',
			'email'=>'',
			'phone'=>''
		]
	]);

});

// validation login route
$app->post("/{language}/login", function($request, $response, $args) {

	try {

		User::login($_POST['reg-email'], $_POST['reg-password'], $args["language"]);

	} catch(Exception $e) {

		User::setError($e->getMessage());

	}

//	header("Location: /".$args["language"]."/store/checkout");
	header("Location: /".$args["language"]."/products");
	exit;

});

//  page route
$app->get("/{language}/logout", function($request, $response, $args) {

	User::logout();

	// configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/store";
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	header("Location: /".$args["language"]."/login");
	exit;

});

// register new user route
$app->post("/{language}/register", function($request, $response, $args) {

	// guardar os dados digitados pelo usuário em uma sessão
	// utilizada para o caso de ter algum erro no cadastro e não limpar os campos da página
	$_SESSION["registerValues"] = $_POST;
/*
	// validação de campos obrigatórios da página
	if (!isset($_POST['name']) || $_POST['name'] == '') {

		User::setErrorRegister("Preencha o seu nome.");
		header('Location: /login');
		exit;

	}

	if (!isset($_POST['email']) || $_POST['email'] == '') {

		User::setErrorRegister("Preencha o seu e-mail.");
		header('Location: /login');
		exit;

	}

	if (!isset($_POST['password']) || $_POST['password'] == '') {

		User::setErrorRegister("Preencha a senha.");
		header('Location: /login');
		exit;

	}

	// verifica se o usuário já existe
	if (User::checkLoginExist($_POST['email']) === true) {

		User::setErrorRegister("Esse endereço de e-mail já está sendo utilizado por outro usuário.");
		header('Location: /login');
		exit;

	}
*/
	$user = new User($args["language"]);

	$user->setData([
		"inadmin"=>0,
		"dsemail"=>$_POST["new-email"],
		"nmfirst"=>$_POST["new-firstname"],
		"nmlast"=>$_POST["new-lastname"],
		"cdpassword"=>$_POST["newpassword"],
		"tptitle"=>$_POST["title"],
		"nrphone"=>$_POST["new-phone"]
	]);

	// autentica o usuário
	// caso isso não seja feito, a rota de checkout irá redirecionar para a rota de login
	// (o usuário precisa estar logado para acessar a rota de checkout)
	$user->insert();

	User::login($_POST["new-email"], $_POST["newpassword"], $args["language"]);

//	header("Location: /".$args["language"]."/checkout");
	header("Location: /".$args["language"]."/profile");
	exit;

});

// rota para página de edição dos dados do usuário
$app->get("/{language}/profile", function($request, $response, $args) {

	User::verifyLogin(false, $args["language"]);

	$user = User::getFromSession($args["language"]);

	// configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/profile";
	$pageConfig[4] = "/".$args["language"];

	// construct
	$page = new Page($pageConfig);

	$page->setTpl("profile", [
		'user'=>$user->getValues(),
		'profileMsg'=>User::getSuccess(),
		'profileError'=>User::getError()
	]);

});

// rota para salvar dados alterados no banco
$app->post("/{language}/profile", function($request, $response, $args) {

	User::verifyLogin(false, $args["language"]);
/*
	// validação de campos obrigatórios da página
	if (!isset($_POST['desperson']) || $_POST['desperson'] === '') {

		User::setError("Preencha o seu nome.");
		header('Location: /profile');
		exit;

	}

	if (!isset($_POST['desemail']) || $_POST['desemail'] === '') {

		User::setErrorRegister("Preencha o seu e-mail.");
		header('Location: /profile');
		exit;

	}
*/
	$user = User::getFromSession($args["language"]);

	// verifica se o usuário já existe
	if ($_POST['dsemail'] !== $user->getdsemail()) {

		if (User::checkLoginExist($_POST['dsemail']) === true) {

			// retorna os valores informados pelo usuário para a sessão
			// no get do profile, esses valores serão lidos e reexibidos nos campos da página
			$_SESSION[User::SESSION] = $_POST;

			Switch ($args["language"]) {

				Case "en":
					User::setError("Email is already being used by another user.");
					break;

				Case "es":
					User::setError("E-mail ya está siendo utilizado por otro usuario.");
					break;

				Case "pt":
					User::setError("E-mail já está sendo utilizado por outro usuário.");
					break;

			}

			header("Location: /".$args["language"]."/profile");
			exit;

		}

	}

	// evita command injection para alterar o usuário para administrador
	// sobrescrevendo uma possível alteração pelo inadmin e pela senha
	// originais salvas no banco de dados
	$_POST['iduser'] = $user->getiduser();
	$_POST['inadmin'] = $user->getinadmin();
	$_POST['password'] = $user->getcdpassword();

	// o login é o mesmo que o e-mail para os usuários do site
//	$_POST['deslogin'] = $_POST['desemail'];

	$user->setData($_POST);

	$user->update();

	$_SESSION[User::SESSION] = $user->getValues();

	Switch ($args["language"]) {

		Case "en":
			User::setSuccess("Data changed successfully!");
			break;

		Case "es":
			User::setSuccess("¡Datos alterados con éxito!");
			break;

		Case "pt":
			User::setSuccess("Dados alterados com sucesso!");
			break;

	}

	header("location: /".$args["language"]."/profile");
	exit;

});

// checkout page route
$app->get("/{language}/checkout", function($request, $response, $args) {

	User::verifyLogin(false);

	$address = new Address();

	$cart = Cart::getFromSession();

	// se o CEP já existir no carrinho: carrega em $_GET o CEP do carrinho
	if (isset($_GET['zipcode'])) {

		$_GET['zipcode'] = $cart->getdeszipcode();

	}

	// verifica se o cep foi informado
	if (isset($_GET['zipcode'])){

		// lê os dados de endereço do cep
		$address->loadFromCEP($_GET['zipcode']);
		
		// atribui o novo cep ao carrinho
		$cart->setdeszipcode($_GET['zipcode']);

		// salva os novos dados no banco de dados
		$cart->save();

		// refaz o cálculo dos valores de frete
		$cart->getCalculateTotal();

	}

	// define os dados no carrinho, mesmo que com conteúdos vazios
	if (!$address->getdsaddress()) $address->setdesaddress('');
	if (!$address->getdsnumber()) $address->setdesnumber('');
	if (!$address->getdscomplement()) $address->setdescomplement('');
	if (!$address->getdsdistrict()) $address->setdesdistrict('');
	if (!$address->getdscity()) $address->setdescity('');
	if (!$address->getdsstate()) $address->setdesstate('');
	if (!$address->getdscountry()) $address->setdescountry('');
	if (!$address->getdszipcode()) $address->setdeszipcode('');

	$page = new Page();

	$page->setTpl("checkout", [
		'cart'=>$cart->getValues(),
		'address'=>$address->getValues(),
		'products'=>$cart->getProducts(),
		'error'=>$address::getMsgError()
	]);

});

// rota de recuperação de senha (forgot)
$app->get("/{language}/forgot", function($request, $response, $args) {

	// configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/store";
	$pageConfig[4] = "/".$args["language"];

	// __construct (header)
	$page = new Page($pageConfig);

	// body
	$page->setTpl("forgot");

});

// rota de salvar senha de recuperação no banco (forgot)
$app->post("/{language}/forgot", function($request, $response, $args) {

	$user = User::getForgot($_POST["email"], $args["language"], false);

	header("location: /".$args["language"]."/forgot/sent");
	exit;

});

// rota de janela de senha enviada (forgot)
$app->get("/{language}/forgot/sent", function($request, $response, $args) {

	// configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/store";
	$pageConfig[4] = "/".$args["language"];

	// __construct (header)
	$page = new Page($pageConfig);

	// body
	$page->setTpl("forgot-sent");

});

// rota de janela de reset de senha
$app->get("/{language}/forgot/reset", function($request, $response, $args) {

	$user = User::validForgotDecrypt($_GET["code"], $_GET["iv"]);

	// configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/store";
	$pageConfig[4] = "/".$args["language"];

	// __construct (header)
	$page = new Page($pageConfig);

	// body
	$page->setTpl("forgot-reset", array(
		"name"=>$user["nmfirst"],
		"code"=>$_GET["code"],
		"iv"=>$_GET["iv"]
	));

});

// rota para salvar a senha de reset no banco
$app->post("/{language}/forgot/reset", function($request, $response, $args) {

	$forgot = User::validForgotDecrypt($_POST["code"], $_POST["iv"]);

	User::setForgotUsed($forgot["idrecovery"]);

	$user = new User($args["language"]);

	$user->get((int)$forgot["iduser"]);

//	$password = USER::getPasswordHash($_POST["password"]);

	$user->setPassword($_POST["password"]);

	// configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/store";
	$pageConfig[4] = "/".$args["language"];

	// __construct (header)
	$page = new Page($pageConfig);

	// body
	$page->setTpl("forgot-reset-success");

});

$app->get("/{language}/profile/change-password", function($request, $response, $args) {

	User::verifyLogin(false, $args["language"]);

	$user = User::getFromSession($args["language"]);

	// configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/profile";
	$pageConfig[4] = "/".$args["language"];

	// __construct (header)
	$page = new Page($pageConfig);

	$page->setTpl("profile-change-password", [
		'user'=>$user->getValues(),
		'changePassError'=>User::getError(),
		'changePassSuccess'=>User::getSuccess()
	]);

});

$app->post("/{language}/profile/change-password", function($request, $response, $args) {

	User::verifyLogin(false, $args["language"]);

	$user = User::getFromSession($args["language"]);
	$user->get($user->getiduser());

	$user->setPassword($_POST['newpassword']);

	Switch ($args["language"]) {

		Case "en":
			User::setSuccess('Password changed successfully.');
			break;

		Case "es":
			User::setSuccess('Contraseña alterada con éxito.');
			break;

		Case "pt":
			User::setSuccess('Senha alterada com sucesso.');
			break;

	}

	header("Location: /".$args["language"]."/profile/change-password");
	exit;

});

$app->get("/{language}/profile/addresses/{type}", function($request, $response, $args) {

	User::verifyLogin(false, $args["language"]);

	$user = User::getFromSession($args["language"]);

	$address = new Address($args["language"]);

	// configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/profile";
	$pageConfig[4] = "/".$args["language"];

	// __construct (header)
	$page = new Page($pageConfig);

	$page->setTpl("profile-addresses", [
		"action"=>"read",
		"type"=>$args["type"],
		'addresses'=>$user->getAddresses(strtoupper(substr($args["type"], 0, 1))),
		'profileAddressError'=>$address::getError(),
		'profileAddressSuccess'=>$address::getSuccess()
	]);

});

$app->get("/{language}/profile/addresses/{type}/new", function($request, $response, $args) {

	User::verifyLogin(false, $args["language"]);

	// configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/profile";
	$pageConfig[4] = "/".$args["language"];

	// __construct (header)
	$page = new Page($pageConfig);

	$page->setTpl("profile-addresses", [
		"action"=>"new",
		"type"=>$args["type"],
		"idperson"=>$_SESSION["User"]["idperson"],
		'profileAddressError'=>"",
		'profileAddressSuccess'=>""
	]);

});

$app->post("/{language}/profile/addresses/{type}/save", function($request, $response, $args) {

	User::verifyLogin(false, $args["language"]);

	$address = new Address($args["language"]);

	$address->setData([
		"idaddress"=>isset($_POST["idaddress"]) ? $_POST["idaddress"] : "",
		"idperson"=>$_SESSION["User"]["idperson"],
		"dsnumber"=>$_POST["dsnumber"],
		"dsaddress"=>$_POST["dsaddress"],
		"dscity"=>$_POST["dscity"],
//		"dscountry"=>$_POST["dscountry"],
		"dscountry"=>"España",
		"cdzipcode"=>$_POST["cdzipcode"],
		"tpaddress"=>$_POST["tpaddress"],
		"fldefault"=>isset($_POST["fldefault"]) ? $_POST["fldefault"] : "N",
		"flreplicate"=>isset($_POST["flreplicate"]) ? $_POST["flreplicate"] : "N"
	]);

	$address->save();

	header("location: /".$args["language"]."/profile/addresses/".$args["type"]);
	exit;

});

$app->get("/{language}/profile/addresses/{type}/edit/{idaddress}/{seqaddress}", function($request, $response, $args) {

	User::verifyLogin(false, $args["language"]);

	$address = new Address($args["language"]);

	$address->setData([
		"idaddress"=>$args["idaddress"]
	]);

	$address->get($address);

	// configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/profile";
	$pageConfig[4] = "/".$args["language"];

	// __construct (header)
	$page = new Page($pageConfig);

	$page->setTpl("profile-addresses", [
		"action"=>"edit",
		"type"=>$args["type"],
		'seqaddress'=>$args["seqaddress"],
		'addresses'=>(array)$address,
		'profileAddressError'=>$address::getError(),
		'profileAddressSuccess'=>$address::getSuccess()
	]);

});

$app->post("/{language}/profile/addresses/{type}/delete", function($request, $response, $args) {

	User::verifyLogin(false, $args["language"]);

	$address = new Address($args["language"]);

	$address->setData([
		"idaddress"=>(int)$_POST["idaddress"]
	]);

	$orders = $address->getOrders($address);

	if (count($orders) !== 0) {

		Switch ($args["language"]) {

			Case "en":
				Address::setError("Address pending delivery. Deletion not allowed at this time.");
				break;

			Case "es":
				Address::setError("Dirección con entrega pendiente. Exclusión no permitida en este momento.");
				break;

			Case "pt":
				Address::setError("Endereço com entrega pendente. Exclusão não permitida nesse momento.");
				break;

		}
		
		header("location: /".$args["language"]."/profile/addresses/".$args["type"]);
		exit;

	}

	$address->delete($address);

	header("location: /".$args["language"]."/profile/addresses/".$args["type"]);
	exit;

});

$app->get("/{language}/profile/orders", function($request, $response, $args) {

	User::verifyLogin(false, $args["language"]);

	$user = User::getFromSession($args["language"]);

	// configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/profile";
	$pageConfig[4] = "/".$args["language"];

	// __construct (header)
	$page = new Page($pageConfig);

	$page->setTpl("profile-orders", [
		'orders'=>$user->getOrders()
	]);

});

$app->get("/{language}/profile/orders/{idorder}", function($request, $response, $args) {

	User::verifyLogin(false, $args["language"]);

	$order = new Order($args["language"]);

	$order->get((int)$args["idorder"]);

	$cart = new Cart($args["language"]);

	$cart->get((int)$order->getidcart());

	$cart->getCalculateTotal();

	// configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/profile";
	$pageConfig[4] = "/".$args["language"];

	// __construct (header)
	$page = new Page($pageConfig);

	$page->setTpl("profile-orders-details", [
		"cart"=>$cart->getValues(),
		"order"=>$order->getValues(),
		"products"=>$cart->getProducts()
	]);

});

$app->get("/{language}/order/{idorder}", function($request, $response, $args) {

	User::verifyLogin(false, $args["language"]);

	$order = new Order($args["language"]);

	$order->get((int)$args["idorder"]);

	// configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/store";
	$pageConfig[4] = "/".$args["language"];

	// __construct (header)
	$page = new Page($pageConfig);

	$page->setTpl("payment", [
		'order'=>$order->getValues()
	]);

});

$app->get("/{language}/profile/wishlist", function($request, $response, $args) {

	User::verifyLogin(false, $args["language"]);

	$user = User::getFromSession($args["language"]);

	// configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/profile";
	$pageConfig[4] = "/".$args["language"];

	// __construct (header)
	$page = new Page($pageConfig);


	$page->setTpl("profile-wishlist", [
		'wishlist'=>$user->getWishlist()
	]);

});

$app->post("/{language}/profile/wishlist/{operation}", function($request, $response, $args) {

/* operation:
   input, minus and plus from (profile-wishlist)
   include from (product-list)
*/
	if ($_POST["nrquantity"] === "") {
		header("Location: /".$args["language"]."/profile/wishlist");
		exit;
	}

	User::verifyLogin(false, $args["language"]);

	$wishList = new WishList($args["language"]);

	if (isset($_POST["idwishlist"])) {

		$wishList->get((int)$_POST["idwishlist"]);

	} else {

		$user = User::getFromSession($args["language"]);

//		$wishList->getByFK($user->getiduser(), (int)$_POST["idproduct"]);

	$wishList->setData([
		"iduser"=>$user->getiduser(),
		"idproduct"=>$_POST["idproduct"]
	]);

	}

	$wishList->setData([
		"nrquantity"=>($args["operation"] === "minus" ? $_POST["nrquantity"] - 1 : 
						($args["operation"] === "plus" ? $_POST["nrquantity"] + 1 : $_POST["nrquantity"]))
	]);

	$wishList->save();

	header("Location: /".$args["language"]."/profile/wishlist");
	exit;

});

/*
// Zipcode reading route
$app->post("/{language}/zipcode/{cdzipcode}", function($request, $response, $args) {

	User::verifyLogin(false, $args["language"]);

	$address = new Address($args["language"]);

	$address->setData([
		"idaddress"=>$_POST["idaddress"],
		"cdzipcode"=>$_POST["cdzipcode"]
	]);

	$address->get($address);

	$address->setData([
		"cdzipcode"=>$_POST["cdzipcode"]
	]);

	$address->loadFromZipCode($args["cdzipcode"]);

	// configure products page
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"];
	$pageConfig[4] = "/".$args["language"];

	// __construct (header)
	$page = new Page($pageConfig);

	$page->setTpl("profile-addresses", [
		"action"=>"edit",
		'idaddress'=>$args["idaddress"],
		'addresses'=>(array)$address,
		'profileAddressError'=>$address::getError(),
		'profileAddressSuccess'=>$address::getSuccess()
	]);

});
*/

/*
// rota para página de carrinho
$app->get("/cart", function() {

	$cart = Cart::getFromSession();

	$page = new Page();

	$page->setTpl("cart", [
		'cart'=>$cart->getValues(),
		'products'=>$cart->getProducts(),
		'error'=>Cart::getMsgError()
	]);

});

// rota para adicionar item do produto no carrinho na página e no banco de dados
$app->get("/cart/{idproduct}/plus", function($request, $response, $args) {

	$product = new Product();

	$product->get((int)$args["idproduct"]);

	// recupera ou inclui o carrinho na sessão
	$cart = Cart::getFromSession();

	// para o caso do usuário ter aumentado o quantitativo de compra do produto
	$qtd = (isset($_GET['qtd'])) ? (int)$_GET['qtd'] : 1;

	for ($i = 0; $i < $qtd; $i++) {

		$cart->addProduct($product);

	}

	header("Location: /cart");
	exit;

});

// rota para excluir um item do produto do carrinho na página e no banco de dados
$app->get("/cart/{idproduct}/minus", function($request, $response, $args) {

	$product = new Product();

	$product->get((int)$args["idproduct"]);

	// recupera ou inclui o carrinho na sessão
	$cart = Cart::getFromSession();

	$cart->removeProduct($product);

	header("Location: /cart");
	exit;

});

// rota para excluir todos os itens do produto do carrinho na página e no banco de dados
$app->get("/cart/{idproduct}/remove", function($request, $response, $args) {

	$product = new Product();

	$product->get((int)$args["idproduct"]);

	// recupera ou inclui o carrinho na sessão
	$cart = Cart::getFromSession();

	$cart->removeProduct($product, true);

	header("Location: /cart");
	exit;

});

// rota para cálculo de frete
$app->post("/cart/freight", function() {

	$cart = Cart::getFromSession();

	$cart->setFreight($_POST['zipcode']);

	header("Location: /cart");
	exit;

});

// rota para página da finalização da compra
$app->get("/checkout", function() {

	User::verifyLogin(false);

	$address = new Address();

	$cart = Cart::getFromSession();

	// se o CEP já existir no carrinho: carrega em $_GET o CEP do carrinho
	if (isset($_GET['zipcode'])) {

		$_GET['zipcode'] = $cart->getdeszipcode();

	}

	// verifica se o cep foi informado
	if (isset($_GET['zipcode'])){

		// lê os dados de endereço do cep
		$address->loadFromCEP($_GET['zipcode']);
		
		// atribui o novo cep ao carrinho
		$cart->setdeszipcode($_GET['zipcode']);

		// salva os novos dados no banco de dados
		$cart->save();

		// refaz o cálculo dos valores de frete
		$cart->getCalculateTotal();

	}

	// define os dados no carrinho, mesmo que com conteúdos vazios
	if (!$address->getdesaddress()) $address->setdesaddress('');
	if (!$address->getdesnumber()) $address->setdesnumber('');
	if (!$address->getdescomplement()) $address->setdescomplement('');
	if (!$address->getdesdistrict()) $address->setdesdistrict('');
	if (!$address->getdescity()) $address->setdescity('');
	if (!$address->getdesstate()) $address->setdesstate('');
	if (!$address->getdescountry()) $address->setdescountry('');
	if (!$address->getdeszipcode()) $address->setdeszipcode('');

	$page = new Page();

	$page->setTpl("checkout", [
		'cart'=>$cart->getValues(),
		'address'=>$address->getValues(),
		'products'=>$cart->getProducts(),
		'error'=>$address::getMsgError()
	]);

});

// rota para salvar dados
$app->post("/checkout", function() {

	User::verifyLogin(false);

	// valida o preenchimento dos campos do formulário
	if (!isset($_POST['zipcode']) || $_POST['zipcode'] === ''){
		Address::setMsgError('Informe o CEP.');
		header("Location: /checkout");
		exit;
	}

	if (!isset($_POST['desaddress']) || $_POST['desaddress'] === ''){
		Address::setMsgError('Informe o endereço.');
		header("Location: /checkout");
		exit;
	}

	if (!isset($_POST['desdistrict']) || $_POST['desdistrict'] === ''){
		Address::setMsgError('Informe o bairro.');
		header("Location: /checkout");
		exit;
	}

	if (!isset($_POST['descity']) || $_POST['descity'] === ''){
		Address::setMsgError('Informe a cidade.');
		header("Location: /checkout");
		exit;
	}

	if (!isset($_POST['desstate']) || $_POST['desstate'] === ''){
		Address::setMsgError('Informe o estado.');
		header("Location: /checkout");
		exit;
	}

	if (!isset($_POST['descountry']) || $_POST['descountry'] === ''){
		Address::setMsgError('Informe o país.');
		header("Location: /checout");
		exit;
	}

	$user = User::getFromSession();
	$user->get($user->getiduser());

	// sobrescrevendo o zipcode porque o campo no formulário não está com o mesmo nome do banco
	$_POST['deszipcode'] = $_POST['zipcode'];

	$_POST['idperson'] = $user->getidperson();

	$address = new Address();
	$address->setData($_POST);

	$address->save();

	$cart = Cart::getFromSession();

	$totals = $cart->getCalculateTotal();

	$order = new Order();

	// não consegui fazer o getidaddress retornar o sequencial do novo endereço
	// get de qualquer atributo da tabela está vazio na volta do save(), embora
	// o $this no método contenha todos os atributos e seus respectivos valores
	$order->setData([
		'idcart'=>$cart->getidcart(),
		//'idaddress'=>$address->getidaddress(),
		'idaddress'=>$address->getValues()['idaddress'],
		'iduser'=>$user->getiduser(),
		'idstatus'=>OrderStatus::EM_ABERTO,
		'vltotal'=>$cart->getvltotal()
	]);

	$order->save();

	switch ((int)$_POST['payment-method']) {
		
		case 1:
			header('Location: /order/'.$order->getidorder().'/pagseguro');
			break;
		
		case 2:
			header('Location: /order/'.$order->getidorder().'/paypal');
			break;

		case 3:
			header('Location: /order/'.$order->getidorder());
			break;

	}
	
	exit;

});

// rota para página de pagseguro
$app->get("/order/{idorder}/pagseguro", function($request, $response, $args) {

	User::verifyLogin();

	$page = new Page([
		'header'=>false,
		'footer'=>false
	]);

	$order = new Order();

	$order->get((int)$args["idorder"]);

	$cart = $order->getCart();

	$page->setTpl("payment-pagseguro", [
		'order'=>$order->getValues(),
		'cart'=>$cart->getValues(),
		'products'=>$cart->getProducts(),
		'phone'=> [
			'areacode'=>substr($order->getnrphone(), 0, 2),
			'number'=>substr($order->getnrphone(), 2, strlen($order->getnrphone()))
		]
	]);

});

// rota para página de paypal
$app->get("/order/{idorder}/paypal", function($request, $response, $args) {

	User::verifyLogin();

	$page = new Page([
		'header'=>false,
		'footer'=>false
	]);

	$order = new Order();

	$order->get((int)$args["idorder"]);

	$cart = $order->getCart();

	$page->setTpl("payment-paypal", [
		'order'=>$order->getValues(),
		'cart'=>$cart->getValues(),
		'products'=>$cart->getProducts()
	]);

});

// rota para a página de login
$app->get("/login", function() {

	$page = new Page();

	$page->setTpl("login", [
		'error'=>User::getError(),
		'errorRegister'=>User::getErrorRegister(),
		'registerValues'=>isset($_SESSION['registerValues']) ? $_SESSION['registerValues'] : [
			'name'=>'',
			'email'=>'',
			'phone'=>''
		]
	]);

});

// rota para a validação do login
$app->post("/login", function() {

	try {

		User::login($_POST['login'], $_POST['password']);

	} catch(Exception $e) {
//echo 'www ----- ';
//echo $e->getMessage();
//echo ' ----- www';
		User::setError($e->getMessage());

	}

	header("Location: /checkout");
	exit;

});

// rota para a página de login
$app->get("/logout", function() {

	User::logout();
	$page = new Page();

	header("Location: /login");
	exit;

});

// rota para o cadastro de um novo usuário
$app->post("/register", function() {

	// guardar os dados digitados pelo usuário em uma sessão
	// utilizada para o caso de ter algum erro no cadastro e não limpar os campos da página
	$_SESSION['registerValues'] = $_POST;

	// validação de campos obrigatórios da página
	if (!isset($_POST['name']) || $_POST['name'] == '') {

		User::setErrorRegister("Preencha o seu nome.");
		header('Location: /login');
		exit;

	}

	if (!isset($_POST['email']) || $_POST['email'] == '') {

		User::setErrorRegister("Preencha o seu e-mail.");
		header('Location: /login');
		exit;

	}

	if (!isset($_POST['password']) || $_POST['password'] == '') {

		User::setErrorRegister("Preencha a senha.");
		header('Location: /login');
		exit;

	}

	// verifica se o usuário já existe
	if (User::checkLoginExist($_POST['email']) === true) {

		User::setErrorRegister("Esse endereço de e-mail já está sendo utilizado por outro usuário.");
		header('Location: /login');
		exit;

	}

	$user = new User();

	$user->setData([
		'inadmin'=>0,
		'desperson'=>$_POST['name'],
		'deslogin'=>$_POST['email'],
		'desemail'=>$_POST['email'],
		'despassword'=>$_POST['password'],
		'nrphone'=>$_POST['phone']
	]);

	// autentica o usuário
	// caso isso não seja feito, a rota de checkout irá redirecionar para a rota de login
	// (o usuário precisa estar logado para acessar a rota de checkout)
	$user->insert();

	User::login($_POST['email'], $_POST['password']);

	header('Location: /checkout');
	exit;

});

// rota de recuperação de senha (forgot)
$app->get("/forgot", function() {

	// __construct (header)
	$page = new Page();

	// body
	$page->setTpl("forgot");

});

// rota de salvar senha de recuperação no banco (forgot)
$app->post("/forgot", function() {
	
	$user = User::getForgot($_POST["email"], false);

	header("location: /forgot/sent");
	exit;

});

// rota de janela de senha enviada (forgot)
$app->get("/forgot/sent", function() {

	// __construct (header)
	$page = new Page();

	// body
	$page->setTpl("forgot-sent");

});

// rota de janela de reset de senha
$app->get("/forgot/reset", function() {

	$user = User::validForgotDecrypt($_GET["code"], $_GET["iv"]);

	// __construct (header)
	$page = new Page();

	// body
	$page->setTpl("forgot-reset", array(
		"name"=>$user["desperson"],
		"code"=>$_GET["code"],
		"iv"=>$_GET["iv"]
	));

});

// rota para salvar a senha de reset no banco
$app->post("/forgot/reset", function() {

	$forgot = User::validForgotDecrypt($_POST["code"], $_POST["iv"]);

	User::setForgotUsed($forgot["idrecovery"]);

	$user = new User();

	$user->get((int)$forgot["iduser"]);

	$password = password_hash($_POST["password"], PASSWORD_DEFAULT, [
		"cost"=>12
	]);

	$user->setPassword($password);

	// __construct (header)
	$page = new Page();

	// body
	$page->setTpl("forgot-reset-success");

});

// rota para página de edição dos dados do usuário
$app->get("/profile", function() {

	User::verifyLogin(false);

	$user = User::getFromSession();

	$page = new Page();

	$page->setTpl("profile", [
		'user'=>$user->getValues(),
		'profileMsg'=>User::getSuccess(),
		'profileError'=>User::getError()
	]);

});

// rota para salvar dados alterados no banco
$app->post("/profile", function() {

	User::verifyLogin(false);

	// validação de campos obrigatórios da página
	if (!isset($_POST['desperson']) || $_POST['desperson'] === '') {

		User::setError("Preencha o seu nome.");
		header('Location: /profile');
		exit;

	}

	if (!isset($_POST['desemail']) || $_POST['desemail'] === '') {

		User::setErrorRegister("Preencha o seu e-mail.");
		header('Location: /profile');
		exit;

	}

	$user = User::getFromSession();

	// verifica se o usuário já existe
	if ($_POST['desemail'] !== $user->getdesemail()) {

		if (User::checkLoginExist($_POST['desemail']) === true) {

			// retorna os valores informados pelo usuário para a sessão
			// no get do profile, esses valores serão lidos e reexibidos nos campos da página
			$_SESSION[User::SESSION] = $_POST;

			User::setError("Esse endereço de e-mail já está sendo utilizado por outro usuário.");
			header('Location: /profile');
			exit;

		}

	}

	// evita command injection para alterar o usuário para administrador
	// sobrescrevendo uma possível alteração pelo inadmin e pela senha
	// originais salvas no banco de dados
	$_POST['iduser'] = $user->getiduser();
	$_POST['inadmin'] = $user->getinadmin();
	$_POST['despassword'] = $user->gedespassword();

	// o login é o mesmo que o e-mail para os usuários do site
	$_POST['deslogin'] = $_POST['desemail'];

	$user->setData($_POST);

	$user->update();

	$_SESSION[User::SESSION] = $user->getValues();

	User::setSuccess("Dados alterados com sucesso!");

	header("location: /profile");
	exit;

});

$app->get("/order/{idorder}", function($request, $response, $args) {

	User::verifyLogin(false);

	$order = new Order();

	$order->get((int)$args["idorder"]);

	$page = new Page();

	$page->setTpl("payment", [
		'order'=>$order->getValues()
	]);

});

$app->get("/boleto/{idorder}", function($request, $response, $args) {

	User::verifyLogin(false);

	$order = new Order();

	$order->get((int)$args["idorder"]);

	// dados de configuração de boleto do banco Itaú (copiados de /res/boletophp/boleto_itau.php) 

	// DADOS DO BOLETO PARA O SEU CLIENTE
	$dias_de_prazo_para_pagamento = 10;
	$taxa_boleto = 5.00;
	$data_venc = date("d/m/Y", time() + ($dias_de_prazo_para_pagamento * 86400));  // Prazo de X dias OU informe data: "13/04/2006"; 
	$valor_cobrado = formatBR($order->getvltotal()); // Valor - REGRA: Sem pontos na milhar e tanto faz com "." ou "," ou com 1 ou 2 ou sem casa decimal
	$valor_cobrado = str_replace(".", "",$valor_cobrado);
	$valor_cobrado = str_replace(",", ".",$valor_cobrado);
	$valor_boleto=number_format($valor_cobrado+$taxa_boleto, 2, ',', '');

	$dadosboleto["nosso_numero"] = $order->getidorder();  // Nosso numero - REGRA: Máximo de 8 caracteres!
	$dadosboleto["numero_documento"] = $order->getidorder();	// Num do pedido ou nosso numero
	$dadosboleto["data_vencimento"] = $data_venc; // Data de Vencimento do Boleto - REGRA: Formato DD/MM/AAAA
	$dadosboleto["data_documento"] = date("d/m/Y"); // Data de emissão do Boleto
	$dadosboleto["data_processamento"] = date("d/m/Y"); // Data de processamento do boleto (opcional)
	$dadosboleto["valor_boleto"] = $valor_boleto; 	// Valor do Boleto - REGRA: Com vírgula e sempre com duas casas depois da virgula

	// DADOS DO SEU CLIENTE
	$dadosboleto["sacado"] = $order->getdesperson();
	$dadosboleto["endereco1"] = $order->getdesaddress() . " - " . $order->getdesdistrict(). " ";
	$dadosboleto["endereco2"] = $order->getdescity(). " - " . $order->getdesstate(). " - " . $order->getdescountry() . " - CEP: " . $order->getdeszipcode();

	// INFORMACOES PARA O CLIENTE
//	$dadosboleto["demonstrativo1"] = "Pagamento de Compra na Loja Brasil en Casa E-commerce";
//	$dadosboleto["demonstrativo2"] = "Taxa bancária - 0,00 €";
//	$dadosboleto["demonstrativo3"] = "";
//	$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar multa de 2% após o vencimento";
//	$dadosboleto["instrucoes2"] = "- Receber até 10 dias após o vencimento";
//	$dadosboleto["instrucoes3"] = "- Em caso de dúvidas entre em contato conosco: suporte@brasilencasa.com";
//	$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema Projeto Loja Brasil en Casa E-commerce - www.brasilencasa.com";

	$dadosboleto["demonstrativo1"] = "Pago de Compra en la tienda Brasil en Casa E-commerce";
	$dadosboleto["demonstrativo2"] = "Tasa bancaria - 0,00 €";
	$dadosboleto["demonstrativo3"] = "";
	$dadosboleto["instrucoes1"] = "- Sr. Caixa, cobrar una multa del 2% después del vencimiento";
	$dadosboleto["instrucoes2"] = "- Recibir hasta 10 días después del vencimiento";
	$dadosboleto["instrucoes3"] = "- En caso de duda entre en contacto con nosotros: suporte@brasilencasa.com";
	$dadosboleto["instrucoes4"] = "&nbsp; Emitido pelo sistema Projeto Loja Brasil en Casa E-commerce - www.brasilencasa.com";

	// DADOS OPCIONAIS DE ACORDO COM O BANCO OU CLIENTE
	$dadosboleto["quantidade"] = "";
	$dadosboleto["valor_unitario"] = "";
	$dadosboleto["aceite"] = "";		
	$dadosboleto["especie"] = "R$";
	$dadosboleto["especie_doc"] = "";


	// ---------------------- DADOS FIXOS DE CONFIGURAÇÃO DO SEU BOLETO --------------- //


	// DADOS DA SUA CONTA - ITAÚ
	$dadosboleto["agencia"] = "1690"; // Num da agencia, sem digito
	$dadosboleto["conta"] = "48781";	// Num da conta, sem digito
	$dadosboleto["conta_dv"] = "2"; 	// Digito do Num da conta

	// DADOS PERSONALIZADOS - ITAÚ
	$dadosboleto["carteira"] = "175";  // Código da Carteira: pode ser 175, 174, 104, 109, 178, ou 157

	// SEUS DADOS
	$dadosboleto["identificacao"] = "Brasil en Casa";
	$dadosboleto["cpf_cnpj"] = "11.111.111/0001-01";
	$dadosboleto["endereco"] = "Rua Voluntário da Pátria, 37 - Botafogo, 22270-000";
	$dadosboleto["cidade_uf"] = "Rio de Janeiro - RJ";
	$dadosboleto["cedente"] = "BRASIL EN CASA";

	// NÃO ALTERAR!
	$path = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "res" . DIRECTORY_SEPARATOR . "boletophp". DIRECTORY_SEPARATOR . "include" . DIRECTORY_SEPARATOR;
	require_once($path . "funcoes_itau.php"); 
	require_once($path . "layout_itau.php");
});

$app->get("/profile/orders", function() {

	User::verifyLogin(false);

	$user = User::getFromSession();

	$page = new Page();

	$page->setTpl("profile-orders", [
		'orders'=>$user->getOrders()
	]);

});

$app->get("/profile/orders/{idorder}", function($request, $response, $args) {

	User::verifyLogin(false);

	$order = new Order();

	$order->get((int)$args["idorder"]);

	$cart = new Cart();

	$cart->get((int)$order->getidcart());

	$cart->getCalculateTotal();

	$page = new Page();

	$page->setTpl("profile-orders-detail", [
		'cart'=>$cart->getValues(),
		'order'=>$order->getValues(),
		'products'=>$cart->getProducts()
	]);

});

$app->get("/profile/change-password", function() {

	User::verifyLogin(false);

	$page = new Page();

	$page->setTpl("profile-change-password", [
		'changePassError'=>User::getError(),
		'changePassSuccess'=>User::getSuccess()
	]);

});

$app->post("/profile/change-password", function() {

	User::verifyLogin(false);

	if (!isset($_POST['current_pass']) || $_POST['current_pass'] === '') {

//		User::setError('Digite a senha atual.');
		User::setError('Introduzca la contraseña actual.');
		
		header('Location: /profile/change-password');
		exit;

	}

	if (!isset($_POST['new_pass']) || $_POST['new_pass'] === '') {

//		User::setError('Digite a nova senha.');
		User::setError('Introduzca la nueva contraseña.');
		
		header('Location: /profile/change-password');
		exit;

	}

	if (!isset($_POST['new_pass_confirm']) || $_POST['new_pass_confirm'] === '') {

//		User::setError('Confirme a nova senha.');
		User::setError('Confirme la nueva contraseña.');
		
		header('Location: /profile/change-password');
		exit;

	}

	if ($_POST['current_pass'] === $_POST['new_pass']) {

//		User::setError('A nova senha deve ser diferente da atual.');
		User::setError('La nueva contraseña debe ser diferente de la actual.');
		
		header('Location: /profile/change-password');
		exit;

	}

	if ($_POST['new_pass'] !== $_POST['new_pass_confirm']) {

//		User::setError('A senha de confirmação deve ser igual à nova senha.');
		User::setError('La contraseña de confirmación debe ser igual a la nueva contraseña.');
		
		header('Location: /profile/change-password');
		exit;

	}

	$user = User::getFromSession();
	$user->get($user->getiduser());

	if(!password_verify($_POST['current_pass'], $user->getdespassword())) {

//		User::setError('A senha atual está inválida.');
		User::setError('La contraseña actual no es válida.');
		
		header('Location: /profile/change-password');
		exit;

	}

	$user->setdespassword($_POST['new_pass']);

	$user->update();

//	User::setSuccess('Senha alterada com sucesso.');
	User::setSuccess('Contraseña alterada con éxito.');

	header('Location: /profile/change-password');
	exit;

});
*/?>
