<?php
// Projet Réservations M2L - version web mobile
// fichier : controleurs/CtrlAnnulerReservation.php
// Rôle : traiter la demande d'annulation d'une réservation
// Création : 12/10/2015 par JM CARTRON
// Mise à jour : 2/6/2016 par JM CARTRON

// on vérifie si le demandeur de cette action est bien authentifié
if ( $_SESSION['niveauUtilisateur'] != 'utilisateur' && $_SESSION['niveauUtilisateur'] != 'administrateur') {
	// si le demandeur n'est pas authentifié, il s'agit d'une tentative d'accès frauduleux
	// dans ce cas, on provoque une redirection vers la page de connexion
	header ("Location: index.php?action=Deconnecter");
}
else {
	if ( ! isset ($_POST ["txtNumReservation"]) ) {
		// si les données n'ont pas été postées, c'est le premier appel du formulaire : affichage de la vue sans message d'erreur
		$numReservation = '';
		$message = '';
		$typeMessage = '';			// 2 valeurs possibles : 'information' ou 'avertissement'
		$themeFooter = $themeNormal;
		include_once ('vues/VueAnnulerReservation.php');
	}
	else {
		// récupération des données postées
		if ( empty ($_POST ["txtNumReservation"]) == true)  $numReservation = "";  else   $numReservation = $_POST ["txtNumReservation"];
		
		if ($numReservation == '') {
			// si les données sont incorrectes ou incomplètes, réaffichage de la vue avec un message explicatif
			$message = 'Données incomplètes ou incorrectes !';
			$typeMessage = 'avertissement';
			$themeFooter = $themeProbleme;
			include_once ('vues/VueAnnulerReservation.php');
		}
		else {
			// connexion du serveur web à la base MySQL
			include_once ('modele/DAO.class.php');
			$dao = new DAO();

			// si le numéro de réservation n'existe pas, réaffichage de la vue
			if ( ! $dao->existeReservation($numReservation) ) {
				$message = "Numéro de réservation inexistant !";
				$typeMessage = 'avertissement';
				$themeFooter = $themeProbleme;
				include_once ('vues/VueAnnulerReservation.php');
			}
			else {
				// si l'utilisateur n'est pas pas l'auteur de cette réservation, l'annulation est refusée
				if ( ! $dao->estLeCreateur($nom, $numReservation) ) {
					$message = "Vous n'êtes pas l'auteur de cette réservation !";
					$typeMessage = 'avertissement';
					$themeFooter = $themeProbleme;
					include_once ('vues/VueAnnulerReservation.php');		
				}
				else {
					// si la réservation est déjà passée, l'annulation est refusée
					if ( $dao->getReservation($numReservation)->getStart_time() < time() ) {
						$message = "Cette réservation est déjà passée !";
						$typeMessage = 'avertissement';
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
						$contenuMail = "Nous avons bien enregistré la suppression de la réservation N° " . $numReservation ;
						$ok = Outils::envoyerMail($adrMail, $sujet, $contenuMail, $ADR_MAIL_EMETTEUR);
						
						if ( $ok ) {
							$message = "Enregistrement effectué.<br>Vous allez recevoir un mail de confirmation.";
							$typeMessage = 'information';
							$themeFooter = $themeNormal;
						}
						else {
							$message = "Enregistrement effectué.<br>L'envoi du mail de confirmation a rencontré un problème.";
							$typeMessage = 'avertissement';
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