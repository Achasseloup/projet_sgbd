<?php
include("config.php");

session_start();

$userid = $_SESSION["id"];
$ref = $_GET["ref"];
$qte = intval($_GET["qte"]);

$query = $db->prepare("SELECT COUNT(*) AS nb, id 
					   FROM Commande 
					   WHERE membre_id=:id AND valide=0");
$query->execute(array(
	"id" => $userid
));

$data = $query->fetch();

if($data["nb"]==0){
	$query = $db->prepare("INSERT INTO Commande(valide, membre_id) VALUES(?,?)");
	$query->execute(array(
		0, $userid
	));
	$commandeid = $db->lastInsertId();
}
else{
	$commandeid = $data["id"];
}

$query = $db->prepare("INSERT INTO Commande_produits(commande_id, produit_ref, qte) VALUES(?,?,?) ON DUPLICATE KEY UPDATE qte = ?");
$query->execute(array(
	$commandeid, $ref, $qte, $qte
));

header("Location: /panier.php");