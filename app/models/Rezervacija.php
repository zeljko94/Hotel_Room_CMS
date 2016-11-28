<?php
/**
* Klasa Rezervacija sluzi za dodavanje, brisanje, dohvacanje i izmjenu podataka
* o  trenutnim rezervacijama koje se nalaze u bazi podataka.
*
*
* @package mojMVC\app\models
* @subpackage Rezervacija
* @version 1.0
* @since 20-05-2015
* @author Zeljko Krnjic <zeljko-10000@hotmail.com>
*/
class Rezervacija
{
	/**
	* Id rezervacije iz baze podataka.
	* @access private
	* @var int
	*/
	private $id;


	/**
	* Datum pocetka rezervacije za određenu sobu/apartman/penthouse.
	* @access private
	* @var DateTime
	*/
	private $pocetniDatum;



	/**
	* Datum zavrsetka rezervacije za određenu sobu/apartman/penthouse.
	* @access private
	* @var DateTime
	*/
	private $zavrsniDatum;




	/**
	* Datum kada je soba rezervirana
	* @access private
	* @var DateTime
	*/
	private $datumUplate;




	/**
	* Ime korisnika koji je rezervirao sobu.
	* @access private
	* @var string
	*/
	private $imeKorisnika;




	/**
	* Prezime korisnika koji je rezervirao sobu.
	* @access private
	* @var string
	*/
	private $prezimeKorisnika;




	/**
	* Email korisnika koji je rezervirao sobu.
	* @access private
	* @var string
	*/
	private $emailKorisnika;





	/**
	* Broj telefona korisnika koji je rezervirao sobu.
	* @access private
	* @var string
	*/
	private $telefonKorisnika;



	/**
	* Id sobe koju je korisnik izabrao za rezervaciju.
	* @access private
	* @var int
	*/
	private $idSobe;

	/**
	* Tip sobe koju je korisnik izabrao(soba/apartman/penthouse)
	* @access private
	* @var string
	*/
	private $tipSobe;


	/**
	* Cijena rezervacije sobe za određeni period uz odabrani pansion(pansion - 7.5KM, polupansion - 5KM, bez - 0KM)
	* @access private
	* @var float
	*/
	private $cijena;



	public function __construct(){}

	/**
	* Javna staticka metoda za dohvacanje svih podataka o rezervacijama iz baze podataka, ako nema podataka vraca false
	* @access public
	* @static
	* @return \Rezervacija[] | false
	*/
	public static function getAll()
	{
		$db = new DB("mywebpage", "localhost", "root", "");
		$db->Query("SELECT * FROM rezervacije WHERE 1", []);
		if(!$db->getResult()) return false;

		$results = array();

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
			$novi->setCijena($rezervacija['cijena']);
			$novi->setTipSobe($rezervacija['tipSobe']);

			array_push($results, $novi);
		}

		return $results;
	}


	/**
	* Dohvaca rezervacije iz baze koje se nalaze unutar određenog vremenskog perioda, vraca false ako nema podataka.
	* Opcionalni parametar idSobe - dohvacaju se podaci sa određenim id-om sobe.
	* Opcionalni parametar tipSobe - dohvacaju se podaci sa određenim tipom sobe.
	* @access public
	* @static
	* @param DateTime $pocetniDatum
	* @param DateTime $zavrsni datum
	* @param int $idSobe (optional) ''
	* @param string $tipSobe (optional) ''
	* @return \Rezervacija[] | false
	*/
	public static function getConflictingReservations($pocetniDatum, $zavrsniDatum, $idSobe='', $tipSobe='')
	{
		$db = new DB("mywebpage", "localhost", "root", "");
		$db->Query("SELECT * FROM rezervacije WHERE idSobe=? AND tipSobe=? AND ((pocetniDatum BETWEEN ? AND ?) OR (zavrsniDatum BETWEEN ? AND ?))", [$idSobe, $tipSobe,
																																					$pocetniDatum, $zavrsniDatum,
																																					$pocetniDatum, $zavrsniDatum]);
		if(!$db->getResult()) return false;
		$results = array();

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
			$novi->setCijena($rezervacija['cijena']);
			$novi->setTipSobe($rezervacija['tipSobe']);

			array_push($results, $novi);
		}
		return $results;
	}
	

	/**
	* Javna staticka metoda za unos rezervacije u bazu ako u bazi nema konfliktnih rezervacija, 
	* ako rezervacija uspije funkcija vraca true, u suprotnom false.
	* @access public
	* @static
	* @param DateTime $pocetniDatum
	* @param DateTime $zavrsniDatum
	* @param DateTime $datumUplate
	* @param string $imeKorisnika
	* @param string $prezimeKorisnika
	* @param string $emailKorisnika
	* @param string $telefonKorisnika
	* @param int $idSobe
	* @param int $cijena
	* @param string $tipSobe
	* @return boolean
	*/
	public static function unesiRezervaciju($pocetniDatum, $zavrsniDatum, $datumUplate, $imeKorisnika, $prezimeKorisnika, $emailKorisnika, $telefonKorisnika, $idSobe, $cijena, $tipSobe)
	{
		$pocetniDatum = $pocetniDatum->format('Y/m/d');
		$zavrsniDatum = $zavrsniDatum->format('Y/m/d');
		$datumUplate = $datumUplate->format('Y/m/d');
		$conflictingReservations = Rezervacija::getConflictingReservations($pocetniDatum, $zavrsniDatum, $idSobe, $tipSobe);

		if(!$conflictingReservations)
		{
			$db = new DB("mywebpage", "localhost", "root", "");
			$db->Query("INSERT INTO rezervacije(pocetniDatum, zavrsniDatum, datumUplate, imeGosta, prezimeGosta, emailGosta, telefonGosta, idSobe, tipSobe, cijena) 
				VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)", [$pocetniDatum, $zavrsniDatum, $datumUplate, $imeKorisnika, $prezimeKorisnika, $emailKorisnika, $telefonKorisnika, $idSobe, $tipSobe, $cijena]);
			return true;
		}
		else
		{
			return false;
		}

	}

	/**
	* Javna staticka metoda za brisanje rezervacije iz baze preko id-a.
	* @access public
	* @static
	* @param int $id
	*/
	public static function brisiById($id)
	{
		$db = new DB("mywebpage", "localhost", "root", "");
		$db->Query("DELETE FROM rezervacije WHERE id=?", [$id]);
	}

	/**
	* Javna staticka metoda koja brise sve istekle rezervacije iz baze.
	* One kod kojih je zavrsni datum manji od trenutnog datuma
	* @access public
	* @static
	*/
	public static function brisiIstekleRezervacije()
	{
		$trenutniDatum = new DateTime();
		$rezervacije = Rezervacija::getAll();

		if($rezervacije)
		{
			foreach($rezervacije as $rezervacija)
			{
				$zavrsni = new DateTime($rezervacija->getZavrsniDatum());
				if($zavrsni < $trenutniDatum)
				{
					Rezervacija::brisiById($rezervacija->getId());
				}
			}
		}
	}



