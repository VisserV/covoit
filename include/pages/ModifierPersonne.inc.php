
<form action="index.php?page=3" id="modifPers" method="post">

  <?php
  $pdo = new Mypdo();
  $personneManager = new PersonneManager($pdo);
  $etudiantManager = new EtudiantManager($pdo);
  $salarieManager = new SalarieManager($pdo);
  $divisionManager = new DivisionManager($pdo);
  $departementManager = new DepartementManager($pdo);
  $fonctionManager = new FonctionManager($pdo);

  if ( empty($_POST["per_num"]) && empty($_POST["per_nom"]) && empty($_POST["per_prenom"])
          && empty($_POST["per_tel"]) && empty($_POST["per_mail"]) ) {
  //1e iteration
?>
      <h1>Modifier une personne</h1>
<?php
      $personnes = $personneManager->getAllPersonne();

      echo "Personne à modifier : ";

      echo "<select class=\"listeDeroul\" name=\"per_num\" size=\"1\" onchange=\"submit()\">";
      echo "<option value=0>Personne</option>\n";
      foreach ($personnes as $pers) {
        echo "<option value=".$pers->getPer_num().">".$pers->getPrenomNomPers()."</option>\n";
      }
      echo "</select>";
  } else if (!empty($_POST["per_num"]) && empty($_POST["per_nom"]) && empty($_POST["per_prenom"])
          && empty($_POST["per_tel"]) && empty($_POST["per_mail"]) ) {
    //2e iteration

    $_SESSION["per_num"] = $_POST["per_num"];

    $pers = $personneManager->getPers($_POST["per_num"]);
    echo "<h1>Modifier ".$pers->getPrenomNomPers()."</h1>";
?>
    <table border=0 class="tab">
      <tr>
        <th>Nom :</th>
        <td>
<?php
          echo "<input class=\"saisie\" type=\"text\" value=\"".$pers->getPer_nom()."\" name=\"per_nom\">";
?>
        </td>
        <th>Prenom :</th>
        <td>
<?php
          echo "<input class=\"saisie\" type=\"text\" value=\"".$pers->getPer_prenom()."\" name=\"per_prenom\">"
?>
        </td>
      </tr>
      <tr>
        <th>Téléphone :</th>
        <td>
<?php
          echo "<input class=\"saisie\" type=\"text\" value=\"".$pers->getPer_tel()."\" name=\"per_tel\">";
?>
        </td>
        <th>Mail :</th>
        <td>
<?php
          echo "<input class=\"saisie\" type=\"text\" value=\"".$pers->getPer_mail()."\" name=\"per_mail\">";
?>
        </td>
      </tr>
      <tr>
        <th>Login :</th>
        <td>
<?php
          echo "<input class=\"saisie\" type=\"text\" value=\"".$pers->getPer_login()."\" name=\"per_login\">";
?>
        </td>
<?php
          //on ne peut modifier que son propre mot de passe
          //il faut donc être connecté en tant que la personne que
          //l'on modifie pour pouvoir changer le mot de passe
          if ($_SESSION["co"] == $pers->getPer_num()) {
?>
        <th>Mot de passe :</th>
        <td>
<?php
          echo "<input class=\"saisie\" type=\"password\" name=\"per_pwd\">";
        echo "</td>";
      }
      echo "</tr>";
      if ($personneManager->is_etudiant($pers->getPer_num()) == 'true'){
?>
        <tr>
          <th>Année :</th>
          <td>
<?php
            $divisions = $divisionManager->getAllDivision();
            $divSelect = $etudiantManager->getDivisionEtu( $pers->getPer_num() );

            echo "<select class=\"listeDeroul\" name=\"div_num\" size=\"1\">";
            echo "<option value=".$divSelect->getDiv_num().">".$divSelect->getDiv_nom()."</option>\n";
            foreach ($divisions as $div) {
              echo "<option value=".$div->getDiv_num().">".$div->getDiv_nom()."</option>\n";
            }
?>
            </select>
          </td>

          <th>Département :</th>
          <td>
<?php

          $departements = $departementManager->getAllDepartement();
          $depSelect = $etudiantManager->getDepartementEtu( $pers->getPer_num() );

          echo "<select class=\"listeDeroul\" name=\"dep_num\" size=\"1\">";
          echo "<option value=".$depSelect->getDep_num().">".$depSelect->getDep_nom()."</option>\n";
          foreach ($departements as $dep) {
            echo "<option value=".$dep->getDep_num().">".$dep->getDep_nom()."</option>\n";
          }
          echo "</select>";
        echo "</tr>";
      }

      //else (ne gère pas bob Marley qui est étudiant ET salarié)
      if ($personneManager->is_salarie($pers->getPer_num()) == 'true'){
        echo "<tr>";
?>
          <th>Téléphone professionnel : </th>
          <td>
<?php
            $sal = $salarieManager->getSal($pers->getPer_num());
            echo "<input class=\"saisie\" type=\"text\" value=".$sal->getSal_telprof()." name=\"sal_telprof\">";

?>
          </td>

          <th>Fonction : </th>
          <td>
<?php
            $fonctions = $fonctionManager->getAllFonction();
            $fonSelect = $salarieManager->getFonctionSal( $pers->getPer_num() );

            echo "<select class=\"listeDeroul\" name=\"fon_num\" size=\"1\">";
            echo "<option value=".$fonSelect->getFon_num().">".$fonSelect->getFon_libelle()."</option>\n";
            foreach ($fonctions as $fonc) {
              echo "<option value=".$fonc->getFon_num().">".$fonc->getFon_libelle()."</option>\n";
            }
?>
            </select>
          </td>
        </tr>
<?php
      }
?>
    </table>

    <br>
    <input class="bouton" type="submit" name="bouton" value="Valider">
<?php
  }
  else {
    //3e iteration

    $pers = $personneManager->getPers($_SESSION["per_num"]);

    echo "<h1>Modifier ".$pers->getPrenomNomPers()."</h1>";

    //quelle(s) valeur(s) a/ont été modifié ?
    //le nom
    if ($_POST["per_nom"] != $pers->getPer_nom()){
      $pers->setPer_nom($_POST["per_nom"]);
    }
    //le prenom
    if ($_POST["per_prenom"] != $pers->getPer_prenom()){
      $pers->setPer_prenom($_POST["per_prenom"]);
    }
    //le numero de telephone
    if ($_POST["per_tel"] != $pers->getPer_tel()){
      $pers->setPer_tel($_POST["per_tel"]);
    }
    //le mail
    if ($_POST["per_mail"] != $pers->getPer_mail()){
      $pers->setPer_mail($_POST["per_mail"]);
    }
    //le login
    if ($_POST["per_login"] != $pers->getPer_login()){
      $pers->setPer_login($_POST["per_login"]);
    }
    //le mot de passe
    //si la personne modifiée n'est pas connectée, le champs ne peut pas être
    //modifié et est donc forcément vide,
    //sinon, si le champs n'est pas vide on considère le mot de passe comme changé
    if (!empty($_POST["per_pwd"])){
      $pers->setPer_pwd($_POST["per_pwd"]);
    }

    //vérification des champs étudiants
    if ($personneManager->is_etudiant($pers->getPer_num()) == 'true'){
      $etu = $etudiantManager->getEtu($pers->getPer_num());

      //la division
      if ($_POST["div_num"] != $etu->getDiv_num()){
        $etu->setDiv_num($_POST["div_num"]);
      }
      //le département
      if ($_POST["dep_num"] != $etu->getDep_num()){
        $etu->setDep_num($_POST["dep_num"]);
      }
    }

    //vérification des champs salariés
    if ($personneManager->is_salarie($pers->getPer_num()) == 'true'){
      $sal = $salarieManager->getSal($pers->getPer_num());

      //le numéro de téléphone pro
      if ($_POST["sal_telprof"] != $sal->getSal_telprof()){
        $sal->setSal_telprof($_POST["sal_telprof"]);
      }
      //le login
      if ($_POST["fon_num"] != $sal->getFon_num()){
        $sal->setFon_num($_POST["fon_num"]);
      }

    }

    // la modification est faite en local mais pas dans la base de données pour le moment
    // la fonction update des managers de classe mettent à jour la base de données
    $resultPers = $personneManager->update($pers);
    $result = $resultPers;

    if ($personneManager->is_etudiant($pers->getPer_num()) == 'true'){
      $resultEtu = $etudiantManager->update($etu);
      $result = $result + $resultEtu;
    }
    if ($personneManager->is_salarie($pers->getPer_num()) == 'true'){
      $resultSal = $salarieManager->update($sal);
      $result = $result + $resultSal;
    }

    if ($result == 0) {  //result contient le nb de lignes affectées
      echo "<img src=\"image/erreur.png\" alt=\"erreur :\" title=\"saisie invalide\" />";
      echo "  Les modifications n'ont pas pu être enregistrées";
    } else {
      echo "<img src=\"image/valid.png\" alt=\"ok :\" title=\"saisie valide\" />";
      echo "  Les modifications ont été enregistrées";
    }

  }
?>
