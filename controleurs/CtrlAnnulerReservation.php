<?php
// Projet Réservations M2L - version web mobile
// Fonction du contrôleur CtrlAnnulerReservation.php : traiter la demande d'annulation d'une réservation
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
		$msgFooter = 'Annuler une réservation';
		$themeFooter = $themeNormal;
		include_once ('vues/VueAnnulerReservation.php');
	}
	else {
		// récupération des données postées
		if ( empty ($_POST ["numReservation"]) == true)  $numReservation = "";  else   $numReservation = $_POST ["numReservation"];
		
		if ($numReservation == '') {
			// si les données sont incorrectes ou incomplètes, réaffichage de la vue avec un message explicatif
			$msgFooter = 'Données incomplètes ou incorrectes !';
			$themeFooter = $themeProbleme;
			include_once ('vues/VueAnnulerReservation.php');
		}
		else {
			// connexion du serveur web à la base MySQL
			include_once ('modele/DAO.class.php');
			$dao = new DAO();

			// si le numéro de réservation n'existe pas, réaffichage de la vue
			if ( ! $dao->existeReservation($numReservation) ) {
				$msgFooter = "Numéro de réservation inexistant !";
				$themeFooter = $themeProbleme;
				include_once ('vues/VueAnnulerReservation.php');
			}
			else {
				// si l'utilisateur n'est pas pas l'auteur de cette réservation, l'annulation est refusée
				if ( ! $dao->estLeCreateur($nom, $numReservation) ) {
					$msgFooter = "Vous n'êtes pas l'auteur de cette réservation !";
					$themeFooter = $themeProbleme;
					include_once ('vues/VueAnnulerReservation.php');		
				}
				else {
					// si la réservation est déjà passée, l'annulation est refusée
					if ( $dao->getReservation($numReservation)->getStart_time() < time() ) {
						$msgFooter = "Cette réservation est déjà passée !";
						$themeFooter = $themeProbleme;
						include_once ('vues/VueAnnulerReservation.php');
					}
					else {
						// supprime la réservation dans la base de données
						$dao->annulerReservation($numReservation);
						
						// recherche de l'adresse mail
						$adrMail = $dao->getUtilisateur($nom)->getEmail();
						
						// envoi d'un mail de confirmation de l'annulation
						$sujet = "Suppression de réservation";
						$message = "Nous avons bien enregistré la suppression de la réservation N° " . $numReservation ;
						$ok = Outils::envoyerMail($adrMail, $sujet, $message, $ADR_MAIL_EMETTEUR);
						
						if ( $ok ) {
							$msgFooter = "Enregistrement effectué.<br>Vous allez recevoir un mail de confirmation.";
							$themeFooter = $themeNormal;
						}
						else {
							$msgFooter = "Enregistrement effectué.<br>L'envoi du mail de confirmation a rencontré un problème.";
							$themeFooter = $themeProbleme;
						}
						include_once ('vues/VueAnnulerReservation.php');
					}
				}
			}
			unset($dao);		// fermeture de la connexion à MySQL
		}
	}
}