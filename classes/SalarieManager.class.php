<?php
class SalarieManager{
	private $dbo;

		public function __construct($db){
			$this->db = $db;
		}

		public function add($salarie){
      $requete = $this->db->prepare(
				'INSERT INTO salarie (per_num, sal_telprof, fon_num)
				VALUES (:per_num, :telpro, :fon_num);');

			$requete->bindValue(':per_num',$salarie->getPer_num());
			$requete->bindValue(':telpro',$salarie->getSal_telprof());
			$requete->bindValue(':fon_num',$salarie->getFon_num());

      $retour=$requete->execute();
			//var_dump($requete->debugDumpParams());

			return $retour;
    }

		public function update($salarie){
			$requete = $this->db->prepare(
				'UPDATE salarie SET sal_telprof = :telprof, fon_num = :fon
				WHERE per_num = :num;' );

			$requete->bindValue(':telprof',$salarie->getSal_telprof());
			$requete->bindValue(':fon',$salarie->getFon_num());
			$requete->bindValue(':num',$salarie->getPer_num());

			$retour = $requete->execute();
			//var_dump($requete->debugDumpParams());

			return $retour;
		}

		public function getSal($num){
			$sql = "SELECT * FROM salarie
			WHERE per_num = \"$num\"";

			$requete = $this->db->prepare($sql);

			$requete->execute();

			$salarie = new Salarie($requete->fetch(PDO::FETCH_OBJ));

			return $salarie;
		}

		public function getFonctionSal($num){

			$salarie = new Salarie($this->getSal($num));

			$fon_num = $salarie->getFon_num();

			$sql = "SELECT * FROM fonction
			WHERE fon_num = \"$fon_num\"";

			$requete = $this->db->prepare($sql);

			$requete->execute();

			$fonction = new Fonction($requete->fetch(PDO::FETCH_OBJ));

			return $fonction;
		}

		public function getFoncNomSal($num){

			$fonction = new Fonction($this->getFonctionSal($num));

			return $fonction->getFon_libelle();
		}

		public function getTelProSal($num){

			$salarie = new Salarie($this->getSal($num));

			return $salarie->getSal_telprof();
		}

		public function deleteSalarie($num){
			$sql = "DELETE FROM salarie WHERE per_num = $num";

			$requete = $this->db->prepare($sql);

			$requete->execute();

			return $requete->rowCount();
		}
}
