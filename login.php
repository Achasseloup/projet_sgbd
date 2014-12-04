<?php
include("config.php");

if(isset($_POST["email"])){
	session_start();
	
	$email = $_POST["email"];
	$password = sha1($_POST["pwd"]);

	$query = $db->prepare("SELECT COUNT(*) AS nb, id
						   FROM Membre
						   WHERE email=? AND password=?
						   LIMIT 1");
	$query->execute(array(
		$email, $password
	));
	$data = $query->fetch();
	if($data["nb"]==1){
		$_SESSION["email"] = $email;
		$_SESSION["id"] = $data["id"];

		header("Location: /");
	}
	else
		echo "Erreur e-mail ou mot de passe inconnu.";
}
else{
	include("template/header.php");
?>

<form action="" method="post" role="form">
	<div class="form-group">
		<label for="email">E-mail : </label>
		<input type="email" class="form-control" name="email" />
	</div>

	<div class="form-group">
		<label for="pwd">Password : </label>
		<input type="password" class="form-control" name="pwd" />
	</div>

	<button type="submit" class="btn btn-default">Se connecter</button>
</form>

<?php
	include("template/footer.php");
}