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
    <meta name="prodotti" content="Pagina di gestione dei prodotti" />
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
          <li class="active"><a href="adminProdotti.php" lang="en" tabindex="1">Prodotti</a></li>
          <li><a href="adminServizi.php" tabindex="5">Servizi</a></li>
          <li><a href="adminOrdini.php" tabindex="7">Ordini</a></li>
          <li><a href="adminPrenotazioni.php" tabindex="9">Prenotazioni</a></li>
          <li><a href="adminClienti.php" tabindex="11">Clienti</a></li>
          <li><a href="adminAmministratori.php" tabindex="11">Amministratori</a></li>
        </ul>
      </div>

      <div id="breadcrumb">
        <p id="path" tabindex="12">Ti trovi in: Prodotti</p>
        <a id="logout" href="adminHome.php?logout=true" xml:lang="en">Logout</a>
        <a id="toSite" href="../">Torna al sito</a>
      </div>
    </header>

    <div class="spacer">
      &nbsp;
    </div>

    <div class="grains">
      <div id="description">
        <h1>Benvenuto nella pagina di gestione delle coltivazioni.</h1>
        <p>In questa pagina &egrave; possibile inserirle, modificarle ed eliminarle.
          <br/> &Egrave; anche possibile cambiarne solo la disponibilit&agrave; e il prezzo.</p>
      </div>
      <div class="list-modify-delete-grain">
      <?php echo (isset($_SESSION['isError']) && $_SESSION['isError']) ? (isset($_SESSION['error']) ? $_SESSION['error'] : '') : ''; ?>
        <?php
        $connection = new DBConnection();
        $connection->openConnection();
      
      // $index = 0;         //forse non serve
      // $grainForPage = 10; //grani da mostrare per pagina
        $grains = $connection->getListGrains();

        if ($grains != null) {
          foreach ($grains as $grain) {
            echo '<div class="grain-section">';
            echo '<h1 tabindex="10">' . $grain['nome'] . '</h1>'; ?>
          <h2>Imposta una nuova disponibilit&agrave;</h2>
          <form id="insertAvailability" action="productManager.php" method="post" enctype="multipart/form-data">
            <label for="availability">Disponibilit&agrave;</label>
            <input name="availability" type="text" id="availability" size="5" value="<?php echo $grain['disponibilita'] ?>"/>
            <input name="grainName" type="hidden" value="<?php echo $grain['nome'] ?>"/>
            <input type="submit" name="submitAvailability" value="Modifica disponibilit&agrave;" />
          </form>
          <h2>Imposta un nuovo prezzo</h2>
          <form id="insertPrice" action="productManager.php" method="post" enctype="multipart/form-data">
            <label for="price">Prezzo</label>
            <input name="price" type="text" id="price" size="5" value ="<?php echo $grain['prezzo'] ?>" />
            <input name="grainName" type="hidden" value="<?php echo $grain['nome'] ?>"/>
            <input type="submit" name="submitPrice" value="Modifica prezzo" />
          </form>
          <?php
          echo '<a class="button" title="Rimuovi ' . $grain['nome'] . '"' . ' href="productManager.php?remove=' . $grain['nome'] . '" >Elimina coltivazione</a>';
          echo '</div>';
          // echo (isset($_SESSION['isError']) && $_SESSION['isError']) ? (isset($_SESSION['error']) ? $_SESSION['error'] : '') : '';
        }
      } else echo '<p>Nessun grano ora in produzione</p>';
      ?>
      </div>

      <div class="add-grain">
        <h1>Inserisci una nuova <span xml:lang="en">cultivar</span></h1>
        <form method="post" action="productManager.php" enctype="multipart/form-data">
          <ul>
            <li>
              <label for="name">Nome:</label>
              <input type="text" name="name" />
            </li>
            <li>
              <label for="availability">Disponibilit&agrave; (in quintali):</label>
              <input type="numbrt" name="availability" />
            </li>
            <li>
              <label for="price">Prezzo:</label>
              <input type="text" name="price" />
            </li>
            <li>
              <label for="description">Descrizione:</label>
              <textarea name="description" rows="5" cols="40"></textarea>
            </li>
            <li>
              <label for="fileToUpload">Seleziona un'immagine dal computer:</label>
              <input type="file" name="fileToUpload" id="fileToUpload" />
            </li>
            <li><input type="submit" name="submit" id="submit" value="Aggiungi" /></li>
          </ul>
        </form>
      </div>




    </div>



    <div id="go-to-menu">
      <a href="#story">Torna su</a>
    </div>
    <footer>
    <div id="site_info">
      <img id="xhtmlvalid" src="../images/valid-xhtml10.png" lang="en" alt="XHTML valid" />
      <img id="cssvalid" src="../images/vcss-blue.gif" lang="en" alt="CSS3 valid" />
      <a href="admin/adminHome.php" id="admin" tabindex="12">Pannello di amministrazione</a>
      <p>Progetto didattico del corso Tecnologie <span xml:lang="en">web</span> prodotto da:</p>
      <ul id="collaborators">
        <li>Manuel Vianello - 1102467</li>
        <li>Stefano Panozzo - 1097068</li>
        <li>Giovanni Cavallin - 1148957</li>
      </ul>
    </div>
    </footer>


    <?php $connection->closeconnection(); ?>
  </body>


</html>
