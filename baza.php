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

<style type"text"/css>
table 
{
	margin: 8px;
}

td 
{
font-family: Arial, Helvetica, sans-serif;
font-size: 1em;
border: 1px solid #ffffff;
padding: 2px 6px;
}

th {
font-family: Arial, Helvetica, sans-serif;
font-size: .7em;
background: #70bf9a;
color: #FFF;
padding: 2px 6px;
border-collapse: separate;
border: 1px solid #000;
}
</style>





<table>
		<?php
		
			require_once "connect.php";

			echo "<p>Witaj ".$_SESSION['user'].'! [<a href ="logout.php">Wyloguj się</a>]'.' [<a href = "dbinterface.php">Wróć</a>] </p>'; //p - akapit	
			echo "<p><b>Emial</b>: ".$_SESSION['email']."</p>";

			$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);	//otwarcie połączenia z bazą danych i utworzenie obiektu reprezentującego to połączenie - 'mysqli' to konstruktor -'@' wycisza raportowanie błędów
	
			if ($polaczenie->connect_errno!=0) //jeśli połączenie się spełni, to nie będzie kodu błędu, czyli mamy wartość '0' i nie wchodzimy do pętli
			{
				echo "Error: ".$polaczenie->connect_errno . " Opis: ".$polaczenie->connect_error;
			}
			else // w przeciwnym razie wszystko się udało i sprawdzamy dane wyjściowe wprowadzone metodą 'POST'
			{

			//Tutaj obsługiwane są przyciski z dbinterface
			if(isset($_POST['input']) && ($_POST['input']=='Skanery Medit')){
				$sql = 'SELECT s.producent, s.model, s.nrseryjny, s.typ, s.moduly, s.uwagi, k.firma, z.status FROM skanery as s, zamowienia as z, klienci as k WHERE s.idprzedmiotu = z.idprzedmiotu AND k.idklienta = z.idklienta AND s.producent = "Medit"  ';
			}elseif(isset($_POST['input']) && ($_POST['input']=='Klucze Exocad')){
				$sql = 'SELECT s.producent, s.model, s.nrseryjny, s.typ, s.moduly, s.uwagi, k.firma, z.status FROM skanery as s, zamowienia as z, klienci as k WHERE s.idprzedmiotu = z.idprzedmiotu AND k.idklienta = z.idklienta AND s.producent = "Exocad"  ';
			}elseif(isset($_POST['input']) && ($_POST['input']=='Skanery Sirona')){
				$sql = 'SELECT s.producent, s.model, s.nrseryjny, s.typ, s.moduly, s.uwagi, k.firma, z.status FROM skanery as s, zamowienia as z, klienci as k WHERE s.idprzedmiotu = z.idprzedmiotu AND k.idklienta = z.idklienta AND s.producent = "Sirona"  ';
			}elseif(isset($_POST['input']) && ($_POST['input']=='klient')){
				$szukaj = $_POST['szukaj'];
				$sql = sprintf('SELECT s.producent, s.model, s.nrseryjny, s.typ, s.moduly, s.uwagi, k.firma, z.status FROM skanery as s, zamowienia as z, klienci as k WHERE s.idprzedmiotu = z.idprzedmiotu AND k.idklienta = z.idklienta AND (k.nazwisko = "%s" OR k.firma="%s" )', $szukaj, $szukaj);
			}
			elseif(isset($_POST['input']) && isset($_POST))
			{
				
				$input = $_POST['input'];
				$szukaj = $_POST['szukaj'];
				$sql = sprintf('SELECT s.producent, s.model, s.nrseryjny, s.typ, s.moduly, s.uwagi, k.firma, z.status FROM skanery as s, zamowienia as z, klienci as k WHERE s.idprzedmiotu = z.idprzedmiotu AND k.idklienta = z.idklienta AND s.%s = "%s" ', $input, $szukaj);
				echo $sql;
			}
			
			if(isset($sql)){
			$rezultat = @$polaczenie->query($sql);
			$ilepozycji = 0;
			while($wiersz = $rezultat->fetch_array(MYSQLI_ASSOC))
			{
				$ilepozycji = $ilepozycji + 1;
				$wiersze[] = $wiersz;
			}
			
			echo "Ilość zwróconych pozycji: ".$ilepozycji;	
			
			$x = 0;
			$class = ($x%2 == 0) ? 'whiteBackground' : 'graybackground';
			
			echo "<th>";
			echo " <td> "."producent"."</td>";
			echo " <td> "."model"."</td>";
			echo " <td> "."nrseryjny"."</td>";
			echo " <td> "."typ"."</td>";
			echo " <td> "."status"."</td>";
			echo " <td> "."firma"."</td>";
			echo " <td> "."moduly"."</td>";
			echo " <td> "."uwagi"."</td>";
			echo "</th>";
			
			foreach($wiersze as $wiersz)
			{
				$x++;
				
				echo "<p>";	
				echo "<tr class = '$class'>"." <td> ".$x."</td>";
				echo " <td> ".$wiersz['producent']."</td>";
				echo " <td> ".$wiersz['model']."</td>";
				echo " <td> ".$wiersz['nrseryjny']."</td>";
				echo " <td> ".$wiersz['typ']."</td>";
				echo " <td> ".$wiersz['status']."</td>";
				echo " <td> ".$wiersz['firma']."</td>";
				echo " <td> ".$wiersz['moduly']."</td>";
				echo " <td> ".$wiersz['uwagi']."</td>"."</p>";
				echo '</tr>';
			}
			unset($_SESSION['blad']); //błąd nie będzie już nam potrzebny, więc zwalniamy pamięć
			$rezultat->free_result();	//czyścimy rezultaty zapytania zapisane w zmiennej 'rezultat'
			}else{
				echo 'Błąd! Wprowadzono nieprawidłowe dane!';
			}
			
			}
			
			$polaczenie->close();
		?>
</table>

</body>
</html>