<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<?php
header('Content-type: application/xhtml+xml');
if (session_status() == PHP_SESSION_NONE) { session_start(); }
?>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1"/>
	<link type="text/css" rel="stylesheet" href="style/errorpage.css" media="handheld, screen"/>
	<script type="text/javascript" src="script/showback.js"></script>
	<title>Errore! - Touhou Italia</title>
</head>
<body>
	<div id="contenuto">
		<h2>Errore!</h2>
		<p><?php if(isset($_SESSION['error'])) echo $_SESSION['error']; else echo('Si è verificato un errore inatteso, per favore contatta il supporto tecnico'); $_SESSION['error'] = null;?></p>
		<img id="imageerr" src="images/err404.jpg" alt=""/> <br/>
		<a href="index.php">Torna alla <span xml:lang="en">home</span> del sito</a> <br/>
		<a id="backpage" href="javascript:history.back()">Ritorna alla pagina precedente</a>
	</div>
</body>
</html>



