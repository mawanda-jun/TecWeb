<?php require_once __DIR__.DIRECTORY_SEPARATOR."dbConnection.php";
header('Content-type: application/xhtml+xml'); ?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<?php

$dbConnection = new DBAccess();
$dbConnection->openDBConnection();
if(!isset($_GET['id']) || !is_numeric($_GET['id']))
{
	$errorInvalidArticle = '<div id="error_id" class="error">'."Non è stato trovato l'articolo indicato o non è stato indicato nessun articolo".'</div>';
	$title = 'Articolo non trovato - Touhou Italia';
	$location = '<span xml:lang="eng">Home</span> &gt;&gt;&gt; <span xml:lang="eng">News</span> &gt;&gt;&gt; Articolo non trovato';
}
else
{
	$notizia = $dbConnection->getArticle($_GET['id']);

	if(strlen($notizia['title']) < 21)
		$title = $notizia['title'].' - Touhou Italia';
	else
		$title = trim(substr($notizia['title'],0,20)).'... - Touhou Italia';
	if(strlen($notizia['title']) < 36)
		$location = '<span xml:lang="eng">Home</span> &gt;&gt;&gt; <span xml:lang="eng">News</span> &gt;&gt;&gt; '.$notizia['title'];
	else
		$location = '<span xml:lang="eng">Home</span> &gt;&gt;&gt; <span xml:lang="eng">News</span> &gt;&gt;&gt; '.trim(substr($notizia['title'],0,35)).'...';
}
?>

<head>
		<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1"/>
		<meta name="title" content="<?php echo $title; ?>"/>
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

		<meta http-equiv="Content-Script-Type" content="text/javascript"/>
		<script type="text/javascript" src="script/script.js"></script>
	<title><?php echo $title; ?></title>
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
					<li><a href="news.php"><span xml:lang="en">News</span></a></li>
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
		<?php echo $location; ?>
	</div>
	<div id="contenitore">
		<div id="contenuto">
		<div id="news">
<?php
if(isset($errorInvalidArticle))
	echo $errorInvalidArticle;
else
{
	if($notizia == null)
		echo '<div id="error_query" class="error">'."L'articolo richiesto non esiste".'</div>';
	else
	{
		echo '<h2>'.$notizia['title'].'</h2>';
		if(isset($notizia['image']) && strcmp($notizia['image'], "") != 0)
			echo '<div class="newsimage"><img src="images/news/'.$notizia['image'].'" alt="'.$notizia['imgdescr'].'"/></div>';
		echo '<div class="data">'.strftime('%e %B %Y',strtotime($notizia['data'])).'</div><div class="testo">'.$notizia['text'].'</div>';
		$ok = true;
	}
?>
			</div>
			<div id="commenti">
				<div id="leavecomment">
					<h3>Lascia un commento</h3>
					<form action="commentadd.php" method="post" id="leavecommentform" onsubmit="return validateForm()">
						<div id="leavecommentfields">
                                <label for="nameinput">Nome</label>: <input id="nameinput" name="name" type="text" size="20" maxlength="30" onchange="validateString('nome',document.getElementById('nameinput').value)"/>
                                <div id="errorenome"></div><br/>
                                <label for="emailinput"><span xml:lang="en">E-mail</span> (non sarà pubblicata)</label>: <input id="emailinput" name="email" type="text" size="20" maxlength="40" onchange="validateEmail()" />
                                <div id="erroreemail"></div><br/>
                                <label for="commentoinput">Commento</label>: <textarea id="commentoinput" name="message" onchange="validateString('commento',document.getElementById('commentoinput').value)" cols="48" rows="4"></textarea><br/>
                                <div id="errorecommento"></div><br/>
                                <input value="Invia" type="submit"/>
                                <input value="Cancella" type="reset"/>
                                <div id="erroreinvio"></div>
						</div>
					</form>
				</div>
				<div id="listacommenti">
					<h3>Commenti lasciati dagli utenti</h3>
<?php
	if(isset($notizia) && $notizia != null)
	{
		$comments = $dbConnection->getListComments($_GET['id'], 200);
		if($comments != null)
		{
			echo '<dl>';
			foreach($comments as $comment)
			{
				echo '<dt>'.$comment['nick'].'</dt>';
				echo '<dd><div class="commenttext">'.$comment['message'].'</div></dd>';
			}
			echo '</dl>';
		}
		else
			echo '<div id="nopostmessage">Nessun commento inserito</div>';
	}
	echo '</div>';
}
?>
			</div>
			<div id="jumptotop">
				<a href="#header">Torna in cima</a>
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
