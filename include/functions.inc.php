<?php
	function getEnglishDate($date){
		$membres = explode('/', $date);
		$date = $membres[2].'-'.$membres[1].'-'.$membres[0];
		return $date;
	}

	function addJours($date, $nbJours){
		$membres = explode('-', $date);

		$jour = intval($membres[2])+$nbJours;
		$mois = $membres[1];
		$annee = $membres[0];
		if ($jour > nbJoursMois($mois, $annee)){
			//changement de mois
			$jour = $jour - nbJoursMois($mois, $annee);
			$mois = intval($mois) + 1;

			if ($mois > 12){
				//changement d'annee
				$mois = 01;
				$annee = intval($annee) + 1;
			}

			if ($mois < 10){
				$mois = '0'.$mois;
			}

		}

		$date = $annee.'-'.$mois.'-'.$jour;
		return $date;
	}

	function removeJours($date, $nbJours){
		$membres = explode('-', $date);

		$jour = intval($membres[2])-$nbJours;
		$mois = $membres[1];
		$annee = $membres[0];

		if ($jour < 0){
			//changement de mois
			$mois = intval($mois) - 1;
			$jour = $jour + nbJoursMois($mois, $annee);

			if ($mois < 1){
				//changement d'annee
				$mois = 12;
				$annee = intval($annee) - 1;
			}

			if ($mois < 10){
				$mois = '0'.$mois;
			}

		}

		$date = $annee.'-'.$mois.'-'.$jour;
		return $date;
	}

	function addMois($date, $nbMois){
		$membres = explode('-', $date);

		if ((intval($membres[1])+$nbMois) <= 12 ) {
			$date = $membres[0].'-';
			if ((intval($membres[1])+$nbMois) < 10){
				$date = $date.'0';
			}
			$date = $date.(intval($membres[1])+$nbMois).'-'.$membres[2];
		}
		else {
			$date = (intval($membres[0])+1).'-';
			if (((intval($membres[1])+$nbMois) - 12) < 10){
				$date = $date.'0';
			}
			$date = $date.((intval($membres[1])+$nbMois) - 12).'-'.$membres[2];
		}
		return $date;
	}

	function nbJoursMois($mois, $annee){
		switch ($mois){
			case 1 : 		//janvier
			case 3 :		//mars
			case 5 :		//mai
			case 7 :		//juillet
			case 8 :		//aout
			case 10 :		//octobre
			case 12 :		//decembre
				return 31;
				break;

			case 4 :		//avril
			case 6 :		//juin
			case 9 :		//septembre
			case 11 :		//novembre
				return 30;
				break;

			case 2 :		//fevrier
				if ((($annee % 4 == 0) && ($annee % 100 != 0)) || ($annee % 400 == 0)){
					//année bisextile
					return 29;
				} else {
					return 28;
				}
				break;

			default :
				return NULL;
				break;
		}
	}

?>
