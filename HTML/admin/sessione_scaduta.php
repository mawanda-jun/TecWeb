<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<?php 
header('Content-type: application/xhtml+xml');
if (session_status() == PHP_SESSION_NONE) { session_start(); }
?>

<head>
  <title>Pannello amministrazione</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="description" content="Pagina di amministrazione per gli amministratori" />
  <meta name="author" content="Tecwweb&amp;Pastorizia" />
  <meta name="keywords" content="agricoltura, azienda, agricola, grano, duro, biologico, HTML, CSS, JavaScript, MySQL, informatica">
  <link rel="icon" type="image/png" href="../../images/icon/favicon-32x32.png" sizes="32x32" />
  <link rel="icon" type="image/png" href="../../images/icon/favicon-16x16.png" sizes="16x16" />
  <link href="../../css/administrator.css" rel="stylesheet" type="text/css" media="handheld, screen" />
  <!-- <link href="../css/small.css" type="text/css" rel="stylesheet" media="handheld, screen and (max-width:480px),only screen and (max-device-width:480px)" /> -->
  <!-- <link href="../css/print.css" type="text/css" rel="stylesheet" media="print" /> -->
  <!-- <script src="../scripts/script.js" type="text/javascript" charset="utf-8"></script> -->
</head>

<body>
  <div id="content">
    <h1>Qualcosa non va...</h1>
    <p>
      <?php 
      if(isset($_SESSION['error'])) 
        echo $_SESSION['error'];
      else 
        echo('Qualcosa &egrave; andato storto. Clicca sul logo e andr&agrave; tutto bene.'); 
      $_SESSION['error'] = null;
      ?>
    </p>
    <!-- <img id="imageerr" src="../images/err404.jpg" alt="Immagine di errore"/> <br/> -->
    <!-- <a href="index.php">Torna alla pagina di amministrazione del sito</a> <br/> -->
    <!-- <a id="backpage" href="javascript:history.back()">Ritorna alla pagina precedente</a> -->
  </div>
</body>

</html>
