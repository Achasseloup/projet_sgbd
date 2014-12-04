<?php
include("config.php");

include("template/header.php");
?>

<?php
$query = $db->prepare("SELECT
							p1.*, Catalogue.nom as catnom,
							(SELECT SUM(Commande_produits.qte*Produit.prix) FROM Commande_produits LEFT JOIN Produit ON Produit.ref = Commande_produits.produit_ref WHERE Commande_produits.produit_ref=p1.ref) AS ca_total
					   FROM Produit p1
					   LEFT JOIN Catalogue ON Catalogue.id = p1.id_catalogue
					   WHERE ref=:reference");
$query->execute(array(
	"reference" => $_GET["ref"]
));

$data = $query->fetch();
?>
<div class="jumbotron">
  <div class="container">
	  <h1><?=$data["designation"]?></h1>
	  <p>
		<ul>
			<li>Reference : <?=$data["ref"]?></li>
			<li>Quantité en stock : <?=$data["qte_stock"]?></li>
			<li>Prix : <?=$data["prix"]?>&euro;</li>
			<li>Catalogue : <a href="/display_catalogue.php?id=<?=$data["id_catalogue"]?>"><?=$data["catnom"]?></a></li>
			<li>CA pour ce produit : <?=$data["ca_total"]?>&euro;</li>
		</ul>

		<?=$data["description"]?>
	  </p>
	  <?php
	  if(isset($_SESSION["id"])):?>
	  	<p><a class="btn btn-primary btn-lg" href="#" role="button" onclick="buy()">Acheter</a></p>
	  <?php
	  else:?>
	  	<p>Pour acheter, vous devez :</p>
	  	<p><a class="btn btn-primary btn-lg" href="/login.php" role="button">vous connecter</a></p>
		<p><a class="btn btn-primary btn-lg" href="/register.php" role="button">vous inscrire</a></p>
	  <?php 
	  endif;?>
  </div>
</div>

<script type="text/javascript">
var buy = function(){
	var qte = prompt("Quantité souhaitée ?", 1);
	window.location.href = "/acheter_produit.php?ref=<?=$_GET["ref"]?>&qte="+qte;
}
</script>

<?php
include("template/footer.php");