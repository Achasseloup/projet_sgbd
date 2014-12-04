<?php
include("config.php");

if(isset($_POST["name"])){
	$query = $db->prepare("INSERT INTO Membre VALUES(0,?,?,?,?,?)");
	$query->execute(array(
		$_POST["name"], $_POST["adresse"], $_POST["email"], $_POST["phone"], sha1($_POST["password"])
	));

	header("Location: admin_data.php");
}
else if(isset($_POST["ref"])){
	$query = $db->prepare("INSERT INTO Produit VALUES(?,?,?,?,?,?)");
	$query->execute(array(
		$_POST["ref"], $_POST["designation"], $_POST["description"], $_POST["qte"], $_POST["prix"], $_POST["catalogue_id"]
	));

	header("Location: admin_data.php");
}
else if(isset($_POST["nom_catalogue"])){
	$query = $db->prepare("INSERT INTO Catalogue VALUES(0, ?,NOW())");
	$query->execute(array(
		$_POST["nom_catalogue"]
	));

	header("Location: admin_data.php");
}

include("template/header.php");

?>

<div class="row">
	<div class="col-lg-12">
		<h1>Administration des données</h1>

		<h3>Mes clients</h3>
		<div class="row">
			<div class="col-lg-12">
				<table class="table">
				<tr>
					<th>Nom</th>
					<th>Addresse</th>
					<th>E-mail</th>
					<th>Téléphone</th>
					<th>Actions</th>
				</tr>
				<?php
				$answer = $db->query("SELECT 
										Membre.*
									  FROM Membre");
				while($data = $answer->fetch() ){
				?>
					<tr>
						<td><?=$data["nom"]?></td>
						<td><?=$data["addr_postale"]?></td>
						<td><?=$data["email"]?></td>
						<td><?=$data["telephone"]?></td>
						<td><a href="remove.php?type=client&amp;id=<?=$data["id"]?>">Supprimer</a></td>
					</tr>
				<?php
				}
				?>
				</table>
			</div>
		</div>
		<h3>Ajout client</h3>
		<form role="form" action="admin_data.php" method="post">
			<div class="row">
				<div class="col-lg-6">
					<div class="input-group">
					  <span class="input-group-addon">Nom</span>
					  <input type="text" class="form-control" name="name" />
					</div>
				</div>
				<div class="col-lg-6">
					<div class="input-group">
					  <span class="input-group-addon">Mot de passe</span>
					  <input type="password" class="form-control" name="password" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="input-group">
					  <span class="input-group-addon">Téléphone</span>
					  <input type="text" class="form-control" name="phone" />
					</div>
				</div>
				<div class="col-lg-6">
					<div class="input-group">
					  <span class="input-group-addon">E-mail</span>
					  <input type="text" class="form-control" name="email" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="input-group">
					  <span class="input-group-addon">Adresse</span>
					  <input type="text" class="form-control" name="adresse" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<button type="submit" class="btn btn-primary">Créer le client</button>
				</div>
			</div>
		</form>
	</div>
</div>

<hr />
<div class="row">
	<div class="col-lg-12">
		<h3>Ajout produit</h3>
		<form role="form" action="admin_data.php" method="post">
			<div class="row">
				<div class="col-lg-6">
					<div class="input-group">
					  <span class="input-group-addon">Ref</span>
					  <input type="text" class="form-control" name="ref" />
					</div>
				</div>
				<div class="col-lg-6">
					<div class="input-group">
					  <span class="input-group-addon">Designation</span>
					  <input type="text" class="form-control" name="designation" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div class="input-group">
					  <span class="input-group-addon">Prix</span>
					  <input type="text" class="form-control" name="prix" />
					</div>
				</div>
				<div class="col-lg-6">
					<div class="input-group">
					  <span class="input-group-addon">Qté stock</span>
					  <input type="text" class="form-control" name="qte" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="input-group">
					  <span class="input-group-addon">Description</span>
					  <textarea class="form-control" name="description"></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<div class="input-group">
					  <select name="catalogue_id" class="form-control">
					  	  <?php
					  	  $answer = $db->query("SELECT * FROM Catalogue");
						  while($data = $answer->fetch() ):
					  	  ?>
						  	<option value="<?=$data["id"]?>"><?=$data["nom"]?></option>
						  <?php
						  endwhile;
						  ?>
					  </select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<button type="submit" class="btn btn-primary">Créer le produit</button>
				</div>
			</div>
		</form>
	</div>
</div>

<hr />

<div class="row">
	<div class="col-lg-12">
		<h3>Mes catalogues</h3>
		<div class="row">
			<div class="col-lg-12">
				<table class="table">
				<tr>
					<th>Nom</th>
					<th>Date maj</th>
					<th>Actions</th>
				</tr>
				<?php
				$answer = $db->query("SELECT 
										Catalogue.*
									  FROM Catalogue");
				while($data = $answer->fetch() ){
				?>
					<tr>
						<td><?=$data["nom"]?></td>
						<td><?=$data["date_maj"]?></td>
						<td><a href="remove.php?type=catalogue&amp;id=<?=$data["id"]?>">Supprimer</a></td>
					</tr>
				<?php
				}
				?>
				</table>
			</div>
		</div>
		<h3>Ajout catalogue</h3>
		<form role="form" action="admin_data.php" method="post">
			<div class="row">
				<div class="col-lg-6">
					<div class="input-group">
					  <span class="input-group-addon">Nom du catalogue</span>
					  <input type="text" class="form-control" name="nom_catalogue" />
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-12">
					<button type="submit" class="btn btn-primary">Créer le catalogue</button>
				</div>
			</div>
		</form>
	</div>
</div>

<?php
include("template/footer.php");