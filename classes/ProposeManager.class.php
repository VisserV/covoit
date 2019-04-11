<?php
class ProposeManager{
	private $dbo;

		public function __construct($db){
			$this->db = $db;
		}

		public function add($propose){
      $requete = $this->db->prepare(
				'INSERT INTO propose (par_num, per_num, pro_date, pro_time, pro_place, pro_sens)
				VALUES (:numPar, :numPer, :dateDepart, :heure, :nbPlace, :sens);');

			$requete->bindValue(':numPar',$propose->getPar_num());
			$requete->bindValue(':numPer',$propose->getPer_num());
			$requete->bindValue(':dateDepart',$propose->getPro_date());
			$requete->bindValue(':heure',$propose->getPro_time());
			$requete->bindValue(':nbPlace',$propose->getPro_place());
			$requete->bindValue(':sens',$propose->getPro_sens());

      $retour=$requete->execute();

			//var_dump($requete->debugDumpParams());

			return $retour;
    }

		public function getAllPropose(){
      $listeProposes = array();

      $sql = 'SELECT * FROM propose';

      $requete = $this->db->prepare($sql);
      $requete->execute();

      while ($propose = $requete->fetch(PDO::FETCH_OBJ))
            $listeProposes[] = new Propose($propose);

      $requete->closeCursor();
      return $listeProposes;
		}

		public function getAllVille() {
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

		public function getAllVilleProposee() {
			$listeVilles = array();

			$sql = "SELECT DISTINCT * FROM
				(SELECT vil_num, vil_nom FROM ville
					JOIN parcours pa ON vil_num1 = vil_num
					JOIN propose pr ON pr.par_num = pa.par_num
					AND pro_sens = 0
				UNION
				SELECT vil_num, vil_nom FROM ville
					JOIN parcours pa ON vil_num2 = vil_num
					JOIN propose pr ON pr.par_num = pa.par_num
				 	AND pro_sens = 1) T1
				ORDER BY vil_nom";

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
					JOIN parcours pa ON vil_num1 = vil_num
					JOIN propose pr ON pr.par_num = pa.par_num
					WHERE vil_num2 = \"$numVille\"
					AND pro_sens = 1
				UNION
				SELECT vil_num, vil_nom FROM ville
					JOIN parcours pa ON vil_num2 = vil_num
					JOIN propose pr ON pr.par_num = pa.par_num
					WHERE vil_num1 = \"$numVille\"
				 	AND pro_sens = 0) T1
				ORDER BY vil_nom";

			$requete = $this->db->prepare($sql);
			$requete->execute();

			while ($ville = $requete->fetch(PDO::FETCH_OBJ))
				$listeVilles[] = new Ville($ville);

			$requete->closeCursor();

			return $listeVilles;
		}

		public function getTrajetPropose($villeDepart, $villeArrivee, $dateMin, $dateMax, $heure){
			$listePropose = array();

			$sql = "SELECT DISTINCT * FROM
				(SELECT per_num, pro_date, pro_time, pro_place FROM propose pr
					JOIN parcours pa ON pa.par_num = pr.par_num
					WHERE vil_num2 = \"$villeDepart\"
					AND vil_num1 = \"$villeArrivee\"
					AND pro_sens = 1
				UNION
				SELECT per_num, pro_date, pro_time, pro_place FROM propose pr
					JOIN parcours pa ON pa.par_num = pr.par_num
					WHERE vil_num1 = \"$villeDepart\"
					AND vil_num2 = \"$villeArrivee\"
				 	AND pro_sens = 0) T1
				WHERE pro_place > 0
				AND pro_time >= \"$heure\"
				AND pro_date >= \"$dateMin\"
				And pro_date <= \"$dateMax\"
				ORDER BY pro_date, pro_time";

			$requete = $this->db->prepare($sql);
			$requete->execute();

			while ($propose = $requete->fetch(PDO::FETCH_OBJ))
				$listePropose[] = new Propose($propose);

			$requete->closeCursor();

			return $listePropose;
		}
}
