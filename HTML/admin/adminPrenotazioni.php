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
  <title>Prenotazioni</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="description" content="Pagina di gestione delle prenotazioni" />
  <meta name="author" content="Tecwweb&amp;Pastorizia" />
  <meta name="keywords" content="agricoltura, azienda, agricola, grano, duro, biologico, HTML, CSS, JavaScript, MySQL, informatica" />
  <link rel="icon" type="image/png" href="../../images/icon/favicon-32x32.png" />
  <link rel="icon" type="image/png" href="../../images/icon/favicon-16x16.png" />
  <link href="../../css/administrator.css" rel="stylesheet" type="text/css" media="handheld, screen" />


</head>

<body>
  <div id="header">
    <div class="row">
      <img src="../../images/logo.jpg" alt="logo azienda" id="logo-img" />
      <ul id="navbar">
        <li><a href="adminHome.php" lang="en">Pannello amministrazione</a></li>
        <li><a href="adminProdotti.php" lang="en">Prodotti</a></li>
        <li><a href="adminServizi.php">Servizi</a></li>
        <li><a href="adminStoricoPrenotazioni.php">Storico prenotazioni</a></li>
      </ul>
      <ul id="navbar2">
        <li class="active"><a href="adminPrenotazioni.php">Prenotazioni</a></li>
        <li><a href="adminClienti.php">Clienti</a></li>
        <li><a href="adminAmministratori.php">Amministratori</a></li>
      </ul>
    </div>

    <div id="breadcrumb">
      <p id="path">Ti trovi in: Amministrazione > Prenotazioni</p>
      <a id="logout" href="adminHome.php?logout=true" xml:lang="en">Logout</a>
      <a id="toSite" href="../../index.php">Torna al sito</a>
    </div>
  </div>

  <div class="spacer">
    &nbsp;
  </div>


  <div class="reservations">
    <div id="description">
      <h1>Benvenuto nella pagina di gestione delle prenotazioni</h1>
      <p>In questa pagina &egrave; possibile inserire ed eliminare una prenotazione se il macchinario
        &egrave; disponibile
        nel periodo indicato.</p>
      <p>Prima di procedere con la prenotazione, ricordati di inserire il nuovo cliente se questo non
        &egrave; gi&agrave;
        presente nel database.</p>
    </div>

    <?php if (isset($_SESSION['isError']) && $_SESSION['isError']) {
        echo '<p id="error">' . $_SESSION['error'] . '</p>';
        $_SESSION['isError'] = false;
      }

      $connection = new DBConnection();
      $connection->openConnection();
      date_default_timezone_set("Europe/Rome");

      $prenotations = $connection->getListActivePrenotations();


      if ($prenotations != null) {
        echo '<h2 id="subtitle">Prenotazioni attive:</h2>';
        foreach ($prenotations as $prenotation) {
          echo '<div class="grain-section">';
          $activeMachinery = $connection->getMachine($prenotation['idMacchinario']);
          echo '<h3>Ordine #' . $prenotation['ordine'] . '</h3>';
          echo '<h4>Macchinario: ' . $activeMachinery['nome'] . ' ' . $activeMachinery['modello'] . '</h4>';
          echo '<p>ID cliente: ' . $prenotation['idCliente'] . '</p>';
          echo '<p>ID macchinario: ' . $prenotation['idMacchinario'] . '</p>';
          echo '<p>Data inizio prenotazione: ' . $prenotation['dataInizio'] . '</p>';
          echo '<p>Data fine prenotazione: ' . $prenotation['dataFine'] . '</p>';
          echo '<a class="button" title="Rimuovi ' . $prenotation['ordine'] . '"' . ' href="prenotationManager.php?remove=' . $prenotation['ordine'] . '" >Elimina prenotazione</a>';
          echo '</div>';
        }
      } else echo '<p id="reservations-message">Nessuna prenotazione attiva al momento.</p>'; ?>

    <div class="add-reservation" id="addClient">
      <h2>Aggiungi una prenotazione</h2>
      <form id="insertPrenotation" action="prenotationManager.php" method="post">

        <fieldset id="prenotationFields">
          <?php
            $clients = $connection->getListClients();
            echo '<label for="clientID">Lista dei clienti: </label>';
            if ($clients != null) { ?>
          <select name="clientID" id="clientID">
            <?php foreach ($clients as $client) {
                  echo '<option value="' . $client['id'] . '" ';
                  echo (isset($_POST['clientID']) && $_POST['clientID'] == $client['id']) ? 'selected="' . $_POST['clientID'] . '"' : '';
                  echo '>' . $client['id'] . ' - ' . $client['nome'] . ' ' . $client['cognome'] . '</option>';
                }
                echo '</select>';
              } else
                echo '<div id="notRegisteredClient">Non ci sono clienti registrati! Registrane prima uno.</div>';
              echo '<p>Se il cliente non è presente nella lista, inseriscilo <a href="adminClienti.php#addClient">qui</a> prima di continuare.</p>';

              $machines = $connection->getListMachinery();
              echo '<label for="machineID">Lista dei macchinari: </label>';
              if ($machines != null) { ?>
            <select name="machineID" id="machineID">
              <?php foreach ($machines as $machine) {
                    echo '<option value="' . $machine['codice'] . '" ';
                    echo (isset($_POST['machineID']) && $_POST['machineID'] == $machine['codice']) ? 'selected="' . $_POST['machineID'] . '"' : '';
                    echo '>' . $machine['nome'] . ' ' . $machine['modello'] . '</option>';
                  }
                  echo '</select>';
                } else
                  echo '<div id="notRegisteredMachine">Non ci sono macchinari registrati! Registrane prima uno.</div>';
                ?>
              <fieldset>
                <legend>Scegli le date della prenotazione:</legend>
                <ul>
                  <li>
                    <label for="start">Inizio</label>
                    <input type="date" id="start" name="start" value="<?php echo date('d/m/Y') ?>" min="<?php echo date('d/m/Y') ?>" />
                  </li>
                  <li>
                    <label for="end">Fine</label>
                    <input type="date" id="end" name="end" value="<?php echo date('d/m/Y') ?>" min="<?php echo date('d/m/Y') ?>" />
                  </li>
                </ul>
              </fieldset>

              <?php 
                  if (isset($_POST['machineID']) && isset($_POST['client'])) {
                    echo '<input name="machineID" type="hidden" value="' . $_POST['machineID'] . '"/>';
                    echo '<input name="clientID" type="hidden" value="' . $_POST['clientID'] . '"/>';
                  } ?>
              <input type="submit" id="submit" value="Aggiungi prenotazione" name="submit" />


        </fieldset>
      </form>
    </div>



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
        <li>Manuel Vianello - 1102467</li>
        <li>Stefano Panozzo - 1097068</li>
        <li>Giovanni Cavallin - 1148957</li>
      </ul>
    </div>
  </div>




</body>


</html>
