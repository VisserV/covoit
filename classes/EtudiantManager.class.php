<?php
class EtudiantManager{
	private $dbo;

		public function __construct($db){
			$this->db = $db;
		}

		public function add($etudiant){
      $requete = $this->db->prepare(
				'INSERT INTO etudiant (per_num, dep_num, div_num)
				VALUES (:per_num, :dep_num, :div_num);');

			$requete->bindValue(':per_num',$etudiant->getPer_num());
			$requete->bindValue(':dep_num',$etudiant->getDep_num());
			$requete->bindValue(':div_num',$etudiant->getDiv_num());

      $retour=$requete->execute();
			//var_dump($requete->debugDumpParams());

			return $retour;
    }

		public function update($etudiant){
			$requete = $this->db->prepare(
				'UPDATE etudiant SET dep_num = :dep, div_num = :div
				WHERE per_num = :num;' );

			$requete->bindValue(':dep',$etudiant->getDep_num());
			$requete->bindValue(':div',$etudiant->getDiv_num());
			$requete->bindValue(':num',$etudiant->getPer_num());

			$retour = $requete->execute();
			//var_dump($requete->debugDumpParams());

			return $retour;
		}

		public function getEtu($num){
			$sql = "SELECT * FROM etudiant
			WHERE per_num = \"$num\"";

			$requete = $this->db->prepare($sql);

			$requete->execute();

			$etudiant = new Etudiant($requete->fetch(PDO::FETCH_OBJ));

			return $etudiant;
		}

		public function getDepartementEtu($num){

			$etudiant = new Etudiant($this->getEtu($num));

			$dep_num = $etudiant->getDep_num();

			$sql = "SELECT * FROM departement
			WHERE dep_num = \"$dep_num\"";

			$requete = $this->db->prepare($sql);

			$requete->execute();

			$departement = new Departement($requete->fetch(PDO::FETCH_OBJ));

			return $departement;
		}

		public function getDepNomEtu($num){

			$departement = new Departement($this->getDepartementEtu($num));

			return $departement->getDep_nom();
		}

		public function getVilleEtu($num){

			$departement = new Departement($this->getDepartementEtu($num));

			$vil_num = $departement->getVil_num();

			$sql = "SELECT * FROM ville
			WHERE vil_num = \"$vil_num\"";

			$requete = $this->db->prepare($sql);

			$requete->execute();

			$ville = new Ville($requete->fetch(PDO::FETCH_OBJ));

			return $ville->getVil_nom();
		}

		public function deleteEtudiant($num){
			$sql = "DELETE FROM etudiant WHERE per_num = $num";

			$requete = $this->db->prepare($sql);

			$requete->execute();

			return $requete->rowCount();
		}

		public function getDivisionEtu($num){
			$etudiant = new Etudiant($this->getEtu($num));

			$div_num = $etudiant->getDiv_num();

			$sql = "SELECT * FROM division
			WHERE div_num = \"$div_num\"";

			$requete = $this->db->prepare($sql);

			$requete->execute();

			$division = new Division($requete->fetch(PDO::FETCH_OBJ));

			return $division;
		}
}
