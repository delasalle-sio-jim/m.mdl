<?php
// Projet Réservations M2L - version web mobile
// Fonction du contrôleur CtrlConfirmerReservation.php : traiter la demande de confirmation d'une réservation provisoire
// Ecrit le 12/10/2015 par Jim

// on vérifie si le demandeur de cette action est bien authentifié
if ( $_SESSION['niveauUtilisateur'] != 'utilisateur' && $_SESSION['niveauUtilisateur'] != 'administrateur') {
	// si le demandeur n'est pas authentifié, il s'agit d'une tentative d'accès frauduleux
	// dans ce cas, on provoque une redirection vers la page de connexion
	header ("Location: index.php?action=Deconnecter");
}
else {
	if ( ! isset ($_POST ["numReservation"]) ) {
		// si les données n'ont pas été postées, c'est le premier appel du formulaire : affichage de la vue sans message d'erreur
		$numReservation = '';
		$msgFooter = 'Confirmer une réservation';
		$themeFooter = $themeNormal;
		include_once ('vues/VueConfirmerReservation.php');
	}
	else {
		// récupération des données postées
		if ( empty ($_POST ["numReservation"]) == true)  $numReservation = "";  else   $numReservation = $_POST ["numReservation"];
		
		if ($numReservation == '') {
			// si les données sont incorrectes ou incomplètes, réaffichage de la vue avec un message explicatif
			$msgFooter = 'Données incomplètes ou incorrectes !';
			$themeFooter = $themeProbleme;
			include_once ('vues/VueConfirmerReservation.php');
		}
		else {
			// connexion du serveur web à la base MySQL
			include_once ('modele/DAO.class.php');
			$dao = new DAO();

			// si le numéro de réservation n'existe pas, réaffichage de la vue
			if ( ! $dao->existeReservation($numReservation) ) {
				$msgFooter = "Numéro de réservation inexistant !";
				$themeFooter = $themeProbleme;
				include_once ('vues/VueConfirmerReservation.php');
			}
			else {
				// si l'utilisateur n'est pas pas l'auteur de cette réservation, la confirmation est refusée
				if ( ! $dao->estLeCreateur($nom, $numReservation) ) {
					$msgFooter = "Vous n'êtes pas l'auteur de cette réservation !";
					$themeFooter = $themeProbleme;
					include_once ('vues/VueConfirmerReservation.php');		
				}
				else {
					// si la réservation est déjà confirmée, la confirmation est refusée
					if ( $dao->getReservation($numReservation)->getStatus() == 0 ) {
						$msgFooter = "Cette réservation est déjà confirmée !";
						$themeFooter = $themeProbleme;
						include_once ('vues/VueConfirmerReservation.php');
					}
					else {
						// si la réservation est déjà passée, la confirmation est refusée
						if ( $dao->getReservation($numReservation)->getStart_time() < time() ) {
							$msgFooter = "Cette réservation est déjà passée !";
							$themeFooter = $themeProbleme;
							include_once ('vues/VueConfirmerReservation.php');
						}
						else {
							// enregistrement de la réservation à l'état confirmé
							$dao->confirmerReservation($numReservation);
							
							// recherche de l'adresse mail
							$adrMail = $dao->getUtilisateur($nom)->getEmail();
							// recherche du digicode
							$digicode = $dao->getReservation($numReservation)->getDigicode();
							
							// envoi d'un mail de confirmation de l'enregistrement
							$sujet = "Confirmation de réservation";
							$message = "Nous avons bien enregistré la confirmation de la réservation N° " . $numReservation . "\n\n";
							$message .= "Le digicode d'accès à la salle est : " . $digicode . "\n";
							$message .= "Il est valable 1 heure avant la réservation, et pendant 1 heure après la réservation.";
							$ok = Outils::envoyerMail($adrMail, $sujet, $message, $ADR_MAIL_EMETTEUR);
							
							if ( $ok ) {
								$msgFooter = "Enregistrement effectué.<br>Vous allez recevoir un mail de confirmation.";
								$themeFooter = $themeNormal;
							}
							else {
								$msgFooter = "Enregistrement effectué.<br>L'envoi du mail de confirmation a rencontré un problème.";
								$themeFooter = $themeProbleme;
							}
							include_once ('vues/VueConfirmerReservation.php');
						}
					}
				}
			}
			unset($dao);		// fermeture de la connexion à MySQL
		}
	}
}