<?php

namespace Tila\Model;

use \Tila\DB\Sql;
use \Tila\Model;
use \Tila\Mailer;

// essa classe User é um model. Todo classe model tem getters e setters
// Classe Model contém os getters e setters, para serem utilizados em todas as classes model
class User extends Model
{
	
	const SESSION = "User";
	const SECRET = "1019019018452124";
	const CIPHER = "aes-128-cbc";
	const ERROR = "UserError";
	const ERROR_REGISTER = "UserErrorRegister";
	const SUCCESS = "UserSuccess";

	public static function getFromSession($language)
	{

		$user = new User($language);

		// verifica se a sessão está definida e se o usuário existe dentro da sessão
		if (isset($_SESSION[User::SESSION]) && (int)$_SESSION[User::SESSION]['iduser'] > 0) {

			$user->setData($_SESSION[User::SESSION]);

		}

		return $user;

	}

	public static function checkLogin($inadmin = true)
	{

		if (
			// se a sessão não está definida
			!isset($_SESSION[User::SESSION])
			||
			// se a sessão está vazia
			!$_SESSION[User::SESSION]
			||
			// se o usuário é válido
			!(int)$_SESSION[User::SESSION]["iduser"] > 0
		) {

			// usuário não está logado
			return false;
			
		} else {

			// I - se a rota é de administração
			// II - se o usuario logado tem permissão para acessar a área de administração
			//  ------- I -------    ----------------------- II -----------------------
			if ($inadmin === true && (bool)$_SESSION[User::SESSION]['inadmin'] === true) {

				return true;

			// a rota não é de administração
			} else if ($inadmin === false) {

				return true;

			} else {

				return false;

			}

		}

	}

	public static function login($email, $password, $language)
	{

		$sql = new Sql();
/*
		$results = $sql->select("SELECT * FROM tb_users u INNER JOIN tb_persons p ON u.idperson = p.idperson WHERE u.dslogin = :LOGIN", array(
			":LOGIN"=>$login
		));
*/
		$results = $sql->select("SELECT * FROM tb_users u INNER JOIN tb_persons p ON u.idperson = p.idperson WHERE p.dsemail = :EMAIL", array(
			":EMAIL"=>$email
		));

		if (count($results) === 0)
		{
			// contrabarra é necessária porque a exceção está no escopo principal (no namespace principal
			// do PHP) e não dentro do namespace corrente (\Tila\Model)
//			throw new \Exception("Usuário inexistente ou senha inválida.", 1);
			return false;
		}

		if ($password === '')
		{
			return true;
		} else {
			$data = $results[0];

			if (password_verify($password, $data["cdpassword"]))
			{
				
				$user = new User($language);

				$data['dsperson'] = utf8_encode($data['dsperson']);

				$user->setData($data);
				
				$_SESSION[User::SESSION] = $user->getValues();

				return $user;

			} else 
			{

				// contrabarra é necessária porque a exceção está no escopo principal (no namespace principal
				// do PHP) e não dentro do namespace corrente (\Tila\Model)
//				throw new \Exception("Usuário inexistente ou senha inválida.", 1);
				return false;
			}
		}
	}

	public static function verifyLogin($inadmin = true)
	{

		if (!User::checkLogin($inadmin)) {
			
			if ($inadmin) {
			
				header("Location: /admin/login");
		
			} else {

				header("Location: /login");

			}

			exit;
		}

	}

