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
  <meta name="keywords" content="agricoltura, azienda, agricola, grano, duro, biologico, HTML, CSS, JavaScript, MySQL, informatica" />
  <link rel="icon" type="image/png" href="../../images/icon/favicon-32x32.png" />
  <link rel="icon" type="image/png" href="../../images/icon/favicon-16x16.png" />
  <link href="../../css/administrator.css" rel="stylesheet" type="text/css" media="handheld, screen" />
  <link href="../../css/small.css" type="text/css" rel="stylesheet" media="handheld, screen and (max-width:720px),only screen and (max-device-width:720px)"
  />
  <link href="../../css/print.css" type="text/css" rel="stylesheet" media="print" />
  <script src="../../scripts/script.js" type="text/javascript" charset="utf-8"></script>


</head>

<body>
  <div id="header">
    <div class="row">
      <img src="../../images/logo.jpg" alt="logo azienda" id="logo-img" />
      <ul id="navbar">
        <li><a href="adminHome.php" lang="en">Pannello amministrazione</a></li>
        <li><a href="adminProdotti.php" lang="en">Prodotti</a></li>
        <li class="active"><a href="adminServizi.php">Servizi</a></li>
        <li><a href="adminStoricoPrenotazioni.php">Storico prenotazioni</a></li>
      </ul>
      <ul id="navbar2">
        <li><a href="adminPrenotazioni.php">Prenotazioni</a></li>
        <li><a href="adminClienti.php">Clienti</a></li>
        <li><a href="adminAmministratori.php">Amministratori</a></li>
      </ul>

      <div class="dropdown">
        <a id="menu-link" href="#anchor-bottom">
          <button onclick="myFunction()" class="dropbtn">Menu</button>
        </a>
        <div id="myDropdown" class="dropdown-content">
          <ul>
            <li><a href="adminHome.php" lang="en">Pannello amministrazione</a></li>
            <li><a href="adminProdotti.php" lang="en">Prodotti</a></li>
            <li class="active"><a href="adminServizi.php">Servizi</a></li>
            <li><a href="adminStoricoPrenotazioni.php">Storico prenotazioni</a></li>
            <li><a href="adminPrenotazioni.php">Prenotazioni</a></li>
            <li><a href="adminClienti.php">Clienti</a></li>
            <li><a href="adminAmministratori.php">Amministratori</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div id="breadcrumb">
      <p id="path">Ti trovi in: Amministrazione > Servizi</p>
      <a id="logout" href="adminHome.php?logout=true" xml:lang="en">Logout</a>
      <a id="toSite" href="../../index.php">Torna al sito</a>
    </div>
  </div>

  <div id="admin-spacer" class="spacer">
    &nbsp;
  </div>

  <div class="services">
    <div id="print-content">
      <h1 id="print-title">Azienda agricola Cavallin</h1>
      <p id="print-path">Ti trovi in: Amministrazione > Servizi</p>
    </div>
    <div id="description">
      <h1>Benvenuto nella pagina di gestione dei servizi</h1>
      <p>In questa pagina &egrave; possibile inserire o eliminare un macchinario a disposizione. Inoltre se
        ne pu&ograve;
        modificare il prezzo.</p>
    </div>

    <?php if (isset($_SESSION['isError']) && $_SESSION['isError']) {
        echo '<p id="error">' . $_SESSION['error'] . '</p>';
        $_SESSION['isError'] = false;
      }
      $connection = new DBConnection();
      $connection->openConnection();

      echo '<div class="list-modify-delete-service">';
      $machines = $connection->getListMachinery();

      if ($machines != null) {
        foreach ($machines as $machine) {
          echo '<div id="admin-machine" class="grain-section">';
          echo '<h2>' . $machine['nome'] . ' ' . $machine['modello'] . '</h2>'; ?>
    <h3>Imposta un nuovo prezzo</h3>
    <form id="insertPrice" action="serviceManager.php" method="post">
      <label for="price <?php echo $machine['nome'] ?>">Prezzo: </label>
      <input name="price" type="text" id="price <?php echo $machine['nome'] ?>" size="5" value="<?php echo $machine['prezzoGiorno'] ?>" />
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
    <h2>Inserisci una nuova macchina</h2>
    <form method="post" action="serviceManager.php" enctype="multipart/form-data">
      <ul>
        <li>
          <label for="id">Codice identificativo:</label>
          <input type="text" name="id" id="id" />
        </li>
        <li>
          <label for="type">Tipo:</label>
          <input type="text" name="type" id="type" />
        </li>
        <li>
          <label for="name">Marca:</label>
          <input type="text" name="name" id="name" />
        </li>
        <li>
          <label for="model">Modello:</label>
          <input type="text" name="model" id="model" />
        </li>
        <li>
          <label for="power">Potenza:</label>
          <input type="text" name="power" id="power" />
        </li>
        <li>
          <label for="year">Anno:</label>
          <input type="text" name="year" id="year" />
        </li>
        <li>
          <label for="price">Prezzo all'ora:</label>
          <input type="text" name="price" id="price" />
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
      <p>Progetto didattico del corso Tecnologie <span xml:lang="en">web</span> prodotto da:</p>
      <ul id="collaborators">
        <li>Manuel Vianello - 1102467</li>
        <li>Stefano Panozzo - 1097068</li>
        <li>Giovanni Cavallin - 1148957</li>
      </ul>
    </div>
  </div>

  <div class="bottom-section">
    <ul id="navbarBottom">
      <li id="anchor-bottom"></li>
      <li><a href="adminHome.php" lang="en">Pannello amministrazione</a></li>
      <li><a href="adminProdotti.php" lang="en">Prodotti</a></li>
      <li class="active"><a href="adminServizi.php">Servizi</a></li>
      <li><a href="adminStoricoPrenotazioni.php">Storico prenotazioni</a></li>
      <li><a href="adminPrenotazioni.php">Prenotazioni</a></li>
      <li><a href="adminClienti.php">Clienti</a></li>
      <li><a href="adminAmministratori.php">Amministratori</a></li>
    </ul>
  </div>

  <?php $connection->closeconnection(); ?>
</body>


</html>
