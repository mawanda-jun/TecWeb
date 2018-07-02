<?php

function deleteImage($fileName)
{
	$returnpage = $_SERVER['HTTP_REFERER'];
// $error = '';
	if (isset($_SESSION['login']) && $_SESSION['login'] == true) {
		$ok = true;
		$folder = "../../images/";

	// controllo il file indicato esista
		if (!file_exists($folder . $fileName))
			$error = 'Il file non esiste';
			header("Location: " . $returnpage);
			exit();
	// controllo non ci siano .. o /
		if (strrpos($fileName, '..') != false || strrpos($fileName, '/') != false)
			$error = 'Il nome contiene caratteri non accettati per motivi di sicurezza, come .. o /';
		if (strcmp("", $error) == 0)
			if (unlink($folder . $fileName)) {
			header("Location: " . $returnpage);
			exit();
		} else
			$error = 'Errore di cancellazione';
	} else
		$error = "non hai i permessi per compiere questa azione";

//trasferisco alla pagina di errore
	$_SESSION['error'] = $error;
	header("Location: sessione_scaduta.php");
	die();
}
?>

