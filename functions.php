<?php

use \Tila\Model\User;
use \Tila\Model\Cart;

function formatEU($vlunformat)
{

	if (!$vlunformat > 0) $vlunformat = 0;

	return number_format($vlunformat, 2, ",", ".");

}

function formatDate($date)
{

	return date('d/m/Y', strtotime($date));

}

function checkLogin($inadmin = true)
{

	return User::checkLogin($inadmin);

}

function getUserName()
{

	$user = User::getFromSession();

	return $user->getdesperson();

}

function getCartNrQtd() {

	$cart = Cart::getFromSession();

	$totals = $cart->getProductsTotals();

	return $totals['nrqtd'];

}

function getCartVlSubTotal() {

	$cart = Cart::getFromSession();

	$totals = $cart->getProductsTotals();

	return formatBR($totals['vlprice']);

}


/* future: listItem as array */
//function arrayLoad(&$array, $arrayDim = "", $list, $listItem = []) :array {
function arrayLoad(&$array, $arrayDim = "", $list, $listItem = "") :array {

	foreach ($list as $Key => $value) {

		if ($arrayDim === "") {
	   		$array[$Key] = $value[$listItem];
		} else {
	   		$array[$arrayDim][$Key] = $value[$listItem];
		}
	}

	return $array;
}


function substring($str, $start, $lenght){
	return substr($str, $start, $lenght);
}

function strPad($str){
	return str_pad($str, 26 - strlen($str), "&nbsp");
}

?>