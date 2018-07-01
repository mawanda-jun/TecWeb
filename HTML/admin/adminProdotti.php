<?php require_once __DIR__ . "/../../php/connection.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<?php
header('Content-type: application/xhtml+xml');
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isset($_SESSION['login']) || !($_SESSION['login'] === true)) {
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
          <form id="insertAvailability" action="productManager.php" method="post">
            <label for="availability">Disponibilit&agrave;</label>
            <input name="availability" type="number" id="availability" size="5" />
            <?php
            echo '<a class="button" title="Imposta disponibilit&agrave;' . $grain['nome'] . '"' . ' href="productManager.php?grainName=' . $grain['nome'] . '" >Aggiungi disponibilit&agrave;</a>';
            ?>
            </form>
          <h2>Imposta un nuovo prezzo</h2>
          <form id="insertPrice" action="productManager.php" method="post">
            <label for="price">Prezzo</label>
            <input name="price" type="number" id="price" size="5" />
            <?php
            echo '<a class="button" title="Imposta prezzo' . $grain['nome'] . '"' . ' href="productManager.php?grainName=' . $grain['nome'] . '" >Aggiungi prezzo</a>';
            ?>
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
          <label for="name">Nome:</label>
          <input type="text" name="name" />
          <label for="availability">Disponibilit&agrave; (in quintali):</label>
          <input type="numbrt" name="availability" />
          <label for="price">Prezzo:</label>
          <input type="number" name="price" />
          <label for="description">Descrizione:</label>
          <textarea name="description" rows="5" cols="40"></textarea>
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
        <?php echo (isset($_SESSION['isError']) && $_SESSION['isError']) ? (isset($_SESSION['error']) ? $_SESSION['error'] : '') : ''; ?><br/>
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
