<?php
// Projet Réservations M2L - version web mobile
// fichier : modele/Salle.class.php
// Rôle : la classe Salle représente les salles pouvant faire l'objet d'une réservation
// Création : 5/11/2015 par JM CARTRON
// Mise à jour : 24/5/2016 par JM CARTRON

class Salle
{
	// ------------------------------------------------------------------------------------------------------
	// ---------------------------------- Membres privés de la classe ---------------------------------------
	// ------------------------------------------------------------------------------------------------------
	
	private $id;				// identifiant de la salle (numéro automatique dans la BDD)
	private $room_name;			// nom de la salle
	private $capacity;			// capacité de la salle
	private $area_name;			// nom du domaine de la salle
	private $area_admin_email;	// adresse mail de l'administrateur du domaine

	// ------------------------------------------------------------------------------------------------------
	// ----------------------------------------- Constructeur -----------------------------------------------
	// ------------------------------------------------------------------------------------------------------
	
	public function Salle($unId, $unRoomName, $unCapacity, $unAreaName, $unAeraAdminEmail) {
		$this->id = $unId;
		$this->room_name = $unRoomName;
		$this->capacity = $unCapacity;
		$this->area_name = $unAreaName;
		$this->area_admin_email = $unAeraAdminEmail;
	}

	// ------------------------------------------------------------------------------------------------------
	// ---------------------------------------- Getters et Setters ------------------------------------------
	// ------------------------------------------------------------------------------------------------------
	
	public function getId()	{return $this->id;}
	public function setId($unId) {$this->id = $unId;}
	
	public function getRoom_name()	{return $this->room_name;}
	public function setRoom_name($unRoom_name) {$this->room_name = $unRoom_name;}
	
	public function getCapacity()	{return $this->capacity;}
	public function setCapacity($unCapacity) {$this->capacity = $unCapacity;}
		
	public function getAreaName()	{return $this->area_name;}
	public function setAreaName($unAreaName) {$this->area_name = $unAreaName;}

	public function getAreaAdminEmail()	{return $this->area_admin_email;}
	public function setAreaAdminEmail($unAreaAdminEmail) {$this->area_admin_email = $unAreaAdminEmail;}

	// ------------------------------------------------------------------------------------------------------
	// ---------------------------------------- Méthodes d'instances ----------------------------------------
	// ------------------------------------------------------------------------------------------------------
	
	public function toString() {
		$msg = "Salle : <br>";
		$msg .= "id : " . $this->id . "<br>";
		$msg .= "room_name : " . $this->room_name . "<br>";
		$msg .= "capacity : " . $this->capacity . "<br>";
		$msg .= "area_name : " . $this->area_name . "<br>";
		$msg .= "area_admin_email : " . $this->area_admin_email . "<br>";
		return $msg;
	}
	
} // fin de la classe Salle

// ATTENTION : on ne met pas de balise de fin de script pour ne pas prendre le risque
// d'enregistrer d'espaces après la balise de fin de script !!!!!!!!!!!!