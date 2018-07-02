<?php require_once __DIR__ . "/../../php/connection.php"; ?>
<?php require_once('../../validation/validator.php'); ?>
<!-- <?php require_once('../../scripts/script.js'); ?> -->

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
    <meta name="prenotazioni" content="Pagina di gestione delle prenotazioni" />
    <meta name="author" content="DASISTEMARE" />
    <link href="../../css/administrator.css" rel="stylesheet" type="text/css" media="handheld, screen" />
    <!-- <link href="../css/small.css" type="text/css" rel="stylesheet" media="handheld, screen and (max-width:480px),only screen and (max-device-width:480px)" /> -->
    <!-- <link href="../css/print.css" type="text/css" rel="stylesheet" media="print" /> -->
    <script src="../../scripts/script.js" type="text/javascript" charset="utf-8"></script>
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

        $machines = $connection->getListMachinery();
        echo '<form id="frm" method="post" class="listMachineAndReserve" onchange="onSelectChange();">Lista dei macchinari:';
        if ($machines != null) { ?>
        <select name="machineID" id="machineID">
          <?php foreach ($machines as $machine) {
                echo '<option value="' . $machine['codice'] . '" ';
                echo (isset($_POST['machineID']) && $_POST['machineID'] == $machine['codice']) ? 'selected="' . $_POST['machineID'] . '"' : '';
                echo '>' . $machine['nome'] . ' ' . $machine['modello'] . '</option>';
            }
            echo '</select></form>';
        } else
            echo '<div id="">Non ci sono macchinari registrati! Registrane prima uno.</div>';
        // echo $_POST['machineID'];
        if (isset($_POST['machineID']) && !empty($_POST['machineID']))
            echo '<div id="machinePrice">
        <p id="costo macchinario">Il costo della macchina &egrave;:'
            . $connection->getMachinePrice($_POST['machineID']) . '</p></div>';
        ?>
          <form method="post">
            <fieldset>
              <legend>Scegli le date della prenotazione:</legend>
              <div>
                <label for="start">Inizio</label>
                <input type="date" id="start" name="start" value="<?php echo date('d/m/Y') ?>" min="<?php echo date('d/m/Y') ?>"/>
              </div>

              <div>
                <label for="end">Fine</label>
                <input type="date" id="end" name="end" value="<?php echo date('d/m/Y') ?>" min="<?php echo date('d/m/Y') ?>"/>
              </div>

            </fieldset>

            <input type="submit" value="Imposta data" />
          </form>




          <h1>Aggiungi un amministratore</h1>
          <form id="insertAdmin " action="adminManager.php " method="post ">
            <!-- onsubmit="return validateFormInsertAdmin() "> da usare quando e se avremo uno script di validazione -->
            <fieldset id="adminFields ">
              <legend>Inserisci i seguenti dati:</legend>
              <label for="email "><span xml:lang="en ">Email:</span></label>
              <input name="email " type="email " id="email " size="30 " maxlength="50 " value="<?php
                                                                                                echo isset($_SESSION['email']) ? $_SESSION['email'] : '' ?>" />
              <label for="password"><span xml:lang="en">Password:</span></label>
              <input name="password" type="password" id="password" size="10" maxlength="12" />
              <input type="submit" value="Aggiungi" name="submit" />
              <div id="errorInput">
                <?php echo (isset($_SESSION['isError']) && $_SESSION['isError']) ? $_SESSION['error'] : '' ?>
              </div>
              <!-- <input type="reset" value="Cancella i campi" name="reset"/> -->
            </fieldset>
          </form>
          <?php
            $connection->closeConnection();
            ?>

    </div>


    <div id="go-to-menu">
      <a href="#story">Torna su</a>
    </div>
    <footer>
      <div class="shrink-center">
        <img id="xhtmlvalid" src="../../images/valid-xhtml10.png" lang="en" alt="XHTML valid" />
        <img id="cssvalid" src="../../images/vcss-blue.gif" lang="en" alt="CSS valid" />
        <p>Da pensare a cosa scriverci</p>
      </div>
    </footer>
    <!-- </div> -->



  </body>


</html>
