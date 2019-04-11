<h1>Proposer un trajet</h1>

<form action="index.php?page=9" id="insertPropose" method="post">

<?php

	$pdo = new Mypdo();
 	$personneManager = new PersonneManager($pdo);
  $villeManager = new VilleManager($pdo);
  $parcoursManager = new ParcoursManager($pdo);
  $proposeManager = new ProposeManager($pdo);

	if (empty($_POST["villeDepart"]) && empty($_POST["villeArrivee"]) &&
		empty($_POST["dateDepart"]) && empty($_POST["heureDepart"]) &&
		empty($_POST["nbPlace"]) ) {


    $villes = $parcoursManager->getAllVille();

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
		      empty($_POST["nbPlace"])){

    $_SESSION["villeDepart"] = $_POST["villeDepart"];
		$date = getEnglishDate(date('d/m/Y'));
		$dateMin = $date;
		$dateMax = addMois($dateMin, 6);
		//un trajet peut etre proposé entre la date du jour et 6 mois après

		$heure = date('H:i:s');

?>
      <table border=0 class="tab">
        <tr>
          <th>Ville de départ :</th>
          <td>
<?php
						echo $villeManager->getVilleNom($_SESSION["villeDepart"]);
?>
          </td>
          <th>Ville d'arrivée :</th>
          <td>
<?php
              $villesReliees = $parcoursManager->getVilleReliee($_SESSION["villeDepart"]);
?>
            <select class="listeDeroul" name="villeArrivee" size="1">
              <option value=0>choisissez</option>
<?php
              foreach ($villesReliees as $ville) {
                echo "<option value=".$ville->getVil_num().">".$ville->getVil_nom()."</option>\n";
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
							value=\"$date\" min=\"$dateMin\" max=\"$dateMax\">";
?>
          </td>
          <th>Heure de départ :</th>
          <td>
<?php
						echo "<input id=\"heureCalendrier\" type=\"time\" name=\"heureDepart\" value=\"$heure\"> ";
?>
          </td>
        </tr>
        <tr>
          <th>Nombre de places :</th>
          <td>
            <input class="saisie" type="text" name="nbPlace">
          </td>
        </tr>
      </table>
      <br>
      <input class="bouton" type="submit" name="bouton" value="Valider">
<?php
  } else {
		//insertion dans la BD mais il faut tenir compte de la personne qui est connectée pour
		//inserser per_num dans la base en fonction de la personne qui saisie les informations

		$par_num = $parcoursManager->getNumParcours($_SESSION["villeDepart"], $_POST["villeArrivee"]);
		$sens = $parcoursManager->getSensPropose($_SESSION["villeDepart"], $_POST["villeArrivee"]);

		$valeursPropose = array('par_num'=>$par_num, 'per_num'=>$_SESSION["co"],
                'pro_date'=>$_POST["dateDepart"], 'pro_time'=>$_POST["heureDepart"],
                'pro_place'=>$_POST["nbPlace"], 'pro_sens'=>$sens);


		$propose = new Propose($valeursPropose);

    //var_dump($propose);

		$resultPro = $proposeManager->add($propose);

		if ($resultPro == 0) {

			echo "<img src=\"image/erreur.png\" alt=\"erreur :\" title=\"saisie invalide\" />";
			echo "  Le trajet n'a pas pu être ajouté";

		} else {

			echo "<img src=\"image/valid.png\" alt=\"ok :\" title=\"saisie valide\" />";
			echo "  Le trajet a été ajouté";

		}
	}
?>
