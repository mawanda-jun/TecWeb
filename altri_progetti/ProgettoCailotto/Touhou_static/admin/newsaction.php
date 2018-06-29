<?php
require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR."dbConnection.php";
if (session_status() == PHP_SESSION_NONE) { session_start(); }

$returnpage = $_SERVER['HTTP_REFERER'];

$error = null;
if(isset($_SESSION['login']) && $_SESSION['login'] == true)
{
	$dbConnection = new DBAccess();

	$dbConnection->openDBConnection();
	$risp = false;

	//Inserimento o modfica da effettuare
	if(isset($_POST['title']) && isset($_POST['text']))
	{
		if(strcmp($_POST['title'],"") != 0 && (isset($_FILES["fileupload"]) || (isset($_POST['image']) && strcmp($_POST['image'],"") != 0)) && strcmp($_POST['text'],"") != 0)
		{
			$returnpage = "news.php";

			if(isset($_POST['hidden']) && $_POST['hidden'] == true)
				$hidden = 1;
			else
				$hidden = 0;
			
			$image = $_POST['image'];
			if($_FILES["fileupload"]['size'] != 0) //se c'è una immagine provo a caricarla e a impostarla
			{
				require('imageuploadfunction.php');
				$ris = imageupload("../images/news/", $_FILES["fileupload"]);
				if($ris['result'])
					$image = $ris['text'];
			}

			//Modifica
			if(isset($_POST['id']))
				$risp = $dbConnection->updateNews($_POST['title'], $image, $hidden,  $_POST['text'], $_POST['imgdescr'], $_POST['id']);
			//Inserimento		
			else
				$risp = $dbConnection->insertNews($_POST['title'], $image, $hidden,  $_POST['text'], $_POST['imgdescr']);
		}
		else
		{
			$error = "Alcuni campi inseriti non sono corretti! ";
			if(strcmp($_POST['title'],"") == 0)
				$error .= "Il titolo non può essere lasciato vuoto! ";
			if(strcmp($_POST['text'],"") == 0)
				$error .= "Il testo non può essere lasciato vuoto! ";
			if($_FILES["fileupload"]['size'] == 0 && (!isset($_POST['image']) || strcmp($_POST['image'],"") == 0))
				$error .= "Non è stata indicata nessuna immagine da utilizzare o da caricare!";
		}
	}
	//Specificata una azione
	if(isset($_GET['action']))
	{
		//modifica
		if(strcmp($_GET['action'],"edit") == 0)
		{
			$returnpage = 'newsadd.php?id='.$_GET['id'];
			$risp = 1;
		}
		//elimina
		if(strcmp($_GET['action'],"delete") == 0)
			$risp = $dbConnection->removeNews($_GET['id']);
		//rendi visibile
		if(strcmp($_GET['action'],"visible") == 0)
			$risp = $dbConnection->updateNewsVisibility($_GET['id'], false);
		//sposta in bozze
		if(strcmp($_GET['action'],"hide") == 0)
			$risp = $dbConnection->updateNewsVisibility($_GET['id'], true);
	}
	
	$dbConnection->closeDBConnection();

	//Se non ho avuto nessuna risposta e non ho ancora l'errore
	if($risp != true)
	{
		if($error == null)
			$error ='Errore durante lo svolgimento dell\'operatione!';
	}
	//Altrimenti ridireziono verso la prossima pagina
	else
	{
		header("Location: ".$returnpage);
		die();
	}
}
else
	$error ='Utente non loggato!';


//Trasferisco alla pagina di errore
$_SESSION['error'] = $error;
header("Location: error.php");
die();
?>

