<?php
include("config.php");

if(isset($_POST["name"])){
	$name = $_POST["name"];
	$email = $_POST["email"];
	$password = sha1($_POST["pwd"]);
	$addr = $_POST["addr"];
	$tel = $_POST["tel"];

	$query = $db->prepare("INSERT INTO Membre(nom, addr_postale, email, telephone, password) VALUES(?,?,?,?,?)");
	if($query->execute(array(
		$name, $addr, $email, $tel, $password
	)))
		header("Location: /");
	else
		echo "Erreur avec votre compte, l'e-mail existe déjà.";
}
else{
	include("template/header.php");
?>

<form action="" method="post" role="form">
	<div class="form-group">
		<label for="name">Nom : </label>
		<input type="text" class="form-control" name="name" />
	</div>

	<div class="form-group">
		<label for="email">E-mail : </label>
		<input type="email" class="form-control" name="email" />
	</div>

	<div class="form-group">
		<label for="pwd">Password : </label>
		<input type="password" class="form-control" name="pwd" />
	</div>

	<div class="form-group">
		<label for="addr">Adresse postale : </label>
		<input type="text" class="form-control" name="addr" />
	</div>

	<div class="form-group">
		<label for="tel">Téléphone : </label>
		<input type="text" class="form-control" name="tel" />
	</div>

	<button type="submit" class="btn btn-default">S'inscrire</button>
</form>

<?php
	include("template/footer.php");
}