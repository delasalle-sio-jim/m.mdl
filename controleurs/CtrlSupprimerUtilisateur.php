<?php
// Projet Réservations M2L - version web mobile
// Fonction du contrôleur CtrlSupprimerUtilisateur.php : traiter la demande de suppression d'un utilisateur
// Ecrit le 21/10/2015 par Jim

// on vérifie si le demandeur de cette action a le niveau administrateur
if ($_SESSION['niveauUtilisateur'] != 'administrateur') {
	// si le demandeur n'a pas le niveau administrateur, il s'agit d'une tentative d'accès frauduleux
	// dans ce cas, on provoque une redirection vers la page de connexion
	header ("Location: index.php?action=Deconnecter");
}
else {
	if ( ! isset ($_POST ["name"]) ) {
		// si les données n'ont pas été postées, c'est le premier appel du formulaire : affichage de la vue sans message d'erreur
		$name = '';
		$msgFooter = 'Supprimer un utilisateur';
		$themeFooter = $themeNormal;
		include_once ('vues/VueSupprimerUtilisateur.php');
	}
	else {
		// récupération des données postées
		if ( empty ($_POST ["name"]) == true)  $name = "";  else   $name = $_POST ["name"];
		
		if ($name == '') {
			// si les données sont incorrectes ou incomplètes, réaffichage de la vue avec un message explicatif
			$msgFooter = 'Données incomplètes ou incorrectes !';
			$themeFooter = $themeProbleme;
			include_once ('vues/VueSupprimerUtilisateur.php');
		}
		else {
			// connexion du serveur web à la base MySQL
			include_once ('modele/DAO.class.php');
			$dao = new DAO();
				
			if ( ! $dao->existeUtilisateur($name) ) {
				// si le nom n'existe pas, réaffichage de la vue
				$msgFooter = "Nom d'utilisateur inexistant !";
				$themeFooter = $themeProbleme;
				include_once ('vues/VueSupprimerUtilisateur.php');
			}
			else {
				// si cet utilisateur a passé des réservations à venir, sa suppression est refusée
				if ( $dao->aPasseDesReservations($name) ) {
					$msgFooter = "Cet utilisateur a passé des réservations à venir !";
					$themeFooter = $themeProbleme;
					include_once ('vues/VueSupprimerUtilisateur.php');		
				}
				else {
					// recherche de l'adresse mail de l'utilisateur (avant de le supprimer)
					$email = $dao->getUtilisateur($name)->getEmail();
				
					// suppression de l'utilisateur dans la BDD
					$ok = $dao->supprimerUtilisateur($name);
					if ( ! $ok ) {
						// si la suppression a échoué, réaffichage de la vue avec un message explicatif
						$msgFooter = "Problème lors de la suppression de l'utilisateur !";
						$themeFooter = $themeProbleme;
						include_once ('vues/VueSupprimerUtilisateur.php');
					}
					else {
						// envoi d'un mail de confirmation de la suppression
						$sujet = "Suppression de votre compte dans le système de réservation de M2L";
						$message = "Bonjour $name.\n\nL'administrateur du système de réservations de la M2L vient de supprimer votre compte utilisateur.\n";
							
						$ok = Outils::envoyerMail($email, $sujet, $message, $ADR_MAIL_EMETTEUR);
						if ( ! $ok ) {
							// si l'envoi de mail a échoué, réaffichage de la vue avec un message explicatif
							$msgFooter = "Suppression effectuée.<br>L'envoi du mail à l'utilisateur a rencontré un problème !";
							$themeFooter = $themeProbleme;
							include_once ('vues/VueSupprimerUtilisateur.php');
						}
						else {
							// tout a fonctionné
							$msgFooter = "Suppression effectuée.<br>Un mail va être envoyé à l'utilisateur !";
							$themeFooter = $themeNormal;
							include_once ('vues/VueSupprimerUtilisateur.php');
						}
					}
				}
			}
			unset($dao);		// fermeture de la connexion à MySQL
		}
	}
}
