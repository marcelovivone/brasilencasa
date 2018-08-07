<?php

namespace Tila;

use Rain\Tpl;

class Page 
{

	private $tpldes_dir = "";
	private $options = [];
	private $defaults = [
//			"header"=>true,
			"header"=>
				[
					"load"=>true,
					"args"=> true
				]
			,
			"footer"=>true,
//			"header"=>false,
//			"footer"=>false,
			"data"=>[]
	];

	// segundo parâmetro devido à PageAdmin estender Page
	public function __construct($opts = array(), $tpl_dir = "/views/") 
	{

		/*
			opts[]:
				0: PHP Header name
				1: TPL archive directory
				2: TPL header archive directory
				3: Menu array
				4: Route for HTML link action
		*/

		$this->options = array_merge($this->defaults, $opts);

		$this->tpl = new Tpl;

		// em todas as páginas HTML vai existir o header (exceto login)
/*		if ($this->options["header"] === true) $this->tpl->draw($tpl_dir.$opts[0]."/header"); */
		if ($this->options["header"]["load"] === true){

			$config = array(
				// utilização de $tpl_dir devido à PageAdmin estender Page
	//    		"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/",
	//    		"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"].$tpl_dir.,
	    		"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"].$tpl_dir.$opts[2]."/",
	    		"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
	    		"debug"         => false // set to false to improve the speed
			);

			Tpl::configure($config);

			$this->setData($this->options["data"]);

//			$this->tpl->draw("header");
			if ($this->options["header"]["args"] === true) {
				$this->setTpl($opts[0], [
					'menu'=>$opts[3],
					'route'=>$opts[4],
					'cart'=>$opts[5],
					'cartProducts'=>$opts[6]
				]);
			} else {
				$this->tpl->draw("header");
			}

			/* for destruct method */
			$this->tpldes_dir = $tpl_dir.$opts[2];

		}

		// config
		$config = array(
			// utilização de $tpl_dir devido à PageAdmin estender Page
//    		"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/",
//    		"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"].$tpl_dir.,
    		"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"].$tpl_dir.$opts[1]."/",
    		"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
    		"debug"         => false // set to false to improve the speed
		);

		Tpl::configure($config);

		$this->setData($this->options["data"]);

	}

	private function setData($data = array())
	{

		// assign variables
		foreach ($data as $key => $value) 
		{

			$this->tpl->assign($key, $value);
		
		}

	}

	// argumentos: nome do template, dados, se retorna o HTML ou se joga na tela
	public function setTpl($name, $data = array(), $returnHTML = false)
	{

		$this->setData($data);

		return $this->tpl->draw($name, $returnHTML);

	}

	public function __destruct()
	{

		// quando a classe for finalizada, deve-se incluir o footer, que vai existir
		// em todas as páginas HTML (exceto login)
		if ($this->options["footer"] === true) {
			$config = array(
				// utilização de $tpl_dir devido à PageAdmin estender Page
	//    		"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"]."/views/",
	//    		"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"].$tpl_dir.,
	    		"tpl_dir"       => $_SERVER["DOCUMENT_ROOT"].$this->tpldes_dir."/",
	    		"cache_dir"     => $_SERVER["DOCUMENT_ROOT"]."/views-cache/",
	    		"debug"         => false // set to false to improve the speed
			);

			Tpl::configure($config);

			$this->setData($this->options["data"]);
			$this->tpl->draw("footer");
		}
	}
}

?>