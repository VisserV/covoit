<?php

$lien = "index.php?page=2";

  $pdo=new Mypdo();
  $etudiantManager = new EtudiantManager($pdo);
  $salarieManager = new SalarieManager($pdo);
  $personneManager = new PersonneManager($pdo);
  $nbPers=$personneManager->getNbPersonne();
  $personnes=$personneManager->getAllPersonne();

  if (empty($_GET["numPers"])){
    //affichage de la liste des personnes
?>
      <h1>Liste des personnes enregistrées</h1>
<?php
      echo "Actuellement ".$nbPers." personnes sont enregistrées <br><br>";
?>

    <table border=1 class="tab">
      <tr>
        <th>Numéro</th>
        <th>Nom</th>
        <th>Prenom</th>
      </tr>
<?php

          foreach ($personnes as $pers) {
            echo "<tr>";
              $lienPers = $lien."&numPers=".$pers->getPer_num();
              echo "<td><a href=\"$lienPers\">".$pers->getPer_num()."</a></td>\n";
              echo "<td>".$pers->getPer_nom()."</td>\n";
              echo "<td>".$pers->getPer_prenom()."</td>\n";
            echo "</tr>";
          }

?>
    </table>
<?php
  }
  else {
    //affichage des détails de la personne selectionnee

    $numPers = $_GET["numPers"];

    if ($personneManager->is_etudiant($numPers) == 'true'){
      echo "<h1>Détail sur l'étudiant ".$personneManager->getNomPers($numPers)."</h1>";

?>
      <table border=1>
        <tr>
          <th>Prénom</th>
          <th>Mail</th>
          <th>Tel</th>
          <th>Département</th>
          <th>Ville</th>
        </tr>
        <tr>
<?php
          echo "<td>".$personneManager->getPrenomPers($numPers)."</td>\n";
          echo "<td>".$personneManager->getMailPers($numPers)."</td>\n";
          echo "<td>".$personneManager->getTelPers($numPers)."</td>\n";
          echo "<td>".$etudiantManager->getDepNomEtu($numPers)."</td>\n";
          echo "<td>".$etudiantManager->getVilleEtu($numPers)."</td>\n";
?>
        </tr>
      </table>
<?php

    }
    //else (ne gère pas bob Marley qui est étudiant ET salarié)
    if ($personneManager->is_salarie($numPers) == 'true') {
      echo "<h1>Détail sur le salarié ".$personneManager->getNomPers($numPers)."</h1>";

?>
      <table border=1>
        <tr>
          <th>Prénom</th>
          <th>Mail</th>
          <th>Tel</th>
          <th>Tel pro</th>
          <th>Fonction</th>
        </tr>
        <tr>
<?php
          echo "<td>".$personneManager->getPrenomPers($numPers)."</td>\n";
          echo "<td>".$personneManager->getMailPers($numPers)."</td>\n";
          echo "<td>".$personneManager->getTelPers($numPers)."</td>\n";
          echo "<td>".$salarieManager->getTelProSal($numPers)."</td>\n";
          echo "<td>".$salarieManager->getFoncNomSal($numPers)."</td>\n";
?>
        </tr>
      </table>
<?php
    }

    //cas de l'acces en tapant le lien avec un numéro inconnu
    if ($personneManager->is_etudiant($numPers) == 'false' && $personneManager->is_salarie($numPers) == 'false'){

      echo "<h1>Détail sur une personne</h1>";

      echo "<img src=\"image/erreur.png\" alt=\"erreur :\" title=\"invalide\" />";
      echo "  Le numéro de personne <b>\"".$numPers."\"</b> est introuvable.";
    }
  }
?>
