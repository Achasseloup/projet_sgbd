<?php
include("config.php");

include("template/header.php");
?>

<h1>Mes commandes</h1>

<?php
$answer = $db->query("SELECT 
							(SELECT SUM(Commande_produits.qte*Produit.prix) FROM Commande_produits LEFT JOIN Produit ON Produit.ref = Commande_produits.produit_ref WHERE Commande_produits.commande_id=c1.id) AS prix_total, 
							Produit.*, c1.*, Commande_produits.qte 
						FROM Commande c1
						LEFT JOIN Commande_produits ON Commande_produits.commande_id=c1.id
						LEFT JOIN Produit ON Produit.ref = Commande_produits.produit_ref
						WHERE c1.valide=1 AND c1.membre_id=".intval($_SESSION["id"])."
						ORDER BY c1.id DESC");
$currentCommande=-1;
while($data = $answer->fetch() ):
	if($currentCommande!=$data["id"] && $currentCommande!=-1):
?>
			</table>
		</div>
	</div>
<?php
	endif;

	if($currentCommande!=$data["id"]):
?>
	<div class="row">
		<div class="col-lg-12">
			<h3>Commande #<?=$data["id"]?></h3>
			<p>
				<ul>
					<li>Montant total (TTC) : <?=$data["prix_total"]?>&euro;</li>
					<li>Date de livraison : <?=$data["date_livraison"]?></li>
					<li>Adresse de livraison : <?=$data["addr_livraison"]?></li>
				</ul>
			</p>
			<table class="table">
			<tr>
				<th>Référence</th>
				<th>Désignation</th>
				<th>Quantité</th>
				<th>Prix unitaire TTC</th>
				<th>Prix Total TTC</th>
			</tr>
<?php
		$currentCommande = $data["id"];
	endif;
?>
			<tr>
				<td><a href="display_produit.php?ref=<?=$data["ref"]?>"><?=$data["ref"]?></a></td>
				<td><?=$data["designation"]?></td>
				<td><?=$data["qte"]?></td>
				<td><?=$data["prix"]?>&euro;</td>
				<td><?=$data["prix"]*$data["qte"]?>&euro;</td>
			</tr>
<?php
endwhile;
?>


<?php
include("template/footer.php");