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

if(isset($_GET['id']))
{
	$edit = true;
	$dbConnection = new DBAccess();
	$dbConnection->openDBConnection();
	$news = $dbConnection->getArticle($_GET['id']);
	$dbConnection->closeDBConnection();
	$title = "Modifica news - Touhou Italia";
	$titleh2 = "Modifica news";
}
else
{
	$edit = false;
	$title = "Inserimento news - Touhou Italia";
	$titleh2 = "Inserimento news";
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

	<meta http-equiv="Content-Script-Type" content="text/javascript"/>
	<script type="text/javascript" src="../script/script.js"></script>
<title><?php echo $title; ?></title>
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
	<span xml:lang="en">Home</span> di amministrazione &gt;&gt;&gt; <span xml:lang="en">News</span> &gt;&gt;&gt; <?php  echo $titleh2;?>
	</div>
	<div id="contenuto">
	<h2><?php echo $titleh2;?></h2>
		<div id="newsadd">
			<form id="addnewsform" action="newsaction.php" method="post" enctype="multipart/form-data" onsubmit="return validateFormAddNews()">
                <fieldset>
					<legend>Inserimento dei dati della notizia:</legend>
<?php if($edit)
echo('<input name="id" class="hidden" id="idform" type="text" value="'.$news['id'].'"/>'); ?>
                    <label for="titleform">Titolo</label>: <input name="title" id="titleform" type="text"  size="20" maxlength="40" onchange="validateString('titolo',document.getElementById('titleform').value)" value="<?php if($edit) echo($news['title'])?>"/>
                    <div id="erroretitolo"></div>
                    <label for="imageform">Titolo con relativa estensione dell'immagine da usare in copertina</label>: <input name="image" id="imageform" type="text"  size="20" maxlength="25" onchange="validateStringImage(document.getElementById('imageform').value, document.getElementById('fileupload').files.length)" value="<?php if($edit) echo($news['image'])?>"/>
                    <div id="erroretitoloimmagine"></div>
                    Oppure<br/>
					<label for="fileupload">Carica nuova immagine, ignorando il box di input precedente</label>:
                    <input type="file" name="fileupload" id="fileupload" onchange="validateStringImage(document.getElementById('imageform').value, document.getElementById('fileupload').files.length)" /><br/>
                    <label for="imgdescrform">Descrizione breve dell'immagine</label>: <input name="imgdescr" type="text" id="imgdescrform"  size="20" maxlength="40" value="<?php if($edit) echo ($news['imgdescr'])?>"/>
                    <div id="erroredescrizione"></div>
                    Nota: utilizzare <a href="image.php">gestione immagini</a> per caricare nuove immagini da inserire all'intero del testo usando il <span xml:lang="en">tag</span> &lt;a&gt;<br/>
					<input name="hidden" id="hiddenform" type="checkbox" <?php if($edit) if($news['hidden'] == true) echo('checked="checked"');?>/><label for="hiddenform"> Bozza</label><br/>
					<label for="textform">Testo</label>: <br/><textarea name="text" id="textform" cols="100" rows="10" onchange="validateString('testo',document.getElementById('textform').value)" ><?php if($edit) echo(htmlentities($news['text']));?></textarea>
                    <div id="erroretesto"></div>
					<input type="submit" value="Salva" name="submit"/>
                    <div id="erroreAdd"></div>
				</fieldset>
			</form>
		</div>
	</div>
</body>
</html>

