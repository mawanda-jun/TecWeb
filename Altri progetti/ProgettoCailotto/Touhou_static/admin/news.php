<?php require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR."dbConnection.php"; ?>
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
	<title>Gestione news - Touhou Italia</title>
</head>
<body>	<div id="subheader">
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
					<li class="disable" xml:lang="en">News</li>
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
		<span xml:lang="en">Home</span> di amministrazione &gt;&gt;&gt; <span xml:lang="en">News</span>
	</div>
	<div id="contenuto">
		<h2>Gestione news</h2>
		<div id="newsadd">
			<a class="button bigbutton" href="newsadd.php">Aggiungi una nuova <span xml:lang="en">news</span></a>
		</div>
		<h3><span xml:lang="en">News</span> presenti nel sito:</h3>
<?php
	$dbConnection = new DBAccess();
	$dbConnection->openDBConnection();
	$news = $dbConnection->getListNews(true, 10000);
	if($news != null)
	{
		echo '<dl>';
		foreach($news as $notizia) 
		{
			echo '<dt><a href="../article?id='.$notizia['id'].'">'.$notizia['title'].'</a></dt>'.
				'<dd>'.
				'<div class="optionsnewsdiv">
				<a title="Modifica notizia: '.$notizia['title'].'" class="button" href="newsaction.php?action=edit&amp;id='.$notizia['id'].'">Modifica</a> 
				<a title="Elimina notizia: '.$notizia['title'].'" class="button" href="newsaction.php?action=delete&amp;id='.$notizia['id'].'">Elimina</a>';
			if($notizia['hidden'])
				echo ' <a title="Pubblica notizia: '.$notizia['title'].'" class="button" href="newsaction.php?action=visible&amp;id='.$notizia['id'].'">Pubblica</a>';
			else
				echo ' <a title="Imposta come bozza la notizia: '.$notizia['title'].'" class="button" href="newsaction.php?action=hide&amp;id='.$notizia['id'].'">Imposta come bozza</a>';
			echo '</div><br/>';
			if(isset($notizia['image']) && strcmp($notizia['image'], "") != 0)
				echo '<div class="newsimage"><img src="../images/news/'.$notizia['image'].'" alt="'.$notizia['imgdescr'].'"/></div>';
			echo '<div class="data">'.strftime('%e %B %Y',strtotime($notizia['data'])).'</div><div class="testo">'.$notizia['text'].'</div></dd>';
		}
		echo '</dl>';
	}
	else
		echo('<div id="nodata">Nessuna news inserita</div>');
	$dbConnection->closeDBConnection();
?>
	</div>
</body>
</html>

