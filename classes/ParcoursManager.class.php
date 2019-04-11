<?php
class ParcoursManager{
	private $dbo;

	public function __construct($db){
		$this->db = $db;
	}

	public function add($parcours){
    $requete = $this->db->prepare(
			'INSERT INTO parcours (par_km, vil_num1, vil_num2)
			VALUES (:nbKm, :ville1, :ville2);');

		$requete->bindValue(':nbKm',$parcours->getPar_km());
		$requete->bindValue(':ville1',$parcours->getVil_num1());
		$requete->bindValue(':ville2',$parcours->getVil_num2());

    $retour=$requete->execute();
		//var_dump($requete->debugDumpParams());

		return $retour;
  }

	public function getAllParcours(){
    $listeParcours = array();

    $sql = 'SELECT par_num, par_km, vil_num1, vil_num2 FROM parcours ORDER BY vil_num1, vil_num2';

    $requete = $this->db->prepare($sql);
    $requete->execute();

    while ($parcours = $requete->fetch(PDO::FETCH_OBJ))
      $listeParcours[] = new Parcours($parcours);

    $requete->closeCursor();
    return $listeParcours;
	}

	public function getNbParcours(){
		$nbParcours = 0;

		$listeParcours = $this->getAllParcours();

		foreach ($listeParcours as $par) {
			$nbParcours++;
		}

    return $nbParcours;
	}

	public function getAllVille(){
		$listeVilles = array();

		$sql = 'SELECT DISTINCT * FROM
				(SELECT vil_num, vil_nom FROM ville
					JOIN parcours ON vil_num1 = vil_num
				UNION
				SELECT vil_num, vil_nom FROM ville
					JOIN parcours ON vil_num2 = vil_num) T1
				ORDER BY vil_nom';

		$requete = $this->db->prepare($sql);
    $requete->execute();

    while ($ville = $requete->fetch(PDO::FETCH_OBJ))
    	$listeVilles[] = new Ville($ville);

    $requete->closeCursor();

		return $listeVilles;
	}

	public function getVilleReliee($numVille){
		$listeVilles = array();

		$sql = "SELECT DISTINCT * FROM
				(SELECT vil_num, vil_nom FROM ville
					JOIN parcours ON vil_num1 = vil_num
					WHERE vil_num2 = \"$numVille\"
				UNION
				SELECT vil_num, vil_nom FROM ville
					JOIN parcours ON vil_num2 = vil_num
					WHERE vil_num1 = \"$numVille\" ) T1
				ORDER BY vil_nom";

		$requete = $this->db->prepare($sql);
		$requete->execute();

		while ($ville = $requete->fetch(PDO::FETCH_OBJ))
			$listeVilles[] = new Ville($ville);

		$requete->closeCursor();

		return $listeVilles;
	}

	public function getNumParcours($villeDepart, $villeArrivee) {

		$sens = $this->getSensPropose($villeDepart, $villeArrivee);

		if ($sens == 0){
			$ville1 = $villeDepart;
			$ville2 = $villeArrivee;
		} else {
			$ville1 = $villeArrivee;
			$ville2 = $villeDepart;
		}

		$sql = "SELECT par_num FROM parcours
							WHERE vil_num2 = \"$ville2\"
							AND vil_num1 = \"$ville1\"";

		$requete = $this->db->prepare($sql);
		$requete->execute();

		$result = new Parcours($requete->fetch(PDO::FETCH_OBJ));

		return $result->getPar_num();
	}

	public function getSensPropose($villeDepart, $villeArrivee) {

		$sql = "SELECT par_num FROM parcours
							WHERE vil_num2 = \"$villeDepart\"
							AND vil_num1 = \"$villeArrivee\"";

		$requete = $this->db->prepare($sql);
		$requete->execute();

		//var_dump($sql);

		if ($requete->rowCount() == 0){
			return 0;
		} else {
			return 1;
		}
	}
}
