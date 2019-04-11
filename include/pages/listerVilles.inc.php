<h1>Liste des villes</h1>

<?php
  $pdo=new Mypdo();
  $villeManager = new VilleManager($pdo);
  $nbVilles=$villeManager->getNbVille();
  $villes=$villeManager->getAllVille();

  echo "Actuellement ".$nbVilles." villes sont enregistrées <br><br>";
?>

<table border=1>
  <tr>
    <th>Numéro</th>
    <th>Nom</th>
  </tr>
<?php

      foreach ($villes as $ville){
        echo "<tr>";
          echo "<td>".$ville->getVil_num()."</td>\n";
          echo "<td>".$ville->getVil_nom()."</td>\n";
        echo "</tr>";
      }

?>
</table>
