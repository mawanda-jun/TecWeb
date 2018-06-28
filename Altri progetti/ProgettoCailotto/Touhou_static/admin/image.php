<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<?php 
header('Content-type: application/xhtml+xml');
if (session_status() == PHP_SESSION_NONE) { session_start(); }

if(!isset($_SESSION['login']) || !$_SESSION['login'] == true)
{
	echo('<div id="wronglogin">Login invalido, sessione scaduta!</div>');
	die;
}
?>
<head>
	<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1"/>
	<meta name="description" content="Fan club italiano di Touhou"/>
	<meta name="keywords" content="Touhou, Tou Hou, fan club, fanclub, italia, italiano, bullethell, bullet hell"/>
	<meta name="language" content="ïtalian it"/>
	<meta name="Author" content="Cailotto Mirco"/>

	<link rel="icon" type="image/png" href="../images/favicon.png"/>
	<link type="text/css" rel="stylesheet" href="../style/style.css" media="handheld, screen"/>
	<link type="text/css" rel="stylesheet" href="../style/admin.css" media="handheld, screen"/>
	<link type="text/css" rel="stylesheet" href="../style/tablet.css" media="handheld, screen and (max-width: 1024px), only screen and (max-device-width:1024px)"/>
	<link type="text/css" rel="stylesheet" href="../style/mobile.css" media="handheld, screen and (max-width: 680px), only screen and (max-device-width:680px)"/>
	<link type="text/css" rel="stylesheet" href="../style/print.css" media="print"/>

	<script type="text/javascript" src="../script/script.js"></script>
	<title>Gestione immagini - Touhou Italia</title>
</head>
<body>
	<div id="subheader">
		<div id="header">
			<div id="titolo">
				<h1>Touhou <span xml:lang="en">Project</span></h1>
				<div id="titoletto">Pannello di amministrazione</div>
			</div>
			<div id="skipmenu">
				<a href="#contenuto">Vai al contenuto</a>
			</div>
			<div id="menudiv">
				<ul id="menu">
					<li id="menuvoice">Menu</li>
					<li><a href="index.php" xml:lang="en">Home</a></li>
					<li><a href="news.php" xml:lang="en">News</a></li>
					<li class="disable">Immagini</li>
					<li><a href="comments.php">Commenti</a></li>
					<li><a href="banlist.php">Utenti bloccati</a></li>
					<li><a href="chapters.php">Capitoli</a></li>
					<li><a href="gestioneamministratori.php">Amministratori</a></li>
					<li><a href="../">Torna al sito</a></li>
					<li><a href="index.php?logout=true" xml:lang="en">Logout</a></li>
				</ul> 
			</div>
		</div>
	</div>
	<div id="locationbar">
		<span xml:lang="en">Home</span> di amministrazione &gt;&gt;&gt; Immagini
	</div>
	<div id="contenuto">
		<h2>Gestione immagini</h2>
		<form action="imageupload.php" method="post" enctype="multipart/form-data">
			<fieldset>
				<legend><span xml:lang="en">Upload</span> nuova immagine</legend>
				<p>Seleziona l'immagine da caricare (Massimo 5<acronym title="mega byte">MB</acronym>, in formato comune):</p>
				<label for="fileupload" xml:lang="en">File:</label> <input type="file" name="fileupload" id="fileupload"/><br/>
				<input type="submit" value="Carica" name="submit"/>
			</fieldset>
		</form>
<?php
$immagini = scandir('../images/news/');
echo '<dl>';
foreach($immagini as $immagine)
{
	if($immagine != '..' && $immagine != '.')
	{
		echo '<dt>'.$immagine.'</dt>';
		echo '<dd>
		<div class="imagediv">
			<div class="imagedescription">
				<div class="imageview">
					<img alt="immagine con nome'.$immagine.'" src="../images/news/'.$immagine.'"/>
				</div>
				<p>Per utilizzare questa immagine inserire: images/news/'.$immagine.'</p>
				<a class="button" title="Elimina l\'immagine '.$immagine.'" href="imagedelete.php?name='.$immagine.'">Elimina</a>
			</div>
		</div>
		</dd>';
	}
}
echo '</dl>';
?>

	</div>
</body>
</html>

