<?php
	// Projet Réservations M2L - version web mobile
	// Fonction de la vue VueSupprimerUtilisateur.php : visualiser la demande de suppression d'un utilisateur
	// Ecrit le 12/10/2015 par Jim
?>
<!doctype html>
<html>
	<head>
		<?php include_once ('vues/head.php'); ?>
	</head> 
	<body>
		<div data-role="page">
			<div data-role="header" data-theme="<?php echo $themeNormal; ?>">
				<h4>M2L-GRR</h4>
				<a href="index.php?action=Menu">Retour menu</a>
			</div>
			<div data-role="content">
				<h4 style="text-align: center; margin-top: 10px; margin-bottom: 10px;">Supprimer un compte utilisateur</h4>
				<form action="index.php?action=SupprimerUtilisateur" method="post">
					<div data-role="fieldcontain" class="ui-hide-label">
						<label for="name">Utilisateur :</label>
						<input type="text" name="name" id="name" placeholder="Entrez le nom de l'utilisateur" value="<?php echo $name; ?>">
					</div>
					<div data-role="fieldcontain">
						<input type="submit" name="btnSupprimerUtilisateur" id="btnSupprimerUtilisateur" value="Supprimer l'utilisateur">
					</div>
				</form>

				<?php if($debug == true) {
					// en mise au point, on peut afficher certaines variables dans la page
					echo "<p>name = " . $name . "</p>";
				} ?>
				
			</div>
			<div data-role="footer" data-position="fixed" data-theme="<?php echo $themeFooter; ?>">
				<h4><?php echo $msgFooter; ?></h4>
			</div>
		</div>
	</body>
</html>