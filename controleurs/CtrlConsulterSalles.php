<?php
// Projet Réservations M2L - version web mobile
// fichier : controleurs/CtrlConsulterSalles.php
// Rôle : traiter la demande de consultation des salles
// écrit par Jim le 12/10/2015
// modifié par Jim le 31/5/2016

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
	
	// récupération des salles à l'aide de la méthode getLesSalles de la classe DAO
	$lesSalles = $dao->getLesSalles();
	
	// mémorisation du nombre de salles
	$nbReponses = sizeof($lesSalles);

	// préparation d'un message précédent la liste
	$message = $nbReponses . " salles disponibles en réservation :";
	
	// affichage de la vue
	include_once ('vues/VueConsulterSalles.php');
	
	unset($dao);		// fermeture de la connexion à MySQL
}