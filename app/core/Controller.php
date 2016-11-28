<?php

/**
* Klasa Controller sluzi za ucitavanje modela i pogleda
*
*
* @package mojMVC\app\core
* @subpackage Controller
* @version 1.0
* @since 20-05-2015
* @author   Zeljko Krnjic <zeljko-10000@hotmail.com>
**/
class Controller
{

	/**
	* Javna metoda za ucitavanje modela
	* @access public
	* @param string $model
	*/
	public function model($model)
	{
		require_once('../app/models/' . $model . '.php');
	}

	/**
	* Javna metoda za ucitavanje pogleda sa određenim podatcima
	* Podatci se salju pogledu u obliku niza.
	* @access public
	* @param string $view
	* @param array
	*/
	public function view($view, $data = [])
	{
		require_once('../app/views/' . $view . '.php');
	}
}