<?php
include("config.php");

session_start();

$addr = $_GET["adresse"];
$date = $_GET["date"];

$answer = $db->query("SELECT 
						Commande_produits.produit_ref, Commande_produits.qte 
					  FROM Commande 
					  LEFT JOIN Commande_produits ON Commande_produits.commande_id=Commande.id
					  WHERE Commande.valide=0 AND Commande.membre_id=".intval($_SESSION["id"]));
while($data = $answer->fetch() ){
	$query = $db->prepare("UPDATE Produit SET qte_stock=qte_stock-:qte WHERE ref = :ref");
	$query->execute(array(
		"ref" => $data['produit_ref'],
		"qte" => $data["qte"]
	));
}

$query = $db->prepare("UPDATE Commande SET valide=1, date_livraison=:date_livraison, addr_livraison=:addr, date_commande=NOW() WHERE Commande.valide=0 AND Commande.membre_id=".intval($_SESSION["id"]));
$query->execute(array(
	"addr" => $addr,
	"date_livraison" => $date
));

header("Location: /commandes.php");