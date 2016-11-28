<?php
session_start();

 /**
 * Kontroler koji upravlja stranicom adminPage
 * Nasljedjuje osnovnu Controller klasu
 *
 *
 * @package mojMVC\app\controllers
 * @subpackage adminPage
 * @version 1.0
 * @since 20-05-2015
 * @author   Zeljko Krnjic <zeljko-10000@hotmail.com>
 **/
class AdminPage extends Controller
{
	/** 
	* Index akcija kontrolera AdminPage
	* @access public
	*/
	public function index()
	{
		$this->model('User');
		$this->model('Session');

		if(Session::isAdmin())
		{
			$this->view('admin_panel/adminPage', []);	
		}
		else
		{
			header("Location: index.php");
		}				

	}

	/**
	* Akcija za prikaz korisnika u obliku tablice
	* Takodjer mozemo pretrazivati korisnike prema odredjenim atributima
	* @access public
	* @param string $searchBy
	* @param string $searchKeyword
	*/
	public function showUsers($searchBy='',$searchKeyword='')
	{
		$this->model('Session');
		if(Session::isAdmin())
			{
				$this->model('User');
				$users = array();
				if(isset($_POST['searchUsersButton']))
				{
					$searchBy = isset($_POST['searchForm']) ? htmlentities($_POST['searchForm']) : "";
					$searchKeyword = htmlentities($_POST['searchUserKeyword']);

					$db = new DB("mywebpage", "localhost", "root", "");
					$db->Query("SELECT * FROM users WHERE $searchBy LIKE ?", ["%".$searchKeyword."%"]);
					

					foreach($db->getResult() as $user)
					{
						$novi = new User();
						$novi->setUsername($user['username']);
						$novi->setPassword($user['password']);
						$novi->setEmail($user['email']);
						$novi->setName($user['name']);
						$novi->setLastName($user['lastName']);
						$novi->setCity($user['city']);
						$novi->setPrava($user['prava']);
						$novi->setId($user['id']);
						array_push($users, $novi);
					}
				}
				else
				{
					$users = User::getAllUsers();
				}

				$this->view('admin_panel/showUsers', ['users' => $users,
													  'searchBy' => $searchBy,
													  'searchKeyword' => $searchKeyword]);
			}
			else
			{
				header("Location: index.php");
			}
	}


	/**
	* Akcija za brisanje odabranog korisnika preko id-a iz admin panela
	* @access public
	* @param int $id
	*/
	public function deleteUser($id)
	{
		$this->model('Session');
		if(Session::isAdmin())
		{
			$this->model('User');
			User::removeFromDB($id);
			header("Location: index.php?url=adminPage/showUsers");
		}
		else
		{
			header("Location: index.php");
		}
	}


	/**
	* Akcija za dodavanje korisnika u bazu preko admin panela.
	* Provjerava je li admin ispravno unijeo podatke, ako jeste sprema korisnika u bazu, u suprotnom
	* javlja greske te trazi od korisnika da unese ponovno.
	* @access public
	*/
	public function addUser()
	{
		$this->model('Session');

		$username = "";
		$password = "";
		$rePassword = "";
		$email = "";
		$name = "";
		$lastName = "";
		$city = "";
		$prava = "";
		$errors = "";
		$errorStyle = "";
		if(Session::isAdmin())
		{
			$this->model('User');
			if(isset($_POST['addUserButton']))
			{
				$username = htmlentities($_POST['username']);
				$password = htmlentities($_POST['password']);
				$rePassword = htmlentities($_POST['rePassword']);
				$email = htmlentities($_POST['email']);
				$name = htmlentities($_POST['name']);
				$lastName = htmlentities($_POST['lastName']);
				$city = htmlentities($_POST['city']);
				$prava = htmlentities($_POST['prava']);
				$errors=  "";
				$errorStyle = "";

				if(!empty($username))
				{
					if(!empty($password))
					{
						if($password === $rePassword)
						{
							if(strstr($email, '@') and strstr($email, '.') and strlen($email) > 6)
							{
								if($prava >=1 and $prava <=4)
								{
										$user = User::getByUsername($username);
										if($user)
										{
											$errors = "Username already exists.";
											$errorStyle = "text-danger";
										}
										else
										{
											$user = User::getByEmail($email);
											if($user) 
											{
												$errors = "Email already exists.";
												$errorStyle = "text-danger";
											}
											else
											{
												User::saveIntoDb($username, md5("asd897s6sd76".$password."7sd8d7f67"), $name, $lastName, $email, $city, $prava);
												$errors = "User added sucessfully.";
												header("Location: index.php?url=adminPage/showUsers");
											}
										}
								}
								else
								{
									$errors = "korisnicka prava invalid.";
									$errorStyle = "text-danger";
								}
							}
							else
								{
									$errors="Invalid email.";
									$errorStyle = "text-danger";
								}
						}
						else
						{
							$errors = "Passwords doesnt match.";
							$errorStyle = "text-danger";
						}
					}
					else
					{
						$errors = "Please enter password for user.";
						$errorStyle = "text-danger";
					}
				}
				else
				{
					$errors = "Please enter username for user.";
					$errorStyle = "text-danger";
				}
			}
			$this->view('admin_panel/addUser', ['errors' => $errors,
												'errorStyle' => $errorStyle,
												'username' => $username,
												'email' => $email,
												'name' => $name,
												'lastName' => $lastName,
												'city' => $city,
												'prava' => $prava]);
		}
		else 
		{
			header("Location: index.php");
		}
	}

