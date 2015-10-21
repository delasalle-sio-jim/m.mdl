<?php
// Projet Réservations M2L - version web mobile
// Fonction du contrôleur CtrlCreerUtilisateur.php : traiter la demande de création d'un nouvel utilisateur
// Ecrit le 21/10/2015 par Jim

// on vérifie si le demandeur de cette action a le niveau administrateur
if ($_SESSION['niveauUtilisateur'] != 'administrateur') {
	// si l'utilisateur n'a pas le niveau administrateur, il s'agit d'une tentative d'accès frauduleux
	// dans ce cas, on provoque une redirection vers la page de connexion
	header ("Location: index.php?action=Deconnecter");
}
else {
	if ( ! isset ($_POST ["name"]) && ! isset ($_POST ["email"]) && ! isset ($_POST ["level"]) ) {
		// si les données n'ont pas été postées, c'est le premier appel du formulaire : affichage de la vue sans message d'erreur
		$name = '';
		$email = '';
		$level = '0';
		$msgFooter = 'Créer un utilisateur';
		$themeFooter = $themeNormal;
		include_once ('vues/VueCreerUtilisateur.php');
	}
	else {
		// récupération des données postées
		if ( empty ($_POST ["name"]) == true)  $name = "";  else   $name = $_POST ["name"];
		if ( empty ($_POST ["email"]) == true)  $email = "";  else   $email = $_POST ["email"];
		if ( empty ($_POST ["level"]) == true)  $level = "0";  else   $level = $_POST ["level"];
		
		// inclusion de la classe Outils pour utiliser les méthodes statiques estUneAdrMailValide et creerMdp
		include_once ('modele/Outils.class.php');
		
		if ($name == '' || $email == '' || $level == '' || Outils::estUneAdrMailValide($email) == false) {
			// si les données sont incorrectes ou incomplètes, réaffichage de la vue de suppression avec un message explicatif
			$msgFooter = 'Données incomplètes ou incorrectes !';
			$themeFooter = $themeProbleme;
			include_once ('vues/VueCreerUtilisateur.php');
		}
		else {
			// connexion du serveur web à la base MySQL
			include_once ('modele/DAO.class.php');
			$dao = new DAO();
				
			if ( $dao->existeUtilisateur($name) ) {
				// si le nom existe déjà, réaffichage de la vue
				$msgFooter = "Nom d'utilisateur déjà existant !";
				$themeFooter = $themeProbleme;
				include_once ('vues/VueCreerUtilisateur.php');
			}
			else {
				// création d'un mot de passe aléatoire de 8 caractères
				$password = Outils::creerMdp();
				// enregistrement de l'utilisateur dans la BDD
				$ok = $dao->enregistrerUtilisateur($name, $level, $password, $email);
				if ( ! $ok ) {
					// si l'enregistrement a échoué, réaffichage de la vue avec un message explicatif					
					$msgFooter = "Problème lors de l'enregistrement !";
					$themeFooter = $themeProbleme;
					include_once ('vues/VueCreerUtilisateur.php');
				}
				else {
					// envoi d'un mail de confirmation de l'enregistrement
					$sujet = "Création de votre compte dans le système de réservation de M2L";
					$message = "L'administrateur du système de réservations de la M2L vient de vous créer un compte utilisateur.\n\n";
					$message .= "Les données enregistrées sont :\n\n";
					$message .= "Votre nom : " . $name . "\n";
					$message .= "Votre mot de passe : " . $password . " (nous vous conseillons de le changer lors de la première connexion)\n";
					$message .= "Votre niveau d'accès (0 : invité    1 : utilisateur    2 : administrateur) : " . $level . "\n";
						
					$ok = Outils::envoyerMail($email, $sujet, $message, $ADR_MAIL_EMETTEUR);
					if ( ! $ok ) {
						// si l'envoi de mail a échoué, réaffichage de la vue avec un message explicatif
						$msgFooter = "Enregistrement effectué.<br>L'envoi du mail à l'utilisateur a rencontré un problème !";
						$themeFooter = $themeProbleme;
						include_once ('vues/VueCreerUtilisateur.php');
					}
					else {
						// tout a fonctionné
						$msgFooter = "Enregistrement effectué.<br>Un mail va être envoyé à l'utilisateur !";
						$themeFooter = $themeNormal;
						include_once ('vues/VueCreerUtilisateur.php');
					}
				}
			}
			unset($dao);		// fermeture de la connexion à MySQL
		}
	}
}
