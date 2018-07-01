<?php require_once __DIR__ . "/../../php/connection.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<?php
header('Content-type: application/xhtml+xml');
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['login']) || !($_SESSION['login'] === true)) {
  $_SESSION['error'] = "Sessione invalida";
  header("Location: sessione_scaduta.html");
  session_unset();
  session_destroy();
  exit();
}
?>

  <head>
    <title>Amministratori</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="gestione_amministratori" content="Pagina di gestione degli amministratori" />
    <meta name="author" content="DASISTEMARE" />
    <link href="../../css/administrator.css" rel="stylesheet" type="text/css" media="handheld, screen" />
    <!-- <link href="../css/small.css" type="text/css" rel="stylesheet" media="handheld, screen and (max-width:480px),only screen and (max-device-width:480px)" /> -->
    <!-- <link href="../css/print.css" type="text/css" rel="stylesheet" media="print" /> -->
    <!-- <script src="../scripts/script.js" type="text/javascript" charset="utf-8"></script> -->
  </head>

  <body>
    <header>
      <div class="row">
        <img src="../../images/logo.jpg" alt="logo azienda" id="logo-img" />
        <ul id="navbar">
          <li><a href="adminHome.php" lang="en" tabindex="1">Pannello amministrazione</a></li>
          <li><a href="adminProdotti.php" lang="en" tabindex="1">Prodotti</a></li>
          <li><a href="adminServizi.php" tabindex="5">Servizi</a></li>
          <li><a href="adminOrdini.php" tabindex="7">Ordini</a></li>
          <li><a href="adminPrenotazioni.php" tabindex="9">Prenotazioni</a></li>
          <li><a href="adminClienti.php" tabindex="11">Clienti</a></li>
          <li class="active"><a href="adminAmministratori.php" tabindex="11">Amministratori</a></li>
        </ul>
      </div>

      <div id="breadcrumb">
        <p id="path" tabindex="12">Ti trovi in: Amministratori</p>
        <a id="logout" href="adminHome.php?logout=true" xml:lang="en">Logout</a>
        <a id="toSite" href="../">Torna al sito</a>
      </div>
    </header>

    <div class="spacer">
      &nbsp;
    </div>

    <div class="grains">
      <div id="description">
        <h3>Benvenuto nella pagina di gestione delle coltivazioni.</h3>
        <p>In questa pagina &egrave; possibile inserirle, modificarle ed eliminarle.
          <br/> &Egrave; anche possibile cambiarne solo la disponibilit&agrave; e il prezzo.</p>
      </div>

      <?php
    $connection = new DBConnection();
    $connection->openConnection();
      
      // $index = 0;         //forse non serve
      // $grainForPage = 10; //grani da mostrare per pagina
    $grains = $connection->getListGrains();

    if ($grains != null) {
      foreach ($grains as $grain) {
        echo '<div class="grain-section">';
        echo '<h1 tabindex="10">' . $grain['nome'] . '</h1>';
        echo '<a class="button" title="removing admin ' . $admin['email'] . '"' . ' href="adminManager.php?remove=' . $admin['email'] . '" >Elimina</a></li>';
        echo '<p tabindex="10">' . $grain['descrizione'] . '</p>';
        // echo '<img src="../images/' . $grain['immagine'] . '" alt="immagine del ' . $grain['nome'] . '"/>';
        echo '</div>';
      }
    } else echo '<p>Nessun grano ora in produzione</p>'
    ?>

    </div>










    <div id="go-to-menu">
      <a href="#story">Torna su</a>
    </div>
    <footer>
      <div class="shrink-center">
        <img id="xhtmlvalid" src="../images/valid-xhtml10.png" lang="en" alt="XHTML valid" />
        <p>Da pensare a cosa scriverci</p>
        <img id="cssvalid" src="../images/vcss-blue.gif" lang="en" alt="CSS valid" />
      </div>
    </footer>


    <?php $connection->closeconnection(); ?>
  </body>


</html>
