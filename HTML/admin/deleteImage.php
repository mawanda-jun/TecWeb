<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
require()
// $returnpage = $_SERVER['HTTP_REFERER'];
// $error = '';
if(isset($_SESSION['login']) && $_SESSION['login'] == true)
{
	$ok = true;
	$folder = "../images/news/";

	// controllo il file indicato esista
	if (!file_exists($folder.$_GET["name"]))
		$error = 'Il file non esiste';
	// controllo non ci siano .. o /
	if (strrpos($_GET["name"], '..') != false || strrpos($_GET["name"], '/') != false)
		$error = 'Il nome contiene caratteri non accettati per motivi di sicurezza, come .. o /';
	if (strcmp("", $error) == 0)
		if (unlink($folder.$_GET["name"]))
		{
			header("Location: ".$returnpage);
			die();
		}
		else
			$error = 'Errore di cancellazione';
}
else
	$error = "non hai i permessi per compiere questa azione";

//trasferisco alla pagina di errore
$_SESSION['error'] = $error;
header("Location: error.php");
die();
?>

