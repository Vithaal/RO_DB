<?php

	session_start();
	
	if((isset($_SESSION['zalogowany'])) && ($_SESSION['zalogowany']==true))
	{
		header('Location: bazaRO.php');
		exit(); 
	}
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<title>Baza danych RO - logowanie</title>
	
	<link rel="stylesheet" href = "style.css" type="text/css"/>
	<link href="https://fonts.googleapis.com/css?family=Lato:400,700&amp;subset=latin-ext" rel="stylesheet"> 
	
</head>

<body>
	
<div id = "start">	
	<h1>Baza danych RO</h1>	
	
	<div id="loging">
	<form action="Zaloguj.php" method="post">
	
		Login: <br /> <input type="text" name="login" /> <br />
		Hasło: <br /> <input type="password" name="haslo" /> <br /><br />
		<input type="submit" value="Zaloguj się" />
	
	</form>
	</div>
</div>
	<?php
	
		if (isset($_SESSION['blad'])) 
			echo $_SESSION['blad'];
		
	?>

</body>
</html>