<?php
session_start();
 /**
 * Kontroler koji upravlja stranicom Contact
 * Nasljedjuje osnovnu Controller klasu
 *
 *
 * @package mojMVC\app\controllers
 * @subpackage contact
 * @version 1.0
 * @since 20-05-2015
 * @author   Zeljko Krnjic <zeljko-10000@hotmail.com>
 **/
class Contact extends Controller
{

	/**
	* Index akcija Contact kontrolera
	* @access public
	*/
	public function index()
	{
		$this->model('Session');
		$this->view('contact/index', []);
	}
}