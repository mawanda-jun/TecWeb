<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<?php 
header('Content-type: application/xhtml+xml');
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
?>

<head>
  <title>Sessione scaduta</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="description" content="Pagina di amministrazione per gli amministratori" />
  <meta name="author" content="Tecwweb&amp;Pastorizia" />
  <meta name="keywords" content="agricoltura, azienda, agricola, grano, duro, biologico, HTML, CSS, JavaScript, MySQL, informatica"
  />
  <link rel="icon" type="image/png" href="../../images/icon/favicon-32x32.png" />
  <link rel="icon" type="image/png" href="../../images/icon/favicon-16x16.png" />
  <link href="../../css/administrator.css" rel="stylesheet" type="text/css" media="handheld, screen" />
</head>

<body>
<div id="header">
      <div class="row">
        <img src="../../images/logo.jpg" alt="logo azienda" id="logo-img" />
      </div>
      <div id="breadcrumb">
        <p id="path">Ti trovi in: Sessione scaduta!</p>
        <a id="toSite" href="../../index.php">Torna al sito</a>
      </div>
    </div>

    <div class="spacer">
      &nbsp;
    </div>


  <div id="content">
    <h1>Qualcosa non va...</h1>
    <p>
      <?php 
      if (isset($_SESSION['error']))
        echo $_SESSION['error'];
      else
        echo ('<p>Qualcosa &egrave; andato storto. Clicca su "Torna al sito" e andr&agrave; tutto bene.</p>');
      $_SESSION['error'] = null;
      ?>
    </p>
  </div>


  <div id="footer">
            <div id="site_info">
              <img id="xhtmlvalid" src="../../images/valid-xhtml10.png" lang="en" alt="XHTML valid" />
              <img id="cssvalid" src="../../images/vcss-blue.gif" lang="en" alt="CSS3 valid" />
              <p>Progetto didattico del corso Tecnologie <span xml:lang="en">web</span> prodotto da:</p>
              <ul id="collaborators">
                <li>Manuel Vianello - 1102467</li>
                <li>Stefano Panozzo - 1097068</li>
                <li>Giovanni Cavallin - 1148957</li>
              </ul>
            </div>
          </div>
</body>

</html>
