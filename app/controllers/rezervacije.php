<?php
session_start();

 /**
 * Kontroler koji upravlja stranicom za rezervaciju soba
 * Nasljedjuje osnovnu Controller klasu
 *
 *
 * @package mojMVC\app\controllers
 * @subpackage rezervacije
 * @version 1.0
 * @since 20-05-2015
 * @author   Zeljko Krnjic <zeljko-10000@hotmail.com>
 **/
class Rezervacije extends Controller
{

	/**
	* Index akcija Rezervacije kontrolera.
	* Prikazuje 3 vrste soba koje hotel ima u ponudi. (soba/apartman/penthouse)
	* @access public
	*/
	public function index()
	{
		$this->model('Session');

			$this->model('Thumbnail');

			$thumbnails = Thumbnail::getAll();
			$errors = "";
			$errorStyle = "";
			
			$this->view('rezervacije/index', ['thumbnails' => $thumbnails,
											  'errors' => $errors,
											  'errorStyle' => $errorStyle]);
	}


	/**
	* Akcija za prikaz pojedinih soba odredjenog tipa, kao argument prima tip sobe (apartman/soba/penthouse)
	* Takodjer preuzima sobe koje je user odabrao preko checkboxa i sprema ih u niz.
	* @access public
	* @param string $naziv
	*/
	public function prikazSoba($naziv='')
	{
		$this->model('Session');

		switch($naziv)
		{
			case "Soba":
			$this->model('Soba');
			$sobe = Soba::getAll();
			break;

			case "Apartman":
			$this->model('Apartman');
			$sobe = Apartman::getAll();
			break;

			case "Penthouse":
			$this->model('Penthouse');
			$sobe = Penthouse::getAll();
			break;

			default:
			break;
		}

		$imena_oznacenih = array();
		$odabraneSobe = array();

		if(isset($_POST['rezervirajButton'])) // provjeri oznacene checkboxe
		{
			$tempCheckbox="";
			if($naziv == 'Soba' or $naziv == 'Apartman')
			{
				for($i=1; $i<=10; $i++)
				{
				   $tempCheckbox = $naziv . $i . "_checkbox";
				   if(isset($_POST[$tempCheckbox])) array_push($imena_oznacenih, $tempCheckbox);
				}
			}
			else if($naziv == 'Penthouse')
			{
				for($i=1; $i<=2; $i++)
				{
					$tempCheckbox = $naziv . $i . "_checkbox";
					if(isset($_POST[$tempCheckbox])) array_push($imena_oznacenih, $tempCheckbox);
				}
			}

			// --------------------------------------------- ---------------------------------------------------------------
			for($i=0; $i<count($imena_oznacenih); $i++)  // dohvati odabrane iz baze
			{
				$ime_sobe = explode('_', $imena_oznacenih[$i]);
				switch($naziv)
				{
					case "Soba";
					$nova_soba = Soba::getByName($ime_sobe[0]);
					array_push($odabraneSobe, $nova_soba);
					break;

					case "Apartman";
					$nova_soba = Apartman::getByName($ime_sobe[0]);
					array_push($odabraneSobe, $nova_soba);
					break;

					case "Penthouse";
					$nova_soba = Penthouse::getByName($ime_sobe[0]);
					array_push($odabraneSobe, $nova_soba);
					break;

					default:
					break;
				}
			}

			$_SESSION['odabraneSobe'] = $odabraneSobe;
			echo "<script type='text/javascript'>window.location.href='index.php?url=rezervacije/rezervirajSobu';</script>";

		}

		$this->view('rezervacije/prikazSoba', ['sobe' => $sobe,
												'naziv' => $naziv,
												'odabraneSobe' => $odabraneSobe]);


	}

