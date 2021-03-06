<?php 

session_start();

require_once("vendor/autoload.php");

use \Slim\App;
use \Tila\Page;
use \Tila\PageAdmin;
use \Tila\Model\User;
use \Tila\Model\Category;

$app = new App([
    'settings' => [
        'displayErrorDetails' => true
    ]
]);

require_once("functions.php");
require_once("store.php");
//require_once("admin.php");
//require_once("admin-users.php");
//require_once("admin-categories.php");
//require_once("admin-products.php");
//require_once("admin-orders.php");

$app->run();
?>