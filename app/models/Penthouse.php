<?php 

/**
* Klasa Penthouse sluzi za dohvacanje, brisanje, dodavanje i izmjenu podataka o penthouse-ima u bazi podataka
*
*
*
* @package mojMVC\app\models
* @subpackage Penthouse
* @version 1.0
* @since 20-05-2015
* @author Zeljko Krnjic <zeljko-10000@hotmail.com>
*/
class Penthouse
{
	/**
	* Naziv penthouse-a. Oblika "penthouseXX", gdje je XX ->broj penthouse-a.
	* Koristi se kao identifikator(id) i naziv(name) u html kodu za manipulaciju penthouse-ima. 
	* @var string
	* @access private
	*/
	private $naziv;

	/**
	* Id penthouse-a u bazi podataka
	* @var int
	* @access private
	*/
	private $id;

	/**
	* Cijena boravka u penthouse-u za 1 noc
	* @var int
	* @access private
	*/
	private $cijena;


	/**
	* Maksimalan broj osoba po penthouse-u
	* @var int
	* @access private
	*/
	private $maxOsoba;

	/**
	* Broj kreveta u penthouse-u
	* @var int
	* @access private
	*/
	private $brojKreveta;


	/**
	* Putanja(Path) do slike penthouse-a koja se nalazi 
	* na serveru u folderu slike.
	* @var string
	* @access private
	*/
	private $img_src;


	/**
	* Konstruktor klase Penthouse
	* @access public
	*/
	public function __construct(){}


	/**
	* Javna staticka metoda koja dohvaca podatke o svim penthousima koji se nalaze u bazi podataka,
	* ako nema podataka vraca false.
	* @access public
	* @static
	* @return array | false
	*/
	public static function getAll()
	{
		$db = new DB("mywebpage", "localhost", "root", "");
		$db->Query("SELECT * FROM penthouse WHERE 1", []);
		if(!$db->getResult()) return false;

		$result = array();
		foreach($db->getResult() as $penthouse)
		{
			/*$novi = new Soba($soba['naziv'], $soba['cijena'], $soba['maxOsoba'], $soba['brojKreveta'], $soba['img_src'], $soba['id']);*/
			$novi = new Penthouse();
			$novi->setNaziv($penthouse['naziv']);
			$novi->setCijena($penthouse['cijena']);
			$novi->setMaxOsoba($penthouse['maxOsoba']);
			$novi->setBrojKreveta($penthouse['brojKreveta']);
			$novi->setImg_Src($penthouse['img_src']);
			$novi->setId($penthouse['id']);

			array_push($result, $novi);
		}
		return $result;
	}


	/**
	* Javna staticka metoda koja dohvaca podatke o penthousu po nazivu.
	* @access public
	* @static
	* @param string $name
	* @return Penthouse | false
	*/
	public static function getByName($name)
	{
		$db = new DB("mywebpage", "localhost", "root", "");
		$db->Query("SELECT * FROM penthouse WHERE naziv=?", [$name]);
		if(!$db->getResult()) return false;

		$novi = new Penthouse();
		$novi->setNaziv($db->getResult()[0]['naziv']);
		$novi->setCijena($db->getResult()[0]['cijena']);
		$novi->setMaxOsoba($db->getResult()[0]['maxOsoba']);
		$novi->setBrojKreveta($db->getResult()[0]['brojKreveta']);
		$novi->setImg_Src($db->getResult()[0]['img_src']);
		$novi->setId($db->getResult()[0]['id']);

		return $novi;
	}

		// GETTERS

		/**
		* Javna metoda za dohvacanje privatnog clana naziv.
		* @access public
		* @return string
		*/
		public function getNaziv(){ return $this->naziv; } 


		/**
		* Javna metoda za dohvacanje privatnog clana cijena.
		* @access public
		* @return int
		*/
		public function getCijena(){ return $this->cijena; } 


		/**
		* Javna metoda za dohvacanje privatnog clana maxOsoba.
		* @access public
		* @return int
		*/
		public function getMaxOsoba(){ return $this->maxOsoba; } 


		/**
		* Javna metoda za dohvacanje privatnog clana brojKreveta.
		* @access public
		* @return int
		*/
		public function getBrojKreveta(){ return $this->brojKreveta; } 

		/**
		* Javna metoda za dohvacanje privatnog clana img_src.
		* @access public
		* @return string
		*/
		public function getImg_Src(){ return $this->img_src; } 


		/**
		* Javna metoda za dohvacanje privatnog clana id.
		* @access public
		* @return int
		*/
		public function getId(){ return $this->id; } 

	// SETTERS

		/**
		* Javna metoda za postavljanje vrijednosti privatnog clana naziv.
		* @access public
		* @param string $value
		*/
		public function setNaziv($value) { $this->naziv = $value;}

		/**
		* Javna metoda za postavljanje vrijednosti privatnog clana cijena.
		* @access public
		* @param int $value
		*/
		public function setCijena($value) { $this->cijena = $value;}


		/**
		* Javna metoda za postavljanje vrijednosti privatnog clana maxOsoba.
		* @access public
		* @param int $value
		*/
		public function setMaxOsoba($value) { $this->maxOsoba = $value;}



		/**
		* Javna metoda za postavljanje vrijednosti privatnog clana brojKreveta.
		* @access public
		* @param int $value
		*/
		public function setBrojKreveta($value) { $this->brojKreveta = $value;}


		/**
		* Javna metoda za postavljanje vrijednosti privatnog clana img_src.
		* @access public
		* @param string $value
		*/
		public function setImg_Src($value) { $this->img_src = $value;}


		/**
		* Javna metoda za postavljanje vrijednosti privatnog clana id.
		* @access public
		* @param int $value
		*/
		public function setId($value) { $this->id = $value;}
}