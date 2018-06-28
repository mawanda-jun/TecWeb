<?php require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR."dbConnection.php";
if (session_status() == PHP_SESSION_NONE) { session_start(); }

$returnpage = $_SERVER['HTTP_REFERER'];

$error = 'Utente non loggato!';
if(isset($_SESSION['login']) && $_SESSION['login'] == true)
{
	$risp = false;

	if(isset($_POST['number']) && strcmp($_POST['number'], "") != 0 &&
		isset($_POST['year']) && strcmp($_POST['year'], "") != 0 &&
		isset($_POST['title']) && strcmp($_POST['title'], "") != 0 &&
		isset($_POST['titleeng']) && strcmp($_POST['titleeng'], "") != 0 &&
		isset($_POST['titleita']) && strcmp($_POST['titleita'], "") != 0 &&
		isset($_POST['plot']) && strcmp($_POST['plot'], "") != 0
		)
	{		//INSERT
		$image = false;
		$ris = false;
		if(isset($_FILES["fileupload"])) //se c'è una immagine provo a caricarla e a impostarla
		{
			require('imageuploadfunction.php');
			$ris = imageupload("../images/chapters/", $_FILES["fileupload"]);
			if($ris['result'])
				$image = $ris['text'];
		}
		if($image != false)
		{
			if(isset($_POST['imagedescr']))
				$imagedescr  = mysqli_real_escape_string($conn, $_POST['imagedescr']);
			else
				$imagedescr = "";
			
			$dbConnection = new DBAccess();
			$dbConnection->openDBConnection();
			$risp = $dbConnection->insertChapter($_POST['number'], $_POST['year'], $_POST['title'], $image, $imagedescr, $_POST['titleeng'], $_POST['titleita'], $_POST['plot']);
			if(!$risp)
			{
				$error = "Errore durante il collegamento al database, contattare un amministratore";
				unlink("../images/chapters/".$image);
			}
			$dbConnection->closeDBConnection();
		}
		else
			$error = $ris['text'];
	}
	else
	{
		$error = "Errore durante l'inserimento! ";
		if(!isset($_POST['number']) || strcmp($_POST['number'], "") == 0)
			$error.= "Il numero del capitolo è stato lasciato vuoto! ";
		if(!isset($_POST['year']) || strcmp($_POST['year'], "") == 0)
			$error.= "L'anno è stato lasciato vuoto! ";
		if(!isset($_POST['title']) || strcmp($_POST['title'], "") == 0)
			$error.= "Il titolo in giapponese è stato lasciato vuoto! ";
		if(!isset($_POST['titleeng']) || strcmp($_POST['titleeng'], "") == 0)
			$error.= "Il titolo in inglese è stato lasciato vuoto! ";
		if(!isset($_POST['titleita']) || strcmp($_POST['titleita'], "") == 0)
			$error.= "Il titolo in italiano è stato lasciato vuoto! ";
		if(!isset($_POST['plot']) || strcmp($_POST['plot'], "") == 0)
			$error.= "La trama è stata lasciata vuota!";
	}
	
	if($risp != false)
	{
		header("Location: chapters.php");
		die();
	}
}
//trasferisco alla pagina di errore
$_SESSION['error'] = $error;
header("Location: error.php");
die();
?>

