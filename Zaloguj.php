<?php

	session_start(); // Otwiera sesję (DOMYŚLNIE TRWA OK. 24 MIN) - nie trzeba jej zamykać. Każdy dokument posiadający tę instrukcję będzie mógł korzystać z sesji.

	if((!isset($_POST['login'])) || (!isset($_POST['haslo'])))  
	{
		header('Location: index.php');
		exit();
	}
	
	require_once "connect.php";	//wczytuje namiary na bazę
	
	$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name);	//otwarcie połączenia z bazą danych i utworzenie obiektu reprezentującego to połączenie - 'mysqli' to konstruktor -'@' wycisza raportowanie błędów
	
	if ($polaczenie->connect_errno!=0) //jeśli połączenie się spełni, to nie będzie kodu błędu, czyli mamy wartość '0' i nie wchodzimy do pętli
	{
		echo "Error: ".$polaczenie->connect_errno . " Opis: ".$polaczenie->connect_error;
	}
	else // w przeciwnym razie wszystko się udało i sprawdzamy dane wyjściowe wprowadzone metodą 'POST'
	{
			$login = $_POST['login'];
			$haslo = $_POST['haslo'];
			
			$login = htmlentities($login, ENT_QUOTES, "UTF-8");	//Tu mamy SANITYZACJĘ kodu. Czyli zamianę ewentualnych znaków wchodzących w skład komend na encje (czyli np. zamiana  '  na   &#039 )
			$haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8");
			
			// - Poniżej wywołujemy metodę sql'a o nazwie 'query' (czyli zapytanie) na rzecz obiektu 'połączenie'. Argumentem jest zapytanie do BD. W przeciwnym razie 'false'.
			// - sprintf zastosowano w celu zepewnienia większej czytelności kodu
			// - mysqli_real_escape_string jest wbudowaną w php metodą zabezpieczającą przed wstrzykiwaniem SQL'a
			if($rezultat = @$polaczenie->query(
			sprintf("SELECT * FROM uzytkownicy WHERE user = '%s' AND pass = '%s'", 
			mysqli_real_escape_string($polaczenie, $login),
			mysqli_real_escape_string($polaczenie,$haslo)))) 
			{
				$ilu_userow = $rezultat->num_rows;
				if($ilu_userow>0)									//jest ok. Dostaliśmy wiersz
				{
					
					$_SESSION['zalogowany'] = true;
					$wiersz = $rezultat->fetch_assoc(); // tablica asocjacyjna (nie ma indeksów tylko są nazwy kolumn - asocjacja, czyli skojarzenie), która przechowa wszystkie pobrane z bazy kolumny. 'fetch_assoc' wprowadza 				kolumny o takich samych nazwach jak te z bazy z danego wiersza.
					//$user = $wiersz['user'];  - wyciąga z tablicy 'wiersz' wartość z komórki o nazwie 'user'
					$_SESSION['id'] = $wiersz['id'];
					$_SESSION['user'] = $wiersz['user'];
					$_SESSION['email'] = $wiersz['email'];
					$_SESSION['access'] = $wiersz['access'];
					
					
					unset($_SESSION['blad']); //błąd nie będzie już nam potrzebny, więc zwalniamy pamięć
					$rezultat->free_result();	//czyścimy rezultaty zapytania zapisane w zmiennej 'rezultat'
					header('Location: dbinterface.php'); //przekierowanie do strony z grą
					
					echo $user;
				}
				else													//nie udało się - 0 wierszy
				{
					$_SESSION['blad'] = '<span style = "color:red">Nieprawidłowy login lub hasło! </span>';
					header('Location: index.php');
				}
			}
			
			$polaczenie->close(); //tutaj zamykamy połączenie, bo tylko w 'else' udało nam się połączyć
												//wcześniej nie ma polecenia 'exit' ze względu na fakt zamykania przez nas połączenia
	}


?>