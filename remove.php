<?php
include("config.php");

session_start();

if($_GET["type"]=="client"){
	$query = $db->prepare("UPDATE Commande SET membre_id=NULL WHERE membre_id = ?");
	$query->execute(array(
		$_GET["id"]
	));

	$query = $db->prepare("DELETE FROM Membre WHERE id = ? LIMIT 1");
	$query->execute(array(
		$_GET["id"]
	));
	
	header("Location: /admin_data.php");
}
else if($_GET["type"]=="catalogue"){
	$query = $db->prepare("SELECT COUNT(*) AS nb FROM Produit WHERE catalogue_id = ?");
	$query->execute(array(
		$_GET["id"]
	));
	$data = $query->fetch();

	if($data["nb"]==0){
		$query = $db->prepare("DELETE FROM Catalogue WHERE id = ? LIMIT 1");
		$query->execute(array(
			$_GET["id"]
		));

		header("Location: /admin_data.php");
	}
	else{
		echo "Erreur : ce catalogue contient encore des produits.";
	}
}