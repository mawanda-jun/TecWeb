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
  header("Location: sessione_scaduta.php");
  session_unset();
  session_destroy();
  exit();
}
?>

  <head>
    <title>Servizi</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="servizi" content="Pagina di gestione dei servizi offerti" />
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
          <li class="active"><a href="adminServizi.php" tabindex="5">Servizi</a></li>
          <li><a href="adminOrdini.php" tabindex="7">Ordini</a></li>
          <li><a href="adminPrenotazioni.php" tabindex="9">Prenotazioni</a></li>
          <li><a href="adminClienti.php" tabindex="11">Clienti</a></li>
          <li><a href="adminAmministratori.php" tabindex="11">Amministratori</a></li>
        </ul>
      </div>

      <div id="breadcrumb">
        <p id="path" tabindex="12">Ti trovi in: Servizi</p>
        <a id="logout" href="adminHome.php?logout=true" xml:lang="en">Logout</a>
        <a id="toSite" href="../">Torna al sito</a>
      </div>
    </header>

    <div class="spacer">
      &nbsp;
    </div>

    <div class="services">
      <div id="description">
        <h1>Benvenuto nella pagina di gestione dei servizi.</h1>
        <p>In questa pagina &egrave; possibile inserire o eliminare un macchinario a disposizione. Inoltre
          se ne pu&ograve; modificare il prezzo.</p>
      </div>
      <div class="list-modify-delete-service">
      <?php echo (isset($_SESSION['isError']) && $_SESSION['isError']) ? (isset($_SESSION['error']) ? $_SESSION['error'] : '') : ''; ?>
        <br/>
        <?php
        $connection = new DBConnection();
        $connection->openConnection();
      
      // $index = 0;         //forse non serve
      // $grainForPage = 10; //grani da mostrare per pagina
        $machines = $connection->getListMachinery();

        if ($machines != null) {
          foreach ($machines as $machine) {
            echo '<div class="grain-section">';
            echo '<h1 tabindex="10">' . $machine['nome'] . ' ' . $machine['modello'] . '</h1>'; ?>
          <h2>Imposta un nuovo prezzo</h2>
          <form id="insertPrice" action="serviceManager.php" method="post">
            <label for="price">Prezzo</label>
            <input name="price" type="text" id="price" size="5" value="<?php echo $machine['prezzoGiorno'] ?>" />
            <input name="machineID" type="hidden" value="<?php echo $machine['codice'] ?>" />
            <input type="submit" name="submitPrice" value="Modifica prezzo" />
          </form>
          <?php
          echo '<a class="button" title="Rimuovi ' . $machine['nome'] . '"' . ' href="serviceManager.php?remove=' . $machine['codice'] . '" >Elimina macchinario</a>';
          echo '</div>';
          // echo (isset($_SESSION['isError']) && $_SESSION['isError']) ? (isset($_SESSION['error']) ? $_SESSION['error'] : '') : '';
        }
      } else echo '<p>Nessun macchinario disponibile</p>';
      ?>
      </div>

      <div class="add-machine">
        <h1>Inserisci una nuova macchina</h1>
        <form method="post" action="serviceManager.php" enctype="multipart/form-data">
          <label for="id">Codice identificativo:</label>
          <input type="text" name="id" />

          <label for="type">Tipo:</label>
          <input type="text" name="type" />

          <label for="name">Marca:</label>
          <input type="text" name="name" />

          <label for="model">Modello:</label>
          <input type="text" name="model" />

          <label for="power">Potenza:</label>
          <input type="text" name="power" />

          <label for="year">Anno:</label>
          <input type="text" name="year" />

          <label for="price">Prezzo all'ora:</label>
          <input type="text" name="price" />

          <label for="fileToUpload">Seleziona un'immagine dal computer:</label>
          <input type="file" name="fileToUpload" id="fileToUpload" />

          <input type="submit" name="submit" value="Aggiungi" />
        </form>
      </div>




    </div>



    <div id="go-to-menu">
      <a href="#story">Torna su</a>
    </div>
    <footer>
      <div class="shrink-center">
        <img id="xhtmlvalid" src="../../images/valid-xhtml10.png" lang="en" alt="XHTML valid" />
        <img id="cssvalid" src="../../images/vcss-blue.gif" lang="en" alt="CSS valid" />
        <p>Da pensare a cosa scriverci</p>
        <!-- <?php echo (isset($_SESSION['file_exists']) && $_SESSION['file_exists']) ? $_SESSION['file_exists'] : ''; ?><br/>
        <?php echo (isset($_SESSION['maxSize']) && $_SESSION['maxSize']) ? $_SESSION['maxSize'] : ''; ?><br/>
        <?php echo (isset($_SESSION['noExtension']) && $_SESSION['noExtension']) ? $_SESSION['noExtension'] : ''; ?><br/>
        <?php echo (isset($_SESSION['noCharacter']) && $_SESSION['noCharacter']) ? $_SESSION['noCharacter'] : ''; ?><br/>
        <?php echo (isset($_SESSION['getImageType']) && $_SESSION['getImageType']) ? $_SESSION['getImageType'] : ''; ?><br/>
        <?php echo (isset($_SESSION['fileName']) && $_SESSION['fileName']) ? $_SESSION['fileName'] : ''; ?><br/>
        <?php echo (isset($_SESSION['file']) && $_SESSION['file']) ? $_SESSION['file'] : ''; ?><br/>
        <?php echo (isset($_SESSION['fileName1']) && $_SESSION['fileName1']) ? $_SESSION['fileName1'] : ''; ?><br/>
        <?php echo (isset($_SESSION['file1']) && $_SESSION['file1']) ? $_SESSION['file1'] : ''; ?><br/> -->
      </div>
    </footer>


    <?php $connection->closeconnection(); ?>
  </body>


</html>
