<?php require_once __DIR__ . "/../php/connection.php";
// mettere nome database
header('Content-type: application/xhtml+xml'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<head>
  <title>Servizi</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="description" content="Servizi offerti dall'azienda" />
  <meta name="author" content="Tecwweb&amp;Pastorizia" />
  <meta name="keywords" content="agricoltura, azienda, agricola, grano, duro, biologico, HTML, CSS, JavaScript, MySQL, informatica">
  <link rel="icon" type="image/png" href="../images/icon/favicon-32x32.png" sizes="32x32" />
  <link rel="icon" type="image/png" href="../images/icon/favicon-16x16.png" sizes="16x16" />
  <link href="../css/style.css" rel="stylesheet" type="text/css" media="handheld, screen" />
  <link href="../css/small.css" type="text/css" rel="stylesheet" media="handheld, screen and (max-width:720px),only screen and (max-device-width:720px)"
  />
  <!-- <link href="../css/print.css" type="text/css" rel="stylesheet" media="print" /> -->
  <script src="../scripts/script.js" type="text/javascript" charset="utf-8"></script>
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
        <li><a href="../html/contattaci.html" tabindex="11">Contattaci</a></li>
      </ul>
      <div class="dropdown">
        <button onclick="myFunction()" class="dropbtn">Menu</button>
        <div id="myDropdown" class="dropdown-content">
          <ul>
            <li class="active"><a href="../html/home.html" lang="en" tabindex="1">Home </a></li>
            <li><a href="../html/chi-siamo.html" tabindex="5">Chi siamo</a></li>
            <li><a href="../html/prodotti.php" tabindex="7">Prodotti</a></li>
            <li><a href="../html/servizi.php" tabindex="9">Servizi</a></li>
            <li><a href="../html/contattaci.html" tabindex="11">Contattaci</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div id="breadcrumb">
      <p id="path" tabindex="12">Ti trovi in: Servizi</p>
    </div>
    <!-- </div> -->
  </header>

  <div class="spacer">
    &nbsp;
  </div>
  <div class="top-img" id="servizi-top-img">
    <!-- <img src="../img/top-img-grain.jpg" alt="" /> da mettere in background 
        da mettere eventualmente informazioni rapide o scritte-->
  </div>

  <div class="content">
    <div id="anchor"></div>
    <div class="center-section" id="services">
      <h1 tabindex="13">Servizio macchinari</h1>
      <p tabindex="15">
        Proponiamo un servizio di noleggio trattori, telescopici e attrezzatura agricola. Mettiamo a vostra disposizione
        un parco trattori ampio e completo, atto a soddisfare tutte le esigenze. Sono disponibili trattori da 50
        a 400 cavalli, telescopici da 6mt a 14mt e attrezzature agricole specializzate.
      </p>
      <p>
        Il servizio del noleggio presenta diversi vantaggi:
        <ul>
          <li>Potete ridurre al minimo il parco macchine, conservando più risorse</li>
          <li>Avete sempre a disposizione la macchina giusta per il lavoro in corso.</li>
          <li>Il noleggio elimina i costi di manutenzione, i costi di riparazione e i costi indiretti dovuti allo stop
            dei lavori.</li>
          <li>Controllo dei costi e budget migliori: il noleggio offre un costo chiaro e semplice, dato dalla fattura
            del noleggiatore.</li>
          <li>Con il noleggio si elimina il rischio di problemi burocratici (assicurazioni, permessi, ecc…). </li>
        </ul>
      </p>
      <p>
        I termini salienti del contratto:
        <ul>
          <li>Trasporto del trattore a scelta dell’utente.</li>
          <li>Massimale di ore di utilizzo.
          </li>
          <li>Veicolo assicurato a carico della cooperativa con obbligo di versamento cauzionale franchigia.</li>
          <li>Copertura furto-incendio-danni meccanici.</li>
          <li>Manutenzione a carico della cooperativa.</li>
        </ul>
      </p>
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
          echo '<div class="service-section">';
          echo '<div class="text-subsection">';
          echo '<h1 tabindex="10">' . $machine['nome'] . '</h1>';
          echo '<h2 tabindex="10"> Modello: ' . $machine['modello'] . '</h2>';
          echo '<p tabindex="10"> Tipologia: ' . $machine['tipologia'] . '</p>';
          echo '<p tabindex="10"> Potenza: ' . $machine['potenzaKW'] . ' KW</p>';
          echo '<p tabindex="10"> Anno: ' . $machine['anno'] . '</p>';
          echo '<p tabindex="10"> Prezzo (al giorno): ' . $machine['prezzoGiorno'] . '€</p>';
          echo '</div>';
          echo '<img src="../images/' . $machine['immagine'] . '" alt="immagine del ' . $machine['nome'] . ' ' . $machine['modello'] . '"/>';
          echo '</div>';
        }
      } else echo '<p>Nessun grano ora in produzione</p>';
      $connection->closeConnection();
      ?>
    </div>

  </div>
  <!-- <div class="shrink-center"> -->
  <div id="go-to-menu">
    <a href="#anchor">Torna su</a>
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
  <!-- </div> -->



</body>


</html>
