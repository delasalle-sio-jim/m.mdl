<?php
	// Projet Réservations M2L - version web mobile
	// Fonction de la vue VueConfirmerReservation.php : visualiser la demande de confirmation d'une réservation provisoire
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
				<h4 style="text-align: center; margin-top: 10px; margin-bottom: 10px;">Confirmer une réservation</h4>
				<form action="index.php?action=ConfirmerReservation" method="post">
					<div data-role="fieldcontain" class="ui-hide-label">
						<label for="numReservation">N° de réservation :</label>
						<input type="number" name="numReservation" id="numReservation" placeholder="Entrez le numéro de réservation" value="<?php echo $numReservation; ?>">
					</div>
					<div data-role="fieldcontain">
						<input type="submit" name="btnConfirmerReservation" id="btnConfirmerReservation" value="Confirmer la réservation">
					</div>
				</form>

				<?php if($debug == true) {
					// en mise au point, on peut afficher certaines variables dans la page
					echo "<p>numReservation = " . $numReservation . "</p>";
				} ?>
				
			</div>
			<div data-role="footer" data-position="fixed" data-theme="<?php echo $themeFooter; ?>">
				<h4><?php echo $msgFooter; ?></h4>
			</div>
		</div>
	</body>
</html>