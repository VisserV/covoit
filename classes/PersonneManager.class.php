<?php
class PersonneManager{
	private $dbo;

		public function __construct($db){
			$this->db = $db;
		}

		public function add($personne){
      $requete = $this->db->prepare(
				'INSERT INTO personne (per_nom, per_prenom, per_tel, per_mail, per_login,	per_pwd)
				VALUES (:nom, :prenom, :tel, :mail, :login, :pwd);');

			$requete->bindValue(':nom',$personne->getPer_nom());
			$requete->bindValue(':prenom',$personne->getPer_prenom());
			$requete->bindValue(':tel',$personne->getPer_tel());
			$requete->bindValue(':mail',$personne->getPer_mail());
			$requete->bindValue(':login',$personne->getPer_login());
			$requete->bindValue(':pwd',$personne->getPer_pwd());

      $retour=$requete->execute();
			//var_dump($requete->debugDumpParams());

			return $retour;
    }

		public function update($personne){
			$requete = $this->db->prepare(
				'UPDATE personne SET per_nom = :nom, per_prenom = :prenom, per_tel = :tel,
				per_mail = :mail, per_login = :login,	per_pwd = :pwd
				WHERE per_num = :num;' );

			$requete->bindValue(':nom',$personne->getPer_nom());
			$requete->bindValue(':prenom',$personne->getPer_prenom());
			$requete->bindValue(':tel',$personne->getPer_tel());
			$requete->bindValue(':mail',$personne->getPer_mail());
			$requete->bindValue(':login',$personne->getPer_login());
			$requete->bindValue(':pwd',$personne->getPer_pwd());
			$requete->bindValue(':num',$personne->getPer_num());

			$retour = $requete->execute();
			//var_dump($requete->debugDumpParams());

			return $retour;
		}

		public function getIdSaisie(){
			$pdo = new Mypdo();
			return $pdo->lastInsertId();
		}

		public function getAllPersonne(){
      $listePersonnes = array();

      $sql = 'SELECT * FROM personne ORDER BY 2';

      $requete = $this->db->prepare($sql);
      $requete->execute();

      while ($personne = $requete->fetch(PDO::FETCH_OBJ))
            $listePersonnes[] = new Personne($personne);

      $requete->closeCursor();
      return $listePersonnes;
		}

		public function getNbPersonne(){
			$nbPersonne = 0;

			$listePersonnes = $this->getAllPersonne();

			foreach ($listePersonnes as $pers) {
				$nbPersonne++;
			}

      return $nbPersonne;
		}

		public function deletePersonne($per_num){
			$sql = "DELETE FROM personne WHERE per_num = $per_num";

			$requete = $this->db->prepare($sql);

			$requete->execute();

			return $requete->rowCount();
		}

		public function getPers($num){
			$sql = "SELECT * FROM personne
			WHERE per_num = \"$num\"";

			$requete = $this->db->prepare($sql);

			$requete->execute();

			$personne = new Personne($requete->fetch(PDO::FETCH_OBJ));

			return $personne;
		}

		public function getPrenomNomPers($num){

			$personne = new Personne($this->getPers($num));

			return $personne->getPrenomNomPers();
		}

		public function getNomPers($num){

			$personne = new Personne($this->getPers($num));

			return $personne->getPer_nom();
		}

		public function getPrenomPers($num){

			$personne = new Personne($this->getPers($num));

			return $personne->getPer_prenom();
		}

		public function getMailPers($num){

			$personne = new Personne($this->getPers($num));

			return $personne->getPer_mail();
		}

		public function getTelPers($num){

			$personne = new Personne($this->getPers($num));

			return $personne->getPer_tel();
		}

		public function is_etudiant($num){
			$sql = "SELECT * FROM etudiant
			WHERE per_num = $num";

			$requete = $this->db->prepare($sql);

			$requete->execute();

			if ($requete->rowCount() > 0){
				return 'true';
			} else {
				return 'false';
			}
		}

		public function is_salarie($num){
			$sql = "SELECT * FROM salarie
			WHERE per_num = $num";

			$requete = $this->db->prepare($sql);

			$requete->execute();

			if ($requete->rowCount() > 0){
				return 'true';
			} else {
				return 'false';
			}
		}

		public function getPersParLogin($login){
			$sql = "SELECT * FROM personne
				WHERE per_login = \"$login\"";

			$requete = $this->db->prepare($sql);

			$requete->execute();

			if ($requete->rowCount() != 1) {
				//login incorrect ou doublon de login (probeleme de BD)
				return 'login';
			}

			$pers = new Personne($requete->fetch(PDO::FETCH_OBJ));

			return $pers;
		}

		public function connexionPossible($login, $pwd){

			$result = $this->getPersParLogin($login);

			if ($result == 'login') {
				//login incorrect ou doublon de login (probeleme de BD)
				return 'login';
			}

			$pers = new Personne($result);

			if ($pers->getPer_pwd() != sha1(sha1($pwd).SALT)){
				return 'pwd';
			}

			return 'true';
		}

		public function getIdParLogin($login){

			$result = $this->getPersParLogin($login);

			if ($result == 'login') {
				//login incorrect ou doublon de login (probeleme de BD)
				return 'login';
			}

			$pers = new Personne($result);

			return $pers->getPer_num();
		}

}
