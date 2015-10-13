<?php
	// Projet Réservations M2L - version web mobile
	// Fonction de la vue VueConsulterReservations.php : visualiser la liste des réservations à venir d'un utilisateur
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
				<h4 style="text-align: center; margin-top: 0px; margin-bottom: 0px;">Consulter mes réservations</h4>
				
				<ul data-role="listview" style="margin-top: 5px;">
				<?php
				// Avec JQuery Mobile, les réservations sont affichées à l'aide d'une liste <ul>
				// chaque réservation est affichée à l'aide d'un élément de liste <li>
				// chaque élément de liste <li> peut contenir des titres et des paragraphes

				foreach ($lesReservations as $uneReservation)
				{ ?>
					<li><a href="#">
					<h5>Réserv. n° <?php echo $uneReservation->getId(); ?></h5>
					<p>Passée le <?php echo Outils::convertirEnDateFR(substr($uneReservation->getTimestamp(), 0, 10)); ?></p>
					<p>Début : <?php echo date('d/m/Y H:i:s', $uneReservation->getStart_time()); ?></p>
					<p>Fin : <?php echo date('d/m/Y H:i:s', $uneReservation->getEnd_time()); ?></p>
					<p>Salle : <?php echo $uneReservation->getRoom_name(); ?></p>
					<p>Etat : <?php if ($uneReservation->getStatus() == 0) 
										echo 'confirmée';
					 				else 
					 					echo 'provisoire';?></p>
					<?php if ($uneReservation->getStatus() == 0) 
							// la classe "ui-li-aside" de JQuery Mobile permet de positionner un élément à droite
							echo '<h5 class="ui-li-aside">Digicode ' . $uneReservation->getDigicode() . '</h5>';?>
					</a></li>
				<?php
				} ?>
				</ul>

			</div>
			<div data-role="footer" data-position="fixed" data-theme="<?php echo $themeFooter;?>">
				<h4><?php echo $msgFooter;?></h4>
			</div>
		</div>

	</body>
</html>