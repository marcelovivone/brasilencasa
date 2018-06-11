<?php

namespace Tila\Model;

use \Tila\DB\Sql;
use \Tila\Model;

class Product extends Model
{

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
			":cdlanguage"=>$this->cdLanguage
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

		$bindArray[":cdlanguage"] = $this->cdLanguage;

		// check if is there any arg
		if (!empty($argsArray)) {
			$sqlWhere = "";
			$lastCol = "";
			$lastVal = "";

			// array sort by key
			ksort($argsArray);

			// iteration to set where and bind strings
			foreach ($argsArray as $key => $value) {
				
				// pick up the name of the column
				$col = substr($key, 0, strlen($key)-1);
				$val = $value;

				// avoid repetition
				if ($col === $lastCol && $val == $lastVal) {
					continue;
				}

				/* add parameter to where clause
				   if the column name is the same, concatenate with OR
				   if not, if is the first iteration, concatenate with (
				   if not, concatenate wiht ) AND (
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

	// pela implementação, as fotos não estão no banco e, portanto, a foto não existe no array de retorno de listAll
	// é necessário criar uma camada para chamar o getValues e retorno os objetos tratados para as fotos
	public static function checkList($list)
	{

		foreach ($list as &$row) {
			
			$p = new Product();
			$p->setData($row);
			$row = $p->getValues();

		}

		// contém os dados de cada produto já formatados
		return $list;

	}

	public function save()
	{

		$sql = new Sql();

		$results = $sql->select("CALL sp_products_save (:idproduct, :desproduct, :vlprice, :vlwidth, :vlheight, :vllength, :vlweight, :desurl)", 
			array(
			":idproduct"=>$this->getidproduct(),
			":desproduct"=>$this->getdesproduct(),
			":vlprice"=>$this->getvlprice(),
			":vlwidth"=>$this->getvlwidth(),
			":vlheight"=>$this->getvlheight(),
			":vllength"=>$this->getvllength(),
			":vlweight"=>$this->getvlweight(),
			":desurl"=>$this->getdesurl()
		));

		// atribui o resultado no próprio objeto, para o caso de quem chamou necessite do resultado
		$this->setData($results[0]);

	}

	public function get($idproduct)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_products WHERE idproduct = :idproduct", array(
			":idproduct"=>$idproduct
		));

		$this->setData($results[0]);

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
			$_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "res" . DIRECTORY_SEPARATOR .
			"site" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR .
			"products" . DIRECTORY_SEPARATOR . $this->getidproduct() . ".jpg"
		)) {

			$url = "/res/site/img/products/" . $this->getidproduct() . ".jpg";

		} else {

			$url = "/res/site/img/product.jpg";

		}

		return $this->setdesphoto($url);

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

		$dist = $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR . "res" . DIRECTORY_SEPARATOR .
				"site" . DIRECTORY_SEPARATOR . "img" . DIRECTORY_SEPARATOR .
				"products" . DIRECTORY_SEPARATOR . $this->getidproduct() . ".jpg";
		
		imagejpeg($image, $dist);

		imagedestroy($image);

		// para carregar a foto no objeto Product
		$this->checkPhoto();

	}

//	public function getFromURL($desurl)
	public function getFromURL($desurl,$language)
	{

		$sql = new Sql();

		$rows = $sql->select("SELECT * FROM tb_products WHERE desurl = :desurl LIMIT 1", [
			':desurl'=>$desurl
//			':desurl'=>$language.'/'.$desurl
		]);

		$this->setData($rows[0]);

	}

	public function getCategories()
	{

		$sql = new Sql();

		return $sql->select("SELECT * FROM tb_categories c INNER JOIN tb_productscategories p ON c.idcategory = p.idcategory WHERE p.idproduct = :idproduct", [
			':idproduct'=>$this->getidproduct()
		]);

	}

	public static function getPage($page = 1, $itemPerPage = 10)
	{

		$start = ($page - 1) * $itemPerPage;

		$sql = new Sql();

		$results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS *
			  FROM tb_products
			 ORDER BY desproduct
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
			  FROM tb_products 
			 WHERE desproduct LIKE :search
			 ORDER BY desproduct
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