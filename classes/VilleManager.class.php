<?php
class VilleManager{
	private $dbo;

		public function __construct($db){
			$this->db = $db;
		}

		public function add($ville){
      $requete = $this->db->prepare(
				'INSERT INTO ville (vil_nom) VALUES (:nom);');

			$requete->bindValue(':nom',$ville->getVil_nom());

      $retour=$requete->execute();
			//var_dump($requete->debugDumpParams());

			return $retour;
    }

		public function getAllVille(){
      $listeVilles = array();

      $sql = 'SELECT * FROM ville ORDER BY vil_nom';

      $requete = $this->db->prepare($sql);
      $requete->execute();

      while ($ville = $requete->fetch(PDO::FETCH_OBJ))
            $listeVilles[] = new Ville($ville);

      $requete->closeCursor();
      return $listeVilles;
		}

		public function getNbVille(){

			$nbVille = 0;

			$listeVilles = $this->getAllVille();

			foreach ($listeVilles as $ville) {
				$nbVille++;
			}

      return $nbVille;
		}

		public function getVilleNom($vilNum) {

			$listeVilles = $this->getAllVille();

			foreach ($listeVilles as $ville) {
				if ($ville->getVil_num() == $vilNum)
					return $ville->getVil_nom();
			}

			return NULL;

		}
}
