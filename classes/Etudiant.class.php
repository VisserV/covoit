<?php
class Etudiant{
	private $per_num;
	private $dep_num;
	private $div_num;


	public function __construct($valeurs = array()){
		if (!empty($valeurs))
				//print_r ($valeurs);
				 $this->affecte($valeurs);
	}

	public function affecte($donnees){
				foreach ($donnees as $attribut => $valeur){
						switch ($attribut){
							case 'per_num': $this->setPer_num($valeur); break;
							case 'dep_num': $this->setDep_num($valeur); break;
							case 'div_num': $this->setDiv_num($valeur); break;
						}
				}
		}

	public function getPer_num() {
		return $this->per_num;
	}

	public function setPer_num($valeur){
	  $this->per_num = $valeur;
	}

	public function getDep_num() {
		return $this->dep_num;
	}

	public function setDep_num($valeur){
	  $this->dep_num = $valeur;
	}

	public function getDiv_num() {
		return $this->div_num;
	}

	public function setDiv_num($valeur){
	  $this->div_num = $valeur;
	}
}
