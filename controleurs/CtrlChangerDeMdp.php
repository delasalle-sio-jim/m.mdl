<?php
// Projet Réservations M2L - version web mobile
// fichier : controleurs/CtrlChangerDeMdp.php
// Rôle : traiter la demande de changement de mot de passe
// Création : 12/10/2015 par JM CARTRON
// Mise à jour : 30/5/2016 par JM CARTRON

// on vérifie si le demandeur de cette action est bien authentifié
if ( $_SESSION['niveauUtilisateur'] != 'utilisateur' && $_SESSION['niveauUtilisateur'] != 'administrateur') {
	// si le demandeur n'est pas authentifié, il s'agit d'une tentative d'accès frauduleux
	// dans ce cas, on provoque une redirection vers la page de connexion
	header ("Location: index.php?action=Deconnecter");
}
else {
	if ( ! isset ($_POST ["txtNouveauMdp"]) && ! isset ($_POST ["txtConfirmationMdp"]) ) {
		// si les données n'ont pas été postées, c'est le premier appel du formulaire : affichage de la vue sans message d'erreur
		$nouveauMdp = '';
		$confirmationMdp = '';
		$afficherMdp = 'off';
		$message = '';
		$typeMessage = '';			// 2 valeurs possibles : 'information' ou 'avertissement'
		$themeFooter = $themeNormal;
		include_once ('vues/VueChangerDeMdp.php');
	}
	else {
		// récupération des données postées
		if ( empty ($_POST ["txtNouveauMdp"]) == true)  $nouveauMdp = "";  else   $nouveauMdp = $_POST ["txtNouveauMdp"];
		if ( empty ($_POST ["txtConfirmationMdp"]) == true)  $confirmationMdp = "";  else   $confirmationMdp = $_POST ["txtConfirmationMdp"];
		if ( empty ($_POST ["caseAfficherMdp"]) == true)  $afficherMdp = 'off';  else   $afficherMdp = $_POST ["caseAfficherMdp"];
			
		if ( $nouveauMdp == "" || $confirmationMdp == "" ) {
			// si les données sont incomplètes, réaffichage de la vue avec un message explicatif
			$message = 'Données incomplètes !';
			$typeMessage = 'avertissement';
			$themeFooter = $themeProbleme;
			include_once ('vues/VueChangerDeMdp.php');
		}
		else {
			if ( $nouveauMdp != $confirmationMdp ) {
				// si les données sont incorrectes, réaffichage de la vue avec un message explicatif
				$message = 'Le nouveau mot de passe et<br>sa confirmation sont différents !';
				$typeMessage = 'avertissement';
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
					$message = "Enregistrement effectué.<br>Vous allez recevoir un mail de confirmation.";
					$typeMessage = 'information';
					$themeFooter = $themeNormal;
				}
				else {
					$message = "Enregistrement effectué.<br>L'envoi du mail de confirmation a rencontré un problème.";
					$typeMessage = 'avertissement';
					$themeFooter = $themeProbleme;
				}
				unset($dao);		// fermeture de la connexion à MySQL
				include_once ('vues/VueChangerDeMdp.php');
			}
		}
	}
}