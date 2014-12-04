<?php
include("config.php");

include("template/header.php");
?>

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
		$answer = $db->query("SELECT * FROM Produit WHERE qte_stock > 0");
		while($data = $answer->fetch() ){
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