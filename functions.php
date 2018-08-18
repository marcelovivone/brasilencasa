<?php

use \Tila\Model\User;
use \Tila\Model\Cart;

function formatEU($vlunformat)
{

	if (!$vlunformat > 0) $vlunformat = 0;

	return number_format($vlunformat, 2, ",", ".");

}

function utf8encode($string)
{

	return utf8_encode($string);

}

function formatDate($date)
{

	return date('d/m/Y', strtotime($date));

}

function checkLogin($inadmin = true)
{

	return User::checkLogin($inadmin);

}

function getUserName($language)
{

	$user = User::getFromSession($language);

	return $user->getnmfirst();

}

function getCartNrQty($language) {

	$cart = Cart::getFromSession($language);
	
	$totals = $cart->getProductsTotals();

	return $totals['nrsubtotalquantity'] == '' ? 0 : $totals['nrsubtotalquantity'];

}

function getCartVlSubTotal($language) {

	$cart = Cart::getFromSession($language);

	$totals = $cart->getProductsTotals();

	return formatEU($totals['vlsubtotalprice']);

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



function verifyTransaction($data) {
    global $paypalUrl;

    $req = 'cmd=_notify-validate';
    foreach ($data as $key => $value) {
        $value = urlencode(stripslashes($value));
        $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value); // IPN fix
        $req .= "&$key=$value";
    }

    $ch = curl_init($paypalUrl);
    curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $req);
    curl_setopt($ch, CURLOPT_SSLVERSION, 6);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
    curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close'));
    $res = curl_exec($ch);

    if (!$res) {
        $errno = curl_errno($ch);
        $errstr = curl_error($ch);
        curl_close($ch);
        throw new Exception("cURL error: [$errno] $errstr");
    }

    $info = curl_getinfo($ch);

    // Check the http response
    $httpCode = $info['http_code'];
    if ($httpCode != 200) {
        throw new Exception("PayPal responded with http code $httpCode");
    }

    curl_close($ch);

    return $res === 'VERIFIED';
}

function checkTxnid($txnid) {
    global $db;

    $txnid = $db->real_escape_string($txnid);
    $results = $db->query('SELECT * FROM `payments` WHERE txnid = \'' . $txnid . '\'');

    return ! $results->num_rows;
}

function addPayment($data) {
    global $db;

    if (is_array($data)) {
        $stmt = $db->prepare('INSERT INTO `payments` (txnid, payment_amount, payment_status, itemid, createdtime) VALUES(?, ?, ?, ?, ?)');
        $stmt->bind_param(
            'sdsss',
            $data['txn_id'],
            $data['payment_amount'],
            $data['payment_status'],
            $data['item_number'],
            date('Y-m-d H:i:s')
        );
        $stmt->execute();
        $stmt->close();

        return $db->insert_id;
    }

    return false;
}



?>