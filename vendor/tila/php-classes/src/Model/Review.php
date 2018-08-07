<?php

namespace Tila\Model;

use \Tila\DB\Sql;
use \Tila\Model;

class Review extends Model
{

	const ERROR = "ReviewError";
	const SUCCESS = "ReviewSuccess";

	public function save()
	{

		$sql = new Sql();

		$results = $sql->select("CALL sp_reviews_save(:idreview, :idproduct, :iduser, :nmname, :dsemail, :vlreview, :dsreview)", [
			':idreview'=>$this->getidreview(),
			':idproduct'=>$this->getidproduct(),
			':iduser'=>$this->getiduser(),
			':nmname'=>$this->getnmname(),
			':dsemail'=>$this->getdsemail(),
			':vlreview'=>$this->getvlreview(),
			':dsreview'=>$this->getdsreview()
		]);

		if (count($results) > 0) {
			$this->setData($results[0]);
		}

	}

	public function get($idreview)
	{

		$sql = new Sql();

		$results = $sql->select("
			SELECT *
			  FROM tb_reviews r
			 INNER JOIN tb_products p USING (idproduct)
			 INNER JOIN tb_products_translate pt ON p.idproduct = pt.idproduct AND
			 									   pt.cdlanguage = :cdlanguage
			 WHERE r.idreview = :idreview
			 ORDER BY r.dtregister DESC
		", [
			':idreview'=>$idreview,
			":cdlanguage"=>$this->getLanguage()
		]);

		if (count($results) > 0) {
			$this->setData($results[0]);
		}

	}

	public function getByProduct()
	{

		$sql = new Sql();

		$results = $sql->select("
			SELECT *
			  FROM tb_reviews r
			 INNER JOIN tb_products p USING (idproduct)
			 INNER JOIN tb_products_translate pt ON p.idproduct = pt.idproduct AND
			 									   pt.cdlanguage = :cdlanguage
			 WHERE r.idproduct = :idproduct AND
			 	   rt.cdlanguage = :cdlanguage
			 ORDER BY r.dtregister DESC
		", [
			':idproduct'=>(int)$this->getidproduct(),
			":cdlanguage"=>$this->getLanguage()
		]);

		for ($i=0; $i < count($results); $i++) { 
			$results[$i]["nmname"] = utf8_encode($results[$i]["nmname"]);
			$results[$i]["dsemail"] = utf8_encode($results[$i]["dsemail"]);
			$results[$i]["dsreview"] = utf8_encode($results[$i]["dsreview"]);
		}

		return $results;

	}

	public static function setSuccess($msg)
	{

		$_SESSION[Review::SUCCESS] = $msg;

	}

	public static function getSuccess()
	{

		$msg = isset($_SESSION[Review::SUCCESS]) && $_SESSION[Review::SUCCESS] ? $_SESSION[Review::SUCCESS] : "";

		Review::clearSuccess();

		return $msg;

	}

	public static function clearSuccess()
	{

		$_SESSION[Review::SUCCESS] = NULL;

	}

	public static function setError($msg)
	{

		$_SESSION[Review::ERROR] = $msg;

	}

	public static function getError()
	{

		$msg = isset($_SESSION[Review::ERROR]) && $_SESSION[Review::ERROR] ? $_SESSION[Review::ERROR] : "";

		Review::clearError();

		return $msg;

	}

	public static function clearError()
	{

		$_SESSION[Review::ERROR] = NULL;

	}

}

?>