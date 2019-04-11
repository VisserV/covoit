<?php
class Fonction{
	private $fon_num;
	private $fon_libelle;


	public function __construct($valeurs = array()){
		if (!empty($valeurs))
				//print_r ($valeurs);
				 $this->affecte($valeurs);
	}

	public function affecte($donnees){
				foreach ($donnees as $attribut => $valeur){
						switch ($attribut){
							case 'fon_num': $this->setFon_num($valeur); break;
							case 'fon_libelle': $this->setFon_libelle($valeur); break;
						}
				}
		}

	public function getFon_num() {
		return $this->fon_num;
	}

	public function setFon_num($valeur){
	  $this->fon_num = $valeur;
	}

	public function getFon_libelle() {
		return $this->fon_libelle;
	}

	public function setFon_libelle($valeur){
	  $this->fon_libelle = $valeur;
	}
}
