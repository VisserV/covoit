<?php
class Personne{
	// Attributs
	private $per_num;
	private $per_nom;
	private $per_prenom;
	private $per_tel;
	private $per_mail;
	private $per_login;
	private $per_pwd;


	public function __construct($valeurs = array()){
		if (!empty($valeurs))
				//print_r ($valeurs);
				 $this->affecte($valeurs);
	}

	public function affecte($donnees){
				foreach ($donnees as $attribut => $valeur){
						switch ($attribut){
							case 'per_num': $this->setPer_num($valeur); break;
							case 'per_nom': $this->setPer_nom($valeur); break;
							case 'per_prenom': $this->setPer_prenom($valeur); break;
							case 'per_tel': $this->setPer_tel($valeur); break;
							case 'per_mail': $this->setPer_mail($valeur); break;
							case 'per_login': $this->setPer_login($valeur); break;
							case 'per_pwd': $this->setPer_pwd($valeur); break;
						}
				}
		}

	public function getPer_num() {
		return $this->per_num;
	}

	public function setPer_num($valeur){
	  $this->per_num=$valeur;
	}

	public function getPer_nom() {
		return $this->per_nom;
	}

	public function setPer_nom($valeur){
	  $this->per_nom=$valeur;
	}

	public function getPer_prenom() {
		return $this->per_prenom;
	}

	public function setPer_prenom($valeur){
	  $this->per_prenom=$valeur;
	}

	public function getPer_tel() {
		return $this->per_tel;
	}

	public function setPer_tel($valeur){
	  $this->per_tel=$valeur;
	}

	public function getPer_mail() {
		return $this->per_mail;
	}

	public function setPer_mail($valeur){
	  $this->per_mail=$valeur;
	}

	public function getPer_login() {
		return $this->per_login;
	}

	public function setPer_login($valeur){
	  $this->per_login=$valeur;
	}

	public function getPer_pwd() {
		return $this->per_pwd;
	}

	public function setPer_pwd($valeur){
	  $this->per_pwd=$valeur;
	}

	public function getPrenomNomPers(){
		return $this->getPer_prenom().' '.$this->getPer_nom();
	}

}
