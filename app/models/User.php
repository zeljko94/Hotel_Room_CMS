<?php

/**
* Klasa user sluzi za dodavanje, brisanje, izmjenu i dohvacanje
* podataka o korisnicima iz baze podataka
* 
*
*
* @package mojMVC\app\models
* @subpackage User
* @version 1.0
* @since 23-05-2015
* @author Zeljko Krnjic <zeljko-10000@hotmail.com>
*/
class User
{
	/**
	* Korisnicko ime 
	* @access private
	* @var string
	*/
	private $username;

	/**
	* Lozinka korisnika
	* @access private
	* @var string
	*/
	private $password;

	/**
	* Email korisnika
	* @access private
	* @var string
	*/
	private $email;

	/**
	* Ime korisnika
	* @access private
	* @var string
	*/
	private $name;

	/**
	* Prezime korisnika
	* @access private
	* @var string
	*/
	private $lastName;

	/**
	* Id korisnika
	* @access private
	* @var int
	*/
	private $id;

	/**
	* Privilegije korisnika
	* @access private
	* @var int
	*/
	private $prava;


	/**
	* Konstruktor klase User
	* @acces public
	*/
	public function User()
	{

	}


	/**
	* Javna staticka metoda za dohvacanje korisnika iz baze preko id-a
	* @access public
	* @static
	* @param int $id
	* @return User | false
	*/
	public static function getById($id)
	{
		$db = new DB("mywebpage", "localhost", "root", "");
		$db->Query("SELECT * FROM users WHERE id=?", [$id]);
		
		$result = new User();
		$result->setUsername($db->getResult()[0]['username']);
		$result->setPassword($db->getResult()[0]['password']);
		$result->setEmail($db->getResult()[0]['email']);
		$result->setName($db->getResult()[0]['name']);
		$result->setLastName($db->getResult()[0]['lastName']);
		$result->setId($db->getResult()[0]['id']);
		$result->setPrava($db->getResult()[0]['prava']);
		$result->setCity($db->getResult()[0]['city']);
		return $result;
	}


	/**
	* Javna staticka metoda za dohvacanje korisnika iz baze preko email-a
	* @access public
	* @static
	* @param string $email
	* @return User | false
	*/
	public static function getByEmail($email)
	{
		$db = new DB("mywebpage", "localhost", "root", "");
		$db->Query("SELECT * FROM users WHERE email=?", [$email]);
		if(!$db->getResult()) return NULL;

		$result = new User();
		$result->setUsername($db->getResult()[0]['username']);
		$result->setPassword($db->getResult()[0]['password']);
		$result->setEmail($db->getResult()[0]['email']);
		$result->setName($db->getResult()[0]['name']);
		$result->setLastName($db->getResult()[0]['lastName']);
		$result->setId($db->getResult()[0]['id']);
		$result->setPrava($db->getResult()[0]['prava']);
		$result->setCity($db->getResult()[0]['city']);
		return $result;
	}


	/**
	* Javna staticka metoda za dohvacanje korisnika iz baze preko korisnickog imena
	* @access public
	* @static
	* @param string $username
	* @return User | false
	*/
	public static function getByUsername($username)
	 {
		$db = new DB("mywebpage", "localhost", "root", "");
		$db->Query("SELECT * FROM users WHERE username=?", [$username]);
		if(!$db->getResult()) return NULL;

		$result = new User();
		$result->setUsername($db->getResult()[0]['username']);
		$result->setPassword($db->getResult()[0]['password']);
		$result->setEmail($db->getResult()[0]['email']);
		$result->setName($db->getResult()[0]['name']);
		$result->setLastName($db->getResult()[0]['lastName']);
		$result->setId($db->getResult()[0]['id']);
		$result->setPrava($db->getResult()[0]['prava']);
		$result->setCity($db->getResult()[0]['city']);
		return $result;

	 }


	 /**
	 * Javna staticka metoda spremanje korisnika u bazu podataka
	 * @access public
	 * @static
	 * @param string $username
	 * @param string $password
	 * @param string $name
	 * @param string $lastName
	 * @param string $email
	 * @param int $prava
	 * @param string $city
	 */
	public static function saveIntoDb($username, $password, $name, $lastName, $email, $city='', $prava=4)
	{
		$db = new DB("mywebpage", "localhost", "root", "");
		$db->Query("INSERT INTO users(username, password, name, lastName, email, city, prava) VALUES(?, ?, ?, ?, ?, ?, ?)", [$username, $password, $name, $lastName, $email, $city, $prava]);
	}

