<?php
session_start();?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>Commerce</title>

    <!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap-theme.min.css">
</head>
<body>

<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/">Site de commerce</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li><a href="/">Accueil</a></li>
      </ul>

	  <?php
	  if(isset($_SESSION["id"])):?>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="/admin.php">Administration</a></li>
        <li><a href="/panier.php">Mon panier</a></li>
        <li><a href="/commandes.php">Mes commandes</a></li>
        <li><a href="/logout.php">Se déconnecter</a></li>
      </ul>
    <?php
    else:?>
      <ul class="nav navbar-nav navbar-right">
        <li><a href="/login.php">Se connecter</a></li>
        <li><a href="/register.php">S'inscrire</a></li>
      </ul>
    <?php
    endif;?>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<div class="row">
	<div class="col-lg-10 col-lg-offset-1">