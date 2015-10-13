<?php
// Projet Réservations M2L - version web mobile
// Fonction du contrôleur CtrlChangerDeMdp.php : traiter la demande de changement de mot de passe
// Ecrit le 12/10/2015 par Jim

// on vérifie si le demandeur de cette action est bien authentifié
if ( $_SESSION['niveauUtilisateur'] != 'utilisateur' && $_SESSION['niveauUtilisateur'] != 'administrateur') {
	// si le demandeur n'est pas authentifié, il s'agit d'une tentative d'accès frauduleux
	// dans ce cas, on provoque une redirection vers la page de connexion
	header ("Location: index.php?action=Deconnecter");
}
else {
	if ( ! isset ($_POST ["nouveauMdp"]) && ! isset ($_POST ["confirmationMdp"]) ) {
		// si les données n'ont pas été postées, c'est le premier appel du formulaire : affichage de la vue sans message d'erreur
		$nouveauMdp = '';
		$confirmationMdp = '';
		$msgFooter = 'Changer mon mot de passe';
		$themeFooter = $themeNormal;
		include_once ('vues/VueChangerDeMdp.php');
	}
	else {
		// récupération des données postées
		if ( empty ($_POST ["nouveauMdp"]) == true)  $nouveauMdp = "";  else   $nouveauMdp = $_POST ["nouveauMdp"];
		if ( empty ($_POST ["confirmationMdp"]) == true)  $confirmationMdp = "";  else   $confirmationMdp = $_POST ["confirmationMdp"];
				
		if ( $nouveauMdp == "" || $confirmationMdp == "" ) {
			// si les données sont incomplètes, réaffichage de la vue avec un message explicatif
			$msgFooter = 'Données incomplètes !';
			$themeFooter = $themeProbleme;
			include_once ('vues/VueChangerDeMdp.php');
		}
		else {
			if ( $nouveauMdp != $confirmationMdp ) {
				// si les données sont incorrectes, réaffichage de la vue avec un message explicatif
				$msgFooter = 'Le nouveau mot de passe et<br>sa confirmation sont différents !';
				$themeFooter = $themeProbleme;
				include_once ('vues/VueChangerDeMdp.php');
			}
			else {
				// connexion du serveur web à la base MySQL
				include_once ('modele/DAO.class.php');
				$dao = new DAO();

				// enregistre le nouveau mot de passe de l'utilisateur dans la bdd après l'avoir codé en MD5
				$dao->modifierMdpUser ($nom, $nouveauMdp);
							
				// envoi d'un mail à l'utilisateur avec son nouveau mot de passe 
				$ok = $dao->envoyerMdp ($nom, $nouveauMdp);
							
				if ( $ok ) {
					$msgFooter = "Enregistrement effectué.<br>Vous allez recevoir un mail de confirmation.";
					$themeFooter = $themeNormal;
				}
				else {
					$msgFooter = "Enregistrement effectué.<br>L'envoi du mail de confirmation a rencontré un problème.";
					$themeFooter = $themeProbleme;
				}
				unset($dao);		// fermeture de la connexion à MySQL
				include_once ('vues/VueChangerDeMdp.php');
			}
		}
	}
}