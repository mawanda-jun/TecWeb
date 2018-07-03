<?php require_once __DIR__ . "/../php/connection.php";
// mettere nome database
header('Content-type: application/xhtml+xml'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<head>
  <title>Prodotti</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="description" content="Prodotti coltivati nella nostra azienda" />
  <meta name="author" content="Tecwweb&amp;Pastorizia" />
  <meta name="keywords" content="agricoltura, azienda, agricola, grano, duro, biologico, HTML, CSS, JavaScript, MySQL, informatica"
  />
  <link rel="icon" type="image/png" href="../images/icon/favicon-32x32.png" />
  <link rel="icon" type="image/png" href="../images/icon/favicon-16x16.png" />
  <link href="../css/style.css" rel="stylesheet" type="text/css" media="handheld, screen" />
  <link href="../css/small.css" type="text/css" rel="stylesheet" media="handheld, screen and (max-width:720px),only screen and (max-device-width:720px)"
  />
  <!-- <link href="../css/print.css" type="text/css" rel="stylesheet" media="print" /> -->
  <script src="../scripts/script.js" type="text/javascript" charset="utf-8"></script>
</head>

<body>

  <div id="header">
    <div class="row">
      <img src="../images/logo.jpg" alt="logo azienda" id="logo-img" tabindex="-1" />
      <ul id="navbar">
        <li><a href="../html/home.html" lang="en" tabindex="10">Home</a></li>
        <li><a href="../html/chi-siamo.html" tabindex="10">Chi siamo</a></li>
        <li class="active"><a href="" tabindex="10">Prodotti</a></li>
        <li><a href="../html/servizi.php" tabindex="10">Servizi</a></li>
        <li><a href="../html/contattaci.html" tabindex="10">Contattaci</a></li>
      </ul>
      <div class="dropdown">
        <button onclick="myFunction()" class="dropbtn">Menu</button>
        <div id="myDropdown" class="dropdown-content">
          <ul>
            <li class="active"><a href="../html/home.html" lang="en" tabindex="10">Home</a></li>
            <li><a href="../html/chi-siamo.html" tabindex="10">Chi siamo</a></li>
            <li><a href="../html/prodotti.php" tabindex="10">Prodotti</a></li>
            <li><a href="../html/servizi.php" tabindex="10">Servizi</a></li>
            <li><a href="../html/contattaci.html" tabindex="10">Contattaci</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div id="breadcrumb">
      <p id="path" tabindex="1">Ti trovi in: Prodotti</p>
      <a id="go-to-content" href="#anchor" tabindex="1">Vai al contenuto</a>
    </div>
  </div>
  <div class="spacer">
    &nbsp;
  </div>
  <div class="top-img" id="prodotti-top-img" tabindex="-1">
  </div>
  <div class="content">
    <div id="anchor"></div>
    <div class="center-section" id="story">
      <h1 tabindex="20">Il grano: vecchio e nuovo</h1>
      <p tabindex="20">Durante gli anni '70 il grano duro ha subito una spinta genetica notevole, che da un lato lo ha reso pi&ugrave;
        basso - quindi pi&ugrave; difficilmente abbattibile e pi&ugrave; facilmente raccoglibile dai macchinari
        moderni -, dall'altro lo ha reso pi&ugrave; produttivo per la produzione di farine e derivati. La nostra
        azienda ha tuttavia deciso di seguire una strada diversa: ricerche importanti hanno visto come il grano
        duro antico offra notevoli vantaggi nutrizionali. Infatti il glutine in esso contenuto ha una struttura
        diversa dagli altri e pi&ugrave; facilmente digeribile, oltre ad avere una composizione proteica migliore
        ed un impatto glicemico inferiore. Non sono poi da trascurare i loro importanti contributi alla biodiversit&agrave;
        e all'ambiente. Va infatti considerato che i grani di antiche variet&agrave; hanno meno bisogno di concimazioni,
        altrimenti si sviluppano anche troppo in altezza; essendo belli svettanti, sono pi&ugrave; difficilmente
        attaccabili dalle infestanti, rendendo superflui i diserbanti. Insomma, si prestano ottimamente alla coltivazione
        biologica.
      </p>
    </div>
    <div class="grains-list">

      <?php
    $connection = new DBConnection();
    $connection->openConnection();
    $grains = $connection->getListGrains();

    if ($grains != null) {
      foreach ($grains as $grain) {
        echo '<div class="grain-section">';
        echo '<div class="text-subsection">';
        echo '<h1 tabindex="30">' . $grain['nome'] . '</h1>';
        echo '<p tabindex="30">' . $grain['descrizione'] . '</p>';
        echo '<p tabindex="30">Disponibilità: ' . $grain['disponibilita'] . ' q</p>';
        echo '<p tabindex="30"> Prezzo: ' . $grain['prezzo'] . '€ (per quintale)</p>';
        echo '</div>';
        echo '<img src="../images/' . $grain['immagine'] . '" alt="immagine del ' . $grain['nome'] . '" tabindex="-1"/>';
        echo '</div>';
      }
    } else echo '<p tabindex="30">Nessun grano ora in produzione</p>'
    ?>
    </div>
  </div>
  <div id="go-to-menu">
    <a href="#anchor" tabindex="900">Torna su</a>
  </div>
  <div id="footer">
    <div id="site_info">
      <img id="xhtmlvalid" src="../images/valid-xhtml10.png" lang="en" alt="XHTML valid" tabindex="1000" />
      <img id="cssvalid" src="../images/vcss-blue.gif" lang="en" alt="CSS3 valid" tabindex="1000" />
      <a href="admin/adminHome.php" id="admin" tabindex="950">Pannello di amministrazione</a>
      <p tabindex="950">Progetto didattico del corso Tecnologie <span xml:lang="en">web</span> prodotto da:</p>
      <ul id="collaborators" tabindex="950">
        <li>Manuel Vianello - 1102467</li>
        <li>Stefano Panozzo - 1097068</li>
        <li>Giovanni Cavallin - 1148957</li>
      </ul>
    </div>
  </div>


  <?php $connection->closeconnection(); ?>
</body>


</html>
