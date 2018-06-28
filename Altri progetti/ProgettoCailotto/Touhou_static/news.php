<?php require_once __DIR__.DIRECTORY_SEPARATOR."dbConnection.php";
header('Content-type: application/xhtml+xml'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<head>
		<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1"/>
		<meta name="title" content="News - Touhou Italia"/>
		<meta name="description" content="Fan club italiano di Touhou"/>
		<meta name="keywords" content="Touhou, Tou Hou, fan club, fanclub, italia, italiano, bullethell, bullet hell"/>
		<meta name="language" content="ïtalian it"/>
		<meta name="Author" content="Cailotto Mirco"/>

		<link rel="icon" type="image/png" href="images/favicon.png"/>
		<link type="text/css" rel="stylesheet" href="style/style.css" media="handheld, screen"/>
		<link type="text/css" rel="stylesheet" href="style/tablet.css" media="handheld, screen and (max-width: 1024px), only screen and (max-device-width:1024px)"/>
		<link type="text/css" rel="stylesheet" href="style/mobile.css" media="handheld, screen and (max-width: 680px), only screen and (max-device-width:600px)"/>
		<link type="text/css" rel="stylesheet" href="style/print.css" media="print"/>

		<link rel="alternate" href="rss.php" title="Ricevi le notizie tramite RSS" type="application/rss+xml"/>

		<script type="text/javascript" src="script/script.js"></script>
	<title>News - Touhou Italia</title>
</head>
<body>
	<div id="subheader">
		<div id="header">
			<div id="titolo">
				<h1>Touhou <span xml:lang="en">Project</span></h1>
				<div id="titoletto">Sito di informazione italiano</div>
			</div>
			<div id="skipmenu">
				<a href="#contenuto">Vai al contenuto</a>
			</div>
			<div id="menudiv">
				<ul id="menu">
					<li id="menuvoice">Menu</li>
					<li><a href="index.php"><span xml:lang="en">Home</span></a></li>
					<li class="disable"><span xml:lang="en">News</span></li>
					<li><a href="gameplay.php"><span xml:lang="en">Gameplay</span></a></li>
					<li><a href="sviluppo.php">Sviluppo</a></li>
					<li><a href="popolarita.php">Popolarità</a></li>
					<li><a href="personaggi.php">Personaggi</a></li>
					<li><a href="capitoli.php">Capitoli</a></li>
				</ul> 
			</div>
		</div>
	</div>
	<div id="locationbar">
		<span xml:lang="eng">Home</span> &gt;&gt;&gt; <span xml:lang="eng">News</span>
	</div>
		<div id="contenitore">
			<div id="contenuto">
				<h2 xml:lang="en">News</h2>
<?php
	$dbConnection = new DBAccess();
	$dbConnection->openDBConnection();
	$index = 0;			// di default prendo le news più recenti
	$newsnumber = 10;	// numero di news per pagina
	if(isset($_GET['index']))
		if($_GET['index']>=0)
			$index = $_GET['index'];
	$news = $dbConnection->getListNews(false, 1000, $newsnumber, $index*$newsnumber);

	//numero totale dei post
	$number = $dbConnection->getNumberNews(false);
	if($news != null)
	{
		echo '<dl>';
		foreach($news as $notizia) 
		{
			echo '<dt><a href="article.php?id='.$notizia['id'].'">'.$notizia['title'].'</a></dt>';
			echo '<dd>';
			if(isset($notizia['image']) && strcmp($notizia['image'], "") != 0)
				echo '<div class="newsimage"><img src="images/news/'.$notizia['image'].'" alt="'.$notizia['imgdescr'].'"/></div>';
			echo '<div class="data">'.strftime('%e %B %Y',strtotime($notizia['data'])).'</div><div class="testo">'.strip_tags($notizia['text']).'</div></dd>';
		}
	echo '</dl>';
	}
	else
		echo '<p>Nessun articolo disponibile</p>';
?>
			<div id="navbutton">
<?php	//genero o meno i tasti per le altre news
if($index+1 < $number/$newsnumber)
	echo('<a id="precnews" class="othernews button" href="news.php?index='.($index+1).'">Notizie precedenti</a>');
if($index > 0)
	echo('<a id="nextnews" class="othernews button" href="news.php?index='.($index-1).'">Notizie successive</a>');
?>
			</div>
		</div>
		<div id="sidebar">
			<dl title="barra laterale">
				<dt class="dtsidebar"  id="lastnews">Ultime notizie</dt>
				<dd class="ddsidebar"><?php include('sidebarnews.php'); ?></dd>
				<dt class="dtsidebar" id="feedRSS"><span xml:lang="en">Feed RSS</span></dt>
				<dd class="ddsidebar">
					<a href="rss.php"><img id="imgrss" src="images/rss-icon.png" alt="Logo RSS"/>Clicka qui per iscriverti ai <acronym xml:lang="en" title="RDS (Resource Description Framework) Site Summary">RSS</acronym>!</a>
					<p>Rimani sempre aggiornato attraverso le notifiche <acronym xml:lang="en" title="RDS (Resource Description Framework) Site Summary">RSS</acronym> iscrivendoti al <span xml:lang="en">feed</span>!<br/>
					Clicka sull'icona ed aggiungilo ai tuoi segnalibri!</p>
				</dd>
			</dl>
		</div>
		<div id="jumptotop">
			<a href="#header">Torna in cima</a>
		</div>
	</div>
	<div id="footer">
		<p>
			Sito web creato da Bisello Samuele, Cailotto Mirco, Todescato Matteo.<br/>
			Tutti i diritti riservati ai rispettivi proprietari, tutti i diritti sui contenuti appartengono ai rispettivi proprietari.<br/>
			La pubblicazione è da ritenere finalizzata unicamente come esempio di sito <span xml:lang="en">web</span> sviluppato per il corso di tecnologie <span xml:lang="en">web</span>.<br/>
			Per qualsiasi necessità contattare gli amministratori all'indirizzo <span xml:lang="en">e-mail</span> <a title="e-mail amministratori" href="mailto:touhouitalia@gmail.com">TouhouItalia@gmail.com</a><br/>
			Per amministrare il sito accedere alla <a id="linkadmin" href="admin/">pagina di amministrazione</a>.
		</p>
	</div>
<?php $dbConnection->closeDBConnection(); ?>
</body>
</html>
