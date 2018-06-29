<?php
require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR."dbConnection.php";
if (session_status() == PHP_SESSION_NONE) { session_start(); }

$returnpage = $_SERVER['HTTP_REFERER'];
$error = null;

if(!isset($_SESSION['login']) || $_SESSION['login'] != true)
	$error = 'Utente non loggato!';
else
{
	$dbConnection = new DBAccess();
	$dbConnection->openDBConnection();
	$idpost = -1;
	$del = true;
	$add = true;
	if(isset($_POST['delete']))
		$idpost = $_POST['delete'];
	if(isset($_POST['ban']))
		$idpost = $_POST['ban'];
	if($idpost == -1)
		$error = 'Il post indicato è invalido!';
	else
	{
		//ottengo l'ip
		$ip = $dbConnection->getIpFromComment($idpost);
		//banno
		if(isset($_POST['ban']))
		{	
			if(isset($_POST['reason']))
				$reason = $_POST['reason'];
			else
				$reason = 'non specificato';
			if(isset($ip) && $ip != null && strcmp($ip,'unknow') != 0)
				$add = $dbConnection->insertBan($ip, $reason);
		}

		//elimino il commento
		if(isset($_POST['delete']) || isset($_POST['ban']))
			$del = $dbConnection->removeComment($idpost);
		if(!$del || !$add)
			$error ='Errore durante la richiesta al database';
	}
	$dbConnection->closeDBConnection();
}

if($error == null)
{
	header("Location: ".$returnpage);
	die();
}

//trasferisco alla pagina di errore
$_SESSION['error'] = $error;
header("Location: error.php");
die();
?>

