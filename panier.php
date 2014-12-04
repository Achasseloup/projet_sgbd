<?php
include("config.php");

include("template/header.php");
?>

<h1>Mon panier</h1>

<div class="row">
	<div class="col-lg-12">
		<table class="table">
		<tr>
			<th>Référence</th>
			<th>Désignation</th>
			<th>Quantité</th>
			<th>Prix unitaire TTC</th>
			<th>Prix Total TTC</th>
		</tr>
		<?php
		$answer = $db->query("SELECT Produit.*, Commande_produits.qte 
							  FROM Commande 
							  LEFT JOIN Commande_produits ON Commande_produits.commande_id=Commande.id
							  LEFT JOIN Produit ON Produit.ref = Commande_produits.produit_ref
							  WHERE Commande.valide=0 AND Commande.membre_id=".intval($_SESSION["id"]));
		$product_number=0;
		while($data = $answer->fetch() ){
		?>
			<tr>
				<td><a href="display_produit.php?ref=<?=$data["ref"]?>"><?=$data["ref"]?></a></td>
				<td><?=$data["designation"]?></td>
				<td><?=$data["qte"]?></td>
				<td><?=$data["prix"]?>&euro;</td>
				<td><?=$data["prix"]*$data["qte"]?>&euro;</td>
			</tr>
		<?php
			$product_number++;
		}
		?>
		</table>
		<?php
		if($product_number>0):?>
			<p><a class="btn btn-primary btn-lg" href="#" role="button" onclick="buy()">Valider ma commande</a></p>
		<?php
		else:?>
			Vous n'avez aucun produit dans votre panier...
		<?php
		endif;?>
	</div>
</div>

<script type="text/javascript">
var buy = function(){
	var date_livraison = prompt("Date de livraison ? (YYYY-MM-DD)", "2014-12-25");
	var adresse_livraison = prompt("Adresse de livraison ?", "1 avenue du Docteur Schweitzer 33400 Talence");
	alert("Le paiement a été effectué !");
	window.location.href = "/validate_panier.php?date="+date_livraison+"&adresse="+adresse_livraison;
}
</script>

<?php
include("template/footer.php");