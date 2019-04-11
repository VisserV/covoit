<h1>Pour vous connecter</h1>

<form action="index.php?page=11" id="connexion" method="post">

<?php

  $pdo = new Mypdo();
  $personneManager = new PersonneManager($pdo);

  if (empty($_POST["saisieLogin"]) && empty($_POST["saisieMdp"])
      && empty($_POST["saisieResult"])) {
?>

    <p>Nom d'utilisateur :</p>
    <input class="saisie" type="text" name="saisieLogin"><br>

    <p>Mot de passe :</p>
    <input class="saisie" type="password" name="saisieMdp"><br>

<?php
      $random1 = rand(1,9);
      $random2 = rand(1,9);

      $_SESSION["rand1"] = $random1;
      $_SESSION["rand2"] = $random2;

      $img1 = "image/nb/".$random1.".jpg";
      $img2 = "image/nb/".$random2.".jpg";

      echo "<h2>
      <img src=\"$img1\" alt=\"$random1\" title=\"1er nombre\" />
      +
      <img src=\"$img2\" alt=\"$random2\" title=\"2e nombre\" />
      =</h2> ";
?>

    <input class="saisie" type="text" name="saisieResult"><br><br>

    <input class="saisie" type="submit" name="bouton" value="Valider">

<?php

} else if (!empty($_POST["saisieLogin"]) && !empty($_POST["saisieMdp"])
            && !empty($_POST["saisieResult"])) {

    if ( $_POST["saisieResult"] != $_SESSION["rand1"] + $_SESSION["rand2"] ) {

      echo "<img src=\"image/erreur.png\" alt=\"erreur :\" title=\"saisie invalide\" />";
      echo "  <b>Résultat</b> incorrect";
    }
    else if ($personneManager->connexionPossible($_POST["saisieLogin"], $_POST["saisieMdp"]) == 'login') {
      echo "<img src=\"image/erreur.png\" alt=\"erreur :\" title=\"saisie invalide\" />";
      echo "  <b>Login</b> incorrect";
    }
    else if ($personneManager->connexionPossible($_POST["saisieLogin"], $_POST["saisieMdp"]) == 'pwd') {
      echo "<img src=\"image/erreur.png\" alt=\"erreur :\" title=\"saisie invalide\" />";
      echo "  <b>Mot de passe</b> incorrect";
    }
    else if ($personneManager->connexionPossible($_POST["saisieLogin"], $_POST["saisieMdp"]) == 'true'){
      //connexion approuvée

      $_SESSION["co"] = $personneManager->getIdParLogin($_POST["saisieLogin"]);

      // affichage test avant d'avoir la redirection car la redirection est immediate
      // (trop rapide pour voir l'affichage)
      echo "<img src=\"image/valid.png\" alt=\"ok :\" title=\"saisie valide\" />";
			echo "  Connexion approuvée <br> Vous allez être redirigé ";

      //redirection vers la page d'accueil en etant connecté
      header("Location: index.php?page=0");
      exit;

    }
  }
?>

</form>
