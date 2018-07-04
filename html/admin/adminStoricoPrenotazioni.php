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
    <link rel="icon" type="image/png" href="../../images/icon/favicon-32x32.png" />
    <link rel="icon" type="image/png" href="../../images/icon/favicon-16x16.png" />
    <link href="../../css/administrator.css" rel="stylesheet" type="text/css" media="handheld, screen" />
    <!-- <link href="../css/small.css" type="text/css" rel="stylesheet" media="handheld, screen and (max-width:480px),only screen and (max-device-width:480px)" /> -->
    <!-- <link href="../css/print.css" type="text/css" rel="stylesheet" media="print" /> -->
  </head>

  <body>
    <div id="header">
      <div class="row">
        <img src="../../images/logo.jpg" alt="logo azienda" id="logo-img" />
        <ul id="navbar">
          <li><a href="adminHome.php" lang="en">Pannello amministrazione</a></li>
          <li><a href="adminProdotti.php" lang="en">Prodotti</a></li>
          <li><a href="adminServizi.php">Servizi</a></li>
          <li class="active"><a href="adminStoricoPrenotazioni.php">Storico prenotazioni</a></li>
        </ul>
        <ul id="navbar2">
          <li><a href="adminPrenotazioni.php">Prenotazioni</a></li>
          <li><a href="adminClienti.php">Clienti</a></li>
          <li><a href="adminAmministratori.php">Amministratori</a></li>
        </ul>
      </div>

      <div id="breadcrumb">
        <p id="path">Ti trovi in: Amministrazione > Storico prenotazioni</p>
        <a id="logout" href="adminHome.php?logout=true" xml:lang="en">Logout</a>
        <a id="toSite" href="../">Torna al sito</a>
      </div>
    </div>

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
          echo '<h2 id="subtitle">Prenotazioni passate:</h2>';
          foreach ($prenotations as $prenotation) {
            echo '<div class="grain-section">';
            $machine = $connection->getMachine($prenotation['idMacchinario']);
            $client = $connection->getClient($prenotation['idCliente']);
            echo '<h3>Ordine #' . $prenotation['ordine'] . '</h3>';
            echo '<h4>Macchinario: ' . $machine['nome'] . ' ' . $machine['modello'] .'</h4>';
            echo '<h4>Cliente: ' . $client['nome'] . ' ' . $client['cognome'] .'</h4>';
            echo '<p>ID cliente: ' . $prenotation['idCliente'] . '</p>';
            echo '<p>ID macchinario: ' . $prenotation['idMacchinario'] . '</p>';
            echo '<p>Data inizio prenotazione: ' . $prenotation['dataInizio'] . '</p>';
            echo '<p>Data fine prenotazione: ' . $prenotation['dataFine'] . '</p>';
            echo '</div>';
          }
        } else echo '<p>Nessuna prenotazione nel database.</p>'; ?>
      <?php $connection->closeConnection(); ?>
    </div>


    <div id="go-to-menu">
      <a href="#story">Torna su</a>
    </div>
    <div id="footer">
      <div id="site_info">
        <img id="xhtmlvalid" src="../../images/valid-xhtml10.png" lang="en" alt="XHTML valid" />
        <img id="cssvalid" src="../../images/vcss-blue.gif" lang="en" alt="CSS3 valid" />
        <p>Progetto didattico del corso Tecnologie <span xml:lang="en">web</span> prodotto da:</p>
        <ul id="collaborators">
          <li>Manuel Vianello - 1102466</li>
          <li>Stefano Panozzo - 1097068</li>
          <li>Giovanni Cavallin - 1148957</li>
        </ul>
      </div>
    </div>
    <!-- </div> -->



  </body>


</html>
