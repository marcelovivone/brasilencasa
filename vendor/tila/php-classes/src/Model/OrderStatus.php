<?php

namespace Tila\Model;

use \Tila\DB\Sql;
use \Tila\Model;

class OrderStatus extends Model
{

	const OPEN = 1;
	const AWAYTING_PAYMENT = 2;
	const PAID_OUT = 3;
	const DELIVERED = 4;

	public static function listAll()
	{

		$sql = new Sql();

		return $sql->select("
			SELECT *
			  FROM tb_ordersstatus 
			 ORDER BY desstatus DESC
		");

	}

}

?>