// GETTERS
	/**
	* Getter metoda za dohvacanje id-a rezervacije.
	* @access public
	* @return int 
	*/
	public function getId(){ return $this->id; }


		/**
	* Getter metoda za dohvacanje pocetnog datuma rezervacije.
	* @access public
	* @return DateTime 
	*/
	public function getPocetniDatum(){ return $this->pocetniDatum; }

	/**
	* Getter metoda za dohvacanje zavrsnog datuma rezervacije.
	* @access public
	* @return DateTime 
	*/
	public function getZavrsniDatum(){ return $this->zavrsniDatum; }


	/**
	* Getter metoda za dohvacanje datuma uplate rezervacije.
	* @access public
	* @return DateTime 
	*/
	public function getDatumUplate(){ return $this->datumUplate; }


	/**
	* Getter metoda za ime korisnika koji je rezervirao sobu.
	* @access public
	* @return string 
	*/
	public function getImeKorisnika(){ return $this->imeKorisnika; }

	/**
	* Getter metoda za prezime korisnika koji je rezervirao sobu.
	* @access public
	* @return string 
	*/
	public function getPrezimeKorisnika(){ return $this->prezimeKorisnika; }

	/**
	* Getter metoda za email korisnika koji je rezervirao sobu.
	* @access public
	* @return string 
	*/
	public function getEmailKorisnika(){ return $this->emailKorisnika; }


	/**
	* Getter metoda za broj telefona korisnika koji je rezervirao sobu.
	* @access public
	* @return string 
	*/
	public function getTelefonKorisnika(){ return $this->telefonKorisnika; }

	/**
	* Getter metoda za id sobe koju je korisnik rezervirao.
	* @access public
	* @return int 
	*/
	public function getIdSobe(){ return $this->idSobe; }


	/**
	* Getter metoda za ukupnu cijenu rezervacije. (ukljucen pansion/polupansion/bez)
	* @access public
	* @return float 
	*/
	public function getCijena(){ return $this->cijena; }

	/**
	* Getter metoda za tip sobe koju korisnik rezervira. (apartman/soba/penthouse)
	* @access public
	* @return string 
	*/
	public function getTipSobe(){ return $this->tipSobe; }

// SETTERS -------------------------------------------------------------------------------------

	/**
	* Setter metoda za id rezervacije.
	* @access public
	* @param int $value
	*/
	public function setId($value){ $this->id = $value; }


	/**
	* Setter metoda za pocetni datum rezervacije.
	* @access public
	* @param DateTime $value
	*/
	public function setPocetniDatum($value){ $this->pocetniDatum = $value; }

	/**
	* Setter metoda za zavrsni datum rezervacije.
	* @access public
	* @param DateTime $value
	*/
	public function setZavrsniDatum($value){ $this->zavrsniDatum = $value; }

	/**
	* Setter metoda za datum uplate rezervacije.
	* @access public
	* @param DateTime $value
	*/
	public function setDatumUplate($value){ $this->datumUplate = $value; }

	/**
	* Setter metoda za ime korisnika koji je rezervirao sobu.
	* @access public
	* @param string $value
	*/
	public function setImeKorisnika($value){ $this->imeKorisnika = $value; }

	/**
	* Setter metoda za prezime korisnika koji je rezervirao sobu.
	* @access public
	* @param string $value
	*/
	public function setPrezimeKorisnika($value){ $this->prezimeKorisnika = $value; }

	/**
	* Setter metoda za email  korisnika koji je rezervirao sobu.
	* @access public
	* @param string $value
	*/
	public function setEmailKorisnika($value){ $this->emailKorisnika = $value; }

	/**
	* Setter metoda za broj telefona korisnika koji je rezervirao sobu.
	* @access public
	* @param string $value
	*/
	public function setTelefonKorisnika($value){ $this->telefonKorisnika = $value; }

	/**
	* Setter metoda za id sobe koju korisnik rezervira.
	* @access public
	* @param int $value
	*/
	public function setIdSobe($value){ $this->idSobe = $value; }

	/**
	* Setter metoda za ukupnu cijenu rezervacije.
	* @access public
	* @param string $value
	*/
	public function setCijena($value){ $this->cijena = $value; }

	/**
	* Setter metoda za tip sobe.
	* @access public
	* @param string $value
	*/
	public function setTipSobe($value){ $this->tipSobe = $value; }

}
