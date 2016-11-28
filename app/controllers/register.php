<?php
session_start();

 /**
 * Kontroler koji upravlja stranicom za registraciju
 * Nasljedjuje osnovnu Controller klasu
 *
 *
 * @package mojMVC\app\controllers
 * @subpackage register
 * @version 1.0
 * @since 20-05-2015
 * @author   Zeljko Krnjic <zeljko-10000@hotmail.com>
 **/
class Register extends Controller
{
	/**
	* Podaci o korisniku dohvacenom iz baze na osnovu
	* korisnikovog unosa u formi za registraciju.
	* @access public
	* @var User | false
	*/
	public $user;

	/**
	* Poruke sa greskama pri registraciji
	* @access public
	* @var string
	*/
	public $errors;

	/**
	* Stil poruka o greskama
	* @access public
	* @var string
	*/
	public $errorStyle;

	/**
	* Korisnikov unos za korisnicko ime sa forme za registraciju
	* @access public
	* @var string
	*/
	public $username;

	/**
	* Korisnikov unos za lozinku sa forme za registraciju
	* @access public
	* @var string
	*/
	public $password;

	/**
	* Korisnikov unos za ponovljenu lozinku sa forme za registraciju
	* @access public
	* @var string
	*/
	public $rePassword;

	/**
	* Korisnikov unos za email sa forme za registraciju
	* @access public
	* @var string
	*/
	public $email;

	/**
	* Korisnikov unos za ime sa forme za registraciju
	* @access public
	* @var string
	*/
	public $name;

	/**
	* Korisnikov unos za prezime sa forme za registraciju
	* @access public
	* @var string
	*/
	public $lastName;

	/**
	* Korisnikov unos za grad sa forme za registraciju
	* @access public
	* @var string
	*/
	public $city;


	/**
	* Index akcija kontrolera Register
	* Provjerava jesu li podaci uneseni od strane korisnika validni,
	* ako jesu pokusava u bazi naci korisnika sa istim podatcima.
	* Ako pronadje takvog korisnika ispisuje se greska i user ponovno unosi podatke, u suprotnom
	* spremaju se podaci o novom korisniku u bazu.
	* @access public
	*/
	public function index()
	{
		$this->model('Session');
		$this->model('User');

		if(isset($_POST['registerSubmitBtn']))
		{
			$this->username = htmlentities($_POST['username']);
			$this->password = htmlentities($_POST['password']);
			$this->email = htmlentities($_POST['email']);
			$this->rePassword = htmlentities($_POST['rePassword']);
			$this->name = htmlentities($_POST['name']);
			$this->lastName = htmlentities($_POST['lastName']);
			$this->city = htmlentities($_POST['city']);

			if($this->username)
			{
				if($this->password)
				{
					if($this->rePassword === $this->password)
					{
						if(strstr($this->email, '@') and strstr($this->email, '.') and strlen($this->email) > 6)
						{
								$user = User::getByEmail($this->email);
								if(!$user)
								{
									$user = User::getByUsername($this->username);
									if(!$user)
									{
										User::saveIntoDb($this->username, md5("asd897s6sd76".$this->password."7sd8d7f67"), $this->name, $this->lastName, $this->email, $this->city, 4);
										$this->errors = "Registration successfull!";
										$this->errorStyle = "text-success";
									}
									else
									{
										$this->errors = "Username already in use.";
										$this->errorStyle = "text-danger";
									}
								}
								else
								{
									$this->errors = "Email  already in use.";
									$this->errorStyle = "text-danger";
								}
						}
						else
						{
							$this->errors = "Invalid email";
							$this->errorStyle = "text-danger";
						}
					}
					else
					{
						$this->errors = "Passwords doesnt match.";
						$this->errorStyle = "text-danger";
					}
				}
				else
				{
					$this->errors = "Please enter your password.";
					$this->errorStyle = "text-danger";
				}
			}
			else
			{
				$this->errors = "Please enter your username.";
				$this->errorStyle = "text-danger";
			}
		}

		$this->view('register/index', ['errors' => $this->errors,
									   'errorStyle' => $this->errorStyle,
									   'username' => $this->username,
									   'name' => $this->name,
									   'lastName' => $this->lastName,
									   'city' => $this->city,
									   'email' => $this->email
									   ]);
	}
}