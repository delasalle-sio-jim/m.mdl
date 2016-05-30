<?php
// Projet Réservations M2L - version web mobile
// Fonction du contrôleur CtrlConsulterReservations.php : traiter la demande de consultation des réservations d'un utilisateur
// Ecrit le 12/10/2015 par Jim
// Modifié le 29/5/2016 par Jim

// on vérifie si le demandeur de cette action est bien authentifié
if ( $_SESSION['niveauUtilisateur'] != 'utilisateur' && $_SESSION['niveauUtilisateur'] != 'administrateur') {
	// si le demandeur n'est pas authentifié, il s'agit d'une tentative d'accès frauduleux
	// dans ce cas, on provoque une redirection vers la page de connexion
	header ("Location: index.php?action=Deconnecter");
}
else {
	// connexion du serveur web à la base MySQL
	include_once ('modele/DAO.class.php');
	$dao = new DAO();
	
	// mise à jour de la table mrbs_entry_digicode (si besoin) pour créer les digicodes manquants
	$dao->creerLesDigicodesManquants();
	
	// récupération des réservations à venir créées par l'utilisateur à l'aide de la méthode getLesReservations de la classe DAO
	$lesReservations = $dao->getLesReservations($nom);
	
	// mémorisation du nombre de réservations
	$nbReponses = sizeof($lesReservations);

	// préparation d'un message dans le pied de page (footer)
	if ($nbReponses == 0) {
		$msgFooter = "Vous n'avez aucune réservation !";
		$themeFooter = $themeProbleme;
	}
	else {
		$msgFooter = "Vous avez " . $nbReponses . " réservation(s) !";
		$themeFooter = $themeNormal;
	}
	
	// affichage de la vue
	include_once ('vues/VueConsulterReservations.php');
	
	unset($dao);		// fermeture de la connexion à MySQL
}