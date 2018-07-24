<?php

namespace Tila\Model;

use \Tila\DB\Sql;
use \Tila\Model;

class Category extends Model
{
	
	public function listAll($order = "t.nrorderappearance ASC")
	{

		$sql = new Sql();

		return $sql->select("SELECT * 
							   FROM tb_categories c,
							   		tb_categories_translate t 
							  WHERE c.idcategory = t.idcategory AND 
							  		t.cdlanguage = UPPER(:cdlanguage) 
						   ORDER BY $order", 
			array(
			":cdlanguage"=>$this->getLanguage(),
		));

	}

	public function insert()
	{

		$sql = new Sql();

		$results = $sql->select("CALL sp_categories_save (:idcategory, :dscategory)", 
			array(
			":idcategory"=>$this->getidcategory(),
			":dscategory"=>$this->getdscategory()
		));

		// atribui o resultado no próprio objeto, para o caso de quem chamou necessite do resultado
		$this->setData($results[0]);

		// refaz o menu de categoria para contemplar a inclusão
		Category::updateFile();

	}

	public function get($idcategory)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_categories WHERE idcategory = :idcategory", array(
			":idcategory"=>$idcategory
		));

		$this->setData($results[0]);

	}

	public function update()
	{

		$sql = new Sql();

		$results = $sql->select("CALL sp_categories_save (:idcategory, :dscategory)", 
			array(
			":idcategory"=>$this->getidcategory(),
			":dscategory"=>$this->getdscategory()
		));

		// atribui o resultado no próprio objeto, para o caso de quem chamou necessite do resultado
		$this->setData($results[0]);

		// refaz o menu de categoria para contemplar a atualização
		Category::updateFile();

	}

	public function delete()
	{

		$sql = new Sql();

		$results = $sql->select("DELETE FROM tb_categories WHERE idcategory = :idcategory ", 
			array(
			":idcategory"=>$this->getidcategory()
		));

		// atribui o resultado no próprio objeto, para o caso de quem chamou necessite do resultado
		$this->setData($results[0]);

		// refaz o menu de categoria para contemplar a exclusão
		Category::updateFile();

	}

	public static function updateFile() {

		$categories = Category::listAll();

		$html = [];

		foreach ($categories as $row) {
			array_push($html, '<li><a href="/categories/'.$row['idcategory'].'">'.$row['dscategory'].'</a></li>');
		}

		file_put_contents($_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "views" . DIRECTORY_SEPARATOR . "categories-menu.html", implode("", $html));

	}

	public function getProducts($related = true)
	{

		$sql = new Sql();

		if ($related) {

			$returns = $sql->select("
				SELECT * 
				  FROM tb_products 
				 WHERE idproduct IN (
				 	SELECT p.idproduct
				 	  FROM tb_products p
				 	 INNER JOIN tb_productscategories c ON p.idproduct = c.idproduct
				 	 WHERE c.idcategory = :idcategory
				 );
			", [
				":idcategory"=>$this->getidcategory()
			]);

		} else {

			$returns = $sql->select("
				SELECT * 
				  FROM tb_products 
				 WHERE idproduct NOT IN (
				 	SELECT p.idproduct
				 	  FROM tb_products p
				 	 INNER JOIN tb_productscategories c ON p.idproduct = c.idproduct
				 	 WHERE c.idcategory = :idcategory
				 );
			", [
				":idcategory"=>$this->getidcategory()
			]);

		}

		return $returns;

	}

	public function getProductsPage($page = 1, $itemPerPage = 8)
	{

		$start = ($page - 1) * $itemPerPage;

		$sql = new Sql();

		$results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS *
			  FROM tb_products p
			 INNER JOIN tb_productscategories pc ON p.idproduct = pc.idproduct
			 INNER JOIN tb_categories c ON c.idcategory = pc.idcategory
			 WHERE c.idcategory = :idcategory
			 LIMIT $start, $itemPerPage;
			 ", [
			 	':idcategory'=>$this->getidcategory()
		]);

		$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

		return [
			'data'=>Product::checklist($results),
			'total'=>(int)$resultTotal[0]['nrtotal'],
			'pages'=>ceil($resultTotal[0]['nrtotal'] / $itemPerPage)
		];

	}

	public function addProduct(Product $product)
	{

		$sql = new Sql();

		$o = $sql->query("INSERT INTO tb_productscategories (idcategory, idproduct) VALUES (:idcategory, :idproduct)", [
			":idcategory"=>$this->getidcategory(),
			":idproduct"=>$product->getidproduct()
		]);

	}

	public function removeProduct(Product $product)
	{

		$sql = new Sql();

		$sql->query("DELETE FROM tb_productscategories WHERE idcategory = :idcategory AND idproduct = :idproduct", [
			":idcategory"=>$this->getidcategory(),
			":idproduct"=>$product->getidproduct()
		]);

	}

	public static function getPage($page = 1, $itemPerPage = 10)
	{

		$start = ($page - 1) * $itemPerPage;

		$sql = new Sql();

		$results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS *
			  FROM tb_categories 
			 ORDER BY descategory
			 LIMIT $start, $itemPerPage;
		");

		$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

		return [
			'data'=>$results,
			'total'=>(int)$resultTotal[0]['nrtotal'],
			'pages'=>ceil($resultTotal[0]['nrtotal'] / $itemPerPage)
		];

	}

	public static function getPageSearch($search, $page = 1, $itemPerPage = 10)
	{

		$start = ($page - 1) * $itemPerPage;

		$sql = new Sql();

		$results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS *
			  FROM tb_categories 
			 WHERE descategory LIKE :search
			 ORDER BY descategory
			 LIMIT $start, $itemPerPage;
		", [
			':search'=>'%'.$search.'%'
		]);

		$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

		return [
			'data'=>$results,
			'total'=>(int)$resultTotal[0]['nrtotal'],
			'pages'=>ceil($resultTotal[0]['nrtotal'] / $itemPerPage)
		];

	}

}

?>