	public static function checkUser($email, $password)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_users WHERE dsemail = :EMAIL", array(
			":EMAIL"=>$email
		));

		if (count($results) === 0)
		{
			return false;
		} else {

			if ($password === ''){
				return true;
			} else {
				$data = $results[0];

				if (password_verify($password, $data["cdpassword"])) {

					$user = new User($language);

					$data['nmlast'] = utf8_encode($data['nmlast']);

					$user->setData($data);
					
					$_SESSION[User::SESSION] = $user->getValues();

					return $user;
				} else {
					return false;
				}


			}
		}

	}

	public static function logout() 
	{
		$_SESSION[User::SESSION] = NULL;
	}

	public static function listAll()
	{

		$sql = new Sql();

		return $results = $sql->select("SELECT * FROM tb_users INNER JOIN tb_persons b USING(idperson) ORDER BY b.dsperson");

	}

	public function insert()
	{

		$sql = new Sql();


		$results = $sql->select("CALL sp_users_save (:dsperson, :dslogin, :cdpassword, :dsemail, :nrphone, :inadmin)", 
			array(
			":dsperson"=>utf8_decode($this->getdsperson()),
			":dslogin"=>$this->getdslogin(),
			":cdpassword"=>User::getPasswordHash($this->getcdpassword()),
			":dsemail"=>$this->getdsemail(),
			":nrphone"=>$this->getnrphone(),
			":inadmin"=>$this->getinadmin()
		));

		// atribui o resultado no próprio objeto, para o caso de quem chamou necessite do resultado
		$this->setData($results[0]);

	}

	public function get($iduser)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_users a INNER JOIN tb_persons b USING(idperson) WHERE a.iduser = :iduser", array(
			":iduser"=>$iduser
		));

		if (count($results) > 0) {

			$data = $results[0];

			$data['dsperson'] = utf8_encode($data['dsperson']);

		}

		$this->setData($results[0]);

	}

	public function update()
	{

		$sql = new Sql();

		$results = $sql->select("CALL sp_usersupdate_save (:iduser, :dsperson, :dslogin, :cdpassword, :dsemail, :nrphone, :inadmin)", 
			array(
			":iduser"=>$this->getiduser(),
			":dsperson"=>utf8_decode($this->getdsperson()),
			":dslogin"=>$this->getdslogin(),
			":cdpassword"=>User::getPasswordHash($this->getcdpassword()),
			":dsemail"=>$this->getdsemail(),
			":nrphone"=>$this->getnrphone(),
			":inadmin"=>$this->getinadmin()
		));

		// atribui o resultado no próprio objeto, para o caso de quem chamou necessite do resultado
		$this->setData($results[0]);

	}

	public function delete()
	{

		$sql = new Sql();

		$results = $sql->select("CALL sp_users_delete (:iduser)", 
			array(
			":iduser"=>$this->getiduser()
		));

		// atribui o resultado no próprio objeto, para o caso de quem chamou necessite do resultado
		$this->setData($results[0]);

	}

	public static function getForgot($email, $language, $inadmin = true)
	{

		$sql = new Sql();

		$results1 = $sql->select("
			SELECT * 
			  FROM tb_persons a
			 INNER JOIN tb_users b USING(idperson)
			 WHERE a.dsemail = :email;",
			 array(
			 	":email"=>$email
			 ));

		if (count($results1) === 0)
		{

			throw new \Exception("Não foi possível recuperar a senha.", 1);
			
		} else {

			$data = $results1[0];

			$results2 = $sql->select("CALL sp_userspasswordsrecoveries_create (:iduser, :dsip)", 
				array(
					":iduser"=>$data["iduser"],
					":dsip"=>$_SERVER["REMOTE_ADDR"]
			));			

		}

		if (count($results2) === 0)
		{

			throw new \Exception("Não foi possível recuperar a senha.", 1);
			
		} else {

			$dataRecovery = $results2[0];

			// chave ou fixa ou passando randomizada e na base 64 pelo get (= ao IV)
			// pesquisar qual maneira é a mais segura
//			$key = openssl_random_pseudo_bytes(USER::SECRET);
			$key = USER::SECRET;

			$iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length(USER::CIPHER));

			$code = base64_encode(openssl_encrypt($dataRecovery["idrecovery"], USER::CIPHER, $key, 0, $iv));
			$iv = base64_encode($iv);

			// se o método foi chamado a partir da área de administração
			// calling origin is the administrative section
			if ($inadmin === true) {
				
				$link = "http://www.brasilencasa.com/$language/admin/forgot/reset?code=$code&iv=$iv";

			// se o método foi chamado a partir da área de loja
			// calling origin is the store section
			} else {

				$link = "http://www.brasilencasa.com/$language/forgot/reset?code=$code&iv=$iv";

			}

			$mailer = new Mailer(
				$data["dsemail"], 
				$data["dsperson"], 
				($language === "en" ? "br-Casa - Password Assistance" :
					($language === "es" ? utf8_decode("br-Casa - Ayuda de Contraseña") :
						($language === "pt" ? utf8_decode("br-Casa - Auxílio de Senha") : "br-Casa - Password Assistance"))), 
				"forgot", 
				array(
					"name"=>$data["dsperson"],
					"link"=>$link
			));

			$mailer->send();

			return $data;

		}

	}

	public static function validForgotDecrypt($code,$iv) {

		// chave fixa ou recebendo randomizada e na base 64 pelo get (= ao IV)
		// pesquisar qual maneira é a mais segura
		$key = USER::SECRET;

		$iv = base64_decode($iv);

		$idrecovery = openssl_decrypt(base64_decode($code), USER::CIPHER, $key, 0, $iv);

		$sql = new Sql();

		$results = $sql->select("
			SELECT *
			  FROM tb_userspasswordsrecoveries r
			  INNER JOIN tb_users u USING(iduser)
			  INNER JOIN tb_persons p USING(idperson)
			 WHERE r.idrecovery = :idrecovery AND
			 	   r.dtrecovery IS NULL AND
			 	   DATE_ADD(r.dtregister, INTERVAL 1 HOUR) >= NOW();
			", array(
				":idrecovery"=>$idrecovery
			));

		if (count($results) === 0) {

			throw new \Exception("Não foi possível recuperar a senha.", 1);

		} else {

			return $results[0];

		}

	}

	public static function setForgotUsed($idrecovery)
	{

		$sql = new Sql();

		$sql->query("UPDATE tb_userspasswordsrecoveries SET dtrecovery = NOW() WHERE idrecovery = :idrecovery", array(
			":idrecovery"=>$idrecovery
		));

	}

	public function setPassword($password)
	{
		
		$sql = new Sql();

		$sql->query("UPDATE tb_users SET cdpassword = :password WHERE iduser = :iduser", array(
			":password"=>$password,
			":iduser"=>$this->getiduser()
		));

	}

	public static function setError($msg)
	{

		$_SESSION[User::ERROR] = $msg;

	}

	public static function getError()
	{

		$msg = isset($_SESSION[User::ERROR]) && $_SESSION[User::ERROR] ? $_SESSION[User::ERROR] : "";

		User::clearError();

		return $msg;

	}

	public static function clearError()
	{

		$_SESSION[User::ERROR] = NULL;

	}

	public static function setErrorRegister($msg)
	{

		$_SESSION[User::ERROR_REGISTER] = $msg;

	}

	public static function getErrorRegister()
	{

		$msg = isset($_SESSION[User::ERROR_REGISTER]) && $_SESSION[User::ERROR_REGISTER] ? $_SESSION[User::ERROR_REGISTER] : "";

		User::clearErrorRegister();

		return $msg;
	}

	public static function clearErrorRegister()
	{

		$_SESSION[User::ERROR_REGISTER] = NULL;

	}

	public static function checkLoginExist($login)
	{

		$sql = new Sql();

		$results = $sql->select("
			SELECT * 
			  FROM tb_users u 
			 INNER JOIN tb_persons p USING(idperson) 
			 WHERE u.dslogin = :dslogin OR 
			 	   p.dsemail = :dslogin", [
			':dslogin'=>$login
		]);

		return (count($results) > 0);

	}

	public static function getPasswordHash($password)
	{

		return password_hash($password, PASSWORD_DEFAULT, [
			'cost'=>12
		]);

	}

	public function getOrders() {

		$sql = new Sql();

		$results = $sql->select("
			SELECT *
			  FROM tb_orders o
			 INNER JOIN tb_ordersstatus s USING (idstatus)
			 INNER JOIN tb_carts c USING (idcart)
			 INNER JOIN tb_users u ON u.iduser = o.iduser
			 INNER JOIN tb_addresses a USING (idaddress)
			 INNER JOIN tb_persons p ON p.idperson = u.idperson
			 WHERE o.iduser = :iduser
		", [
			':iduser'=>$this->getiduser()
		]);

		return $results;

	}

	public static function setSuccess($msg)
	{

		$_SESSION[User::SUCCESS] = $msg;

	}

	public static function getSuccess()
	{

		$msg = isset($_SESSION[User::SUCCESS]) && $_SESSION[User::SUCCESS] ? $_SESSION[User::SUCCESS] : "";

		User::clearSuccess();

		return $msg;

	}

	public static function clearSuccess()
	{

		$_SESSION[User::SUCCESS] = NULL;

	}

	public static function getPage($page = 1, $itemPerPage = 10)
	{

		$start = ($page - 1) * $itemPerPage;

		$sql = new Sql();

		$results = $sql->select("
			SELECT SQL_CALC_FOUND_ROWS *
			  FROM tb_users u
			 INNER JOIN tb_persons p USING(idperson) 
			 ORDER BY p.dsperson
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
			  FROM tb_users u
			 INNER JOIN tb_persons p USING(idperson) 
			 WHERE p.dsperson LIKE :searchLike OR p.dsemail = :search OR u.dslogin LIKE :searchLike
			 ORDER BY p.dsperson
			 LIMIT $start, $itemPerPage;
		", [
			':search'=>$search,
			':searchLike'=>'%'.$search.'%'
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