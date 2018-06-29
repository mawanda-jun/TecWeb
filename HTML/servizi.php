<?php require_once __DIR__ . "/../php/connection.php";
// mettere nome database
header('Content-type: application/xhtml+xml'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<head>
  <title>Home Page</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="description" content="DASISTEMARE" />
  <meta name="author" content="DASISTEMARE" />
  <link href="../css/style.css" rel="stylesheet" type="text/css" media="handheld, screen" />
  <!-- <link href="../css/small.css" type="text/css" rel="stylesheet" media="handheld, screen and (max-width:480px),only screen and (max-device-width:480px)" /> -->
  <!-- <link href="../css/print.css" type="text/css" rel="stylesheet" media="print" /> -->
  <!-- <script src="../scripts/script.js" type="text/javascript" charset="utf-8"></script> -->
</head>

<body>

  <header>
    <p id="go-to-content" tabindex="3"><a href="#content">Vai al contenuto</a></p>
    <!-- <div class="shrink-center"> -->
    <div class="row">
      <img src="../images/logo.jpg" alt="logo azienda" id="logo-img" />
      <!-- da nascondere -->
      <!-- <p id="hidden-breadcrumb" tabindex="1">Ti trovi in: Home</p> -->
      <!-- da nascondere -->
      <ul id="navbar">
        <li><a href="../html/home.html" lang="en" tabindex="1">Home </a></li>
        <li><a href="../html/chi-siamo.html" tabindex="5">Chi siamo</a></li>
        <li><a href="../html/prodotti.php" tabindex="7">Prodotti</a></li>
        <li class="active"><a href="" tabindex="9">Servizi</a></li>
        <li><a href="" tabindex="11">Contattaci</a></li>
      </ul>
    </div>
    <div class="row">
      <div id="breadcrumb">
        <div id="path" tabindex="12">Ti trovi in: Servizi</div>
      </div>
    </div>
    <!-- </div> -->
  </header>
  <div class="top-img" id="servizi-top-img">
    <!-- <img src="../img/top-img-grain.jpg" alt="" /> da mettere in background 
        da mettere eventualmente informazioni rapide o scritte-->
  </div>
  <div class="content">
    <div class="left-section" id="story">
      <h1 tabindex="13">Servizio macchinari</h1>
      <p tabindex="15">L'azienda Cavallin pone la propria attrezzatura a vostra disposizione. Quì di seguito si possono
        trovare i vari macchinari e la relativa disponibilità. Per prenotare un macchinario si prega
        di contattare l'azienda.
      </p>
      <img src="../images/logo.jpg" alt="" tabindex="16" />
    </div>

<div class="machines-list">

<?php
$connection = new DBConnection();
$connection->openConnection();
  
  // $index = 0;         //forse non serve
  // $grainForPage = 10; //grani da mostrare per pagina
$machines = $connection->getListMachinery();

if ($machines != null) {
  foreach ($machines as $machine) {
    echo '<div class="machine-section">';
    echo '<h1 tabindex="10">' . $machine['nome'] . '</h1>';
    echo '<h2 tabindex="10">' . $machine['modello'] . '</h2>';
    // echo '<img src="../images/' . $machine['immagine'] . '" alt="immagine del ' . $machine['nome'] . '" "' . $machine['modello'] . '"/>';
    echo '</div>';
  }
} else echo '<p>Nessun grano ora in produzione</p>'
?>
</div>

</div>
  <!-- <div class="shrink-center"> -->
  <div id="go-to-menu">
    <a href="#story">Torna su</a>
  </div>
  <footer>
    <div class="shrink-center">
      <img id="xhtmlvalid" src="../images/valid-xhtml10.png" lang="en" alt="XHTML valid" />
      <p>Da pensare a cosa scriverci</p>
      <img id="cssvalid" src="../images/vcss-blue.gif" lang="en" alt="CSS valid" />
    </div>
  </footer>
  <!-- </div> -->



</body>


</html>
