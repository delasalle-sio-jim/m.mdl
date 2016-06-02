<?php
	// Projet Réservations M2L - version web mobile
	// fichier : vues/VueConfirmerReservation.php
	// Rôle : visualiser la demande de confirmation d'une réservation provisoire
	// cette vue est appelée par le contôleur controleurs/CtrlConfirmerReservation.php
	// Création : 12/10/2015 par JM CARTRON
	// Mise à jour : 2/6/2016 par JM CARTRON
	
	// pour obliger la page à se recharger
	header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
	header('Pragma: no-cache');
	header('Content-Tranfer-Encoding: none');
	header('Expires: 0');
?>
<!doctype html>
<html>
	<head>
		<?php include_once ('vues/head.php'); ?>
		
		<script>
			// associe une fonction à l'événement pageinit
			$(document).bind('pageinit', function() {
				<?php if ($typeMessage != '') { ?>
					// affiche la boîte de dialogue 'affichage_message'
					$.mobile.changePage('#affichage_message', {transition: "<?php echo $transition; ?>"});
				<?php } ?>
			} );
		</script>
	</head>
	
	<body>
		<div data-role="page" id="page_principale">
			<div data-role="header" data-theme="<?php echo $themeNormal; ?>">
				<h4>M2L-GRR</h4>
				<a href="index.php?action=Menu" data-transition="<?php echo $transition; ?>">Retour menu</a>
			</div>
			
			<div data-role="content">
				<h4 style="text-align: center; margin-top: 10px; margin-bottom: 10px;">Confirmer une réservation</h4>
				<form action="index.php?action=ConfirmerReservation" method="post" data-ajax="false">
					<div data-role="fieldcontain" class="ui-hide-label">
						<label for="txtNumReservation">N° de réservation :</label>
						<input type="number" name="txtNumReservation" id="txtNumReservation" required 
							placeholder="Entrez le numéro de réservation" value="<?php echo $numReservation; ?>">
					</div>
					<div data-role="fieldcontain">
						<input type="submit" name="btnConfirmerReservation" id="btnConfirmerReservation" value="Confirmer la réservation" data-mini="true">
					</div>
				</form>

				<?php if($debug == true) {
					// en mise au point, on peut afficher certaines variables dans la page
					echo "<p>numReservation = " . $numReservation . "</p>";
					echo "<p>typeMessage = " . $typeMessage . "</p>";
					echo "<p>message = " . $message . "</p>";
				} ?>
			</div>
			
			<div data-role="footer" data-position="fixed" data-theme="<?php echo $themeNormal; ?>">
				<h4>Suivi des réservations de salles<br>Maison des ligues de Lorraine (M2L)</h4>
			</div>
		</div>
		
		<?php include_once ('vues/dialog_message.php'); ?>
		
	</body>
</html>