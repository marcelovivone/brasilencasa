<?php

namespace Tila\Model;

use \Tila\DB\Sql;
use \Tila\Model;

class Product extends Model
{

	protected $sql;
	protected $stmt;

	public function listAll($order = "t.nmproduct ASC")
	{

		$sql = new Sql();

		return $sql->select("SELECT * 
							   FROM tb_products p, 
							   		tb_products_translate t 
							  WHERE p.idproduct = t.idproduct AND 
							  		t.cdlanguage = UPPER(:cdlanguage) 
						   ORDER BY $order", 
			array(
			":cdlanguage"=>$this->getLanguage()
		));

	}

	public function listByArgs($argsArray = [], $order = "t.nmproduct ASC")
	{

		$sqlQuery = "SELECT distinct p.*, t.* 
					   FROM tb_products p 
					   		LEFT JOIN tb_productssubcategories s 
					   				ON p.idproduct = s.idproduct, 
							tb_products_translate t  
					  WHERE p.idproduct = t.idproduct AND 
							t.cdlanguage = UPPER(:cdlanguage) ";

		$bindArray[":cdlanguage"] = $this->getLanguage();

		// Check if there is any arg
		if (!empty($argsArray)) {
			$sqlWhere = "";
			$lastCol = "";
			$lastVal = "";

			// Array sort by key
			ksort($argsArray);

			// Iteration to set where and bind strings
			foreach ($argsArray as $key => $value) {
				
				// pick up the name of the column
				$col = substr($key, 0, strlen($key)-1);
				$val = $value;

				// Avoid repetition
				if ($col === $lastCol && $val == $lastVal) {
					continue;
				}

				/* Add parameter to where clause
				   If the column name is the same, concatenate with OR
				   If not, if is the first iteration, concatenate with (
				   If not, concatenate wiht ) AND (
				*/
				$sqlWhere .= ($col === $lastCol ? " OR " : ($lastCol !== "" ? ") AND (" : "AND ("));

				$sqlWhere .= "s.$col = :$key";

				$bindArray[":$key"] = $value;

				$lastCol = $col;
				$lastVal = $val;
			}

			$sqlWhere .= ") ";
			$sqlQuery .= $sqlWhere;
		}
		
		$sqlQuery .= "ORDER BY $order";

		$sql = new Sql();

		return $sql->select($sqlQuery, $bindArray);

	}

	public function listBySearch($search, $limit = 10000)
	{

		$sql = new Sql();
		
		$results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS *
			  FROM tb_products p, 
				   tb_products_translate t 
			 WHERE p.idproduct = t.idproduct AND 
				   t.cdlanguage = UPPER(:cdlanguage) AND
				 ( t.nmproduct LIKE :search OR 
				   t.dsproductred LIKE :search OR 
				   t.dsproductext LIKE :search ) 
		  ORDER BY t.nmproduct ASC
		  ", 
			array(
			":cdlanguage"=>$this->getLanguage(),
			":search"=>"%".$search."%"
		));

		$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

		return [
			"data"=>$results,
			"total"=>(int)$resultTotal[0]["nrtotal"]
		];

	}
