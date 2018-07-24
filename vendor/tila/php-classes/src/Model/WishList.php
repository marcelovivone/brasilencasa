<?php

namespace Tila\Model;

use \Tila\DB\Sql;
use \Tila\Model;

class WishList extends Model
{

	const ERROR = "WishListError";
	const SUCCESS = "WishListSuccess";

	public function save()
	{

		$sql = new Sql();

		$results = $sql->select("CALL sp_wishlist_save(:idwishlist, :iduser, :idproduct, :nrquantity)", [
			':idwishlist'=>$this->getidwishlist(),
			':idproduct'=>$this->getidproduct(),
			':iduser'=>$this->getiduser(),
			':nrquantity'=>$this->getnrquantity()
		]);

		if (count($results) > 0) {
			$this->setData($results[0]);
		}

	}

	public function get($idwishlist)
	{

		$sql = new Sql();

		$results = $sql->select("
			SELECT *
			  FROM tb_wishlist w
			 INNER JOIN tb_products p USING (idproduct)
			 INNER JOIN tb_products_translate t ON p.idproduct = t.idproduct AND
			 									   t.cdlanguage = :cdlanguage
			 WHERE w.idwishlist = :idwishlist
			 ORDER BY w.dtregister DESC
		", [
			':idwishlist'=>$idwishlist,
			":cdlanguage"=>$this->getLanguage()
		]);

		if (count($results) > 0) {
			$this->setData($results[0]);
		}

	}

	public function getProduct():Product
	{

		$product = new Product($this->getcdLanguage);

		$product->get((int)$this->getidproduct());

		return $product;

	}

	public static function setSuccess($msg)
	{

		$_SESSION[WishList::SUCCESS] = $msg;

	}

	public static function getSuccess()
	{

		$msg = isset($_SESSION[WishList::SUCCESS]) && $_SESSION[WishList::SUCCESS] ? $_SESSION[WishList::SUCCESS] : "";

		WishList::clearSuccess();

		return $msg;

	}

	public static function clearSuccess()
	{

		$_SESSION[WishList::SUCCESS] = NULL;

	}

	public static function setError($msg)
	{

		$_SESSION[WishList::ERROR] = $msg;

	}

	public static function getError()
	{

		$msg = isset($_SESSION[WishList::ERROR]) && $_SESSION[WishList::ERROR] ? $_SESSION[WishList::ERROR] : "";

		WishList::clearError();

		return $msg;

	}

	public static function clearError()
	{

		$_SESSION[WishList::ERROR] = NULL;

	}

}

?>