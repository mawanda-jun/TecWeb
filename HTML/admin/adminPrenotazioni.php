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
          <li><a href="adminOrdini.php" tabindex="7">Ordini</a></li>
          <li class="active"><a href="adminPrenotazioni.php" tabindex="9">Prenotazioni</a></li>
          <li><a href="adminClienti.php" tabindex="11">Clienti</a></li>
          <li><a href="adminAmministratori.php" tabindex="11">Amministratori</a></li>
        </ul>
      </div>

      <div id="breadcrumb">
        <p id="path" tabindex="12">Ti trovi in: Amministrazione > Prenotazioni</p>
        <a id="logout" href="adminHome.php?logout=true" xml:lang="en">Logout</a>
        <a id="toSite" href="../">Torna al sito</a>
      </div>
    </header>

    <div class="spacer">
      &nbsp;
    </div>


    <div class="reservations">
      <div id="description">
        <h1>Benvenuto nella pagina di gestione delle prenotazioni</h1>
      </div>

      <?php
        $connection = new DBConnection();
        $connection->openConnection();
        date_default_timezone_set("Europe/Rome");

        $prenotations = $connection->getListActivePrenotations();

        
        if ($prenotations != null) {
          echo '<h2 tabindex="10" id="subtitle">Prenotazioni attive:</h2>';
          foreach ($prenotations as $prenotation) {
            echo '<div class="grain-section">';
            $activeMachinery = $connection->getMachine($prenotation['idMacchinario']);
            echo '<h3 tabindex="10">Ordine #' . $prenotation['ordine'] . '</h3>';
            echo '<h4 tabindex="10">' . $activeMachinery['nome'] . ' ' . $activeMachinery['modello'] .'</h4>';
            echo '<p tabindex="10">ID cliente: ' . $prenotation['idCliente'] . '</p>';
            echo '<p tabindex="10">ID macchinario: ' . $prenotation['idMacchinario'] . '</p>';
            echo '<p tabindex="10">Data inizio prenotazione: ' . $prenotation['dataInizio'] . '</p>';
            echo '<p tabindex="10">Data fine prenotazione: ' . $prenotation['dataFine'] . '</p>';
            echo '<a class="button" title="Rimuovi ' . $prenotation['ordine'] . '"' . ' href="prenotationManager.php?remove=' . $prenotation['ordine'] . '" >Elimina prenotazione</a>';
            echo '</div>';
          }
        } else echo '<p>Nessuna prenotazione attiva al momento.</p>'; ?>

        <div class="add-reservation" id="addClient">
          <h2>Aggiungi una prenotazione</h2>
          <form id="insertPrenotation" action="prenotationManager.php" method="post">
            <!-- onsubmit="return validateFormInsertAdmin()"> da usare quando e se avremo uno script di validazione -->
            <fieldset id="prenotationFields">
              <?php
        $clients = $connection->getListClients();
        echo '<form id="form" method="post" class="listClientAndReserve">Lista dei clienti:';
        if ($clients != null) { ?>
                <select name="clientID" id="clientID">
                  <?php foreach ($clients as $client) {
                echo '<option value="' . $client['id'] . '" ';
                echo (isset($_POST['clientID']) && $_POST['clientID'] == $client['id']) ? 'selected="' . $_POST['clientID'] . '"' : '';
                echo '>' . $client['id'] . ' - ' . $client['nome'] . ' ' . $client['cognome'] .'</option>';
            }
            echo '</select></form>';
        } else
            echo '<div id="notRegisteredClient">Non ci sono clienti registrati! Registrane prima uno.</div>';
        echo '<p>Se il cliente non è presente nella lista, inseriscilo <a href="adminClienti.php#addClient">qui</a> prima di continuare.</p>';
        
        $machines = $connection->getListMachinery();
        echo '<form id="form" method="post">Lista dei macchinari:';
        if ($machines != null) { ?>
                  <select name="machineID" id="machineID">
                    <?php foreach ($machines as $machine) {
            echo '<option value="' . $machine['codice'] . '" ';
            echo (isset($_POST['machineID']) && $_POST['machineID'] == $machine['codice']) ? 'selected="' . $_POST['machineID'] . '"' : '';
            echo '>' . $machine['nome'] . ' ' . $machine['modello'] . '</option>';
          }
          echo '</select></form>';
        } else
            echo '<div id="notRegisteredMachine">Non ci sono macchinari registrati! Registrane prima uno.</div>';
        ?>
                    <fieldset>
                      <legend>Scegli le date della prenotazione:</legend>
                      <ul>
                        <li>
                          <label for="start">Inizio</label>
                          <input type="date" id="start" name="start" value="<?php echo date('d/m/Y') ?>" min="<?php echo date('d/m/Y') ?>"
                          />
                        </li>
                        <li>
                          <label for="end">Fine</label>
                          <input type="date" id="end" name="end" value="<?php echo date('d/m/Y') ?>" min="<?php echo date('d/m/Y') ?>" />
                        </li>
                      </ul>
                    </fieldset>

                    <input type="submit" id="submit" value="Aggiungi prenotazione" name="submit" />

                    <!-- <input type="reset" value="Cancella i campi" name="reset"/> -->
            </fieldset>
          </form>
        </div>



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
