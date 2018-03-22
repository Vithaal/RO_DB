<?php

	session_start();

	if (!isset($_SESSION['zalogowany'])) //ta instrukcja warunkowa odsyła usera do strony logowania jeśli próbuje się dostać na stronę 'gra.php' nie będąc zalogowanym
	{
		header('Location: index.php');
		exit();
	}
	
	
	//Udana walidacja - jak, któryś z testów nie przejdzie zmiania się na 'false'
		$all_ok=true;
		$error_msg="";
	//Czy jedno z pól (tutaj nrseryjny) zostało wypełnione
	
	if (isset($_POST['nrseryjny']))
	{
		
		//Sprawdź czy nr seryjny istnieje
		$serialno = $_POST['nrseryjny'];
		
		//Sprawdzenie długości nicka
		if(strlen($serialno)!=12)
		{
			$all_ok=false;
			$_SESSION['e_serial']="Nr seryjny musi składać się z 12 znaków!";
			$error_msg = $_SESSION['e_serial'];
		}
		
		if (preg_match('/[A-Za-z].*[0-9]|[0-9].*[A-Za-z]/', $serialno)==false)
		{
			$all_ok=false;
			$_SESSION['e_serial']="Nr seryjny może zawierać wyłącznie znaki alfanumeryczne!";
			$error_msg = $_SESSION['e_serial'];
		}
		
		require_once "connect.php"; //Połączenie z bazą danych! <=======================================
		//Sprawdzanie, czy połączenie się udało
		
		mysqli_report(MYSQLI_REPORT_STRICT); //Kasuje niepotrzebne powiadomienia o błędach
		
		try
		{
			$polaczenie = new mysqli($host, $db_user, $db_password, $db_name);
				if ($polaczenie->connect_errno!=0) //jeśli połączenie się spełni, to nie będzie kodu błędu, czyli mamy wartość '0' i nie wchodzimy do pętli
				{
				throw new Exception(mysqli_connect_errno());
				}
				else
				{
					//Czy skaner o podanym nr seryjnym już istnieje?
					$rezultat = $polaczenie->query("SELECT * FROM skanery WHERE nrseryjny='$serialno'");
					
					if(!$rezultat) throw new Exception($polaczenie->error);
					//Jeżeli powyższe zapytanie się powiedzie, to znaczy, że taki skaner już istnieje w bazie
					//Jeśli taka pozycja już istnieje, to ilość nrseryjnych o tej wartości będzie >0, więc:
					$ile_takich_skanerow = $rezultat->num_rows;
					if($ile_takich_skanerow>0)
					{
						$all_ok=false;
						$_SESSION['e_serial']="Skaner o podanym nr seryjnym już istnieje w bazie!";
					}
					
					$polaczenie->close();
				}
		}
		catch(Exception $e)
		{
			echo '<span style="color:red;">Błąd serwera! Przepraszamy za niedogodności.</span>';
			echo '<br /> Informacja developerska: '.$e;
		}
		
		
		if ($all_ok==true)
		{
			//Dodanie pozycji do BD
			echo "Pozycja została dodana"; exit();
		}
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

<!--Error dialog box-->

        <script>
            function dlgLogin(){
                var whitebg = document.getElementById("white-background");
                var dlg = document.getElementById("dlgbox");
                whitebg.style.display = "none";
                dlg.style.display = "none";
            }
            
            function showDialog(){
                var whitebg = document.getElementById("white-background");
                var dlg = document.getElementById("dlgbox");
                whitebg.style.display = "block";
                dlg.style.display = "block";
                
                var winWidth = window.innerWidth;
                var winHeight = window.innerHeight;
                
                dlg.style.left = (winWidth/2) - 480/2 + "px";
                dlg.style.top = "150px";
            }
        </script>


	
	<!--Main form-->
	
	<form method = "post">

	<div id = "container_main">
		
		<div id="header"> Formularz skanerów laboratoryjnych Medit </div>
		
			<div id="container_form_left">
			
			
			<!--===================================================-->
			
			
				<fieldset id= "container_form_basic_param" >
				
				<legend style="background-color: #edd790; border: 2px black solid; border-radius: 2em; color: #472f0f; margin-left: 1em; padding: 0.2em 0.8em ">Dane skanera</legend>
				
					<!--<form method = "post">-->
					
						<div class = "row">
							<label for="scanner_model">Model: </label>
						</div>
								<div class="input-container">
									<select name="scanner_model" id="scanner_model" class="text">
									
												<option value='1'>- T300 -</option>
												<option value='2'>- T500 -</option>
												<option value='3'>- Hybrid -</option>
								
									</select>
								</div>
							

						<div class = "row">
							<label for="firma">Firma: </label>
						</div>	
						<div class = "input-container">
								<select name="firma" id="firma" class="txt">
								
											<option value='1'>- Scan_lab -</option>
											<option value='2'>- Robocam -</option>
							
								</select>
								
							
						</div>
						
						<div class = "row">
							<label for="nrseryjny">Nr seryjny: </label>
						</div>
						
						
						
						<div class = "input-container">
							<input type="text" name="nrseryjny" id="nrseryjny" /> 
										
						</div>
						
					<!--</form>-->
					
				</fieldset>
				
				
<!-- ==================================================-->

				<fieldset id= "container_form_checkbox" >
				
				<legend style="background-color: #edd790; border: 2px black solid; border-radius: 2em; color: #472f0f; margin-left: 1em; padding: 0.2em 0.8em ">Elementy dodatkowe</legend>
				
					<!--<form method = "post">-->
					
						<div class = "row">
							<label>
									<input type="checkbox" name="kas" value="KAS" > KAS jig
							</label>
						</div>
						
						<div class="row">
							<label>
								   <input type="checkbox" name="artexplate" value="Artex plate" > Artex plate
							</label>
						</div>
		
						<div class = "row">
							<label>
									<input type="checkbox" name="artexjig" value="Artex jig" > Artex jig
							</label>		
						</div>	
						
						
					<!--</form>-->
					
				</fieldset>



<!-- ==================================================-->
				<fieldset id= "container_form_exocad" >
				
				<legend style="background-color: #edd790; border: 2px black solid; border-radius: 2em; color: #472f0f; margin-left: 1em; padding: 0.2em 0.8em ">Exocad</legend>
				
					<!--<form method = "post">-->		
						
						
						<div class = "row" style="border-bottom: solid #f49e42; important!">
							<label for="exocad">Klucz Exocad: </label>
						</div>

						<div class = "input-container">
							<input type="text" name="exocad" id="exocad" /> 									
						</div>
				
						<div class = "row">
							<label>
									<input type="checkbox" name="exocad_articulator" value="Articulator" > Articulator
							</label>
						</div>
						
						<div class="row">
							<label>
								   <input type="checkbox" name="abutimp" value="Abutment/Imlant" > Abutment/Implant
							</label>	   
						</div>
							

						<div class = "row">
							<label>
									<input type="checkbox" name="dicom" value="Dicom" > Dicom
							</label>		
						</div>	
				
						<div class = "row">
							<label>
									<input type="checkbox" name="bars" value="Bars" > Bars
							</label>		
						</div>	
						
						<div class = "row">
							<label>
									<input type="checkbox" name="trusmile" value="TruSmile" > TruSmile
							</label>		
						</div>	
						
						<div class = "row">
							<label>
									<input type="checkbox" name="bitesplint" value="Bite splint" > Bite splint
							</label>
						</div>	
						
						<div class = "row">
							<label>
									<input type="checkbox" name="provtemp" value="Provisional / Temporary Crown" > Provisional / Temporary Crown
							</label>		
						</div>	
						
						<div class = "row">
							<label>
									<input type="checkbox" name="modelcreator" value="Model creator" > Model creator
							</label>
						</div>	
						
				
					<!--</form>-->
					
				</fieldset>
				
			</div>
		
		
		<!--==========================================================-->
		
		
		<div id="container_form_right">
		
							<fieldset id= "container_form_client" >
				
				<legend style="background-color: #edd790; border: 2px black solid; border-radius: 2em; color: #472f0f; margin-left: 1em; padding: 0.2em 0.8em ">Dane klienta</legend>
				
					<!--<form method = "post">-->
					
						<div class = "row">
							<label for="client_fname"> Imię: </label>
						</div>
						<div class="input-container">
							<input type="text" name="client_fname" id="client_fname" />
						</div>
						
						<div class = "row">
							<label for="client_lname"> Nazwisko: </label>
						</div>
						<div class="input-container">
							<input type="text" name="client_lname" id="client_lname" />
						</div>
						<div class = "row">
							<label for="company_name"> Nazwa firmy: </label>
						</div>
						<div class="input-container">
							<input type="text" name="company_name" id="company_name" />
						</div>
					    <div class = "row">
							<label for="street"> Ulica: </label>
						</div>
						<div class="input-container">
							<input type="text" name="street" id="street" />
						</div>	
						<div class = "row">
							<label for="zip"> Kod pocztowy: </label>
						</div>
						<div class="input-container">
							<input type="text" name="zip" id="zip" />
						</div>
						<div class = "row">
							<label for="city"> Miasto: </label>
						</div>
						<div class="input-container">
							<input type="text" name="city" id="city" />
						</div>
						<div class = "row">
							<label for="email"> e-mail: </label>
						</div>
						<div class="input-container">
							<input type="text" name="email" id="email" />
						</div>
						<div class = "row">
							<label for="phone"> Telefon: </label>
						</div>
						<div class="input-container">
							<input type="text" name="phone" id="phone" />
						</div>


						
						
					<!--</form>-->
					
				</fieldset>
		
		
			
			
				<fieldset id= "container_form_device" >
				
				<legend style="background-color: #edd790; border: 2px black solid; border-radius: 2em; color: #472f0f; margin-left: 1em; padding: 0.2em 0.8em ">Sprzęt</legend>
				
					<!--<form method = "post">-->		
						
						<div class = "row">
							<label for="computer_model">Komputer (model): </label>
						</div>

						<div class = "input-container">
							<input type="text" name="computer_model" id="computer_model" /> 									
						</div>

						<div class = "row">
							<label for="computer_serial">Nr seryjny komputera: </label>
						</div>

						<div class = "input-container">
							<input type="text" name="computer_serial" id="computer_serial" /> 									
						</div>
						
						
						<div class = "row">
							<label for="monitor_model">Monitor (model): </label>
						</div>

						<div class = "input-container">
							<input type="text" name="monitor_model" id="monitor_model" /> 									
						</div>

						<div class = "row">
							<label for="monitor_serial">Nr seryjny monitora </label>
						</div>

						<div class = "input-container">
							<input type="text" name="monitor_serial" id="monitor_serial" /> 									
						</div>
						
				
						<div class = "row">
							<label for="monitor_connection">Podłączenie monitora: </label>
						</div>
								<div class="input-container">
									<select name="monitor_connection" id="monitor_connection" class="text">
									
												<option value='1'>- DVI/VGA -</option>
												<option value='2'>- HDMI -</option>
												<option value='3'>- DisplayPort -</option>
								
									</select>
								</div>
				
					<!--</form>-->
					
				</fieldset>
				
	<!--=============================================================-->			
		
				<fieldset id= "container_form_notes" >
				
				<legend style="background-color: #edd790; border: 2px black solid; border-radius: 2em; color: #472f0f; margin-left: 1em; padding: 0.2em 0.8em ">Notatki</legend>
				
					<!--<form method = "post">-->
						
						<div id = "comment_field">
							<textarea name="comment" form="usrform" rows="8" cols="52"> ... </textarea>
						</div>
						
					<!--</form>-->
					
				</fieldset>
				
			</div>
		
		
		<div id="submitdata">
				<input type="submit" value = "Dodaj skaner do bazy" />
		</div>
		
		</div>
		
	</form>
	
	
	        <!-- dialog box -->
        <div id="white-background">
        </div>
        <div id="dlgbox">
            <div id="dlg-header">Błąd!</div>
			<div id="dlg-body"><?php echo '<pre>'.htmlspecialchars($error_msg) .'</pre>';?></div>
            <div id="dlg-footer">
                <button onclick="dlgLogin()">Zamknij</button>
				
            </div>
        </div>
	
	<?php
			if(isset($_SESSION['e_serial']))
			{
				echo '<script type="text/javascript">showDialog();</script>';
				unset($_SESSION['e_serial']); //<-- kasuje zmienną sesyjną na potrzeby kolejnej sesji
			}
	?>

	
</body>
</html>		