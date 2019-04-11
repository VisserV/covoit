<h1>Ajouter un parcours</h1>

<form action="index.php?page=5" id="insertParcours" method="post">

<?php

    $pdo=new Mypdo();
    $parcoursManager = new ParcoursManager($pdo);
    $villeManager = new VilleManager($pdo);
    $villes = $villeManager->getAllVille();

    if (empty($_POST["vil_num1"]) && empty($_POST["vil_num2"]) && empty($_POST["saisieKm"])){
      echo "Ville 1 : ";

      echo "<select class=\"listeDeroul\" name=\"vil_num1\" size=\"1\">";
      echo "<option value=0>ville 1</option>\n";
      foreach ($villes as $ville) {
        echo "<option value=".$ville->getVil_num().">".$ville->getVil_nom()."</option>\n";
      }
      echo "</select>";


      echo "  Ville 2 : ";

      echo "<select class=\"listeDeroul\" name=\"vil_num2\" size=\"1\">";
      echo "<option value=0>ville 2</option>\n";
      foreach ($villes as $ville) {
        echo "<option value=".$ville->getVil_num().">".$ville->getVil_nom()."</option>\n";
      }
      echo "</select>";

      echo "  Nombre de kilomètre(s)";
?>

      <input class="saisie" type="text" name="par_km">
      <br>
      <input class="bouton" type="submit" name="bouton" value="Valider">
<?php
  } else {
    $ville1 = $_POST["vil_num1"];
    $ville2 = $_POST["vil_num2"];
    $nbKm = $_POST["par_km"];

    $valeursParcours = array('par_km'=>$nbKm, 'vil_num1'=>$ville1, 'vil_num2'=>$ville2);

    $parcours = new Parcours($valeursParcours);

    $result = $parcoursManager->add($parcours);

    if ($result == 0) {
      echo "<img src=\"image/erreur.png\" alt=\"erreur :\" title=\"saisie invalide\" />";
      echo "  Le parcours n'a pas pu être ajouté";
    } else {
      echo "<img src=\"image/valid.png\" alt=\"ok :\" title=\"saisie valide\" />";
      echo "  Le parcours a été ajouté";
    }

  }
?>

</form>
