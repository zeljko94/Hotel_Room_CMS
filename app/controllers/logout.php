<?php
session_start();

 /**
 * Kontroler koji upravlja logout stranicom
 * Nasljedjuje osnovnu Controller klasu
 *
 *
 * @package mojMVC\app\controllers
 * @subpackage logout
 * @version 1.0
 * @since 20-05-2015
 * @author   Zeljko Krnjic <zeljko-10000@hotmail.com>
 **/
class Logout extends Controller
{

	/**
	* Index akcija logout kontrolera.
	* Unistava podatke o trenutnoj sesiji.
	* @access public
	*/
	public function index()
	{
		$this->model('Session');
		
		Session::destroySession();
		header("Location: index.php");
	}
}