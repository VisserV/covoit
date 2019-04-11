<?php
class AvisManager{
	private $dbo;

		public function __construct($db){
			$this->db = $db;
		}

		public function add($departement){
      $requete = $this->db->prepare(
				'INSERT INTO departement (per_num, per_per_num, par_num, avi_comm, avi_note, avi_date)
				VALUES (:per_num, :per_per_num, :par_num, :avi_comm, :avi_note, :avi_date);');

			$requete->bindValue(':per_num',$departement->getPer_num());
			$requete->bindValue(':per_per_num',$departement->getPer_per_num());
			$requete->bindValue(':par_num',$departement->getPar_num());
			$requete->bindValue(':avi_comm',$departement->getAvi_comm());
			$requete->bindValue(':avi_note',$departement->getAvi_note());
			$requete->bindValue(':avi_date',$departement->getAvi_date());

      $retour=$requete->execute();
			//var_dump($requete->debugDumpParams());

			return $retour;
    }

		public function getDerAvis($numPers) {
			$requete = $this->db->prepare(
				"SELECT avi_comm FROM avis
				WHERE per_num = \"$numPers\"
				ORDER BY avi_date DESC;"
			);

			$requete->execute();

			$avis = new Avis($requete->fetch(PDO::FETCH_OBJ));

			return $avis->getAvi_comm();
		}

		public function getMoyenneAvis($numPers) {
			$requete = $this->db->prepare(
				"SELECT AVG(avi_note) AS avi_note FROM avis
				WHERE per_num = \"$numPers\";"
			);

			$requete->execute();

			$moyenne = new Avis($requete->fetch(PDO::FETCH_OBJ));

			return $moyenne->getAvi_note();
		}

		public function aUnAvis($numPers) {
			$requete = $this->db->prepare(
				"SELECT * FROM avis
				WHERE per_num = \"$numPers\";"
			);

			$requete->execute();

			$row = $requete->fetchAll();

			if (count($row) == 0){
				return false;
			} else {
				return true;
			}
		}

}
