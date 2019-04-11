
	<h1>Supprimer des personnes enregistrées</h1>

	<form action="index.php?page=4" id="supprimerPersonne" method="post">

	<?php

	    $pdo=new Mypdo();
			$etudiantManager = new EtudiantManager($pdo);
			$salarieManager = new SalarieManager($pdo);
	    $personneManager = new PersonneManager($pdo);
			$personnes = $personneManager->getAllPersonne();

			if (empty($_POST["per_num"])) {
				echo "personne : ";

	      echo "<select class=\"listeDeroul\" name=\"per_num\" size=\"1\">";
	      echo "<option value=0>sélectionnez une personne</option>\n";
	      foreach ($personnes as $personne) {
					$perNum = $personne->getPer_num();
	        echo "<option value=".$perNum.">".$personneManager->getPrenomNomPers($perNum)."</option>\n";
	      }
	      echo "</select>";

?>
				<br><br>
				<input class="bouton" type="submit" name="bouton" value="Supprimer">
<?php
			} else {
				$prenomNom = $personneManager->getPrenomNomPers($_POST["per_num"]);

				if ($personneManager->is_etudiant($_POST["per_num"]) == 'true'){
					$count = $etudiantManager->deleteEtudiant($_POST["per_num"]);

					if ($count == 0) {
			      echo "<img src=\"image/erreur.png\" alt=\"erreur :\" title=\"echec de la suppression\" />";
			      echo "  L'étudiant <b>".$prenomNom."</b> n'a pas pu être supprimé";
			    }
				}
				//else (ne gère pas bob Marley qui est étudiant ET salarié)
		    if ($personneManager->is_salarie($_POST["per_num"]) == 'true') {
					$count = $salarieManager->deleteSalarie($_POST["per_num"]);

					if ($count == 0) {
			      echo "<img src=\"image/erreur.png\" alt=\"erreur :\" title=\"echec de la suppression\" />";
			      echo "  Le salarié <b>".$prenomNom."</b> n'a pas pu être supprimé";
			    }
				}

				$count = $personneManager->deletePersonne($_POST["per_num"]);

				if ($count == 0) {
		      echo "<img src=\"image/erreur.png\" alt=\"erreur :\" title=\"echec de la suppression\" />";
		      echo "  La personne <b>".$prenomNom."</b> n'a pas pu être supprimée";
		    } else {
		      echo "<img src=\"image/valid.png\" alt=\"ok :\" title=\"suppression effectuee\" />";
		      echo "  La personne <b>".$prenomNom."</b> a été supprimée";
		    }
			}
?>
