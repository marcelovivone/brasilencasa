<?php

namespace Tila\Model;

use \Tila\DB\Sql;
use \Tila\Model;

class Address extends Model
{

	const ERROR = "AddressError";
	const SUCCESS = "AddressSuccess";

/*	public function getFromUser()
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_address WHERE iduser = :iduser)",
			array(
			":iduser"=>User::getFromSession($this->language)->iduser
		));

		// atribui o resultado no próprio objeto, para o caso de quem chamou necessitar do resultado
		$this->setData($results[0]);

	}
*/
	public static function getZipCode($cdZipCode)
	{

		$cdZipCode = str_replace("-", "", $cdZipCode);

		$ch = curl_init();

//		curl_setopt($ch, CURLOPT_URL, "http://viacep.com.br/ws/$nrcep/json");
		curl_setopt($ch, CURLOPT_URL, "https://maps.googleapis.com/maps/api/geocode/json?postalcode=$cdZipCode&components=country:ES&KEY=AIzaSyAVuRxfZhK1rT3qC2bXDZdCcE2LDFsadJs");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$data = json_decode(curl_exec($ch), true);

		$lat = $data["results"][0]["geometry"]["location"]["lat"];
		$lng = $data["results"][0]["geometry"]["location"]["lng"];

		curl_setopt($ch, CURLOPT_URL, "https://maps.googleapis.com/maps/api/geocode/json?latlng=$lat,$lng&components=country:ES");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

		$data = json_decode(curl_exec($ch), true);

		curl_close($ch);

		return $data;

	}

	public function loadFromZipCode($cdZipCode)
	{

		$data = Address::getZipCode($cdZipCode);
/*
		if (isset($data['logradouro']) && $data['logradouro']){

			$this->setdsaddress($data['dsaddress']);
			$this->setdscity($data['dscity']);
			$this->setdscountry('Brasil');
			$this->setnrzipcode($nrcep);

		}
*/
		$this->setdsaddress($data['dsaddress']);
		$this->setdscity($data['place']['place name']);
		$this->setdscountry('Spain');
		$this->setcdzipcode($cdZipCode);

	}

	public function get($address)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_addresses WHERE idaddress = :idaddress", [
			':idaddress'=>$address->getidaddress()
		]);

		if (count($results) > 0) {

			$this->setData($results[0]);

		}

	}

	public function getDefault()
	{

		$sql = new Sql();

		$results = $sql->select("
			SELECT * 
			  FROM tb_addresses 
			 WHERE idperson = :idperson AND
			 	   tpaddress = :tpaddress AND
			 	   fldefault = 'S'", [
			":idperson"=>$this->getidperson(),
			":tpaddress"=>$this->gettpaddress()
		]);

		if (count($results) > 0) {

			$this->setData($results[0]);

		}

	}

	public function save()
	{

		$sql = new Sql();

		$results = $sql->select("CALL sp_addresses_save(:idaddress, :idperson, :dsaddress, :dsnumber, :dscity, :dscountry, :cdzipcode, :tpaddress, :fldefault, :flreplicate)", [
			':idaddress'=>$this->getidaddress(), 
			':idperson'=>$this->getidperson(),
			':dsnumber'=>$this->getdsnumber(), 
			':dsaddress'=>utf8_decode($this->getdsaddress()), 
			':dscity'=>utf8_decode($this->getdscity()),
			':dscountry'=>utf8_decode($this->getdscountry()),
			':cdzipcode'=>$this->getcdzipcode(),
			':tpaddress'=>$this->gettpaddress(),
			':fldefault'=>$this->getfldefault(),
			':flreplicate'=>$this->getflreplicate()
		]);

		if (count($results) > 0) {
			$this->setData($results[0]);
		}

	}

	public function delete()
	{

		$sql = new Sql();

		$results = $sql->select("CALL sp_addresses_delete (:idaddress)", 
			array(
			":idaddress"=>$this->getidaddress()
		));

		// atribui o resultado no próprio objeto, para o caso de quem chamou necessite do resultado
		$this->setData($results[0]);

	}

	public function getOrders($address) {

		$sql = new Sql();

		$results = $sql->select("
			SELECT *
			  FROM tb_orders 
			 WHERE idaddress = :idaddress AND 
			 	   idstatus <> 4
		  ORDER BY dtregister DESC
		", [
			":idaddress"=>$this->getidaddress()
		]);

		return $results;

	}

	public static function setSuccess($msg)
	{

		$_SESSION[Address::SUCCESS] = $msg;

	}

	public static function getSuccess()
	{

		$msg = isset($_SESSION[Address::SUCCESS]) && $_SESSION[Address::SUCCESS] ? $_SESSION[Address::SUCCESS] : "";

		Address::clearSuccess();

		return $msg;

	}

	public static function clearSuccess()
	{

		$_SESSION[Address::SUCCESS] = NULL;

	}

	public static function setError($msg)
	{

		$_SESSION[Address::ERROR] = $msg;

	}

	public static function getError()
	{

		$msg = isset($_SESSION[Address::ERROR]) && $_SESSION[Address::ERROR] ? $_SESSION[Address::ERROR] : "";

		Address::clearError();

		return $msg;

	}

	public static function clearError()
	{

		$_SESSION[Address::ERROR] = NULL;

	}

}

?>