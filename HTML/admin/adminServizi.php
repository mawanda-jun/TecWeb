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
    <meta name="description" content="Pagina di gestione dei servizi offerti" />
    <meta name="author" content="Tecwweb&amp;Pastorizia" />
    <meta name="keywords" content="agricoltura, azienda, agricola, grano, duro, biologico, HTML, CSS, JavaScript, MySQL, informatica"
    />
    <link rel="icon" type="image/png" href="../../images/icon/favicon-32x32.png" />
    <link rel="icon" type="image/png" href="../../images/icon/favicon-16x16.png" />
    <link href="../../css/administrator.css" rel="stylesheet" type="text/css" media="handheld, screen" />
    <!-- <link href="../css/small.css" type="text/css" rel="stylesheet" media="handheld, screen and (max-width:480px),only screen and (max-device-width:480px)" /> -->
    <!-- <link href="../css/print.css" type="text/css" rel="stylesheet" media="print" /> -->
    <!-- <script src="../scripts/script.js" type="text/javascript" charset="utf-8"></script> -->
  </head>

  <body>
    <div id="header">
      <div class="row">
        <img src="../../images/logo.jpg" alt="logo azienda" id="logo-img" />
        <ul id="navbar">
          <li><a href="adminHome.php" lang="en" tabindex="1">Pannello amministrazione</a></li>
          <li><a href="adminProdotti.php" lang="en" tabindex="1">Prodotti</a></li>
          <li class="active"><a href="adminServizi.php" tabindex="5">Servizi</a></li>
          <li><a href="adminStoricoPrenotazioni.php" tabindex="7">Storico prenotazioni</a></li>
        </ul>
        <ul id="navbar2">
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
    </div>

    <div class="spacer">
      &nbsp;
    </div>

    <div class="services">
      <div id="description">
        <h1>Benvenuto nella pagina di gestione dei servizi.</h1>
        <p>In questa pagina &egrave; possibile inserire o eliminare un macchinario a disposizione. Inoltre se ne pu&ograve;
          modificare il prezzo.</p>
      </div>

      <?php if(isset($_SESSION['isError']) && $_SESSION['isError']) {
        echo '<p id="error">' . $_SESSION['error'] . '</p>';
        $_SESSION['isError'] = false;
      }
        $connection = new DBConnection();
        $connection->openConnection();
      
      echo '<div class="list-modify-delete-service">';
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
        <input type="submit" name="submitPrice" id="submit" value="Modifica prezzo" />
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
        <ul>
          <li>
            <label for="id">Codice identificativo:</label>
            <input type="text" name="id" />
          </li>
          <li>
            <label for="type">Tipo:</label>
            <input type="text" name="type" />
          </li>
          <li>
            <label for="name">Marca:</label>
            <input type="text" name="name" />
          </li>
          <li>
            <label for="model">Modello:</label>
            <input type="text" name="model" />
          </li>
          <li>
            <label for="power">Potenza:</label>
            <input type="text" name="power" />
          </li>
          <li>
            <label for="year">Anno:</label>
            <input type="text" name="year" />
          </li>
          <li>
            <label for="price">Prezzo all'ora:</label>
            <input type="text" name="price" />
          </li>
          <li>
            <label for="fileToUpload">Seleziona un'immagine dal computer:</label>
            <input type="file" name="fileToUpload" id="fileToUpload" />
          </li>
          <li>
            <input type="submit" name="submit" id="submit" value="Aggiungi macchinario" />
          </li>
        </ul>
      </form>
    </div>
    </div>



    <div id="go-to-menu">
      <a href="#story">Torna su</a>
    </div>
    <div id="footer">
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
    </div>


    <?php $connection->closeconnection(); ?>
  </body>


</html>
