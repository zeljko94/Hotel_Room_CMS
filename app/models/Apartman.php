<?php 
/**
* Klasa Apartman sluzi za dohvacanje, brisanje, dodavanje i izmjenu podataka o apartmanima u bazi podataka
*
*
*
* @package mojMVC\app\models
* @subpackage Apartman
* @version 1.0
* @since 20-05-2015
* @author   Zeljko Krnjic <zeljko-10000@hotmail.com>
**/
class Apartman
{
	/**
	* Naziv apartmana. Oblika "apartmanXX", gdje je XX ->broj apartmana.
	* Koristi se kao identifikator(id) i naziv(name) u html kodu za manipulaciju apartmanima. 
	* @var string
	* @access private
	*/
	private $naziv;

	/**
	* Id apartmana u bazi podataka
	* @var int
	* @access private
	*/
	private $id;

	/**
	* Cijena boravka u apartmanu za 1 noc
	* @var int
	* @access private
	*/
	private $cijena;


	/**
	* Maksimalan broj osoba po apartmanu
	* @var int
	* @access private
	*/
	private $maxOsoba;

	/**
	* Broj kreveta u apartmanu
	* @var int
	* @access private
	*/
	private $brojKreveta;


	/**
	* Putanja(Path) do slike apartmana koja se nalazi 
	* na serveru u folderu slike.
	* @var string
	* @access private
	*/
	private $img_src;


	/**
	* Konstruktor klase Apartman
	* @access public
	*/
	public function __construct(){}


	/**
	* Javna(public) statička metoda koja dohvaca podatke
	* o svim apartmanima koji su spremljeni u bazu podataka.
	* Vraća ih u obliku niza objekata klase Apartman.
	* @access public
	* @static
	* @return array | false
	*/
	public static function getAll()
	{
		$db = new DB("mywebpage", "localhost", "root", "");
		$db->Query("SELECT * FROM apartmani WHERE 1", []);
		if(!$db->getResult()) return false;

		$result = array();
		foreach($db->getResult() as $apartman)
		{
			/*$novi = new Soba($soba['naziv'], $soba['cijena'], $soba['maxOsoba'], $soba['brojKreveta'], $soba['img_src'], $soba['id']);*/
			$novi = new Apartman();
			$novi->setNaziv($apartman['naziv']);
			$novi->setCijena($apartman['cijena']);
			$novi->setMaxOsoba($apartman['maxOsoba']);
			$novi->setBrojKreveta($apartman['brojKreveta']);
			$novi->setImg_Src($apartman['img_src']);
			$novi->setId($apartman['id']);

			array_push($result, $novi);
		}
		return $result;
	}


	/**
	* Javna staticka metoda koja dohvaca podatke o apartmanu preko imena apartmana
	* ako takav postoji, u suprotnom vraca false.
	* Vraca jedan objekt klase Apartman ako je objekt pronadjen u bazi, u protivnom vraca false.
	* @access public
	* @static
	* @param string $name
	* @return Apartman | false
	*/
	public static function getByName($name)
	{
		$db = new DB("mywebpage", "localhost", "root", "");
		$db->Query("SELECT * FROM apartmani WHERE naziv=?", [$name]);
		if(!$db->getResult()) return false;

		$novi = new Apartman();
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
