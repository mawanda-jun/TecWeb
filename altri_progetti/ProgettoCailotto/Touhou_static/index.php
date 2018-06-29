<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<?php header('Content-type: application/xhtml+xml'); ?>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<head>
		<meta http-equiv="Content-Type" content="application/xhtml+xml; charset=UTF-8"/>
		<meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1"/>
		<meta name="title" content="Touhou fan club italiano"/>
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
	<title>Touhou fan club italiano</title>
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
					<li class="disable"><span xml:lang="en">Home</span></li>
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
		<span xml:lang="eng">Home</span>
	</div>
	<div id="contenitore">
		<div id="contenuto">
			<h2 xml:lang="eng">Home page</h2>
			<h3>Touhou <span xml:lang="en">Project</span></h3>
	<!-- introduzione -->
			<p>Touhou <span xml:lang="en">Project</span> (<ruby xml:lang="ja"><rb>東方</rb><rp>(</rp><rt>とうほう</rt><rp>)</rp></ruby><span xml:lang="en">Project</span>) è una <strong>serie di videogiochi</strong> per <span xml:lang="en">PC-98</span> e <span xml:lang="en">Windows</span>, sviluppata a partire dal 1996 dalla casa produttrice giapponese <strong xml:lang="en">Team Shanghai Alice</strong>, il cui unico membro è <strong>ZUN</strong>.</p>
	<!-- breve descrizione di touhou -->
			<div class="withtotal2images">
				<img src="images/gameplay1.jpg" alt="Immagine di una schermata di gioco, con una enorme quantità di proiettili" class="total2images"/>
				<img src="images/gameplay2.jpg" alt="Immagine di gioco del sesto capitolo" class="total2images"/>
			</div>
			<p>I giochi sono di tipologia "<em xml:lang="en">Bullet Hell</em>", cioè sparattutto a scorrimento verticale, caratterizzati da una difficoltà decisamente elevata e che per essere completati richiedono tecnica, dedizione e ottimi riflessi.
			</p>
	<!-- popolarità di touhou -->
			<h3>Popolarità</h3>
			<img src="images/meme3.jpg" alt="Immagine con ZUN che sfida il giocatore a giocare a difficoltà massima" class="total3images"/>
			<img src="images/meme1.jpg" alt="Immagine di un gruppo di lettori di floppy che suonano Bad Apple" class="total3images"/>
			<img src="images/meme2.jpg" alt="Immagine con caricatura di Marisa Kirisame" class="total3images"/>
			<p>Touhou ha avuto un enorme successo anche al dì fuori del Giappone, soprattutto grazie ad <span xml:lang="en">internet</span> e a svariati tormentoni ricorrenti, come i <strong><span xml:lang="en">remix</span> di alcune canzoni</strong> presenti nel gioco (<a title="colonna sonora Bad Apple suonata con dei floppy drive, su YouTube" href="https://www.youtube.com/watch?v=hkZbAJHeu9w">alcuni fatti persino usando dei lettori di <span xml:lang="en">floppy disk</span>, visibile su <span xml:lang="en">YouTube</span></a>), le <strong>caricature</strong> dei personaggi o le <strong>battute riguardandi la difficoltà</strong>, come ad esempio "<em>finendo Touhou a <span xml:lang="en">lunatic</span> si impara come correre sotto la pioggia senza bagnarsi</em>".
			</p>
	<!-- obbiettivo del sito -->
			<h3>Conferenze e raduni in Italia</h3>
			<img src="images/cosplay.jpg" alt="Gruppo di cosplay vestiti come i personaggi di Touhou"/>
			<p>Questo sito si pone l'obbiettivo di riuscire a collaborare con portali e fiere per la creazione di <strong>eventi, conferenze e raduni</strong> riguardanti Touhou, in modo da far incontrare i <span xml:lang="en">fan</span> e magari realizzare qualche <strong>evento <span xml:lang="en">cosplay</span> a tema!</strong><br/>
	Rimanete sintonizzati sulla sezione <em xml:lang="en">News</em> per ricevere aggiornamenti a riguardo.
			</p>
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
</body>
</html>

