<?php
require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR."dbConnection.php";
if (session_status() == PHP_SESSION_NONE) { session_start(); }

$returnpage = $_SERVER['HTTP_REFERER'];
$error = '';

if(isset($_SESSION['login']) && $_SESSION['login'] == true)
{
	if(!isset($_GET['ip']))
		$error = 'Non è stato indicato l\'ip';
	else
	{
		$dbConnection = new DBAccess();
		$dbConnection->openDBConnection();
		//elimino il ban
		$risp = $dbConnection->removeBan($_GET['ip']);
		//se non è stata eliminata esattamente una riga
		if($risp != 1)
			$error ='Errore durante la richiesta al database';
		$dbConnection->closeDBConnection();
	}
}
else
	$error = 'Utente non loggato!';

if(strcmp('', $error) == 0)
{
	header("Location: ".$returnpage);
	die();
}

//trasferisco alla pagina di errore
$_SESSION['error'] = $error;
header("Location: error.php");
die();
?>