	/**
	* Akcija koja kontrolira formu za rezervaciju sobe.
	* Provjerava da li je korisnik unijeo potrebne informacije u formu za rezerviranje, te da li su podatci ispravno uneseni.
	* U slucaju da korisnik nepotpuno popune formu, ili je popuni neispravnim podatcima ispisuje se poruka o gresci i
	* user ponovno unosi podatke.
	* @access public
	*/
	public function rezervirajSobu()
	{
		$this->model('Session');
		$this->model('Soba');
		$this->model('Apartman');
		$this->model('Penthouse');
		$this->model('Rezervacija');

		Rezervacija::brisiIstekleRezervacije();
		// ---------------------------------------------------------------------------------------------------------------
		// provjera forme za rezervaciju

		$odabraneSobe = unserialize(serialize($_SESSION['odabraneSobe']));
		$pocetniDatum = new DateTime;
		$zavrsniDatum = new DateTime;
		$imeKorisnika = "";
		$prezimeKorisnika = "";
		$emailKorisnika = "";
		$telefonKorisnika = "";
		$pansion = "";
		$pansionCijena = 0;
		$total = 0;
		$brojDana = null;
		$errors = "";
		$errorStyle = "";

		// dohvati podatke iz forme za rezervaciju -----------------------------------------------------------------------
		if(isset($_POST['rezervirajSubmitButton']))
		{
			$pocetniDatum = DateTime::createFromFormat('d/m/Y', $_POST['pocetniDatum']);
			$zavrsniDatum = DateTime::createFromFormat('d/m/Y', $_POST['zavrsniDatum']);
			$imeKorisnika = isset($_POST['imeKorisnika']) ? $_POST['imeKorisnika'] : "";
			$prezimeKorisnika = isset($_POST['prezimeKorisnika']) ? $_POST['prezimeKorisnika'] : "";
			$emailKorisnika = isset($_POST['emailKorisnika']) ? $_POST['emailKorisnika'] : "";
			$telefonKorisnika = isset($_POST['telefonKorisnika']) ? $_POST['telefonKorisnika'] : "";
			$razlika = $pocetniDatum->diff($zavrsniDatum);
			$brojDana = $razlika->d + ($razlika->m * 30) + ($razlika->y * 365);
			$pansion = isset($_POST['pansion']) ? $_POST['pansion'] : "";
		}

			// odredi cijenu za pansion ----------------------------------------------------------------
			switch($pansion)
			{
				case "Pansion":
				$pansionCijena = 7.5;
				break;

				case "Polupansion":
				$pansionCijena = 5.0;
				break;

				default:
				$pansionCijena = 0;
				break;
			}


			// izracunaj total -------------------------------------------------------
		for($i=0; $i<count($odabraneSobe); $i++)
		{
			$total += ($odabraneSobe[$i]->getCijena() * $brojDana) + ($pansionCijena*$brojDana);
		}
		

		// provjeri da  li je rezervacija moguća ---------------------------------------------------------------
		if(!$imeKorisnika || !$prezimeKorisnika)
		{
			$errors = "Rezervacija nije uspjela. </br> Molimo unesite ime i prezime.</br>";
			$errorStyle = "text-danger";
					$this->view('rezervacije/rezervirajSobu', ['pocetniDatum' => $pocetniDatum->format('d/m/Y'),
													'zavrsniDatum' => $zavrsniDatum->format('d/m/Y'),
													'imeKorisnika' => $imeKorisnika,
													'prezimeKorisnika' => $prezimeKorisnika,
													'emailKorisnika' => $emailKorisnika,
													'telefonKorisnika' => $telefonKorisnika,
													'odabraneSobe' => $odabraneSobe,
													'brojDana' => $brojDana,
													'pansionCijena' => $pansionCijena,
													'total' => $total,
													'errors' => $errors,
													'errorStyle' => $errorStyle]);
					return false;
		}
		// ------------------ nadji ima li među odabranim sobama onih koje su vec rezervirane za trazeni datum
		$zauzete = array();
		foreach($odabraneSobe as $odabranaSoba)
		{
			$tipSobe = preg_replace('/[0-9]+/', '', $odabranaSoba->getNaziv());
			$zauzeta = Rezervacija::getConflictingReservations($pocetniDatum->format('Y/m/d'), $zavrsniDatum->format('Y/m/d'), $odabranaSoba->getId(), $tipSobe);
			if($zauzeta)
			{
				array_push($zauzete, $odabranaSoba);
			}
		}
		if(!empty($zauzete))
		{
			$errors = "Rezervacija nije uspjela.</br>";
			foreach($zauzete as $zauzeta)
			{
				$errors .= $zauzeta->getNaziv() . " je zauzeta za odabrani period. </br>";
				$errorStyle = "text-danger";
			}
			$this->view('rezervacije/rezervirajSobu', ['pocetniDatum' => $pocetniDatum->format('d/m/Y'),
													'zavrsniDatum' => $zavrsniDatum->format('d/m/Y'),
													'imeKorisnika' => $imeKorisnika,
													'prezimeKorisnika' => $prezimeKorisnika,
													'emailKorisnika' => $emailKorisnika,
													'telefonKorisnika' => $telefonKorisnika,
													'odabraneSobe' => $odabraneSobe,
													'brojDana' => $brojDana,
													'pansionCijena' => $pansionCijena,
													'total' => $total,
													'errors' => $errors,
													'errorStyle' => $errorStyle]);
			return false;
		}
		// -----------------------------------------------------------------------------------------------------------------------
		foreach($odabraneSobe as $odabranaSoba)
		{
			$cijena_sobe = $odabranaSoba->getCijena() * $brojDana + ($pansionCijena*$brojDana);
			$tipSobe = preg_replace('/[0-9]+/', '', $odabranaSoba->getNaziv());
			$datumUplate = new DateTime();
			if(Rezervacija::unesiRezervaciju($pocetniDatum, $zavrsniDatum, $datumUplate, $imeKorisnika, $prezimeKorisnika, $emailKorisnika, $telefonKorisnika,
				$odabranaSoba->getId(), $cijena_sobe, $tipSobe))
			{
				$errors = "Uspješno ste rezervirali!";
				$errorStyle = "text-success";
			}
			else
			{
				$errors = "Rezervacija nije uspjela</br>";
				$errors .= $odabranaSoba->getNaziv() . " je zauzeta za odabrani datum. </br>";
				$errorStyle = "text-danger";
			}
		}

		$this->view('rezervacije/rezervirajSobu', ['pocetniDatum' => $pocetniDatum->format('d/m/Y'),
													'zavrsniDatum' => $zavrsniDatum->format('d/m/Y'),
													'imeKorisnika' => $imeKorisnika,
													'prezimeKorisnika' => $prezimeKorisnika,
													'emailKorisnika' => $emailKorisnika,
													'telefonKorisnika' => $telefonKorisnika,
													'odabraneSobe' => $odabraneSobe,
													'brojDana' => $brojDana,
													'pansionCijena' => $pansionCijena,
													'total' => $total,
													'errors' => $errors,
													'errorStyle' => $errorStyle]);
	}
}