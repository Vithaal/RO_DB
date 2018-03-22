<?php

	session_start();

	if (!isset($_SESSION['zalogowany'])) //ta instrukcja warunkowa odsyła usera do strony logowania jeśli próbuje się dostać na stronę 'gra.php' nie będąc zalogowanym
	{
		header('Location: index.php');
		exit();
	}
	
?>



<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Baza RO</title>
	
	<link rel="stylesheet" href = "style.css" type="text/css"/>
	
</head>

<body>



	
	<div id="header"> Formularz skanerów wewnątrzustnych Sirona </div>
	
	<div id="container_form_left">
	

	</div>
	
	<div id="container_form_right">
	
	</div>
	
	
</body>
</html>		