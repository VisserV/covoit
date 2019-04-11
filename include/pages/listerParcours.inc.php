<h1>Liste des parcours proposés</h1>

<?php
  $pdo=new Mypdo();
  $parcoursManager = new ParcoursManager($pdo);
  $villeManager = new VilleManager($pdo);
  $nbParcours=$parcoursManager->getNbParcours();
  $parcours=$parcoursManager->getAllParcours();

  echo "Actuellement ".$nbParcours." parcours sont enregistrés <br><br>";
?>

<table border=1 class="tab">
  <tr>
    <th>Numéro</th>
    <th>Nom ville</th>
    <th>Nom ville</th>
    <th>Nombre de Km</th>
  </tr>
<?php
      foreach ($parcours as $par) {
        echo "<tr>";
          echo "<td>".$par->getPar_num()."</td>\n";
          echo "<td>".$villeManager->getVilleNom($par->getVil_num1())."</td>\n";
          echo "<td>".$villeManager->getVilleNom($par->getVil_num2())."</td>\n";
          echo "<td>".$par->getPar_km()."</td>\n";
        echo "</tr>";
      }

?>
</table>
