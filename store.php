<?php

use \Tila\Page;
//use \Tila\PageAdmin;
use \Tila\Model\Address;
use \Tila\Model\Cart;
use \Tila\Model\CartProduct;
use \Tila\Model\Category;
use \Tila\Model\Order;
use \Tila\Model\OrderStatus;
use \Tila\Model\Product;
use \Tila\Model\Recipe;
use \Tila\Model\Review;
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

	$cart = Cart::getFromSession($language);

	/* Page configuration */
	$pageConfig[2] = $language;
	$pageConfig[3] = $menu;
	$pageConfig[5] = $cart->getValues();
	$pageConfig[6] = $cart->getProducts();
	$pageConfig[7] = "";

}

/* Root page route */
$app->get("/", function() {

/*

$product = new Product("en");
$product->prepareFetchSearch($sql, $stmt, 'a');
echo '000';
print_r($product->fecthSearch($sql, $stmt));
echo '111';
//print_r($page["data"]["nmproduct"]);
//print_r($product->getPageSearch($args["searchFilter"],$start,5));
//$result = $product->fetch($stm, \PDO::FECTH_ASSOC);
exit;
*/
	// Set default language
	$language = "en";

	// Configure products page
	mainMenu($language, $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $language;
	$pageConfig[4] = $language;

	$page = new Page($pageConfig);

	// Tpl configuration and drawning
	$page->setTpl("index", [
		"menu"=>$menu
	]);

});

/* Language page route */
$app->get("/{language}", function($request, $response, $args) {

	// Configure products page
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"];
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	// Tpl configuration and drawning
	$page->setTpl("index", [
		"menu"=>$menu
	]);

});

/* About page route */
$app->get("/{language}/about", function($request, $response, $args) {

	// Configure products page
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/about";
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	// Tpl configuration and drawning
	$page->setTpl("about", [
		"menu"=>$menu
	]);

});

/* Contact page route */
$app->get("/{language}/contact", function($request, $response, $args) {

	// Configure products page
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/contact";
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	// Tpl configuration and drawning
	$page->setTpl("contact", [
		"menu"=>$menu
	]);

});

/* Recipe page route */
$app->get("/{language}/recipes", function($request, $response, $args) {

	// Configure products page
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/recipe";
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	$recipe = new Recipe($args["language"]);

	// Tpl configuration and drawning
	$page->setTpl("recipes", [
		// Passes null recipe
		"recipes"=>$recipe
	]);

});

/* Recipe by product page route */
$app->get("/{language}/recipes/{dsurl}", function($request, $response, $args) {

	// Configure products page
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/recipe";
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	/* Loading products */
	$product = new Product($args["language"]);

	// Read product from URL name
	$product->getFromURL($args["dsurl"],10);

	$recipe = new Recipe($args["language"]);

	// Set recipe product ID
	$recipe->setData([
		"idproduct"=>$product->getidproduct()
	]);

	$page->setTpl("recipes", [
		// Load recipe by product ID
		"recipes"=>$recipe->getByProduct()
	]);

});

/* Products page route */
$app->get("/{language}/products", function($request, $response, $args) {

	// Configure products page
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Set default order */
	$order = "AZ";

	// Loading products
	$product = new Product($args["language"]);

	/* Page configuration */
	$pageConfig[0] = "header-compact";
	$pageConfig[1] = $args["language"]."/product";
	$pageConfig[4] = "/".$args["language"]."/products";

	$page = new Page($pageConfig);

	// Tpl configuration and drawning
	$page->setTpl("product-list", [
		"menu"=>$menu,
		// Sort registers by user chosen
		"sort"=>$order,
		// Load all products
		"products"=>$product->listAll()
	]);

});

/* Route to read from DB. Two cases:
   1 - Read all products from DB
   2 - Read products filtered by Product sub-menu items
*/
$app->post("/{language}/products", function($request, $response, $args) {

	// Configure products page
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Loading products */
	$product = new Product($args["language"]);

	/* Sort configuration */
	// Used to order data in Product
	$order = "t.nmproduct ASC";

	if (isset($_POST["sort"])) {

		Switch ($_POST["sort"]) {

			Case "AZ":
				$order = "t.nmproduct ASC";
				break;

			Case "ZA":
				$order = "t.nmproduct DESC";
				break;

			Case "LP":
				$order = "p.vlprice ASC";
				break;

			Case "HP":
				$order = "p.vlprice DESC";
				break;

			Case "BS":
				$order = "p.qtvenda DESC";
				break;

			Case "LS":
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

	$page = new Page($pageConfig);

	// Tpl configuration and drawning
	$page->setTpl("product-list", [
		"menu"=>$menu,
		// Sort registers by user chosen or by its initial ordering
		"sort"=>isset($_POST["sort"]) ? $_POST["sort"] : "AZ",
		// Load products chosen by user
		"products"=>$product->listByArgs($filter,$order)
	]);

});

/* Route to read from DB the search string typed by user */
$app->post("/{language}/products/catalogsearch/{searchFilter}", function($request, $response, $args) {

	// Configure products page
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Loading products */
	$product = new Product($args["language"]);
	$products = $product->listBySearch($args["searchFilter"], $limit = 10000);

	/* Page configuration */
	$pageConfig[0] = "header-compact";
	$pageConfig[1] = $args["language"]."/product";
	$pageConfig[4] = "/".$args["language"]."/products";
	$pageConfig[7] = $args["searchFilter"];

	$page = new Page($pageConfig);

	// Tpl configuration and drawning
	$page->setTpl("product-list", [
		"menu"=>$menu,
		// Sort registers by its initial ordering
		"sort"=>"AZ",
		// Load products chosen by user
		"products"=>$products["data"]
	]);

});

/* Route to read from DB the search string typed by user (for each character typed) */
$app->post("/{language}/products/livesearch/{searchFilter}", function($request, $response, $args) {

	// Configure products page
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	$product = new Product($args["language"]);
	$products = $product->listBySearch($args["searchFilter"], $limit = 10000);

	if (sizeOf($products["data"]) === 0) {
		$html = "";
	} else {

		$html = "<div class='row no-gutters title'>
					<div class='col-9 d-flex justify-content-start'>
						<h6>Products (".$products["total"].")</h6>
					</div>

					<div class='col-3 d-flex justify-content-end view-all'>
						<a class='dropdown-item pt-1 mr-1' href='javascript:void(0);' onclick='submitSearchForm()'>View All</a>
					</div>
				</div>
			";

		foreach ($products["data"] as $key => $value) {

			$html .= "
					<div class='row no-gutters products'>
						<div class='col-3'>
							<a class='dropdown-item pt-2 pl-1' href='/en/products/".$value["nmproduct"]."' ".
							($key === 0 ? "style='border-top: none'" : "").
							"><img alt='".$value["nmproduct"]."' src='/assets/img/products/product".$value["idproduct"].".jpg'>
							</a>
						</div>

						<div class='col-7 middle'>
						<a class='dropdown-item' href='/en/products/".$value["dsurl"]."' ".
						($key === 0 ? "style='border-top: none'>" : ">").$value["nmproduct"]."</a>
						</div>

						<div class='col-2 middle'>
							<a class='dropdown-item d-flex justify-content-end pr-2' href='/en/products/".$value["dsurl"]."' ".
							($key === 0 ? "style='border-top: none'>" : ">").$value["vlprice"]." €</a>
						</div>
					</div>
					
					<hr class=''>
				";

		}

	}

	echo $html;
	exit;

});

/* Product details page route */
$app->get("/{language}/products/{dsurl}", function($request, $response, $args) {

	// Configure products page
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Loading products */
	$product = new Product($args["language"]);

	// Read product from URL name
	$product->getFromURL($args["dsurl"]);

	/* Page configuration */
	$pageConfig[0] = "header";

	$recipe = new Recipe($args["language"]);

	if ($product->getidproduct() == "") {
		$pageConfig[1] = $args["language"];
		$pageConfig[4] = "/".$args["language"];
		
		$page = new Page($pageConfig);

		$page->setTpl("404", [
		]);
		exit;

	}

	$pageConfig[1] = $args["language"]."/product";
	$pageConfig[4] = "/".$args["language"]."/products";

	// Set product ID
	$recipe->setData([
		"idproduct"=>$product->getidproduct()
	]);

	$page = new Page($pageConfig);

	// Tpl configuration and drawning
	$page->setTpl("product-detail", [
		// Load values of current product
		"product"=>$product->getValues(),
		// Load categories of current product
		"categories"=>$product->getCategories(),
		// Load recipes of current product
		"recipes"=>$recipe->getByProduct()
	]);

});

/* Product review DB action route */
$app->post("/{language}/products/review/save", function($request, $response, $args) {

	// Configure products page
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	$review = new Review($args["language"]);

	// Read session user
	$user = User::getFromSession($args["language"]);

	// Set review register values
	$review->setData([
		"idreview"=>0,
		"idproduct"=>$_POST["idproduct"],
		"iduser"=>$user->getiduser() !== null ? $user->getiduser() : 0,
		"nmname"=>$_POST["name"],
		"dsemail"=>$_POST["email"],
		"vlreview"=>$_POST["rating"],
		"dsreview"=>$_POST["review"]
	]);

	// Saves review
	$review->save();

	/* Loading products */
	$product = new Product($args["language"]);

	$product->get($_POST["idproduct"]);

	// Head page to current product
	header("Location: /".$args["language"]."/products/".$product->getdsurl());
	exit;

});

/* Login page route */
$app->get("/{language}/login", function($request, $response, $args) {

	// Configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/admin";
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	// Tpl configuration and drawning
	$page->setTpl("login", [
		"error"=>User::getError(),
		"errorRegister"=>User::getErrorRegister(),
		"registerValues"=>isset($_SESSION["registerValues"]) ? $_SESSION["registerValues"] : [
			"name"=>"",
			"email"=>"",
			"phone"=>""
		]
	]);

});

/* Login validation route */
$app->post("/{language}/login", function($request, $response, $args) {

	try {

		// Try to validate data entered by user
		User::login($_POST["reg-email"], $_POST["reg-password"], $args["language"]);

	} catch(Exception $e) {

		User::setError($e->getMessage());

	}

//	header("Location: /".$args["language"]."/store/checkout");
	header("Location: /".$args["language"]."/products");
	exit;

});

/* Logout action route */
$app->get("/{language}/logout", function($request, $response, $args) {

	// Logout process
	User::logout();

	// Configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/store";
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	header("Location: /".$args["language"]."/login");
	exit;

});

/* New user register route */
$app->post("/{language}/register", function($request, $response, $args) {

	// Saving data typed by user in a session
	// In case of register error occurrency
	$_SESSION["registerValues"] = $_POST;

	$user = new User($args["language"]);

	// Set user  register values
	$user->setData([
		"inadmin"=>0,
		"dsemail"=>$_POST["new-email"],
		"nmfirst"=>$_POST["new-firstname"],
		"nmlast"=>$_POST["new-lastname"],
		"cdpassword"=>$_POST["newpassword"],
		"tptitle"=>$_POST["title"],
		"nrphone"=>$_POST["new-phone"]
	]);

	// Saves user
	$user->insert();

	// User autentication
	// If this is not done the checkout route will redirect to login route
	// (the user must be logged in to access the checkout route)
	User::login($_POST["new-email"], $_POST["newpassword"], $args["language"]);

//	header("Location: /".$args["language"]."/checkout");
	header("Location: /".$args["language"]."/profile");
	exit;

});

/* User data edit page route */
$app->get("/{language}/profile", function($request, $response, $args) {

	// User must be logged in
	User::verifyLogin(false, $args["language"]);

	// Read session user
	$user = User::getFromSession($args["language"]);

	// Configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/profile";
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	// Tpl configuration and drawning
	$page->setTpl("profile", [
		"user"=>$user->getValues(),
		"profileMsg"=>User::getSuccess(),
		"profileError"=>User::getError()
	]);

});

/* Page route for Saving data profile in DB */
$app->post("/{language}/profile", function($request, $response, $args) {

	// User must be logged in
	User::verifyLogin(false, $args["language"]);

	// Set user data from session
	$user = User::getFromSession($args["language"]);

	if ($_POST["dsemail"] !== $user->getdsemail()) {

		// Check user
		if (User::checkLoginExist($_POST["dsemail"]) === true) {

			// Saves typed user data in session
			// Data will be read at profile get route
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

	// Avoids "injection command" to change user type to admnistrator or user password
	// Overwriting data by original values read from DB
	$_POST["iduser"] = $user->getiduser();
	$_POST["inadmin"] = $user->getinadmin();
	$_POST["password"] = $user->getcdpassword();

	// Set typed data
	$user->setData($_POST);

	// Saves user
	$user->update();

	$_SESSION[User::SESSION] = $user->getValues();

	Switch ($args["language"]) {

		Case "en":
			User::Setuccess("Data changed successfully!");
			break;

		Case "es":
			User::Setuccess("¡Datos alterados con éxito!");
			break;

		Case "pt":
			User::Setuccess("Dados alterados com sucesso!");
			break;

	}

	header("location: /".$args["language"]."/profile");
	exit;

});

/* Password recovery page route (forgot) */
$app->get("/{language}/forgot", function($request, $response, $args) {

	// Configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/store";
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	$page->setTpl("forgot");

});

/* Page route to save password recovery in DB (forgot) */
$app->post("/{language}/forgot", function($request, $response, $args) {

	// Saves data
	$user = User::getForgot($_POST["email"], $args["language"], false);

	header("location: /".$args["language"]."/forgot/sent");
	exit;

});

/* Password sending page route (forgot) */
$app->get("/{language}/forgot/sent", function($request, $response, $args) {

	// Configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/store";
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	$page->setTpl("forgot-sent");

});

/* Password reset page route */
$app->get("/{language}/forgot/reset", function($request, $response, $args) {

	// Password decryption
	$user = User::validForgotDecrypt($_GET["code"], $_GET["iv"]);

	// Configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/store";
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	$page->setTpl("forgot-reset", array(
		"name"=>$user["nmfirst"],
		"code"=>$_GET["code"],
		"iv"=>$_GET["iv"]
	));

});

/* Page route to save password in DB */
$app->post("/{language}/forgot/reset", function($request, $response, $args) {

	// Password decryption
	$forgot = User::validForgotDecrypt($_POST["code"], $_POST["iv"]);

	// Saves ID recovery in DB
	User::setForgotUsed($forgot["idrecovery"]);

	$user = new User($args["language"]);

	// Read user ID
	$user->get((int)$forgot["iduser"]);

//	$password = USER::getPasswordHash($_POST["password"]);

	// Set new password in DB
	$user->setPassword($_POST["password"]);

	// Configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/store";
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	$page->setTpl("forgot-reset-success");

});

/* Password change page route */
$app->get("/{language}/profile/change-password", function($request, $response, $args) {

	// User must be logged in
	User::verifyLogin(false, $args["language"]);

	// Set user from session
	$user = User::getFromSession($args["language"]);

	// Configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/profile";
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	$page->setTpl("profile-change-password", [
		"user"=>$user->getValues(),
		"changePassError"=>User::getError(),
		"changePassSuccess"=>User::getSuccess()
	]);

});

/* Route to save password in DB */
$app->post("/{language}/profile/change-password", function($request, $response, $args) {

	// User must be logged in
	User::verifyLogin(false, $args["language"]);

	// Set user from session
	$user = User::getFromSession($args["language"]);

	// Read data from DB
	$user->get($user->getiduser());

	// Saves password in DB
	$user->setPassword($_POST["newpassword"]);

	Switch ($args["language"]) {

		Case "en":
			User::Setuccess("Password changed successfully.");
			break;

		Case "es":
			User::Setuccess("Contraseña alterada con éxito.");
			break;

		Case "pt":
			User::Setuccess("Senha alterada com sucesso.");
			break;

	}

	header("Location: /".$args["language"]."/profile/change-password");
	exit;

});

/* Address type (billing or shipping) page route */
$app->get("/{language}/profile/addresses/{type}", function($request, $response, $args) {

	// User must be logged in
	User::verifyLogin(false, $args["language"]);

	// Set user from session
	$user = User::getFromSession($args["language"]);

	$address = new Address($args["language"]);

	// Configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/profile";
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	$page->setTpl("profile-addresses", [
		"action"=>"read",
		"type"=>$args["type"],
		"addresses"=>$user->getAddresses(strtoupper(substr($args["type"], 0, 1))),
		"profileAddressError"=>$address::getError(),
		"profileAddressSuccess"=>$address::getSuccess()
	]);

});

/* New address page route */
$app->get("/{language}/profile/addresses/{type}/new", function($request, $response, $args) {

	// User must be logged in
	User::verifyLogin(false, $args["language"]);

	// Configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/profile";
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	$page->setTpl("profile-addresses", [
		"action"=>"new",
		"type"=>$args["type"],
		"idperson"=>$_SESSION["User"]["idperson"],
		"profileAddressError"=>"",
		"profileAddressSuccess"=>""
	]);

});

/* Edit address page route */
$app->post("/{language}/profile/addresses/{type}/save", function($request, $response, $args) {

	// User must be logged in
	User::verifyLogin(false, $args["language"]);

	$address = new Address($args["language"]);

	// Set address data using user data typed
	$address->setData([
		"idaddress"=>isset($_POST["idaddress"]) ? $_POST["idaddress"] : "",
		"idperson"=>$_SESSION["User"]["idperson"],
		"dsnumber"=>$_POST["dsnumber"],
		"dsaddress"=>$_POST["dsaddress"],
		"dscity"=>$_POST["dscity"],
		"dscountry"=>$_POST["dscountry"],
		"cdzipcode"=>$_POST["cdzipcode"],
		"tpaddress"=>$_POST["tpaddress"],
		"fldefault"=>isset($_POST["fldefault"]) ? $_POST["fldefault"] : "N",
		"flreplicate"=>isset($_POST["flreplicate"]) ? $_POST["flreplicate"] : "N"
	]);

	// Saves address in DB
	$address->save();

	header("location: /".$args["language"]."/profile/addresses/".$args["type"]);
	exit;

});

/* Detail edit address page route */
$app->get("/{language}/profile/addresses/{type}/edit/{idaddress}/{seqaddress}", function($request, $response, $args) {

	// User must be logged in
	User::verifyLogin(false, $args["language"]);

	$address = new Address($args["language"]);

	// Set ID address
	$address->setData([
		"idaddress"=>$args["idaddress"]
	]);

	// Read address from DB
	$address->get($address);

	// Configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/profile";
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	$page->setTpl("profile-addresses", [
		"action"=>"edit",
		"type"=>$args["type"],
		"seqaddress"=>$args["seqaddress"],
		"addresses"=>(array)$address,
		"profileAddressError"=>$address::getError(),
		"profileAddressSuccess"=>$address::getSuccess()
	]);

});

/* Delete address page route */
$app->post("/{language}/profile/addresses/{type}/delete", function($request, $response, $args) {

	// User must be logged in
	User::verifyLogin(false, $args["language"]);

	$address = new Address($args["language"]);

	// Set ID address
	$address->setData([
		"idaddress"=>(int)$_POST["idaddress"]
	]);

	// Read orders of address from DB
	$orders = $address->getOrders($address);

	// Check if address already has orders
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

	// Deletes address of DB
	$address->delete($address);

	header("location: /".$args["language"]."/profile/addresses/".$args["type"]);
	exit;

});

/* Orders page route */
$app->get("/{language}/profile/orders", function($request, $response, $args) {

	// User must be logged in
	User::verifyLogin(false, $args["language"]);

	// Set user from session
	$user = User::getFromSession($args["language"]);

	// Configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/profile";
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	$page->setTpl("profile-orders", [
		"orders"=>$user->getOrders()
	]);

});

/* Order detail page route */
$app->get("/{language}/profile/orders/{idorder}", function($request, $response, $args) {

	// User must be logged in
	User::verifyLogin(false, $args["language"]);

	$order = new Order($args["language"]);

	$order->get((int)$args["idorder"]);

	$cart = new Cart($args["language"]);

	// Read cart data from DB
	$cart->get((int)$order->getidcart());

	// Calculates totals of cart
	$cart->getTotals();

	// Configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/profile";
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	$page->setTpl("profile-orders-details", [
		"cart"=>$cart->getValues(),
		"order"=>$order->getValues(),
		"products"=>$cart->getProducts()
	]);

});

/* Payment route page */
$app->get("/{language}/profile/order/{idorder}", function($request, $response, $args) {

	// User must be logged in
	User::verifyLogin(false, $args["language"]);

	$order = new Order($args["language"]);

	// Read cart data from DB
	$order->get((int)$args["idorder"]);

	// Configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/payment";
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	$page->setTpl("payment", [
		"order"=>$order->getValues()
	]);

});

/* Wishlist page route */
$app->get("/{language}/profile/wishlist", function($request, $response, $args) {

	// User must be logged in
	User::verifyLogin(false, $args["language"]);

	// Set user from session
	$user = User::getFromSession($args["language"]);

	// Configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/profile";
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	$page->setTpl("profile-wishlist", [
		"wishlist"=>$user->getWishlist()
	]);

});

/* Route to DB wishlist operation */
$app->post("/{language}/profile/wishlist/{operation}", function($request, $response, $args) {

	/* operation:
	   input, minus and plus from (profile-wishlist)
	   include from (product-list)
	*/
	if ($_POST["nrquantity"] === "") {
		header("Location: /".$args["language"]."/profile/wishlist");
		exit;
	}

	// User must be logged in
	User::verifyLogin(false, $args["language"]);

	$wishList = new WishList($args["language"]);

	// If requisition comes from wishlist page
	if (isset($_POST["idwishlist"])) {

		// Read wishlist ID
		$wishList->get((int)$_POST["idwishlist"]);

	// If requisition comes from pages with no wishlist ID
	} else {

		// Set user from session
		$user = User::getFromSession($args["language"]);

		// Set user ID and product ID to wishlist register
		$wishList->setData([
			"iduser"=>$user->getiduser(),
			"idproduct"=>$_POST["idproduct"]
		]);

	}

	// Set quantity to wishlist register depending on the operation
	$wishList->setData([
		"nrquantity"=>($args["operation"] === "minus" ? $_POST["nrquantity"] - 1 : 
						($args["operation"] === "plus" ? $_POST["nrquantity"] + 1 : $_POST["nrquantity"]))
	]);

	// Saves wishlist in DB
	$wishList->save();

	// Directs to requisition origin page
	header("Location: ".$_SERVER["HTTP_REFERER"]);
	exit;

});

/* Cart page route */
$app->get("/{language}/checkout/cart", function($request, $response, $args) {

	// Configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/checkout";
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	// Set cart from session
	$cart = Cart::getFromSession($args["language"]);

	// Tpl configuration and drawning
	$page->setTpl("cart", [
		// Load values of current cart
		"cart"=>$cart->getValues(),
		// Load cart products
		"products"=>$cart->getProducts(),
		"error"=>Cart::getMsgError()
	]);

});

/* Route to save cart data in DB */
$app->post("/{language}/checkout/cart/{operation}", function($request, $response, $args) {

	/* operation:
	   input, minus and plus from (profile-wishlist)
	   include from (product-list)
	*/

	// Do nothing if quantity doesn't exist in origin page
	if ($_POST["nrquantity"] === "") {
		header("Location: /".$args["language"]."/checkout/cart");
		exit;
	}

	// User must be logged in
	User::verifyLogin(false, $args["language"]);

	// Read cart from session
	$cart = Cart::getFromSession($args["language"]);

	// Set cart quantity depending on the operation
	$cart->setData([
		"nrquantity"=>($args["operation"] === "minus" ? $_POST["nrquantity"] - 1 : 
						($args["operation"] === "plus" ? $_POST["nrquantity"] + 1 : $_POST["nrquantity"]))
	]);

	$product = new Product($args["language"]);

	// Set product ID
	$product->setData([
		"idproduct"=>$_POST["idproduct"]
	]);

	// Saves product in cart DB table
	$cart->addProduct($product);

	header("Location: ".$_SERVER["HTTP_REFERER"]);
	exit;

});

/* Checkout page route */
$app->get("/{language}/checkout", function($request, $response, $args) {

	// User must be logged in
	User::verifyLogin(false, $args["language"]);

	// Set user from session
	$user = User::getFromSession($args["language"]);

	$addressBilling = new Address($args["language"]);

	// Set person ID and billing type to address register
	$addressBilling->setData([
		"idperson"=>$user->getidperson(),
		"tpaddress"=>"B"
	]);

	// Read default billing address from DB
	$addressBilling->getDefault();

	$addressShipping = new Address($args["language"]);

	// Set person ID and shipping type to address register
	$addressShipping->setData([
		"idperson"=>$user->getidperson(),
		"tpaddress"=>"S"
	]);

	// Read default shipping address from DB
	$addressShipping->getDefault();

	// Set cart from session
	$cart = Cart::getFromSession($args["language"]);

	// Configure billing address data if no default registerd
	if (!$addressBilling->getdsaddress()) $addressBilling->setdsaddress("");
	if (!$addressBilling->getdsnumber()) $addressBilling->setdsnumber("");
	if (!$addressBilling->getdscity()) $addressBilling->setdscity("");
	if (!$addressBilling->getdscountry()) $addressBilling->setdscountry("");
	if (!$addressBilling->getcdzipcode()) $addressBilling->setcdzipcode("");
	if (!$addressBilling->getfldefault()) $addressBilling->setfldefault("");
	if (!$addressBilling->gettpaddress()) $addressBilling->settpaddress("");

	// Configure shipping address data if no default registerd
	if (!$addressShipping->getdsaddress()) $addressShipping->setdsaddress("");
	if (!$addressShipping->getdsnumber()) $addressShipping->setdsnumber("");
	if (!$addressShipping->getdscity()) $addressShipping->setdscity("");
	if (!$addressShipping->getdscountry()) $addressShipping->setdscountry("");
	if (!$addressShipping->getcdzipcode()) $addressShipping->setcdzipcode("");
	if (!$addressShipping->getfldefault()) $addressShipping->setfldefault("");
	if (!$addressShipping->gettpaddress()) $addressShipping->settpaddress("");

	// Configure main menu products
	mainMenu($args["language"], $menu, $filter, $pageConfig);

	/* Page configuration */
	$pageConfig[0] = "header";
	$pageConfig[1] = $args["language"]."/checkout";
	$pageConfig[4] = "/".$args["language"];

	$page = new Page($pageConfig);

	$page->setTpl("checkout", [
		"user"=>$user->getValues(),
		"cart"=>$cart->getValues(),
		"addressBilling"=>$addressBilling->getValues(),
		"addressShipping"=>$addressShipping->getValues(),
		"products"=>$cart->getProducts(),
		"error"=>$addressBilling::getError()
	]);

});

/* Checkout page route */
$app->post("/{language}/checkout/paypal", function($request, $response, $args) {

	// For test payments we want to enable the sandbox mode. If you want to put live
	// payments through then this setting needs changing to `false`.
	$enableSandbox = true;

	// Database settings. Change these for your database configuration.
	//$dbConfig = [
	//    "host" => "localhost",
	//    "username" => "root",
	//    "password" => "",
	//    "name" => "db_brasilcasa"
	//];

	// PayPal settings. Change these to your account details and the relevant URLs
	// for your site.
	$paypalConfig = [
	    "email" => "marcelovivone@gmail.com",
	    "return_url" => "http://www.brasilencasa.com/checkout/paypal/successful",
	    "cancel_url" => "http://www.brasilencasa.com/checkout/paypal/cancelled",
	    "notify_url" => "http://www.brasilencasa.com/checkout/paypal/notify"
	];

	$paypalUrl = $enableSandbox ? "https://www.sandbox.paypal.com/cgi-bin/webscr" : "https://www.paypal.com/cgi-bin/webscr";

	// Product being purchased.
//	$itemName = $_POST["summary"];
//	$itemAmount = $_POST["total"];
	$itemName = "Purchase";
	$itemAmount = 49.81;

	// Include Functions
	//require "functions.php";

	// Check if paypal request or response
	if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])) {

	    // Grab the post data so that we can set up the query string for PayPal.
	    // Ideally we'd use a whitelist here to check nothing is being injected into
	    // our post data.
	    $data = [];
	    foreach ($_POST as $key => $value) {
	        $data[$key] = stripslashes($value);
	    }

	    // Set the PayPal account.
	    $data["business"] = $paypalConfig["email"];

	    // Set the PayPal return addresses.
	    $data["return"] = stripslashes($paypalConfig["return_url"]);
	    $data["cancel_return"] = stripslashes($paypalConfig["cancel_url"]);
	    $data["notify_url"] = stripslashes($paypalConfig["notify_url"]);

	    // Set the details about the product being purchased, including the amount
	    // and currency so that these aren"t overridden by the form data.
	    $data["item_name"] = $itemName;
	    $data["amount"] = $itemAmount;
	    $data["currency_code"] = "GBP";

	    // Add any custom fields for the query string.
	    //$data["custom"] = USERID;

	    // Build the query string from the data.
	    $queryString = http_build_query($data);

	    // Redirect to paypal IPN
	    header("location:" . $paypalUrl . "?" . $queryString);
	    exit();

	} else {

		// Handle the PayPal response.

		// Create a connection to the database.
		$db = new mysqli($dbConfig["host"], $dbConfig["username"], $dbConfig["password"], $dbConfig["name"]);

		// Assign posted variables to local data array.
		$data = [
		    "item_name" => $_POST["item_name"],
		    "item_number" => $_POST["item_number"],
		    "payment_status" => $_POST["payment_status"],
		    "payment_amount" => $_POST["mc_gross"],
		    "payment_currency" => $_POST["mc_currency"],
		    "txn_id" => $_POST["txn_id"],
		    "receiver_email" => $_POST["receiver_email"],
		    "payer_email" => $_POST["payer_email"],
		    "custom" => $_POST["custom"],
		];

		// We need to verify the transaction comes from PayPal and check we"ve not
		// already processed the transaction before adding the payment to our
		// database.
		if (verifyTransaction($_POST) && checkTxnid($data["txn_id"])) {
		    if (addPayment($data) !== false) {
		        // Payment successfully added.
		    }
		}

	}

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

	User::Setuccess("Dados alterados com sucesso!");

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

//	User::Setuccess('Senha alterada com sucesso.');
	User::Setuccess('Contraseña alterada con éxito.');

	header('Location: /profile/change-password');
	exit;

});
*/?>
