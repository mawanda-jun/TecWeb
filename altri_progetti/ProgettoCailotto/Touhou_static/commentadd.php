<?php
require_once __DIR__.DIRECTORY_SEPARATOR.'dbConnection.php';
	if(isset($_SERVER['HTTP_REFERER']))
		$returnpage = $_SERVER['HTTP_REFERER'];
	else
		$returnpage = "/"; //evita Local Filesystem Paths Found
	$addrarray = explode("=",$returnpage);
	$id = end($addrarray);
	$error = null;
	if(isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message']) &&
		strcmp($_POST['name'], "") != 0 && strcmp($_POST['email'], "") != 0 && strcmp($_POST['message'], "") != 0)
	{
		$email = $_POST['email'];
		//avverto con messaggi mirati nel caso di errori più comuni
		if(strpos($email, '@') == false)
			$error = '<span xml:lang="en">E-mail</span> invalida, non è presente il carattere "chiocciola" (@).';
		if(strpos($email, '@') != strrpos($email, '@'))
			$error = '<span xml:lang="en">E-mail</span> invalida, il carattere "chiocciola" (@) non è univoco.';
		if(strpos($email, '.') == false)
			$error = '<span xml:lang="en">E-mail</span> invalida, deve essere presente il dominio (ad esempio it, en o com) preceduto da un punto.';
		//tutti gli altri formati invalidi, come email.com@gmail, prova@tiscali.it@, etc
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		 	$error = 'L\'<span xml:lang="en">e-mail</span> non è nel formato corretto, si prega di ricontrollarla.';
		}
		if(strcmp($error, "") == 0)
		{
			$dbConnection = new DBAccess();
			$dbConnection->openDBConnection();

			$ip = 'unknow';
			//evito di bannare il local host
			if (array_key_exists('HTTP_CLIENT_IP', $_SERVER))
				$ip = $_SERVER['HTTP_CLIENT_IP'];
			if($ip != 'unknow' && $dbConnection->checkBannedIp($ip))
				$error = 'Il tuo indirizzo IP risulta bloccato a causa di precedenti messaggi inopportuni, se ritieni che questo messaggio sia un errore contattare un amministratore.';
			else
				$risp = $dbConnection->insertComment($_POST['name'], $email, $_POST['message'], $id, $ip);
			if(!$risp && $error == null)
				$error = 'Errore nell\'inserimento del commento, per favore contattare un amministratore.';
			$dbConnection->closeDBConnection();
			if($error == null)
			{
				header("Location: ".$returnpage);
				die();
			}
		}
	}
	else
		$error ="Alcuni campi sono stati lasciati vuoti, per favore compilare tutti i campi.";

	header('Content-type: application/xhtml+xml'); if (session_status() == PHP_SESSION_NONE) { session_start(); }
	//trasferisco alla pagina di errore
	$_SESSION['error'] = $error;
	header('Location: error.php');
	die();
?>
