<?php
include("config.php");

include("template/header.php");
?>

<h1>Administration</h1>

<a href="admin_data.php">Gérer les données</a> / <a href="promo.php">Faire une promotion</a><br />

<h3>Mes clients</h3>
<div class="row">
	<div class="col-lg-12">
		<table class="table">
		<tr>
			<th>Nom</th>
			<th>Addresse</th>
			<th>E-mail</th>
			<th>Téléphone</th>
			<th>Chiffre d'affaire</th>
		</tr>
		<?php
		$answer = $db->query("SELECT 
								Membre.*,
								SUM(Commande_produits.qte*Produit.prix) AS ca_total
							  FROM Membre 
							  LEFT JOIN Commande ON Commande.membre_id = Membre.id
							  LEFT JOIN Commande_produits ON Commande_produits.commande_id=Commande.id
							  LEFT JOIN Produit ON Produit.ref = Commande_produits.produit_ref
							  GROUP BY Membre.nom, Membre.addr_postale, Membre.email, Membre.telephone");
		$product_number=0;
		while($data = $answer->fetch() ){
		?>
			<tr>
				<td><?=$data["nom"]?></td>
				<td><?=$data["addr_postale"]?></td>
				<td><?=$data["email"]?></td>
				<td><?=$data["telephone"]?></td>
				<td><?=$data["ca_total"]?>&euro;</td>
			</tr>
		<?php
			$product_number++;
		}
		?>
		</table>
	</div>
</div>

<h3>Mes 5 clients avec le meilleur CA</h3>
<div class="row">
	<div class="col-lg-12">
		<table class="table">
		<tr>
			<th>Nom</th>
			<th>Addresse</th>
			<th>E-mail</th>
			<th>Téléphone</th>
			<th>Chiffre d'affaire</th>
		</tr>
		<?php
		$answer = $db->query("SELECT 
								Membre.*,
								SUM(Commande_produits.qte*Produit.prix) AS ca_total
							  FROM Membre 
							  LEFT JOIN Commande ON Commande.membre_id = Membre.id
							  LEFT JOIN Commande_produits ON Commande_produits.commande_id=Commande.id
							  LEFT JOIN Produit ON Produit.ref = Commande_produits.produit_ref
							  GROUP BY Membre.nom, Membre.addr_postale, Membre.email, Membre.telephone
							  ORDER BY ca_total DESC
							  LIMIT 5");
		$product_number=0;
		while($data = $answer->fetch() ){
		?>
			<tr>
				<td><?=$data["nom"]?></td>
				<td><?=$data["addr_postale"]?></td>
				<td><?=$data["email"]?></td>
				<td><?=$data["telephone"]?></td>
				<td><?=$data["ca_total"]?>&euro;</td>
			</tr>
		<?php
			$product_number++;
		}
		?>
		</table>
	</div>
</div>

<h3>Les 5 produits donnant le meilleur CA</h3>
<div class="row">
	<div class="col-lg-12">
		<table class="table">
		<tr>
			<th>Référence</th>
			<th>Désignation</th>
			<th>Quantité en stock</th>
			<th>Prix</th>
		</tr>
		<?php
		$query = $db->prepare("SELECT
									p1.*,
									(SELECT SUM(Commande_produits.qte*Produit.prix) FROM Commande_produits LEFT JOIN Produit ON Produit.ref = Commande_produits.produit_ref WHERE Commande_produits.produit_ref=p1.ref) AS ca_total
							   FROM Produit p1
							   LEFT JOIN Commande_produits ON Commande_produits.produit_ref = p1.ref
							   GROUP BY p1.ref, p1.designation, p1.qte_stock, p1.prix
							   ORDER BY ca_total DESC
							   LIMIT 5");
		$query->execute(array(
		));
		while($data = $query->fetch() ){
		?>
			<tr>
				<td><a href="display_produit.php?ref=<?=$data["ref"]?>"><?=$data["ref"]?></a></td>
				<td><?=$data["designation"]?></td>
				<td><?=$data["qte_stock"]?></td>
				<td><?=$data["prix"]?>&euro;</td>
			</tr>
		<?php
		}
		?>
		</table>
	</div>
</div>

<h3>Les 5 produits les plus vendus</h3>
<div class="row">
	<div class="col-lg-12">
		<table class="table">
		<tr>
			<th>Référence</th>
			<th>Désignation</th>
			<th>Quantité en stock</th>
			<th>Prix</th>
		</tr>
		<?php
		$query = $db->prepare("SELECT
									Produit.*
							   FROM Produit
							   RIGHT JOIN Commande_produits ON Commande_produits.produit_ref = Produit.ref
							   GROUP BY Produit.ref, Produit.designation, Produit.qte_stock, Produit.prix
							   ORDER BY SUM(Commande_produits.qte) DESC
							   LIMIT 5");
		$query->execute(array(
		));
		while($data = $query->fetch() ){
		?>
			<tr>
				<td><a href="display_produit.php?ref=<?=$data["ref"]?>"><?=$data["ref"]?></a></td>
				<td><?=$data["designation"]?></td>
				<td><?=$data["qte_stock"]?></td>
				<td><?=$data["prix"]?>&euro;</td>
			</tr>
		<?php
		}
		?>
		</table>
	</div>
</div>


<h3>Les 5 produits les moins vendus</h3>
<div class="row">
	<div class="col-lg-12">
		<table class="table">
		<tr>
			<th>Référence</th>
			<th>Désignation</th>
			<th>Quantité en stock</th>
			<th>Prix</th>
		</tr>
		<?php
		$query = $db->prepare("SELECT
									Produit.*
							   FROM Produit
							   RIGHT JOIN Commande_produits ON Commande_produits.produit_ref = Produit.ref
							   GROUP BY Produit.ref, Produit.designation, Produit.qte_stock, Produit.prix
							   ORDER BY SUM(Commande_produits.qte) ASC
							   LIMIT 5");
		$query->execute(array(
		));
		while($data = $query->fetch() ){
		?>
			<tr>
				<td><a href="display_produit.php?ref=<?=$data["ref"]?>"><?=$data["ref"]?></a></td>
				<td><?=$data["designation"]?></td>
				<td><?=$data["qte_stock"]?></td>
				<td><?=$data["prix"]?>&euro;</td>
			</tr>
		<?php
		}
		?>
		</table>
	</div>
</div>


<?php
include("template/footer.php");