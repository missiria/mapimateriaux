<?php

	require_once"../inc/settings.php";
	
		// INSERT THE DATE COMMANDE
		if(isset($_POST['date_commande'])) {
			$date_commande = $_POST['date_commande'];
			$q = "INSERT INTO commandes (date_commande) VALUE (:date_commande)";
			$query = $odb->prepare($q);
			$results_date_commande = $query->execute(array(
				":date_commande" => $date_commande			
			));
		}
		// Table of clients
		$query_client = "SELECT * FROM clients";
		$results_clients = $odb->query($query_client);
		
		// Table of produits
		$query_produits = "SELECT * FROM produits";
		$results_produits = $odb->query($query_produits);
		
		// INSERT QT (Quantité)
		if(isset($_POST['qt_commande'])) {
			$qt_commande = $_POST['qt_commande'];
			$q = "INSERT INTO detail_commande (qt_commande) VALUE (:qt_commande)";
			$query = $odb->prepare($q);
			$results_qt_commande = $query->execute(array(
				":qt_commande" => $qt_commande			
			));
		}
		
		// INSERT PRICE (prix_unitaire)
		if(isset($_POST['prix_unitaire'])) {
			$prix_unitaire = $_POST['prix_unitaire'];
			$q = "INSERT INTO detail_commande (prix_unitaire) VALUE (:prix_unitaire)";
			$query = $odb->prepare($q);
			$results_qt_commande = $query->execute(array(
				":prix_unitaire" => $prix_unitaire			
			));
		}

?>