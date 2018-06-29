<?php require_once __DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR."dbConnection.php"; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">
<?php
header('Content-type: application/xhtml+xml');
if (session_status() == PHP_SESSION_NONE) { session_start(); }

$wronglogin = false;
$wrongloginmessage = '<div id="wronglogin">Dati errati!</div>';

$dbConnection = new DBAccess();
$dbConnection->openDBConnection();

if(isset($_POST['username']) && isset($_POST['password']))
	if($dbConnection->adminLogIn( $_POST['username'], $_POST['password'])) //linea dove avviene il controllo dell'accesso
	{
		$_SESSION['login'] = true;
		$_SESSION['username'] = $_POST['username'];
	}
else
	$wronglogin = true;

$dbConnection->closeDBConnection();

if(isset($_GET['logout']) && $_GET['logout'] == "true")
{
	$_SESSION['login'] = false;
	$_SESSION['username'] = null;
	header("Location: ../index.php");
	die();
}
if(isset($_SESSION['login']) && $_SESSION['login'] == true)
	$title = "Pannello di amministrazione";
else
	$title = "Login";
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
	<title><?php echo $title;?></title>
</head>
<body>
	<?php if(isset($_SESSION['login']) && $_SESSION['login'] == true) { ?>
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
					<li class="disable" xml:lang="en">Home</li>
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
	<?php } ?>
	<div id="locationbar">
		<span xml:lang="en">Home</span> di amministrazione
	</div>
	<div id="contenuto">
		<?php
		if(isset($_SESSION['login']) && $_SESSION['login'] == true)
		{ ?>
			<h2>Benvenuto nell’area di amministrazione</h2>
			<p>In quest’ area potrai gestire, aggiornare e monitorare alcune parti del sito.</p>

			<h3 xml:lang="en">News</h3>
			<p>In questa pagina si ha la possibilità di:</p>
			<ul>
				<li>aggiungere <span xml:lang="en">news</span></li>
				<li>cancellare la <span xml:lang="en">cache</span> delle <span xml:lang="en">news</span> per la <span xml:lang="en">sidebar</span></li>
				<li>cancellare le <span xml:lang="en">news</span></li>
				<li>modificare le <span xml:lang="en">news</span></li>
				<li>impostare le <span xml:lang="en">news</span> come bozza o pubblicarle</li>
			</ul>

			<h3>Immagini</h3>
			<p>In questa sezione è possibile fare l’<span lang="en">upload</span> di nuove immagini o rimuoverle dal sito.</p>

			<h3>Commenti e utenti bloccati</h3>
			<p>Nella sezione commenti è presente una lista di tutti i commenti presenti nel sito. E’ possibile bloccare un utente, specificandone il motivo (se desiderato) e conseguentemente eliminare il commento oppure eliminare solo il commento.</p>
			<p>Nella pagina utenti bloccati invece troviamo un elenco di tutti gli utenti ai quali è impedito l'inserimento dei commenti e c'è la funzione per sbloccarli.</p>

			<h3>Capitoli</h3>
			<p>Questa sezione elenca tutti i capitoli presenti, permettendo di aggiungerne di nuovi o di eliminarne.</p>

			<h3>Amministratori</h3>
			<p>In questa sezione è possibile aggiungere e rimuovere amministratori, cambiare la propria password ed aggiornare la propria <span xml:lang="it">e-mail</span>.</p>

			<p>Infine puoi ritornare al sito rimanendo loggato all’Area amministrativa o fare <span xml:lang="en">Logout</span>.</p>
		<?php
		} else { ?>
		<h1>Pagina di <span xml:lang="en">login</span></h1>
		<form action="index.php" method="post" id="loginform">
			<fieldset id="loginfields">
				<legend> <span xml:lang="en">Login</span></legend>
				<?php 
				if($wronglogin)
					echo($wrongloginmessage);
				?>
				<label for="username">Nome utente</label>: <input id="username" name="username" type="text"/><br/>
				<label for="password"><span xml:lang="en">Password</span></label>: <input id="password" name="password" type="password"/><br/>
				<input value="Login" type="submit"/>
				<input value="Cancella" type="reset"/> 
			</fieldset>
		</form>
		<a href="../">Torna al sito</a>
		<?php
		} ?>
	</div>
</body>
</html>
