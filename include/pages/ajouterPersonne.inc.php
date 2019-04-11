
<form action="index.php?page=1" id="insertPers" method="post">

<?php
	$pdo = new Mypdo();
 	$personneManager = new PersonneManager($pdo);
	$etudiantManager = new EtudiantManager($pdo);
	$salarieManager = new SalarieManager($pdo);
	$divisionManager = new DivisionManager($pdo);
	$departementManager = new DepartementManager($pdo);
	$fonctionManager = new FonctionManager($pdo);

	if ((empty($_POST["per_nom"]) || empty($_POST["per_prenom"]) ||
		empty($_POST["per_tel"]) || empty($_POST["per_mail"]) ||
		empty($_POST["per_login"]) || empty($_POST["per_pwd"]))
		&& (empty($_POST["div_num"]) && empty($_POST["dep_num"])
		&& empty($_POST["sal_telprof"]) && empty($_POST["fon_num"]))) {
?>

			<h1>Ajouter une personne</h1>

			<table border=0 class="tab">
				<tr>
					<th>Nom :</th>
					<td>
						<input class="saisie" type="text" name="per_nom">
					</td>
					<th>Prenom :</th>
					<td>
						<input class="saisie" type="text" name="per_prenom">
					</td>
				</tr>
				<tr>
					<th>Téléphone :</th>
					<td>
						<input class="saisie" type="text" name="per_tel">
					</td>
					<th>Mail :</th>
					<td>
						<input class="saisie" type="text" name="per_mail">
					</td>
				</tr>
				<tr>
					<th>Login :</th>
					<td>
						<input class="saisie" type="text" name="per_login">
					</td>
					<th>Mot de passe :</th>
					<td>
						<input class="saisie" type="password" name="per_pwd">
					</td>
				</tr>
			</table>
			<br>
				<p>Catégorie : </p>
				<input type="radio" name="categorie" value="etudiant" checked> Etudiant
				<input type="radio" name="categorie" value="personnel"> Personnel

			<br>
			<br>
			<input class="bouton" type="submit" name="bouton" value="Valider">

<?php
		} else {
			if (!empty($_POST["categorie"])){
				//2e itération

				$_SESSION["per_nom"] = $_POST["per_nom"];
				$_SESSION["per_prenom"] = $_POST["per_prenom"];
				$_SESSION["per_tel"] = $_POST["per_tel"];
				$_SESSION["per_mail"] = $_POST["per_mail"];
				$_SESSION["per_login"] = $_POST["per_login"];
				//codage du mot de passe saisi
				$_SESSION["per_pwd"] = sha1(sha1($_POST["per_pwd"]).SALT);
				$_SESSION["categorie"] = $_POST["categorie"];

				if ($_POST["categorie"] == "etudiant") {
					//la personne saisie est un étudiant

					echo "<h1>Ajouter un étudiant</h1>";


					$divisions = $divisionManager->getAllDivision();

					echo "Année : ";

					echo "<select class=\"listeDeroul\" name=\"div_num\" size=\"1\">";
		      echo "<option value=0>division</option>\n";
			    foreach ($divisions as $div) {
			    	echo "<option value=".$div->getDiv_num().">".$div->getDiv_nom()."</option>\n";
			    }
			    echo "</select>";


					$departements = $departementManager->getAllDepartement();

					echo "  Département : ";

					echo "<select class=\"listeDeroul\" name=\"dep_num\" size=\"1\">";
		      echo "<option value=0>département</option>\n";
		      foreach ($departements as $dep) {
		        echo "<option value=".$dep->getDep_num().">".$dep->getDep_nom()."</option>\n";
		      }
		      echo "</select>";

?>
					<br>
					<input class="bouton" type="submit" name="bouton" value="Valider">
<?php

				} else {
					//la personne saisie est un salarié

					echo "<h1>Ajouter un salarié</h1>";

					echo "Téléphone professionnel : ";
					echo "<input type=\"text\" name=\"sal_telprof\">";

					$fonctions = $fonctionManager->getAllFonction();

					echo "  Fonction : ";

					echo "<select class=\"listeDeroul\" name=\"fon_num\" size=\"1\">";
		      echo "<option value=0>fonction</option>\n";
		      foreach ($fonctions as $fonc) {
		        echo "<option value=".$fonc->getFon_num().">".$fonc->getFon_libelle()."</option>\n";
		      }
		      echo "</select>";

?>
					<br>
					<br>
					<input class="bouton" type="submit" name="bouton" value="Valider">
<?php

				}

			} else {
				//3e itération

				$per_nom = $_SESSION["per_nom"];
				$per_prenom = $_SESSION["per_prenom"];
				$per_tel = $_SESSION["per_tel"];
				$per_mail = $_SESSION["per_mail"];
				$per_login = $_SESSION["per_login"];
				$per_pwd = $_SESSION["per_pwd"];

				$valeursPers = array('per_nom'=>$per_nom, 'per_prenom'=>$per_prenom, 'per_tel'=>$per_tel,
									'per_mail'=>$per_mail, 'per_login'=>$per_login, 'per_pwd'=>$per_pwd);

	      $personne = new Personne($valeursPers);

				$resultPers = $personneManager->add($personne);
				$per_num = $personneManager->getIdSaisie();

				if ($resultPers == 0) {

					echo "<img src=\"image/erreur.png\" alt=\"erreur :\" title=\"saisie invalide\" />";
					echo "  La personne <b>\"".$per_nom." ".$per_prenom."\"</b> n'a pas pu être ajouté";

				} else {

					if ($_SESSION["categorie"] == "etudiant"){

						echo "<h1>Ajouter un étudiant</h1>";

						$div_num = $_POST["div_num"];
						$dep_num = $_POST["dep_num"];


						$valeursEtu = array('per_num'=>$per_num, 'dep_num'=>$dep_num, 'div_num'=>$div_num);

			      $etudiant = new Etudiant($valeursEtu);

						$resultEtu = $etudiantManager->add($etudiant);

						if ($resultEtu == 0) {

							//supprimer la personne de la table personne
							$personneManager->deletePersonne($per_num);

				      echo "<img src=\"image/erreur.png\" alt=\"erreur :\" title=\"saisie invalide\" />";
				      echo "  L'étudiant <b>\"".$per_nom." ".$per_prenom."\"</b> n'a pas pu être ajouté";

				    } else {

							echo "<img src=\"image/valid.png\" alt=\"ok :\" title=\"saisie valide\" />";
				      echo "  L'étudiant <b>\"".$per_nom." ".$per_prenom."\"</b> a été ajouté";

			      }

					} else {

						echo "<h1>Ajouter un salarié</h1>";

						$telPro = $_POST["sal_telprof"];
						$fonction = $_POST["fon_num"];


						$valeursSal = array('per_num'=>$per_num, 'sal_telprof'=>$telPro, 'fon_num'=>$fonction);

			      $salarie = new Salarie($valeursSal);

						$resultSal = $salarieManager->add($salarie);

						if ($resultSal == 0) {

							//supprimer la personne de la table personne
							$personneManager->deletePersonne($per_num);

				      echo "<img src=\"image/erreur.png\" alt=\"erreur :\" title=\"saisie invalide\" />";
				      echo "  Le salarié <b>\"".$per_nom." ".$per_prenom."\"</b> n'a pas pu être ajouté";

				    } else {

							echo "<img src=\"image/valid.png\" alt=\"ok :\" title=\"saisie valide\" />";
				      echo "  Le salarié <b>\"".$per_nom." ".$per_prenom."\"</b> a été ajouté";

			      }
					}
				}
			}
		}

?>

</form>
