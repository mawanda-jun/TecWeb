<?php
if (session_status() == PHP_SESSION_NONE) { session_start(); }
$returnpage = $_SERVER['HTTP_REFERER'];
require_once('imageuploadfunction.php');
if(!isset($_FILES["fileupload"]))
	die();
$ris = imageupload("../images/news/", $_FILES["fileupload"]);
if($ris['result']) {
	header("Location: ".$returnpage);
	die();
}

//trasferisco alla pagina di errore
$_SESSION['error'] = $ris['text'];
header("Location: error.php");
die();
?>

