<?php require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR."dbConnection.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<?php 
header('Content-type: application/xhtml+xml'); if (session_status() == PHP_SESSION_NONE) { session_start(); }

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
	<title>Moderazione commenti - Touhou Italia</title>
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
					<li><a href="index.php"  xml:lang="en">Home</a></li>
					<li><a href="news.php" xml:lang="en">News</a></li>
					<li><a href="image.php">Immagini</a></li>
					<li class="disable">Commenti</li>
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
		<span xml:lang="en">Home</span> di amministrazione &gt;&gt;&gt; Commenti
	</div>
	<div id="contenuto">
		<h2>Moderazione commenti</h2>
<?php

$dbConnection = new DBAccess();
$dbConnection->openDBConnection();
$comments = $dbConnection->getListComments(null, false, true);
if($comments != null)
{
	echo '<dl>';
	$inc = 1;
	foreach($comments as $comment) 
	{
		echo '<dt>'.$comment['id']. ' - ' .$comment['nick'].' - '.$comment['email'].'</dt>'.
			'<dd>'.
			'<div class="data">'.$comment['data'].'</div>'.
			'<div class="message"><p>'.$comment['message'].'</p></div>'.
			'<div class="ip">'.$comment['ip'].'</div>'.
			'<form class="commentaction" action="commentaction.php" method="post">'.
			'<div class="commentactionsformcontent">'.
			'<label for="reasonform'.$inc.'">Motivo del blocco a '.$comment['nick'].' per via del commento con <acronym title="Identificativo">ID</acronym> '.$comment['id'].'</label>: <input id="reasonform'.$inc.'" type="text" size="25" maxlength="255" name="reason"/><br/>'.
			'<button name="ban" value="'.$comment['id'].'">Blocca l\'utente '.$comment['nick'].' ed elimina il commento con <acronym title="Identificativo">ID</acronym> '.$comment['id'].'</button><br/>'.
			' <button name="delete" value="'.$comment['id'].'">Elimina il commento di '.$comment['nick'].' con <acronym title="Identificativo">ID</acronym> '.$comment['id'].'</button>'.
			'</div>'.
			'</form>'.
			'</dd>';
		$inc += 1;
	}
	echo '</dl>';
}
else
	echo('<div id="nodata">Nessun commento inserito</div>');
$dbConnection->closeDBConnection();
?>
	</div>
</body>
</html>