	/**
	* Javna staticka metoda za dohvatanje svih korisnika iz baze
	* @access public
	* @static
	* @return \User[] | false
	*/
	public static function getAllUsers()
	{
		$db = new DB("mywebpage", "localhost", "root", "");
		$db->Query("SELECT * FROM users WHERE 1", []);
		if(!$db->getResult()) return false;

		$result = array();
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
			array_push($result, $novi);
		}
		return $result;
	}

	/**
	* Javna staticka metoda za brisanje korisnika iz baze preko id-a
	* ako postoji korisnik u bazi sa zadanim id-om
	* @access public
	* @static
	* @param int $id
	* @return User | false
	*/
	public static function removeFromDB($id)
	{
		$user = User::getById($id);
		if(!$user) return false;
		$db = new DB("mywebpage", "localhost", "root", "");
		$db->Query("DELETE FROM users WHERE id=?", [$id]);
		return true;
	}


	/**
	* Javna staticka metoda za izmjenu podataka korisnika sa zadanim id-om
	* ako korisnik postoji u bazi.
	* Ako je brisanje uspjesno vraca true u suprotnom vraca false.
	* @access public
	* @static
	* @param string $username
	* @param string $password
	* @param string $email
	* @param string $name
	* @param string $lastName
	* @param string $city
	* @param int $prava
	* @param int $id
	* @return boolean
	*/
	public static function update($username, $password, $email, $name, $lastName, $city, $prava,$id)
	{
		$user = User::getById($id);
		if(!$user) return false;
		$db = new DB("mywebpage", "localhost", "root", "");
		$db->Query("UPDATE users SET username=?, password=?, email=?, name=?, lastName=?, city=?, prava=? WHERE id=?",
			[$username, $password, $email, $name, $lastName, $city, $prava, $id]);
		return true;
	}
	// GETTERS ----------------------------------------------------------------------------------------------------------------------------------
	/**
	* Getter metoda za korisnicko ime
	* @access public
	* @return string
	*/
	public function getUsername(){ return $this->username; }

	/**
	* Getter metoda za lozinku korisnika
	* @access public
	* @return string
	*/
	public function getPassword(){ return $this->password; }

	/**
	* Getter metoda za email korisnika
	* @access public
	* @return string
	*/
	public function getEmail(){ return $this->email; }

	/**
	* Getter metoda za ime korisnika
	* @access public
	* @return string
	*/
	public function getName(){ return $this->name; }

	/**
	* Getter metoda za prezime korisnika
	* @access public
	* @return string
	*/
	public function getLastName(){ return $this->lastName; }

	/**
	* Getter metoda za id korisnika
	* @access public
	* @return int
	*/
	public function getId(){ return $this->id; }

	/**
	* Getter metoda za privilegije korisnika
	* @access public
	* @return int
	*/
	public function getPrava(){ return $this->prava; }

	/**
	* Getter metoda za grad korisnika
	* @access public
	* @return string
	*/
	public function getCity(){ return $this->city; }

	// SETTERS -------------------------------------------------------------------------------------------------------------------------------------------------
	/**
	* Setter metoda za korisnicko ime
	* @access public
	* @param string $value
	*/
	public function setUsername($value) { $this->username = $value; }

	/**
	* Setter metoda za lozinku
	* @access public 
	* @param string $value
	*/
	public function setPassword($value) { $this->password = $value; }

	/**
	* Setter metoda za email
	* @access public 
	* @param string $value
	*/
	public function setEmail($value) { $this->email = $value; }

	/**
	* Setter metoda za ime korisnika
	* @access public 
	* @param string $value
	*/
	public function setName($value) { $this->name = $value; }

	/**
	* Setter metoda za prezime korisnika
	* @access public 
	* @param string $value
	*/
	public function setLastName($value) { $this->lastName = $value; }

	/**
	* Setter metoda za id korisnika
	* @access public 
	* @param int $value
	*/
	public function setId($value) { $this->id = $value; }

	/**
	* Setter metoda za privilegije korisnika
	* @access public 
	* @param int $value
	*/
	public function setPrava($value) { $this->prava = $value; }

	/**
	* Setter metoda za grad korisnika
	* @access public 
	* @param string $value
	*/
	public function setCity($value) { $this->city = $value; }
}
