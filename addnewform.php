<?php

	session_start();

	if (!isset($_SESSION['zalogowany'])) //ta instrukcja warunkowa odsyła usera do strony logowania jeśli próbuje się dostać na stronę 'gra.php' nie będąc zalogowanym
	{
		header('Location: index.php');
		exit();
	}
	
?>

<?php

if(isset($_POST['input']) && ($_POST['input']=='meditlab')){
	
		header('Location: meditform.php');
	
}elseif(isset($_POST['input']) && ($_POST['input']=='sironaintraoral')){

	header('Location: sironaintraoralform.php');

}elseif(isset($_POST['input']) && ($_POST['input']=='trios')){

	header('Location: triosform.php');
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


</body>
</html>		