<h1>Ajouter une ville</h1>

<form action="index.php?page=7" id="insertVille" method="post">

<?php

    if (empty($_POST["vil_nom"])){

      echo "Nom : ";
?>
      <input class="saisie" type="text" name="vil_nom">
      <input class="bouton" type="submit" name="bouton" value="Valider">
<?php
    } else {
      $pdo=new Mypdo();
      $villeManager = new VilleManager($pdo);
      $ville = new Ville($_POST);
      $result=$villeManager->add($ville);

      if ($result == 0) {  //result contient le nb de lignes affectées
        echo "<img src=\"image/erreur.png\" alt=\"erreur :\" title=\"saisie invalide\" />";
        echo "  La ville <b>\"".$_POST["vil_nom"]."\"</b> n'a pas pu être ajoutée";
      } else {
        echo "<img src=\"image/valid.png\" alt=\"ok :\" title=\"saisie valide\" />";
        echo "  La ville <b>\"".$_POST["vil_nom"]."\"</b> a été ajoutée";
      }

    }

?>

</form>
