<?php
	// Projet Réservations M2L - version web mobile
	// Fonction de la vue VueCreerUtilisateur.php : visualiser la demande de création d'un nouvel utilisateur
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
				<h4 style="text-align: center; margin-top: 0px; margin-bottom: 0px;">Créer un compte utilisateur</h4>
				<form action="index.php?action=CreerUtilisateur" method="post">
					<div data-role="fieldcontain" class="ui-hide-label">
						<label for="name">Utilisateur :</label>
						<input type="text" name="name" id="name" placeholder="Entrez le nom de l'utilisateur" value="<?php echo $name; ?>">
					</div>
					<div data-role="fieldcontain" class="ui-hide-label">
						<label for="email">Mot de passe :</label>
						<input type="email" name="email" id="email" placeholder="Entrez l'adresse mail" value="<?php echo $email; ?>">
					</div>
					<div data-role="fieldcontain">
						<fieldset data-role="controlgroup">
							<legend>Niveau :</legend>
							<input type="radio" name="level" id="invite" value="0" data-mini="true" <?php if ($level == "0") echo 'checked';?> >
							<label for="invite">Invité</label>
							<input type="radio" name="level" id="utilisateur" value="1" data-mini="true" <?php if ($level == "1") echo 'checked';?> >
							<label for="utilisateur">Utilisateur</label>
							<input type="radio" name="level" id="administrateur" value="2" data-mini="true" <?php if ($level == "2") echo 'checked';?> >
							<label for="administrateur">Administrateur</label>
						</fieldset>
					</div>
					<div data-role="fieldcontain">
						<input type="submit" name="btnCrerUtilisateur" id="btnCrerUtilisateur" value="Créer l'utilisateur">
					</div>
				</form>

				<?php if($debug == true) {
					// en mise au point, on peut afficher certaines variables dans la page
					echo "<p>name = " . $name . "</p>";
					echo "<p>email = " . $email . "</p>";
					echo "<p>level = " . $level . "</p>";
				} ?>
				
			</div>
			<div data-role="footer" data-position="fixed" data-theme="<?php echo $themeFooter; ?>">
				<h4><?php echo $msgFooter; ?></h4>
			</div>
		</div>
	</body>
</html>