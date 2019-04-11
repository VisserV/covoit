<?php
	$_SESSION["co"] = 'false';

	//redirection vers la page d'accueil en n'étant plus connecté
	header('Location: index.php?page=0');
	exit;

?>
