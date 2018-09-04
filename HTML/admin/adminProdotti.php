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
  <title>Prodotti</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="description" content="Pagina di gestione dei prodotti" />
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
        <li class="active"><a href="adminProdotti.php" lang="en">Prodotti</a></li>
        <li><a href="adminServizi.php">Servizi</a></li>
        <li><a href="adminStoricoPrenotazioni.php">Storico prenotazioni</a></li>
      </ul>
      <ul id="navbar2">
        <li><a href="adminPrenotazioni.php">Prenotazioni</a></li>
        <li><a href="adminClienti.php">Clienti</a></li>
        <li><a href="adminAmministratori.php">Amministratori</a></li>
      </ul>
    </div>

    <div id="breadcrumb">
      <p id="path">Ti trovi in: Amministrazione > Prodotti</p>
      <a id="logout" href="adminHome.php?logout=true" xml:lang="en">Logout</a>
      <a id="toSite" href="../../index.php">Torna al sito</a>
    </div>
  </div>

  <div class="spacer">
    &nbsp;
  </div>

  <div class="grains">
    <div id="description">
      <h1>Benvenuto nella pagina di gestione delle coltivazioni</h1>
      <p>In questa pagina &egrave; possibile inserirle, modificarle ed eliminarle.
        <br /> &Egrave; anche possibile cambiarne solo la disponibilit&agrave; e il prezzo.</p>
    </div>
    <div class="list-modify-delete-grain">
      <?php if (isset($_SESSION['isError']) && $_SESSION['isError']) {
          echo '<p id="error">' . $_SESSION['error'] . '</p>';
          $_SESSION['isError'] = false;
        }
        $connection = new DBConnection();
        $connection->openConnection();
      
        $grains = $connection->getListGrains();

        if ($grains != null) {
          foreach ($grains as $grain) {
            echo '<div id="admin-grain" class="grain-section">';
            echo '<h2>' . $grain['nome'] . '</h2>'; ?>
      <h3>Imposta una nuova disponibilit&agrave;</h3>
      <form id="insertAvailability" action="productManager.php" method="post" enctype="multipart/form-data">
        <label for="availability <?php echo $grain['nome'] ?>">Disponibilit&agrave;: </label>
        <input name="availability <?php echo $grain['nome'] ?>" type="text" id="availability <?php echo $grain['nome'] ?>"
          size="5" value="<?php echo $grain['disponibilita'] ?>" />
        <input name="grainName" type="hidden" value="<?php echo $grain['nome'] ?>" />
        <input type="submit" name="submitAvailability" value="Modifica disponibilit&agrave;" />
      </form>
      <h3>Imposta un nuovo prezzo</h3>
      <form id="insertPrice" action="productManager.php" method="post" enctype="multipart/form-data">
        <label for="price <?php echo $grain['nome'] ?>">Prezzo: </label>
        <input name="price <?php echo $grain['nome'] ?>" type="text" id="price <?php echo $grain['nome'] ?>"
          size="5" value="<?php echo $grain['prezzo'] ?>" />
        <input name="grainName" type="hidden" value="<?php echo $grain['nome'] ?>" />
        <input type="submit" name="submitPrice" value="Modifica prezzo" />
      </form>
      <?php
        echo '<a class="button" title="Rimuovi ' . $grain['nome'] . '"' . ' href="productManager.php?remove=' . $grain['nome'] . '" >Elimina coltivazione</a>';
        echo '</div>';
      }
    } else echo '<p>Nessun grano ora in produzione</p>';
    ?>
    </div>

    <div class="add-grain">
      <h2>Inserisci una nuova <span xml:lang="en">cultivar</span></h2>
      <form method="post" action="productManager.php" enctype="multipart/form-data">
        <ul>
          <li>
            <label for="name">Nome:</label>
            <input type="text" name="name" id="name" />
          </li>
          <li>
            <label for="availability">Disponibilit&agrave; (in quintali):</label>
            <input type="numbrt" name="availability" id="availability" />
          </li>
          <li>
            <label for="price">Prezzo:</label>
            <input type="text" name="price" id="price" />
          </li>
          <li>
            <label for="new description">Descrizione:</label>
            <textarea name="description" id="new description" rows="5" cols="40"></textarea>
          </li>
          <li>
            <label for="fileToUpload">Seleziona un'immagine dal computer:</label>
            <input type="file" name="fileToUpload" id="fileToUpload" />
          </li>
          <li>
            <input type="submit" name="submit" id="submit" value="Aggiungi coltivazione" />
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


  <?php $connection->closeconnection(); ?>
</body>


</html>