	/**
	* Akcija za izmjenu podataka odabranog korisnika preko id-a
	* @access public
	* @param int $id
	*/
	public function editUser($id='')
	{
		$this->model('Session');

		$errors = "";
		$errorStyle = "";
		$username = "";
		$password = "";
		$rePassword = "";
		$email = "";
		$name = "";
		$lastName = "";
		$city = "";
		$prava = "";

		if(!Session::isAdmin())
		{
			header("Location: index.php");
		}
		$this->model('User');
		$user = User::getById($id);
		if(!$user) return;


		if(isset($_POST['editUserButton']))
		{
			$username = htmlentities($_POST['username']);
			$password = htmlentities($_POST['password']);
			$email = htmlentities($_POST['email']);
			$name = htmlentities($_POST['name']);
			$lastName = htmlentities($_POST['lastName']);
			$city = htmlentities($_POST['city']);
			$prava = htmlentities($_POST['prava']);

			if(!empty($username))
			{
				if(!empty($password))
				{
						if(strstr($email, '@') && strstr($email, '.') and strlen($email) > 6)
						{
							if($prava >=1 and $prava <=4)
							{
								$novi = User::getByEmail($email);
								if(!$novi || $novi->getEmail() === $email)
								{
									$novi = User::getByUsername($username);
									if(!$novi || $novi->getUsername() === $username)
									{
										User::update($username, md5("asd897s6sd76".$password."7sd8d7f67"), $email, $name, $lastName, $city, $prava, $user->getId());
										header("Location: index.php?url=adminPage/showUsers");
									}
									else
									{
										$errors = "Username already exists.";
										$errorStyle = "text-danger";
									}
								}
								else
								{
									$errors = "Email already in use.";
									$errorStyle = "text-danger";
								}
							}
							else	
							{
								$errors = "Invalid prava.";
								$errorStyle = "text-danger";
							}
						}
						else
						{
							$errors = "Invalid email.";
							$errorStyle = "text-danger";
						}
					}
				else
				{
					$errors = "Please enter your password.";
					$errorStyle = "text-danger";
				}
			}
			else
			{
				$errors = "Please enter your username.";
				$errorStyle = "text-danger";
			}
		}

		$this->view('admin_panel/editUser', ['user' => $user,
											 'errors' => $errors]);
	}


	/**
	* Akcija za prikaz i pretragu rezervacija spremljenih u bazi.
	* @access public
	* @param string $searchBy
	* @param string $searchKeyword
	*/
	public function pregledRezervacija($searchBy='', $searchKeyword='')
	{
		$this->model('Session');

		if(!Session::isAdmin()) header("Location index.php");
		$this->model('Session');
		$this->model('Rezervacija');

		Rezervacija::brisiIstekleRezervacije();
		
		$rezervacije = array();
		if(isset($_POST['searchRezervacijeButton']))
		{
			$searchBy = isset($_POST['searchRezervacijeSelect']) ? $_POST['searchRezervacijeSelect'] : "";
			$searchKeyword = isset($_POST['searchRezervacijeKeyword']) ? $_POST['searchRezervacijeKeyword'] : "";

			if(!empty($searchBy) && !empty($searchKeyword))
			{

				$db = new DB("mywebpage", "localhost", "root", "");
				$db->Query("SELECT * FROM rezervacije WHERE $searchBy LIKE ?", ["%".$searchKeyword."%"]);

				foreach($db->getResult() as $rezervacija)
				{
					$novi = new Rezervacija();
					$novi->setId($rezervacija['id']);
					$novi->setPocetniDatum($rezervacija['pocetniDatum']);
					$novi->setZavrsniDatum($rezervacija['zavrsniDatum']);
					$novi->setDatumUplate($rezervacija['datumUplate']);
					$novi->setImeKorisnika($rezervacija['imeGosta']);
					$novi->setPrezimeKorisnika($rezervacija['prezimeGosta']);
					$novi->setEmailKorisnika($rezervacija['emailGosta']);
					$novi->setTelefonKorisnika($rezervacija['telefonGosta']);
					$novi->setIdSobe($rezervacija['idSobe']);
					$novi->setTipSobe($rezervacija['tipSobe']);
					$novi->setCijena($rezervacija['cijena']);
					array_push($rezervacije, $novi);
				}
			}			
		}
		else
		{
			$rezervacije = Rezervacija::getAll();
		}


		$this->view('admin_panel/pregledRezervacija', ['rezervacije' => $rezervacije,
													   'searchBy' => $searchBy,
													   'searchKeyword' => $searchKeyword]);
	}


	/**
	* Akcija za brisanje odabrane rezervacije preko id-a
	* @access public
	* @param int $id
	*/
	public function brisiRezervaciju($id='')
	{
		$this->model('Session');
		if(!Session::isAdmin()) header("Location: index.php");

		$this->model('Rezervacija');
		Rezervacija::brisiById($id);
		header("Location: index.php?url=adminPage/pregledRezervacija");
	}
}