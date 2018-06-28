<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<?php
header('Content-type: application/xhtml+xml');
if (session_status() == PHP_SESSION_NONE) { session_start(); }

if(!isset($_SESSION['login']) || !$_SESSION['login'] == true)
{
	$_SESSION['error'] = "Login invalido, sessione scaduta!";
	header("Location: error.php");
	die();
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
	<meta http-equiv="Content-Script-Type" content="text/javascript"/>
	<title>Aggiunta capitolo - Touhou Italia</title>
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
					<li><a href="index.php">Home</a></li>
					<li><a href="news.php" xml:lang="en">News</a></li>
					<li><a href="image.php">Immagini</a></li>
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
		<span xml:lang="en">Home</span> di amministrazione &gt;&gt;&gt; Capitoli &gt;&gt;&gt; Aggiunta capitolo
	</div>
	<div id="contenuto">
		<h2>Aggiunta capitolo</h2>
		<div id="newsadd">
			<form id="addchapterform" action="chapteraddaction.php" method="post" enctype="multipart/form-data" onsubmit="return validateFormAddChapter()">
				<div id="addchapterdiv">
					<label for="title">Titolo giapponese</label>: <input name="title" type="text" id="title" size="20" maxlength="40" onchange="validateString('titolo', document.getElementById('title').value)"/>
                    <div id="erroretitolo"></div>
					<label for="titleeng">Titolo inglese</label>: <input name="titleeng" type="text" id="titleeng" size="20" maxlength="40" onchange="validateString('titolo_inglese', document.getElementById('titleeng').value)"/>
                    <div id="erroretitolo_inglese"></div>
                    <label for="titleita">Titolo italiano</label>: <input name="titleita" type="text" id="titleita" size="20" maxlength="40" onchange="validateString('titolo_italiano', document.getElementById('titleita').value)"/>
                    <div id="erroretitolo_italiano"></div>
                    <label for="fileupload">Immagine della copertina</label>: <br/>
					<input type="file" name="fileupload" id="fileupload"/><br/>
                    <label for="imagedescr">Descrizione breve dell'immagine</label>: <input name="imagedescr" type="text" id="imagedescr" size="20" maxlength="40" onchange="validateString('image_descr', document.getElementById('imagedescr').value)"/>
                    <div id="erroreimage_descr"></div>
                    <label for="number">Numero</label>: <input type="text" name="number" id="number" size="8" maxlength="10" onchange="validateString('numero', document.getElementById('number').value)" />
                    <div id="errorenumero"></div>
                    <label for="year">Anno</label>: <input name="year" type="text" id="year" size="4" onchange="validateYear('anno', document.getElementById('year').value)" value="<?php echo date("Y");?>"/>
                    <div id="erroreanno"></div>
                    <label for="plot">Trama</label>: <br/><textarea name="plot" id="plot" onchange="validateString('testo', document.getElementById('plot').value)" cols="100" rows="10"></textarea>
                    <div id="erroretesto"></div>
                    <input type="submit" value="Aggiungi" name="submit"/>
                    <div id="erroreNewChapter"></div>
				</div>
			</form>
		</div>
	</div>
</body>
</html>
