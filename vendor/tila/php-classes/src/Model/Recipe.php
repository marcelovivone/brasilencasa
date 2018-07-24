<?php

namespace Tila\Model;

use \Tila\DB\Sql;
use \Tila\Model;

class Recipe extends Model
{

	const ERROR = "RecipeError";
	const SUCCESS = "RecipeSuccess";

	public function save()
	{

		$sql = new Sql();

		$results = $sql->select("CALL sp_recipes_save(:idrecipe, :idproduct, :cdlanguage:, :nmrecipe, :dsingredient, :dsrecipe)", [
			':idrecipe'=>$this->getidrecipe(),
			':idproduct'=>$this->getidproduct(),
			':cdlanguage'=>$this->getcdLanguage(),
			':dnmrecipe'=>$this->nmrecipe(),
			':dsingredient'=>$this->dsingredient(),
			':dsrecipe'=>$this->dsrecipe()
		]);

		if (count($results) > 0) {
			$this->setData($results[0]);
		}

	}

	public function get($idrecipe)
	{

		$sql = new Sql();

		$results = $sql->select("
			SELECT *
			  FROM tb_recipe r,
			  	   tb_recipe_translate rt
			 INNER JOIN tb_products p USING (idproduct)
			 INNER JOIN tb_products_translate pt ON p.idproduct = pt.idproduct AND
			 									   pt.cdlanguage = :cdlanguage
			 WHERE r.idrecipe = :idrecipe AND
			 	   r.idrecipe = rt.idrecipe AND
			 	   rt.cdlanguage = :cdlanguage
			 ORDER BY r.dtregister DESC
		", [
			':idrecipe'=>$idrecipe,
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
			  FROM tb_recipes r
			 INNER JOIN tb_products p USING (idproduct)
			 INNER JOIN tb_products_translate pt ON p.idproduct = pt.idproduct AND
			 									   pt.cdlanguage = :cdlanguage,
			  	   tb_recipes_translate rt
			 WHERE r.idproduct = :idproduct AND
			 	   r.idrecipe = rt.idrecipe AND
			 	   rt.cdlanguage = :cdlanguage
			 ORDER BY r.dtregister DESC
		", [
			':idproduct'=>(int)$this->getidproduct(),
			":cdlanguage"=>$this->getLanguage()
		]);

		for ($i=0; $i < count($results); $i++) { 
			$results[$i]["nmrecipe"] = utf8_encode($results[$i]["nmrecipe"]);
			$results[$i]["dsingredient"] = utf8_encode($results[$i]["dsingredient"]);
			$results[$i]["dsrecipe"] = utf8_encode($results[$i]["dsrecipe"]);
		}

		return $results;

	}

	public static function setSuccess($msg)
	{

		$_SESSION[Recipe::SUCCESS] = $msg;

	}

	public static function getSuccess()
	{

		$msg = isset($_SESSION[Recipe::SUCCESS]) && $_SESSION[Recipe::SUCCESS] ? $_SESSION[Recipe::SUCCESS] : "";

		Recipe::clearSuccess();

		return $msg;

	}

	public static function clearSuccess()
	{

		$_SESSION[Recipe::SUCCESS] = NULL;

	}

	public static function setError($msg)
	{

		$_SESSION[Recipe::ERROR] = $msg;

	}

	public static function getError()
	{

		$msg = isset($_SESSION[Recipe::ERROR]) && $_SESSION[Recipe::ERROR] ? $_SESSION[Recipe::ERROR] : "";

		Recipe::clearError();

		return $msg;

	}

	public static function clearError()
	{

		$_SESSION[Recipe::ERROR] = NULL;

	}

}

?>