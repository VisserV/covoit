<?php
class DepartementManager{
	private $dbo;

		public function __construct($db){
			$this->db = $db;
		}

		public function add($departement){
      $requete = $this->db->prepare(
				'INSERT INTO departement (dep_num, dep_nom, vil_num)
				VALUES (:dep_num, :dep_nom, :vil_num);');

			$requete->bindValue(':dep_num',$departement->getDep_num());
			$requete->bindValue(':dep_nom',$departement->getDep_nom());
			$requete->bindValue(':vil_nom',$departement->getVil_num());

      $retour=$requete->execute();
			//var_dump($requete->debugDumpParams());

			return $retour;
    }

		public function getAllDepartement(){
      $listeDepartements = array();

      $sql = 'SELECT * FROM departement';

      $requete = $this->db->prepare($sql);
      $requete->execute();

      while ($departement = $requete->fetch(PDO::FETCH_OBJ))
            $listeDepartements[] = new Departement($departement);

      $requete->closeCursor();
      return $listeDepartements;
		}
}
