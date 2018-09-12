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
  <meta name="viewport" content="width=device-width" />
  <meta name="description" content="Home page azienda agricola Cavallin" />
  <meta name="keywords" content="agricoltura, azienda, agricola, grano, duro, biologico, HTML, CSS, JavaScript, MySQL, informatica" />
  <link rel="icon" type="image/png" href="../../images/icon/favicon-32x32.png" />
  <link rel="icon" type="image/png" href="../../images/icon/favicon-16x16.png" />

  <title>Clienti</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="description" content="Pagina di gestione dei clienti" />
  <meta name="author" content="Tecwweb&amp;Pastorizia" />
  <link href="../../css/administrator.css" rel="stylesheet" type="text/css" media="handheld, screen" />
  <link href="../../css/small.css" type="text/css" rel="stylesheet" media="handheld, screen and (max-width:720px),only screen and (max-device-width:720px)"/>
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
        <li><a href="adminServizi.php">Servizi</a></li>
        <li><a href="adminStoricoPrenotazioni.php">Storico prenotazioni</a></li>
      </ul>
      <ul id="navbar2">
        <li><a href="adminPrenotazioni.php">Prenotazioni</a></li>
        <li class="active"><a href="adminClienti.php">Clienti</a></li>
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
            <li><a href="adminServizi.php">Servizi</a></li>
            <li><a href="adminStoricoPrenotazioni.php">Storico prenotazioni</a></li>
            <li><a href="adminPrenotazioni.php">Prenotazioni</a></li>
            <li class="active"><a href="adminClienti.php">Clienti</a></li>
            <li><a href="adminAmministratori.php">Amministratori</a></li>
          </ul>
        </div>
      </div>
    </div>

    <div id="breadcrumb">
      <p id="path">Ti trovi in: Amministrazione > Clienti</p>
      <a id="logout" href="adminHome.php?logout=true" xml:lang="en">Logout</a>
      <a id="toSite" href="../../index.php">Torna al sito</a>
    </div>
  </div>

  <div id="admin-spacer" class="spacer">
    &nbsp;
  </div>


  <div class="clients">
    <div id="print-content">
        <h1 id="print-title">Azienda agricola Cavallin</h1>
        <p id="print-path">Ti trovi in: Amministrazione > Clienti</p>
    </div>
    <div id="description">
      <h1>Benvenuto nella pagina di gestione dei clienti</h1>
      <p>In questa pagina &egrave; possibile inserire ed eliminare i clienti.</p>
      <p>&Egrave; inoltre possibile modificarne il numero di telefono e l'indirizzo <span xml:lang="en">email</span>.</p>
    </div>


    <?php if (isset($_SESSION['isError']) && $_SESSION['isError']) {
        echo '<p id="error">' . $_SESSION['error'] . '</p>';
        $_SESSION['isError'] = false;
      }
      $connection = new DBConnection();
      $connection->openConnection();
      $clients = $connection->getListClients();

      if ($clients != null) { ?>
    <?php 
      foreach ($clients as $client) {
        echo '<div id="admin-customers" class="grain-section">';
        echo '<h2 id="client">' . $client['nome'] . ' ' . $client['cognome'] . '</h2>';
        echo '<p> Identificativo: ' . $client['id'] . '</p>';
        echo '<p> Telefono: ' . $client['telefono'] . '</p>';
        echo '<p> Email: ' . $client['email'] . '</p>';
        ?>

    <form id="insertNumber" action="clientManager.php" method="post" enctype="multipart/form-data">
      <label for="number <?php echo $client['id'] ?>">Nuovo numero di telefono:</label>
      <input name="number" type="text" id="number <?php echo $client['id'] ?>" size="9" />
      <?php echo '<input name="clientId" type="hidden" value="' . $client['id'] . '"/>'; ?>
      <input type="submit" class="admin-input" id="submit" name="submitNumber" value="Modifica numero" />
    </form>

    <form id="insertEmail" action="clientManager.php" method="post" enctype="multipart/form-data">
      <label for="email<?php echo $client['id'] ?>">Nuova email:</label>
      <input name="email" type="text" id="email<?php echo $client['id'] ?>" size="23" />
      <?php echo '<input name="clientId" type="hidden" value="' . $client['id'] . '"/>'; ?>
      <input type="submit" class="admin-input" id="submit" name="submitEmail" value="Modifica email" />
    </form>

    <?php
      echo '<a class="button" title="Rimuovi ' . $client['id'] . '"' . ' href="clientManager.php?remove=' . $client['id'] . '" >Elimina cliente</a>';
      echo '</div>';
    }

  } else echo '<p>Nessun cliente presente.</p>';
  ?>

    <div class="add-client" id="addClient">
      <h2>Aggiungi un cliente</h2>
      <form id="insertClient" action="clientManager.php" method="post">

        <fieldset id="clientFields">
          <ul>
            <legend>Inserisci i seguenti dati:</legend>
            <li>
              <label for="id">Carta d'identità:</label>
              <input name="id" type="text" id="id" size="30" maxlength="50" />
            </li>
            <li>
              <label for="nome">Nome:</label>
              <input name="nome" type="text" id="nome" size="30" maxlength="50" />
            </li>
            <li>
              <label for="cognome">Cognome:</label>
              <input name="cognome" type="text" id="cognome" size="30" maxlength="50" />
            </li>
            <li>
              <label for="telefono">Numero di telefono:</label>
              <input name="telefono" type="text" id="telefono" size="30" maxlength="50" />
            </li>
            <li>
              <label for="email"><span xml:lang="en">Email:</span></label>
              <input name="email" type="email" id="email" size="30" maxlength="50" />
            </li>
            <li>
              <input type="submit" id="submit" value="Aggiungi cliente" name="submit" />
            </li>
          </ul>

        </fieldset>
      </form>
      <div id="errorInput">
        <?php echo (isset($_SESSION['isError']) && $_SESSION['isError']) ? $_SESSION['error'] : '' ?>
      </div>
    </div>

    <?php
        $connection->closeConnection();
        ?>

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
      <li><a href="adminServizi.php">Servizi</a></li>
      <li><a href="adminStoricoPrenotazioni.php">Storico prenotazioni</a></li>
      <li><a href="adminPrenotazioni.php">Prenotazioni</a></li>
      <li class="active"><a href="adminClienti.php">Clienti</a></li>
      <li><a href="adminAmministratori.php">Amministratori</a></li>
    </ul>
  </div>

</body>


</html>
