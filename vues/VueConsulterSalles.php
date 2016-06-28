<?php
	// Projet Réservations M2L - version web mobile
	// fichier : vues/VueConsulterSalles.php
	// Rôle : visualiser la liste des salles
	// cette vue est appelée par le contôleur controleurs/CtrlConsulterSalles.php
	// Création : 28/6/2016 par JM CARTRON
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
				<a href="index.php?action=Menu" data-transition="<?php echo $transition; ?>">Retour menu</a>
			</div>
			<div data-role="content">
				<h4 style="text-align: center; margin-top: 0px; margin-bottom: 25px;"><?php echo $message; ?></h4>
				<ul data-role="listview">
				<?php
				// Avec jQuery Mobile, les salles sont affichées à l'aide d'une liste <ul>
				// chaque salle est affichée à l'aide d'un élément de liste <li>
				// chaque élément de liste <li> peut contenir des titres et des paragraphes

				foreach ($lesSalles as $uneSalle)
				{ ?>
					<li><a href="#">
					<h5>Salle : <?php echo $uneSalle->getRoom_name(); ?></h5>
					<p>Domaine : <?php echo $uneSalle->getAreaName(); ?></p>

					<!-- la classe "ui-li-aside" de jQuery Mobile permet de positionner un élément à droite -->
					<p class="ui-li-aside"><?php echo $uneSalle->getCapacity() . " places"; ?></p>
					</a></li>
				<?php
				} ?>
				</ul>

			</div>
			<div data-role="footer" data-position="fixed" data-theme="<?php echo $themeNormal;?>">
				<h4>Suivi des réservations de salles<br>Maison des ligues de Lorraine (M2L)</h4>
			</div>
		</div>
		
	</body>
</html>