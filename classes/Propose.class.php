<?php
class Propose{
	private $par_num;
	private $per_num;
	private $pro_date;
	private $pro_time;
	private $pro_place;
	private $pro_sens;


	public function __construct($valeurs = array()){
		if (!empty($valeurs))
			//print_r ($valeurs);
			$this->affecte($valeurs);
	}

	public function affecte($donnees){
				foreach ($donnees as $attribut => $valeur){
						switch ($attribut){
							case 'par_num': $this->setPar_num($valeur); break;
							case 'per_num': $this->setPer_num($valeur); break;
							case 'pro_date': $this->setPro_date($valeur); break;
							case 'pro_time': $this->setPro_time($valeur); break;
							case 'pro_place': $this->setPro_place($valeur); break;
							case 'pro_sens': $this->setPro_sens($valeur); break;
						}
				}
		}

	public function getPar_num() {
		return $this->par_num;
	}

	public function setPar_num($valeur){
	  $this->par_num = $valeur;
	}

	public function getPer_num() {
		return $this->per_num;
	}

	public function setPer_num($valeur){
	  $this->per_num = $valeur;
	}

	public function getPro_date() {
		return $this->pro_date;
	}

	public function setPro_date($valeur){
		$this->pro_date = $valeur;
	}

	public function getPro_time() {
		return $this->pro_time;
	}

	public function setPro_time($valeur){
		$this->pro_time = $valeur;
	}

	public function getPro_place() {
		return $this->pro_place;
	}

	public function setPro_place($valeur){
		$this->pro_place = $valeur;
	}

	public function getPro_sens() {
		return $this->pro_sens;
	}

	public function setPro_sens($valeur){
		$this->pro_sens = $valeur;
	}
}
