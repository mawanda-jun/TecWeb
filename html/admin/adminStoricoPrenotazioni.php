<?php require_once __DIR__ . "/../../php/connection.php"; ?>
<?php require_once('../../validation/validator.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<?php
header('Content-type: application/xhtml+xml');
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isAdmin()) {
  $_SESSION['error'] = "Sessione invalida";
  header("Location: sessione_scaduta.html");
  session_unset();
  session_destroy();
  exit();
}
?>

  <head>
    <title>Storico prenotazioni</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Pagina di gestione delle prenotazioni passate" />
    <meta name="author" content="Tecwweb&amp;Pastorizia" />
    <meta name="keywords" content="agricoltura, azienda, agricola, grano, duro, biologico, HTML, CSS, JavaScript, MySQL, informatica"
    />
    <link rel="icon" type="image/png" href="../../images/icon/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="../../images/icon/favicon-16x16.png" sizes="16x16" />
    <link href="../../css/administrator.css" rel="stylesheet" type="text/css" media="handheld, screen" />
    <!-- <link href="../css/small.css" type="text/css" rel="stylesheet" media="handheld, screen and (max-width:480px),only screen and (max-device-width:480px)" /> -->
    <!-- <link href="../css/print.css" type="text/css" rel="stylesheet" media="print" /> -->
  </head>

  <body>
    <header>
      <div class="row">
        <img src="../../images/logo.jpg" alt="logo azienda" id="logo-img" />
        <ul id="navbar">
          <li><a href="adminHome.php" lang="en" tabindex="1">Pannello amministrazione</a></li>
          <li><a href="adminProdotti.php" lang="en" tabindex="1">Prodotti</a></li>
          <li><a href="adminServizi.php" tabindex="5">Servizi</a></li>
          <li class="active"><a href="adminStoricoPrenotazioni.php" tabindex="7">Storico prenotazioni</a></li>
          <li><a href="adminPrenotazioni.php" tabindex="9">Prenotazioni</a></li>
          <li><a href="adminClienti.php" tabindex="11">Clienti</a></li>
          <li><a href="adminAmministratori.php" tabindex="11">Amministratori</a></li>
        </ul>
      </div>

      <div id="breadcrumb">
        <p id="path" tabindex="12">Ti trovi in: Amministrazione > Storico prenotazioni</p>
        <a id="logout" href="adminHome.php?logout=true" xml:lang="en">Logout</a>
        <a id="toSite" href="../">Torna al sito</a>
      </div>
    </header>

    <div class="spacer">
      &nbsp;
    </div>


    <div class="reservations">
      <div id="description">
        <h1>Benvenuto nella pagina di gestione delle prenotazioni passate</h1>
        <p>In questa pagina &egrave; possibile visionare le prenotazioni passate di un macchinario.</p>
      </div>

      <?php if(isset($_SESSION['isError']) && $_SESSION['isError']) {
        echo '<p id="error">' . $_SESSION['error'] . '</p>';
        $_SESSION['isError'] = false;
      }
      
      $connection = new DBConnection();
        $connection->openConnection();
        date_default_timezone_set("Europe/Rome");

        $prenotations = $connection->getListPastPrenotations();

        
        if ($prenotations != null) {
          echo '<h2 tabindex="10" id="subtitle">Prenotazioni passate:</h2>';
          foreach ($prenotations as $prenotation) {
            echo '<div class="grain-section">';
            $machine = $connection->getMachine($prenotation['idMacchinario']);
            $client = $connection->getClient($prenotation['idCliente']);
            echo '<h3 tabindex="10">Ordine #' . $prenotation['ordine'] . '</h3>';
            echo '<h4 tabindex="10">Macchinario: ' . $machine['nome'] . ' ' . $machine['modello'] .'</h4>';
            echo '<h4 tabindex="10">Cliente: ' . $client['nome'] . ' ' . $client['cognome'] .'</h4>';
            echo '<p tabindex="10">ID cliente: ' . $prenotation['idCliente'] . '</p>';
            echo '<p tabindex="10">ID macchinario: ' . $prenotation['idMacchinario'] . '</p>';
            echo '<p tabindex="10">Data inizio prenotazione: ' . $prenotation['dataInizio'] . '</p>';
            echo '<p tabindex="10">Data fine prenotazione: ' . $prenotation['dataFine'] . '</p>';
            echo '</div>';
          }
        } else echo '<p>Nessuna prenotazione nel database.</p>'; ?>
<?php $connection->closeConnection(); ?>
    </div>


    <div id="go-to-menu">
      <a href="#story">Torna su</a>
    </div>
    <footer>
      <div id="site_info">
        <img id="xhtmlvalid" src="../../images/valid-xhtml10.png" lang="en" alt="XHTML valid" />
        <img id="cssvalid" src="../../images/vcss-blue.gif" lang="en" alt="CSS3 valid" />
        <a href="admin/adminHome.php" id="admin" tabindex="12">Pannello di amministrazione</a>
        <p>Progetto didattico del corso Tecnologie <span xml:lang="en">web</span> prodotto da:</p>
        <ul id="collaborators">
          <li>Manuel Vianello - 1102467</li>
          <li>Stefano Panozzo - 1097068</li>
          <li>Giovanni Cavallin - 1148957</li>
        </ul>
      </div>
    </footer>
    <!-- </div> -->



  </body>


</html>