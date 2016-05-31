<?php
	// Projet Réservations M2L - version web mobile
	// fichier : vues/VueDemanderMdp.php
	// Rôle : visualiser la vue de demande d'envoi d'un nouveau mot de passe
	// cette vue est appelée par le contôleur controleurs/CtrlDemanderMdp.php
	// Création : 12/10/2015 par JM CARTRON
	// Mise à jour : 31/5/2016 par JM CARTRON
?>
<!doctype html>
<html>
	<head>
		<?php include_once ('vues/head.php'); ?>
		
		<script>
			<?php if ($typeMessage != '') { ?>
				// associe une fonction à l'événement pageinit
				$(document).bind('pageinit', function() {
					// affiche la boîte de dialogue 'affichage_message'
					$.mobile.changePage('#affichage_message', {transition: "<?php echo $transition; ?>"});
				} );
			<?php } ?>
		</script>
	</head>
	
	<body>
		<div data-role="page">
			<div data-role="header" data-theme="<?php echo $themeNormal; ?>">
				<h4>M2L-GRR</h4>
				<a href="index.php?action=Connecter" data-ajax="false" data-transition="<?php echo $transition; ?>">Reconnexion</a>
			</div>
			<div data-role="content">
				<h4 style="text-align: center; margin-top: 10px; margin-bottom: 10px;">Demander un nouveau mot de passe</h4>
				<form name="form1" id="form1" action="index.php?action=DemanderMdp" data-ajax="false" method="post" data-transition="<?php echo $transition; ?>">
					<div data-role="fieldcontain" class="ui-hide-label">
						<label for="nom">Utilisateur :</label>
						<input type="text" name="nom" id="nom" placeholder="Entrez votre nom" value="<?php echo $nom; ?>" >
					</div>

					<div data-role="fieldcontain">
						<input type="submit" name="demanderMdp" id="demanderMdp" value="M'envoyer un nouveau mot de passe">
					</div>
				</form>
				
				<?php if($debug == true) {
					// en mise au point, on peut afficher certaines variables dans la page
					echo "<p>SESSION['nom'] = " . $_SESSION['nom'] . "</p>";
					echo "<p>SESSION['mdp'] = " . $_SESSION['mdp'] . "</p>";
					echo "<p>SESSION['niveauUtilisateur'] = " . $_SESSION['niveauUtilisateur'] . "</p>";
				} ?>
			</div>
			<div data-role="footer" data-position="fixed" data-theme="<?php echo $themeNormal; ?>">
				<h4>Suivi des réservations de salles<br>Maison des ligues de Lorraine (M2L)</h4>
			</div>
		</div>
		
		<?php include_once ('vues/dialog_message.php'); ?>
		
	</body>
</html>