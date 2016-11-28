<?php

/**
* Klasa Soba sluzi za dohvacanje, dodavanje, brisanje i izmjenu
* podataka o sobama koje se nalazi u bazi podataka.
* 
*
*
* @package mojMVC\app\models
* @subpackage Soba
* @version 1.0
* @since 23-05-2015
* @author Zeljko Krnjic <zeljko-10000@hotmail.com>
*/
class Soba
{
	/**
	* Naziv sobe
	* @access private
	* @var string
	*/
	private $naziv;

	/**
	* Id sobe
	* @access private
	* @var int
	*/
	private $id;

	/**
	* Cijena sobe po nocenju
	* @access private
	* @var int
	*/
	private $cijena;

	/**
	* Maksimalan broj osoba 
	* @access private
	* @var int
	*/
	private $maxOsoba;

	/**
	* Broj kreveta u sobi 
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


	/*public function Soba($naziv, $cijena, $maxOsoba, $brojKreveta, $img_src,  $id)
	{
		$this->naziv = $naziv;
		$this->cijena = $cijena;
		$this->maxOsoba = $maxOsoba;
		$this->brojKreveta = $brojKreveta;
		$this->img_src = $img_src;
		$this->id = $id;
	}*/

	/**
	* Konstruktor klase Soba
	* @access public
	*/
	public function Soba()
	{

	}

	/**
	* Javna staticka metoda za dohvacanje sobe iz baze preko id-a sobe.
	* @access public
	* @static
	* @param int $id
	* @return Soba | false
	*/
	public static function getById($id)
	{
		$db = new DB("mywebpage", "localhost", "root", "");
		$db->Query("SELECT * FROM sobe WHERE id=?", [$id]);
		if(!$db->getResult()) return false;

		/*return new Soba($db->result[0]['naziv'], $db->result[0]['cijena'], $db->result[0]['maxOsoba'], $db->result[0]['brojKreveta']
			, $db->result[0]['img_src'], $db->result[0]['id']);*/
		$novi = new Soba();
		$novi->setNaziv($db->getResult()[0]['naziv']);
		$novi->setCijena($db->getResult()[0]['cijena']);
		$novi->setMaxOsoba($db->getResult()[0]['maxOsoba']);
		$novi->setBrojKreveta($db->getResult()[0]['brojKreveta']);
		$novi->setImg_Src($db->getResult()[0]['img_src']);
		$novi->setId($db->getResult()[0]['id']);

		return $novi;
	}




	/**
	* Javna staticka metoda za dohvacanje sobe iz baze preko naziva sobe.
	* @access public
	* @static
	* @param string $name
	* @return Soba | false
	*/
	public static function getByName($name)
	{
		$db = new DB("mywebpage", "localhost", "root", "");
		$db->Query("SELECT * FROM sobe WHERE naziv=?", [$name]);
		if(!$db->getResult()) return false;

		$novi = new Soba();
		$novi->setNaziv($db->getResult()[0]['naziv']);
		$novi->setCijena($db->getResult()[0]['cijena']);
		$novi->setMaxOsoba($db->getResult()[0]['maxOsoba']);
		$novi->setBrojKreveta($db->getResult()[0]['brojKreveta']);
		$novi->setImg_Src($db->getResult()[0]['img_src']);
		$novi->setId($db->getResult()[0]['id']);

		return $novi;
	}





	/**
	* Javna staticka metoda za dohvacanje svih soba iz baze.
	* @access public
	* @static
	* @return \Soba[] | false
	*/
	public static function getAll()
	{
		$db = new DB("mywebpage", "localhost", "root", "");
		$db->Query("SELECT * FROM sobe WHERE 1", []);
		if(!$db->getResult()) return false;

		$result = array();
		foreach($db->getResult() as $soba)
		{
			/*$novi = new Soba($soba['naziv'], $soba['cijena'], $soba['maxOsoba'], $soba['brojKreveta'], $soba['img_src'], $soba['id']);*/
			$novi = new Soba();
			$novi->setNaziv($soba['naziv']);
			$novi->setCijena($soba['cijena']);
			$novi->setMaxOsoba($soba['maxOsoba']);
			$novi->setBrojKreveta($soba['brojKreveta']);
			$novi->setImg_Src($soba['img_src']);
			$novi->setId($soba['id']);

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