/*
	public function prepareFetchSearch(&$sql, &$stmt, $search)
	{

		$sql = new Sql();

		$cmd = "SELECT * 
							   FROM tb_products p, 
							   		tb_products_translate t 
							  WHERE p.idproduct = t.idproduct AND 
							  		t.cdlanguage = UPPER(:cdlanguage) AND
							  	  ( t.nmproduct LIKE :search OR 
							  	    t.dsproductred LIKE :search OR 
							  	    t.dsproductext LIKE :search ) 
						   ORDER BY t.nmproduct ASC";

		$params = array(
			":cdlanguage"=>$this->getLanguage(),
			":search"=>"%".$search."%"
		);

		$stmt = $sql->prepare($cmd, $params);

		$this->sql = $sql;
		$this->stmt = $stmt;
//$this->fetchSearch($sql, $stmt);

$html = '<ul>';

//while ($result = $this->fetchSearch($sql, $stmt)) {
//while ($result = $stmt->fetch(\PDO::FETCH_ASSOC)) {
while ($result = $sql->fetch($stmt)) {

// Creating unordered list items.

// Calling javascript function named as "fill" found in "script.js" file.

// By passing fetched result as parameter. -->

	$html .= "
	<li onclick='fill(".$result["nmproduct"].")'>
	<a>
		".$result["nmproduct"]."
		</a>
	</li>
	";

}

$html .= "</ul>";


//		return $stmt;

	}

	public function fetchSearch($sql, $stmt): array
	{

print_r($sql->fetch($stmt));
		return $sql->fetch($stmt);

	}
*/
	// pela implementação, as fotos não estão no banco e, portanto, a foto não existe no array de retorno de listAll
	// é necessário criar uma camada para chamar o getValues e retorno os objetos tratados para as fotos
	public static function checkList($list, $language)
	{

		foreach ($list as &$row) {
			
			$p = new Product($language);
			$p->setData($row);
			$row = $p->getValues();

		}

		// contém os dados de cada produto já formatados
		return $list;

	}

	public function save()
	{

		$sql = new Sql();

		$results = $sql->select("CALL sp_products_save (:idproduct, :nmproduct, :dsproductred, :dsproductext, :dshistory, :dsurl, :vlprice, :vlwidth, :vlheight, :vllength, :vlweight, :qtsale, :qtstock)", 
			array(
			":idproduct"=>$this->getidproduct(),
			":nmproduct"=>$this->getnmproduct(),
			":dsproductred"=>$this->getdsproductred(),
			":dsproductext"=>$this->getdsproductext(),
			":dshistory"=>$this->getdshistory(),
			":dsurl"=>$this->getdsurl(),
			":vlprice"=>$this->getvlprice(),
			":vlwidth"=>$this->getvlwidth(),
			":vlheight"=>$this->getvlheight(),
			":vllength"=>$this->getvllength(),
			":vlweight"=>$this->getvlweight(),
			":qtsale"=>$this->getqtsale(),
			":qtstock"=>$this->getqtstock()
		));

		// atribui o resultado no próprio objeto, para o caso de quem chamou necessite do resultado
		$this->setData($results[0]);

	}

	public function get($idproduct)
	{

		$sql = new Sql();

		$results = $sql->select("
			SELECT * 
			  FROM tb_products p, 
			  	   tb_products_translate t
			 WHERE p.idproduct = :idproduct AND
			 	   p.idproduct = t.idproduct AND
			 	   t.cdlanguage = UPPER(:cdlanguage)"
			 	   , array(
			":idproduct"=>$idproduct,
			":cdlanguage"=>$this->getLanguage()
		));

		$this->setData($results[0]);
		$this->checkPhoto();

	}

	public function delete()
	{

		$sql = new Sql();

		$results = $sql->select("DELETE FROM tb_products WHERE idproduct = :idproduct ", 
			array(
			":idproduct"=>$this->getidproduct()
		));

		// atribui o resultado no próprio objeto, para o caso de quem chamou necessite do resultado
		$this->setData($results[0]);

	}

	public function checkPhoto()
	{

		if (file_exists(
			$_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR .
			"img" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR . 
			"product" . $this->getidproduct() . ".jpg"
		)) {

			$url = "/assets/img/products/product" . $this->getidproduct() . ".jpg";

		} else {

			$url = "/assets/img/products/product.jpg";

		}

		return $this->setdsphoto($url);

	}

	// melhor forma de implementação seria com a criação de um atributo para as imagens
	// como não existe a coluna, foram criados os métodos getValues e checkPhoto
	public function getValues()
	{

		$this->checkPhoto();

		$values = parent::getValues();

		return $values;

	}

	public function setPhoto($file)
	{

		// extrai a extensão da foto
		$extension = explode(".", $file['name']);

		$extension = end($extension);

		// verifica a extensão da foto e cria o jpeg dessa imagem
		switch($extension) {

			case "jpg":
			case "jpeg":
			echo 'A: '.$file["tmp_name"];
				$image = imagecreatefromjpeg($file["tmp_name"]);
				break;

			case "gif":
				$image = imagecreatefromgif($file["tmp_name"]);
				break;

			case "png":
				$image = imagecreatefrompng($file["tmp_name"]);
				break;
		}

		$dist = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "assets" . DIRECTORY_SEPARATOR .
				"img" . DIRECTORY_SEPARATOR . "products" . DIRECTORY_SEPARATOR . 
				$this->getidproduct() . ".jpg";
		
		imagejpeg($image, $dist);

		imagedestroy($image);

		// para carregar a foto no objeto Product
		$this->checkPhoto();

	}

	public function getFromURL($dsurl, $limit = 1)
	{

		$sql = new Sql();

		$rows = $sql->select("
			SELECT * 
			  FROM tb_products p,
			  	   tb_products_translate t
			 WHERE p.idproduct = t.idproduct AND
			 	   t.dsurl = :dsurl AND
			 	   t.cdlanguage = UPPER(:cdlanguage)
			 LIMIT ".$limit, [
				':dsurl'=>$dsurl,
				':cdlanguage'=>$this->getLanguage()
		]);

		if (count($rows) > 0) { 
			$this->setData($rows[0]);
			$this->checkPhoto();
		} else {
			$this->setData([
				"idprodutct"=>"0"
			]);
		}

	}

	public function getCategories()
	{

		$sql = new Sql();

		return $sql->select("
			SELECT * 
			  FROM tb_categories c INNER JOIN tb_productscategories p ON c.idcategory = p.idcategory,
			  	   tb_categories_translate t
			 WHERE p.idproduct = :idproduct AND
			 	   p.idcategory = t.idcategory AND
			 	   t.cdlanguage = UPPER(:cdlanguage)
		  ORDER BY t.nmcategory", [
			':idproduct'=>$this->getidproduct(),
			':cdlanguage'=>$this->getLanguage()
		]);

	}

	public static function getPage($page = 1, $itemPerPage = 10)
	{

		$start = ($page - 1) * $itemPerPage;

		$sql = new Sql();

		$results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS *
			  FROM tb_products
			 ORDER BY dsproductred
			 LIMIT $start, $itemPerPage;
		");

		$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

		return [
			'data'=>$results,
			'total'=>(int)$resultTotal[0]['nrtotal'],
			'pages'=>ceil($resultTotal[0]['nrtotal'] / $itemPerPage)
		];

	}

	public function getPageSearch($search, $page = 1, $itemPerPage = 10)
	{

		$start = ($page - 1) * $itemPerPage;

		$sql = new Sql();
/*
		$results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS *
			  FROM tb_products 
			 WHERE dsproduct LIKE :search
			 ORDER BY dsproduct
			 LIMIT $start, $itemPerPage;
		", [
			':search'=>'%'.$search.'%'
		]);
*/

		$results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS *
			  FROM tb_products p, 
				   tb_products_translate t 
			 WHERE p.idproduct = t.idproduct AND 
				   t.cdlanguage = UPPER(:cdlanguage) AND
				 ( t.nmproduct LIKE :search OR 
				   t.dsproductred LIKE :search OR 
				   t.dsproductext LIKE :search ) 
		  ORDER BY t.nmproduct ASC
		     LIMIT 0,
		     	   9;
		", 
			array(
			":cdlanguage"=>$this->getLanguage(),
			":search"=>"%".$search."%"
		));

		$resultTotal = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

		return [
			"data"=>$results,
			"total"=>(int)$resultTotal[0]["nrtotal"],
			"pages"=>ceil($resultTotal[0]["nrtotal"] / $itemPerPage)
		];

	}

}

?>