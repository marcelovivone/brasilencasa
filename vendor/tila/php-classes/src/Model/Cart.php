<?php

namespace Tila\Model;

use \Tila\DB\Sql;
use \Tila\Model;
use \Tila\Model\User;

class Cart extends Model
{
	// sessão precisa ser criada para conter o id do carrinho
	const SESSION = "Cart";

	// sessão para mensagem de erro (utilizada no cálculo do frete)
	const SESSION_ERROR = 'CartError';

	public static function getFromSession()
	{

		$cart = new Cart();

		// verifica se a sessão está definida e se o carrinho que está sendo criado já está na sessão 
//		if (isset($_SESSION[Cart::SESSION]) && (int)$_SESSION[Cart::SESSION]['idcart'] > 0) {
		if (isset($_SESSION[Cart::SESSION]) && isset($_SESSION[Cart::SESSION]['idcart'])) {

			$cart->get((int)$_SESSION[Cart::SESSION]['idcart']);

		// se a sessão não está definida ou o carrinho ainda não foi incluído nela
		} else {

			// lê o ID do carrinho da sessão
			$cart->getFromSessionID();

			// se o ID do carrinho da sessão ainda não existe
			if (!(int)$cart->getidcart() > 0) {

				// criar carrinho novo
				$data = [
					'dssessionid'=>session_id()
				];

				// verifica se a rota não é de administração
				// se retornar true, significa que o usuário está logado
				if (User::checkLogin(false)) {

					//lê o usuário da sessão
					$user = User::getFromSession();

					$data['iduser'] = $user->getiduser();

				}

				$cart->setData($data);

				$cart->save();

				$cart->setToSession();

			}

		}

		return $cart;

	}

	public function setToSession()
	{

		$_SESSION[Cart::SESSION] = $this->getValues();		

	}

