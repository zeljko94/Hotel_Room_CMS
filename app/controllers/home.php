<?php
session_start();

 /**
 * Kontroler koji upravlja naslovnom stranicom
 * Nasljedjuje osnovnu Controller klasu
 *
 *
 * @package mojMVC\app\controllers
 * @subpackage home
 * @version 1.0
 * @since 20-05-2015
 * @author   Zeljko Krnjic <zeljko-10000@hotmail.com>
 **/
class Home extends Controller
{
	/**
	* Index akcija home kontrolera
	* @access public
	*/
	public function index()
	{
		$this->model('User');
		$this->model('Session');
		
		$this->view('home/index', ['naslov' => 'Homepage'
			]);
	}
}