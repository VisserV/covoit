<?php
class Avis{
	private $per_num;
	private $per_per_num;
	private $par_num;
	private $avi_comm;
	private $avi_note;
	private $avi_date;


	public function __construct($valeurs = array()){
		if (!empty($valeurs))
				//print_r ($valeurs);
				 $this->affecte($valeurs);
	}

	public function affecte($donnees){
			foreach ($donnees as $attribut => $valeur){
					switch ($attribut){
						case 'per_num': $this->setPer_num($valeur); break;
						case 'per_per_num': $this->setPer_per_num($valeur); break;
						case 'par_num': $this->setPar_num($valeur); break;
						case 'avi_comm': $this->setAvi_comm($valeur); break;
						case 'avi_note': $this->setAvi_note($valeur); break;
						case 'avi_date': $this->setAvi_date($valeur); break;
					}
			}
	}

	public function getPer_num() {
		return $this->per_num;
	}

	public function setPer_num($valeur){
	  $this->per_num = $valeur;
	}

	public function getPer_per_num() {
		return $this->per_per_nom;
	}

	public function setPer_per_nom($valeur){
	  $this->per_per_nom = $valeur;
	}

	public function getPar_num() {
		return $this->par_num;
	}

	public function setPar_num($valeur){
	  $this->par_num = $valeur;
	}

	public function getAvi_comm() {
		return $this->avi_comm;
	}

	public function setAvi_comm($valeur){
	  $this->avi_comm = $valeur;
	}

	public function getAvi_note() {
		return $this->avi_note;
	}

	public function setAvi_note($valeur){
	  $this->avi_note = $valeur;
	}

	public function getAvi_date() {
		return $this->avi_date;
	}

	public function setAvi_date($valeur){
	  $this->avi_date = $valeur;
	}

}
