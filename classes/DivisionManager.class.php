<?php
class DivisionManager{
	private $dbo;

		public function __construct($db){
			$this->db = $db;
		}

		public function add($division){
      $requete = $this->db->prepare(
				'INSERT INTO departement (div_num, div_nom)
				VALUES (:div_num, :div_nom);');

			$requete->bindValue(':div_num',$division->getDiv_num());
			$requete->bindValue(':div_nom',$division->getDiv_nom());

      $retour=$requete->execute();
			//var_dump($requete->debugDumpParams());

			return $retour;
    }

		public function getAllDivision(){
      $listeDivisions = array();

      $sql = 'SELECT * FROM division';

      $requete = $this->db->prepare($sql);
      $requete->execute();

      while ($division = $requete->fetch(PDO::FETCH_OBJ))
            $listeDivisions[] = new Division($division);

      $requete->closeCursor();
      return $listeDivisions;
		}
}
