<?php

/**
* Klasa Thumbnail sluzi kako bi se korisniku prikazali
* moguci tipovi soba koje hotel nudi.
* 
*
*
* @package mojMVC\app\models
* @subpackage Thumbnail
* @version 1.0
* @since 23-05-2015
* @author Zeljko Krnjic <zeljko-10000@hotmail.com>
*/
class Thumbnail
{
	/**
	* Naziv thumbnaila
	* @access private
	* @var string
	*/
	private $naziv;

	/**
	* Id thumbnaila
	* @access private
	* @var int
	*/
	private $id;

	/**
	* Cijena sobe sa thumbnaila
	* @access private
	* @var int
	*/
	private $cijena;

	/**
	* Maksimalan broj osoba sobe sa thumbnaila
	* @access private
	* @var int
	*/
	private $maxOsoba;

	/**
	* Broj kreveta u sobi sa thumbnaila
	* @access private
	* @var int
	*/
	private $brojKreveta;

	/**
	* Putanja(PATH) do slike sobe koja se nalazi u folderu slike
	* @access private
	* @var string
	*/
	private $img_src;


	/**
	* Konstruktor klase Thumbnail
	* @access public
	*/
	public function __construct()
	{
	}


	/**
	* Javna staticka metoda koja dohvaca sve thumbnaile iz baze podataka.
	* @access public
	* @static
	* @return \Thumbnail[] | false
	*/
	public static function getAll()
	{
		$db = new DB("mywebpage", "localhost", "root", "");
		$db->Query("SELECT * FROM thumbnails WHERE 1", []);
		if(!$db->getResult()) return false;

		$result = array();
		foreach($db->getResult() as $thumbnail)
		{
			$novi = new Thumbnail();
			$novi->setNaziv($thumbnail['naziv']);
			$novi->setCijena($thumbnail['cijena']);
			$novi->setId($thumbnail['id']);
			$novi->setMaxOsoba($thumbnail['maxOsoba']);
			$novi->setBrojKreveta($thumbnail['brojKreveta']);
			$novi->setImg_Src($thumbnail['img_src']);
			array_push($result, $novi);
		}
		return $result;
	}


		// GETTERS ------------------------------------------------------------------------------------------------------------------------------
		/**
		* Getter metoda za naziv sobe.
		* @access public
		* @return string
		*/
		public function getNaziv(){ return $this->naziv; } 

		/**
		* Getter metoda za cijenu sobe.
		* @access public
		* @return int
		*/
		public function getCijena(){ return $this->cijena; } 

		/**
		* Getter metoda za maksimalan broj osoba sobe.
		* @access public
		* @return int
		*/
		public function getMaxOsoba(){ return $this->maxOsoba; } 

		/**
		* Getter metoda za broj kreveta u sobi.
		* @access public
		* @return int
		*/
		public function getBrojKreveta(){ return $this->brojKreveta; } 


		/**
		* Getter metoda za putanju do slike sobe.
		* @access public
		* @return string
		*/
		public function getImg_Src(){ return $this->img_src; } 

		/**
		* Getter metoda za id sobe.
		* @access public
		* @return int
		*/
		public function getId(){ return $this->id; } 



		// SETTERS ---------------------------------------------------------------------------------------------------
		/**
		* Setter metoda za naziv sobe.
		* @access public
		* @param string $value
		*/
		public function setNaziv($value) { $this->naziv = $value;}

		/**
		* Setter metoda za cijenu sobe.
		* @access public
		* @param int $value
		*/
		public function setCijena($value) { $this->cijena = $value;}

		/**
		* Setter metoda za maksimalan broj osoba sobe.
		* @access public
		* @param int $value
		*/
		public function setMaxOsoba($value) { $this->maxOsoba = $value;}

		/**
		* Setter metoda za broj kreveta u sobi.
		* @access public
		* @param int $value
		*/
		public function setBrojKreveta($value) { $this->brojKreveta = $value;}


		/**
		* Setter metoda za putanju do slike sobe.
		* @access public
		* @param string $value
		*/
		public function setImg_Src($value) { $this->img_src = $value;}

		/**
		* Setter metoda za id sobe.
		* @access public
		* @param int $value
		*/
		public function setId($value) { $this->id = $value;}
}
