<?php
session_start();

 /**
 * Kontroler koji upravlja stranicom Login
 * Nasljedjuje osnovnu Controller klasu
 *
 *
 * @package mojMVC\app\controllers
 * @subpackage login
 * @version 1.0
 * @since 20-05-2015
 * @author   Zeljko Krnjic <zeljko-10000@hotmail.com>
 **/
class Login extends Controller
{
	/**
	* Objekt klase User
	* Rezultat iz baze podataka sa istim emailom kao onim sto ga je korisnik unijeo u formu
	* @access public
	* @var User
	*/
	public $user = NULL;

	/**
	* Sadrzi poruke o greskama koje su se dogodile pri logiranju
	* @access public
	* @var string
	*/
	public $errors = "";

	/**
	* Sadrzi izgled poruke o greskama ili uspjelom logiranju
	* @access public
	* @var string
	*/
	public $errorStyle = "";


	/**
	* Index akcija login kontrolera
	* Preuzima podatke koje je korisnik unijeo u login formu,
	* te ako su podatci valjani pokušava pronaci korisnika u bazi.
	* Ako pronadje korisnika postavlja se sesija -> korisnik se ulogira,
	* u suprotnom ispisuje pogreske do kojih je doslo
	* @access public
	*/
	public function index()
	{
		$this->model('User');
		$this->model('Session');

		if(Session::exists())
		{
			echo "<h3 class='text-danger'>&nbsp;&nbsp;&nbsp;You are already logged in as: " . Session::getUsername() . "</h3></br>";
		}

		if(isset($_POST['loginSubmitBtn']))
		{
			$tempEmail = htmlentities($_POST['email']);
			$tempPass = htmlentities(md5("asd897s6sd76".$_POST['password']."7sd8d7f67"));
			$this->user = User::getByEmail($tempEmail);
			
			
			if($this->user)
			{
				echo "User found</br>";
				if($this->user->getPassword() === $tempPass)
				{
					$this->errors = "Login Successfull!";
					$this->errorStyle = "text-success";

					Session::setSession($this->user->getUsername(), $this->user->getPrava(), $this->user->getId(), $this->user->getEmail());
					header("Location: index.php");
				}
				else
				{
					$this->errors = "Login Invalid.";
					$this->errorStyle = "text-danger";
				}
			}
			else
			{
				$this->errors = "Login invalid.";
				$this->errorStyle = "text-danger";
			}
		}
		$this->view('login/index', ['errors' => $this->errors,
									'errorStyle' => $this->errorStyle,
									'naslov' => 'Login page']);
	}

}