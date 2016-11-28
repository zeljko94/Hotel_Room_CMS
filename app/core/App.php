<?php

/**
* Klasa App sluzi za odredjivanje kontrolera, akcije i parametara
* iz URL-a
*
*
* @package mojMVC\app\core
* @subpackage App
* @version 1.0
* @since 20-05-2015
* @author   Zeljko Krnjic <zeljko-10000@hotmail.com>
**/
class App
{
	/**
	* Kontroler koji pokrece stranicu
	* @access protected
	* @var string
	*/
	protected $controller = 'home';

	/**
	* Akcija kontrolera
	* @access protected
	* @var string
	*/
	protected $method = 'index';
	/**
	* Parametri koje predajemo akciji kontrolera
	* @access protected
	* @var array
	*/
	protected $params = [];	


	/**
	* Konstruktor klase App
	* Ucitava zadani kontroler i akciju kontrolerima sa parametrima ako ih ima.
	* Ako zadani naziv kontrolera i akcije ne postoje ucitava se kontroler 'home' sa akcijom 'index' bez parametara.
	* Metoda prima string URL rastavljen u niz, te prvi element u nizu($url[0]) predstavlja kontroler,
	* drugi element akciju kontrolera($url[1]),  a svi ostali elementi parametre koji se predaju akciji kontrolera
	* @access public
	*/
	public function __construct()
	{
		$url = $this->parseUrl();
		
		if(file_exists('../app/controllers/' . $url[0] . '.php'))
		{
			$this->controller = $url[0];
			unset($url[0]);
		}

		require_once('../app/controllers/' . $this->controller . '.php');
		
		$this->controller = new $this->controller;

		if(isset($url[1]))
		{
			if(method_exists($this->controller, $url[1]))
			{
				$this->method = $url[1];
				unset($url[1]);
			}
		}

		$this->params = $url ? array_values($url) : [];

		call_user_func_array([$this->controller, $this->method], $this->params);
	}


	/**
	* Metoda koja rastavlja URL na svako pojavljivanje znaka '/' i
	* vraca rastavljeni URL kao niz.
	* @access public
	* @return array
	*/
	public function parseUrl()
	{
		if(isset($_GET['url']))
		{
			return $url = explode('/', filter_var(rtrim($_GET['url'], '/'), FILTER_SANITIZE_URL));
		}
	}
}