<?php
class FonctionManager{
	private $dbo;

		public function __construct($db){
			$this->db = $db;
		}

		public function add($fonction){
      $requete = $this->db->prepare(
				'INSERT INTO departement (fon_num, fon_libelle)
				VALUES (:fon_num, :fon_libelle);');

			$requete->bindValue(':fon_num',$fonction->getFon_num());
			$requete->bindValue(':fon_libelle',$fonction->getFon_libelle());

      $retour=$requete->execute();
			//var_dump($requete->debugDumpParams());

			return $retour;
    }

		public function getAllFonction(){
      $listeFonctions = array();

      $sql = 'SELECT * FROM fonction';

      $requete = $this->db->prepare($sql);
      $requete->execute();

      while ($fonction = $requete->fetch(PDO::FETCH_OBJ))
            $listeFonctions[] = new Fonction($fonction);

      $requete->closeCursor();
      return $listeFonctions;
		}
}
