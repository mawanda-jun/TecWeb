<?php
require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR."dbConnection.php";
if (session_status() == PHP_SESSION_NONE) { session_start(); }

$returnpage = $_SERVER['HTTP_REFERER'];

$error = 'Utente non loggato!';
if(isset($_SESSION['login']) && $_SESSION['login'] == true)
{
	$risp = false;

	if(isset($_GET['id']))
	{
		$dbConnection = new DBAccess();
		$dbConnection->openDBConnection();
		$risp = $dbConnection->removeChapter($_GET['id']);
		if(!$risp)
			$error ='Errore nella eliminazione del capitolo, contattare una amministratore!';

		unlink("../images/chapters/".$dbConnection->getChapterImage($_GET['id'])['image']);

		$dbConnection->closeDBConnection();
		header("Location: ".$returnpage);
		die();
	}
	else
		$error ='Nessuna richiesta effettuata';
}
//trasferisco alla pagina di errore
$_SESSION['error'] = $error;
header("Location: error.php");
die();
?>


