<?php

/**
* Klasa koja sluzi za spajanje sa bazom i 
* vrsenje upita nad bazom podataka.
*
*
* @package mojMVC\app\core
* @subpackage DB
* @version 1.0
* @since 20-05-2015
* @author   Zeljko Krnjic <zeljko-10000@hotmail.com>
**/
class DB
{
	private $server;
	private $user;
	private $password;
	private $dbName;
	private $conn;
	private $query = "";
	private $result = NULL;
	private $rows = 0;

	/**
	* Konstruktor klase DB - kreira objekt baze podataka sa zadanim
	* nazivom baze, nazivom domene, korisnickim imenom i  lozinkom, te
	* se pokusava spojiti na bazu.Ako spajanje u bazu ne uspije ispisuje se tekst pogreske.
	* @access public
	* @throw PDOException $e
	* @param string $name
	* @param string $server
	* @param string $user
	* @param string $password
	*/
	public function DB($name, $server, $user, $password)
	{
		$this->dbName = $name;
		$this->password = $password;
		$this->server = $server;
		$this->user = $user;

		try
		{
			$this->conn = new PDO("mysql: host=$this->server;dbname=$this->dbName;charset=utf8;", "root", "");
		}catch(PDOException $e)
		{
			echo "ERROR: " . $e->getMessage() . "</br>";
		}
	}

	/**
	* Metoda za vrsenje upita nad bazom podataka koristeci PDO (PHP Database Object)
	* Kao prvi argument prima zeljeni SQL upit, a kao drugi argument
	* prima niz varijabli koje zelimo umetnuti u nas upit.
	* @access public
	* @param string $sql
	* @param array $params
	* @return array
	*/
	public function Query($sql, $params = [])
	{
			$this->query = $this->conn->prepare($sql);

			$x=1;
			foreach($params as $param)
			{
				$this->query->bindValue($x, $param);
				$x++;
			}
			$this->query->execute();
			$this->result = $this->query->fetchAll();
			$this->rows = $this->query->rowCount();

			return $this->result;
	}


	// GETTERS -------------------------------------------------------------------------------------------
	/**
	* Getter metoda za server na kojem se nalazi baza.
	* @access public
	* @return string
	*/
	public function getServer(){ return $this->server; }

	/**
	* Getter metoda za korisnicko ime za pristup bazi.
	* @access public
	* @return string
	*/
	public function getUser(){ return $this->user; }

	/**
	* Getter metoda za lozinku za pristup bazi.
	* @access public
	* @return string
	*/
	public function getPassword(){ return $this->password; }

	/**
	* Getter metoda za naziv odabrane baze.
	* @access public
	* @return string
	*/
	public function getDbName(){ return $this->dbName; }

	/**
	* Getter metoda za konekciju sa bazom.
	* @access public
	* @return PDO
	*/
	public function getConn(){ return $this->conn; }

	/**
	* Getter metoda za upit 
	* @access public
	* @return string
	*/
	public function getQuery(){ return $this->query; }

	/**
	* Getter metoda za rezultate izvrsenog upita.
	* @access public
	* @return mixed
	*/
	public function getResult(){ return $this->result; }

	/**
	* Getter metoda za broj rezultata.
	* @access public
	* @return int
	*/
	public function getRows(){ return $this->rows; }
	// SETTERS -------------------------------------------------------------------------------------------

	/**
	* Setter metoda za server na kojem je baza.
	* @access public
	* @param string $value
	*/
	public function setServer($value){ $this->server = $value; }


	/**
	* Setter metoda za korisnicko ime za pristup bazi
	* @access public
	* @param string $value
	*/
	public function setUser($value){ $this->user = $value; }


	/**
	* Setter metoda za lozinku za pristup bazi
	* @access public
	* @param string $value
	*/
	public function setPassword($value){ $this->password = $value; }

	/**
	* Setter metoda za naziv baze
	* @access public
	* @param string $value
	*/
	public function setDbName($value){ $this->dbName = $value; }


	/**
	* Setter metoda za konekciju sa bazom
	* @access public
	* @param PDO $value
	*/
	public function setConn($value){ $this->conn = $value; }

	/**
	* Setter metoda za upit nad bazom
	* @access public
	* @param string $value
	*/
	public function setQuery($value){ $this->query = $value; }

	/**
	* Setter metoda za rezultate izvrsenog upita
	* @access public
	* @param mixed $value
	*/
	public function setResult($value){ $this->result = $value; }

	/**
	* Setter metoda za broj rezultata izvrsenog upita
	* @access public
	* @param int $value
	*/
	public function setRows($value){ $this->rows = $value; }
}
