<h1>Rechercher un trajet</h1>

<form action="index.php?page=10" id="rechercherPropose" method="post">

<?php

	$pdo = new Mypdo();
 	$personneManager = new PersonneManager($pdo);
  $villeManager = new VilleManager($pdo);
  $parcoursManager = new ParcoursManager($pdo);
  $proposeManager = new ProposeManager($pdo);
  $avisManager = new AvisManager($pdo);

	if (empty($_POST["villeDepart"]) && empty($_POST["villeArrivee"]) &&
		empty($_POST["dateDepart"]) && empty($_POST["heureDepart"]) &&
		empty($_POST["precision"]) ) {


    $villes = $proposeManager->getAllVilleProposee();

    echo "<b>Ville de départ : </b><br><br>";

    echo "<select class=\"listeDeroul\" name=\"villeDepart\" size=\"1\" onchange=\"submit()\">";
    echo "<option value=0>choisissez</option>\n";
    foreach ($villes as $ville) {
      echo "<option value=".$ville->getVil_num().">".$ville->getVil_nom()."</option>\n";
    }
    echo "</select>";
  }
	else if (!empty($_POST["villeDepart"]) && empty($_POST["villeArrivee"]) &&
		empty($_POST["dateDepart"]) && empty($_POST["heureDepart"]) &&
		empty($_POST["precision"]) ) {

			$_SESSION["villeDepart"] = $_POST["villeDepart"];

			$date = getEnglishDate(date('d/m/Y'));
			$dateMin = $date;
			$dateMax = addMois($dateMin, 6);
			//un trajet peut etre proposé entre la date du jour et 6 mois après

?>
	      <table border=0 class="tab">
	        <tr>
	          <th>Ville de départ :</th>
	          <td>
	            <?php echo $villeManager->getVilleNom($_SESSION["villeDepart"]); ?>
	          </td>
	          <th>Ville d'arrivée :</th>
	          <td>
<?php
	              $villesReliees = $proposeManager->getVilleReliee($_SESSION["villeDepart"]);
?>
	            <select class="listeDeroul" name="villeArrivee" size="1">
	              <option value=0>choisissez</option>
<?php
	              foreach ($villesReliees as $ville) {
	                echo "<option value=".$ville->getVil_num().">".$ville->getVil_nom()."</option>";
	              }
?>
	            </select>
	          </td>
	        </tr>
	        <tr>
	          <th>Date de départ :</th>
	          <td>
<?php
							echo "<input class=\"calendrier\" type=\"date\" name=\"dateDepart\"
								value=\"$date\" max=\"$dateMax\">";
?>
	          </td>

						<th>Précision :</th>
	          <td>
							<select class="listeDeroul" name="precision" size="1">
								<option value="0">Ce jour</option>
								<option value="1">+/- 1 jour</option>
								<option value="2">+/- 2 jours</option>
								<option value="3">+/- 3 jours</option>
							</select>
	          </td>
	        </tr>
	        <tr>
						<th>A partir de :</th>
	          <td>
							<select class="listeDeroul" name="heureDepart" size="1">
<?php
								for ($i=0; $i < 24; $i++) {
									if ($i < 10){
										$i = '0'.$i;
									}
									echo "<option value=\"".$i.":00:00\">".$i."h</option>\n";
								}
?>
							</select>
	          </td>
	        </tr>
	      </table>
	      <br>
	      <input class="bouton" type="submit" name="bouton" value="Valider">
<?php
	}
	else {
    //var_dump($_POST["dateDepart"]);
    // $_POST["dateDepart"] est deja au format de date anglais
		$date = /* getEnglishDate( */ $_POST["dateDepart"] /* ) */ ;
		$dateMin = removeJours($date, $_POST["precision"]);
		$dateMax = addJours($date, $_POST["precision"]);

		$trajetPropose = $proposeManager->getTrajetPropose($_SESSION["villeDepart"],
								$_POST["villeArrivee"], $dateMin, $dateMax, $_POST["heureDepart"]);

		if ($trajetPropose == NULL){
			echo "<img src=\"image/erreur.png\" alt=\"erreur :\" title=\"saisie invalide\" />";
			echo "  Désolé, pas de trajet disponible !";
		}
		else {
?>
			<table border=1>
				<tr>
					<th>Ville départ</th>
					<th>Ville arrivée</th>
					<th>Date départ</th>
					<th>Heure départ</th>
					<th>Nombre de place(s)</th>
					<th>Nom du covoitureur</th>
				</tr>
<?php

				$depart = $villeManager->getVilleNom($_SESSION["villeDepart"]);
				$arrivee = $villeManager->getVilleNom($_POST["villeArrivee"]);

				$idLigne = 0;
				foreach ($trajetPropose as $trajet) {
					$date = $trajet->getPro_date();
					$time = $trajet->getPro_time();
					$place = $trajet->getPro_place();
					$pers = $personneManager->getPrenomNomPers($trajet->getPer_num());

					echo "<tr>";
						echo "<td>$depart</td>";
						echo "<td>$arrivee</td>";
						echo "<td>$date</td>";
						echo "<td>$time</td>";
						echo "<td>$place</td>";

						echo "<td>";
							$lien = "index.php?page=2&numPers=".$trajet->getPer_num();
							$idElement = 'avisPop'.$idLigne;
							echo "<div class=\"avisPersonne\" onmouseover=\"afficherCacherAvis($idElement)\"
											onmouseout=\"afficherCacherAvis($idElement)\"><a href=\"$lien\">$pers</a>";

								// avis à afficher lorsque la souris est sur le nom
								echo "<span class=\"avisPop\" id=\"$idElement\">";

									if ($avisManager->aUnAvis($trajet->getPer_num())) {
										echo "Moyenne des avis : ".$avisManager->getMoyenneAvis($trajet->getPer_num());
										echo "<br> Dernier avis : ".$avisManager->getDerAvis($trajet->getPer_num());
									} else {
										echo "Cette personne n'a pas encore recu d'avis";
									}
?>
								</span>
							</div>
						</td>
					</tr>
<?php
					$idLigne++;
				}
?>
			</table>

			<script type="text/javascript" src="js/popup.js"></script>
<?php
		}
	}
?>
</form>
