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

		<?php
		
			echo "<p>Witaj ".$_SESSION['user'].'! [<a href ="logout.php">Wyloguj się</a>]</p>';			
		?>
	
	
	<div id = "container_top">
	
			<div class = subcontainer_top_1>
						<div id = menu>
				<form action="baza.php" method="post">
	
					<div class="option"><input type="submit" name="input" value="Skanery Medit" /></div>
					<div class="option"><input type="submit" name="input" value="Klucze Exocad" /></div>
					<div class="option"><input type="submit" name="input" value="Skanery Sirona" /></div>
	
				</form>
				<div style="clear:both;"></div>
			</div>
	</div>	
	
	
		<div id = subcontainer_top_2>
		<img src="scan_lab_logo_white-medium.png" />
	</div>
	
	</div>

	
	<div class = container_mid>
		<p> 
		<div id = subcontainer_mid_1>
		<form action="addnewform.php" method="post">
		Dodaj nową pozycję :
					<select name="input">
						<option value=" ">...</option>
						<option value="meditlab">Medit lab.</option>
						<option value="sironaintraoral">Sirona Cerec</option>
						<option value="trios">3Shape TRIOS</option>
					</select>
					<input type="submit" name="addinput" value="Dodaj" />
					</form>
				<div style="clear:both;"></div>
		</div>
		</p>
		<div id = subcontainer_mid_2>
					
			<form action="baza.php" method="post">
				<p>
					<div class = search>Wyszukiwanie</div>
				</p>
				<p>
					Wybierz pozycję:
					<select name="input">
						<option value=" ">...</option>
						<option value="producent">producent</option>
						<option value="model">model</option>
						<option value="nrseryjny">nr seryjny</option>
						<option value="typ">typ</option>
						<option value="klient">klient</option>
					</select>
				</p>
				Wprowadź szukaną frazę: <input type="text" name="szukaj" />
				<div id = search>
					<input type="submit" value="Szukaj" />
				</div>
			</form>
		</div>
		<div style="clear:both"></div>
	</div>
	
	<div id = container3>
		<img src="robot_front.png" />
	</div>
	
	
	
</body>
</html>




		

	
	