	public function getFromSessionID()
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_carts WHERE dssessionid = :dssessionid", [
			':dssessionid'=>session_id()
		]);

		if (count($results) > 0) {

			$this->setData($results[0]);

		}

	}

	public function get(int $idcart)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_carts WHERE idcart = :idcart", [
			':idcart'=>$idcart
		]);

		if (count($results) > 0) {

			$this->setData($results[0]);

		}

	}

	public function save()
	{

		$sql = new Sql();

		$results = $sql->select("CALL sp_carts_save(:idcart, :dssessionid, :iduser, :dszipcode, :vlfreight, :nrdays)", [
			':idcart'=>$this->getidcart(), 
			':dssessionid'=>$this->getdssessionid(), 
			':iduser'=>$this->getiduser(), 
			':dszipcode'=>$this->getdszipcode(), 
			':vlfreight'=>$this->getvlfreight(), 
			':nrdays'=>$this->getnrdays()
		]);

		$this->setData($results);

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

	public function addProduct(Product $product)
	{

		$sql = new Sql();

		$sql->query("INSERT INTO tb_cartsproducts (idcart, idproduct) VALUES (:idcart, :idproduct)", [
			':idcart'=>$this->getidcart(),
			':idproduct'=>$product->getidproduct()
		]);

		// atualiza os valores da página de frete
		$this->getCalculateTotal();

	}

	public function removeProduct(Product $product, $all = false)
	{

		$sql = new Sql();

		// não há exclusão de registro para que os dados possam ser utilizados para análises futuras
		$query = "UPDATE tb_cartsproducts 
					 SET dtremoved = NOW() 
				   WHERE idcart = :idcart AND 
				   		 idproduct = :idproduct AND 
				   		 dtremoved IS NULL";

		// $all:
		// true - remove todos os itens do produto do carrinho (o produto some do carrinho na página)
		// false - remove um item do produto do carrinho (diminui uma quantidade do mostrador da página)
		if (!$all) {
			
			$query .= ' LIMIT 1';

		}
		
		$sql->query($query, [
			':idcart'=>$this->getidcart(),
			'idproduct'=>$product->getidproduct()
		]);

		// atualiza os valores da página de frete
		$this->getCalculateTotal();

	}

	public function getProducts(){

		$sql = new Sql();

//		$rows = $sql->select("
//			SELECT p.idproduct,
//		  		   pt.nmproduct,
//		  		   p.vlprice,
//		  		   p.vlwidth, 
//		  		   p.vlheight, 
//		  		   p.vllength,
//		  		   p.vlweight,
//		  		   pt.dsurl,
//		  		   COUNT(*) AS nrqtd,
//		  		   SUM(p.vlprice) AS vltotal
		$rows = $sql->select("
			SELECT p.idproduct,
		  		   pt.nmproduct,
		  		   p.vlprice,
		  		   p.vlwidth, 
		  		   p.vlheight, 
		  		   p.vllength,
		  		   p.vlweight,
		  		   pt.dsurl,
		  		   c.nrquantidade,
		  		   p.vlprice
			  FROM tb_cartsproducts c
			 INNER JOIN tb_products p ON c.idproduct = p.idproduct
             INNER JOIN tb_products_translate pt ON p.idproduct = pt.idproduct AND
													pt.cdlanguage = :cdlanguage
			 WHERE c.idcart = :idcart AND
			 	   c.dtremoved IS NULL
		  ORDER BY pt.nmproduct
		  ", [
		  	":idcart"=>$this->getidcart(),
		  	":cdlanguage"=>$this->getLanguage()
		  ]);

		// inclui as fotos do produto às linhas do array
		return Product::checkList($rows, $this->getLanguage());
	}

	public function getProductsTotals()
	{

		$sql = new Sql();

//		$results = $sql->select("
//			SELECT SUM(vlprice) AS vlprice,
//				   SUM(vlwidth) AS vlwidth,
//				   SUM(vlheight) AS vlheight,
//				   SUM(vllength) AS vllength,
//				   SUM(vlweight) AS vlweight,
//				   COUNT(*) AS nrqtd
		$results = $sql->select("
			SELECT SUM(vlprice*nrquantidade) AS vlpricesubtotal,
				   SUM(vlwidth*nrquantidade) AS vlwidthsubtotal,
				   SUM(vlheight*nrquantidade) AS vlheightsubtotal,
				   SUM(vllength*nrquantidade) AS vllengthsubtotal,
				   SUM(vlweight*nrquantidade) AS vlweightsubtotal,
				   SUM(nrquantidade) AS nrquantidadesubtotal
			  FROM tb_products p
			 INNER JOIN tb_cartsproducts c ON p.idproduct = c.idproduct
			 WHERE c.idcart = :idcart AND
			 	   dtremoved IS NULL
 			", [
 				':idcart'=>$this->getidcart()
 			]);

		if (count($results) > 0) {

			return $results[0];

		} else {

			return [];

		}
	}

	public function setFreight($nrzipcode)
	{

		$nrzipcode = str_replace('-', '', $nrzipcode);

		$totals = $this->getProductsTotals();

		if (isset($totals['nrqtd'])) {

			// corrigindo manualmente os erros retornados pelo webservice para poder executar a requisição
			// no mundo real, esses erros devem ser tratados apropriadamente
			$totals['vllength'] = ($totals['vllength'] >= 16) ? $totals['vllength'] : 16;
			$totals['vlheight'] = ($totals['vlheight'] >= 2) ? $totals['vlheight'] : 11;
			$totals['vlwidth'] = ($totals['vlwidth'] >= 11) ? $totals['vlwidth'] : 11;
			$totals['vlwidth'] = ($totals['vlwidth'] <= 105) ? $totals['vlwidth'] : 105;

			$qs = http_build_query([
				'nCdEmpresa'=>'',
				'sDsSenha'=>'',
				'nCdServico'=>'40010',
				'sCepOrigem'=>'22270000',
				'sCepDestino'=>$nrzipcode,
				'nVlPeso'=>$totals['vlweight'],
				'nCdFormato'=>'1',
				'nVlComprimento'=>$totals['vllength'],
				'nVlAltura'=>$totals['vlheight'],
				'nVlLargura'=>$totals['vlwidth'],
				'nVlDiametro'=>'0',
				'sCdMaoPropria'=>'S',
				'nVlValorDeclarado'=>'0',
				'sCdAvisoRecebimento'=>'S'
			]);

			// webservice vai retornar os dados em XML
			$xml = simplexml_load_file("http://ws.correios.com.br/calculador/CalcPrecoPrazo.asmx/CalcPrecoPrazo?".$qs);

			$result = $xml->Servicos->cServico;
//echo(json_encode((array($xml))));
//exit;
			if ($result->MsgErro == '') {

				Cart::clearMsgError();

			} else {

				Cart::setMsgError($result->MsgErro);

			}

			$this->setnrdays($result->PrazoEntrega);
			$this->setvlfreight(Cart::formatValueToDecimal($result->Valor));
			$this->setdszipcode($nrzipcode);

			$this->save();

			return $result;

		} else {


		}

	}
	
	public static function formatValueToDecimal($value):float
	{

		$value = str_replace('.', '', $value);
		return str_replace(',', '.', $value);

	}

	public static function setMsgError($msg) 
	{

		$_SESSION[Cart::SESSION_ERROR] = $msg;

	}

	public static function getMsgError() 
	{

		$msg = isset($_SESSION[Cart::SESSION_ERROR]) ? $_SESSION[Cart::SESSION_ERROR] : "";

		Cart::clearMsgError();

		return $msg;

	}

	public static function clearMsgError() 
	{

		$_SESSION[Cart::SESSION_ERROR] = NULL;

	}

	public function updateFreight() 
	{

		// atualiza o valor do frete na página apenas se o zipcode tiver sido informado
		if ($this->getdszipcode() != ''){

			$this->setFreight($this->getdszipcode());

		}


	}

	// sobrescrevendo o método do Model para adicionar 2 valores que devem ser mostrados na
	// página de cálculo de frete e que não estão originalmente dentro do carrinho (subtotal
	// e total geral)
	public function getValues()
	{

		$this->getCalculateTotal();

		return parent::getValues();

	}

	public function getCalculateTotal()
	{

		$this->updateFreight();

		$totals = $this->getProductsTotals();

		$this->setnrquantidadesubtotal($totals['nrquantidadesubtotal']);
		$this->setvlsubtotal($totals['vlpricesubtotal']);
		$this->setvltotal($totals['vlpricesubtotal'] + $this->getvlfreight());

	}

}

?>