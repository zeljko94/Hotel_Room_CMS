<?php

/**
* Ova klasa sadrzi metode za rad sa session superglobal varijablama.
* Sadrzi metode za kreiranje, brisanje ili izmjenu sesija
* Sluzi za provjeru je li user ulogiran, koje su mu privilegije i sl.
* 
*
*
* @package mojMVC\app\models
* @subpackage Session
* @version 1.0
* @since 23-05-2015
* @author Zeljko Krnjic <zeljko-10000@hotmail.com>
*/
class Session
{

	/**
	* Sadrzi korisnicko ime trenutne sesije
	* @access private
	* @var string
	*/
	private $username;


	/**
	* Sadrzi privilegije korisnika trenutne sesije (1-ADMIN, 2-MODERATOR, 3-DIREKTOR, 4-KORISNIK)
	* @access private
	* @var int
	*/
	private $prava;

	/**
	* Sadrzi id korisnika trenutne sesije
	* @access private
	* @var int
	*/
	private $id;

	/**
	* Sadrzi email korisnika trenutne sesije
	* @access private
	* @var string
	*/
	private $email;

	/**
	* Konstruktor klase Session
	* @access public
	*/
	public function __construct(){}

	/**
	* Javna staticka metoda koja provjerava postoji li trenutna sesija,
	* ako postoji vraca true, u suprotnom false
	* @access public
	* @static
	* @return boolean
	*/
	public static function exists()
	{
		if(isset($_SESSION['username']) && !empty($_SESSION['username']) &&
		   isset($_SESSION['prava']) && !empty($_SESSION['prava']) &&
		   isset($_SESSION['id']) && !empty($_SESSION['id']) &&
		   isset($_SESSION['email']) && !empty($_SESSION['email']))
		{
			return true;
		}
		else
		{
			return false;
		}
	}


	/**
	* Javna staticka metoda koja postavlja vrijednosti sesije
	* @access public
	* @static
	* @param string $username
	* @param int $prava
	* @param int $id
	* @param string $email
	*/
	public static function setSession($username, $prava, $id, $email)
	{
		$_SESSION['username'] = $username;
		$_SESSION['prava'] = $prava;
		$_SESSION['id'] = $id;
		$_SESSION['email'] = $email;
	}



	/**
	* Javna staticka metoda koja provjerava da li je korisnik
	* trenutne sesije administrator
	* @access public
	* @static
	* @return boolean
	*/
	public static function isAdmin()
	{
		if(isset($_SESSION['prava']))
		{
			if((int) $_SESSION['prava'] === 1) return true;
		}
		else return false;
	}



	/**
	* Javna staticka metoda koja provjerava da li je korisnik
	* trenutne sesije moderator
	* @access public
	* @static
	* @return boolean
	*/
	public static function isModerator()
	{
		if(isset($_SESSION['prava']))
		{
			if((int)$_SESSION['prava'] === 2) return true;
		}
		else return false;
	}


	/**
	* Javna staticka metoda koja unistava trenutnu sesiju
	* @access public
	* @static
	*/
	public static function destroySession()
	{
		session_destroy();
	}


	// GETTERS ----------------------------------------------------------------------------------------------
	/**
	* Getter funkcija za username
	* @access public
	* @static
	* @return string | false
	*/
	public static function getUsername()
	{
		if(Session::exists())
		{
			return $_SESSION['username'];
		}
		else
		{
			return false;
		}
	}



	/**
	* Getter funkcija za id
	* @access public
	* @static
	* @return int | false
	*/
	public static function getId()
	{
		if(Session::exists())
		{
			return $_SESSION['id'];
		}
		return false;
	}


	/**
	* Getter funkcija za email
	* @access public
	* @static
	* @return string | false
	*/
	public static function getEmail()
	{
		if(Session::exists())
		{
			return $_SESSION['email'];
		}
		return false;
	}


	/**
	* Getter funkcija za prava
	* @access public
	* @static
	* @return int | false
	*/
	public static function getPrava()
	{
		if(Session::exists())
		{
			return $_SESSION['prava'];
		}
		return false;
	}

	// SETTERS-------------------------------------------------------------------------------------------
	/**
	* Setter funkcija za username
	* @access public
	* @static
	* @param string $username
	*/
	public static function setUsername($username){ $_SESSION['username'] = $username; }

	/**
	* Setter funkcija za email
	* @access public
	* @static
	* @param string $email
	*/
	public static function setEmail($email){ $_SESSION['email'] = $email; }


	/**
	* Setter funkcija za id
	* @access public
	* @static
	* @param int $id
	*/
	public static function setId($id){ $_SESSION['id'] = $id; }

	/**
	* Setter funkcija za prava
	* @access public
	* @static
	* @param int $prava
	*/
	public static function setPrava($prava){ $_SESSION['prava'] = $prava; }

}