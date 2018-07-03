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
  <meta name="keywords" content="agricoltura, azienda, agricola, grano, duro, biologico, HTML, CSS, JavaScript, MySQL, informatica"
  />
  <meta http-equiv="Content-Script-Type" content="text/javascript" />
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
      <img src="../images/logo.jpg" alt="logo azienda" id="logo-img" />
      <ul id="navbar">
        <li><a href="../html/home.html" lang="en" tabindex="10" target="_top">Home</a></li>
        <li><a href="../html/chi-siamo.html" tabindex="10" target="_top">Chi siamo</a></li>
        <li><a href="../html/prodotti.php" tabindex="10" target="_top">Prodotti</a></li>
        <li class="active"><a href="" tabindex="10" target="_top">Servizi</a></li>
        <li><a href="../html/contattaci.html" tabindex="10" target="_top">Contattaci</a></li>
      </ul>
      <div class="dropdown">
        <button onclick="myFunction()" class="dropbtn">Menu</button>
        <div id="myDropdown" class="dropdown-content">
          <ul>
            <li class="active"><a href="../html/home.html" lang="en" tabindex="10" target="_top">Home</a></li>
            <li><a href="../html/chi-siamo.html" tabindex="10" target="_top">Chi siamo</a></li>
            <li><a href="../html/prodotti.php" tabindex="10" target="_top">Prodotti</a></li>
            <li><a href="../html/servizi.php" tabindex="10" target="_top">Servizi</a></li>
            <li><a href="../html/contattaci.html" tabindex="10" target="_top">Contattaci</a></li>
          </ul>
        </div>
      </div>
    </div>
    <div id="breadcrumb">
      <p id="path">Ti trovi in: Servizi</p>
      <a id="go-to-content" href="#anchor" tabindex="1" target="_self">Vai al contenuto</a>
    </div>
  </div>

  <div class="spacer" tabinde="-1">
    &nbsp;
  </div>
  <div class="top-img" id="servizi-top-img">
  </div>

  <div class="content">
    <div id="anchor"></div>
    <div class="center-section" id="services">
      <h1>Servizio macchinari</h1>
      <p>
        Proponiamo un servizio di noleggio trattori, telescopici e attrezzatura agricola. Mettiamo a vostra disposizione
        un parco trattori ampio e completo, atto a soddisfare tutte le esigenze. Sono disponibili trattori da 50
        a 400 cavalli, telescopici da 6mt a 14mt e attrezzature agricole specializzate.
      </p>
      <div class="service-first-list">
        Il servizio del noleggio presenta diversi vantaggi:
        <ul class="service-list-description">
          <li>Potete ridurre al minimo il parco macchine, conservando più risorse</li>
          <li>Avete sempre a disposizione la macchina giusta per il lavoro in corso.</li>
          <li>Il noleggio elimina i costi di manutenzione, i costi di riparazione e i costi indiretti dovuti allo stop
            dei lavori.</li>
          <li>Controllo dei costi e budget migliori: il noleggio offre un costo chiaro e semplice, dato dalla fattura
            del noleggiatore.</li>
          <li>Con il noleggio si elimina il rischio di problemi burocratici (assicurazioni, permessi, ecc…). </li>
        </ul>
      </div>
      <div class="service-first-list">
        I termini salienti del contratto:
        <ul class="service-list-description">
          <li>Trasporto del trattore a scelta dell’utente.</li>
          <li>Massimale di ore di utilizzo.
          </li>
          <li>Veicolo assicurato a carico della cooperativa con obbligo di versamento cauzionale franchigia.</li>
          <li>Copertura furto-incendio-danni meccanici.</li>
          <li>Manutenzione a carico della cooperativa.</li>
        </ul>
      </div>
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
          echo '<h1>' . $machine['nome'] . '</h1>';
          echo '<h2> Modello: ' . $machine['modello'] . '</h2>';
          echo '<p> Tipologia: ' . $machine['tipologia'] . '</p>';
          echo '<p> Potenza: ' . $machine['potenzaKW'] . ' KW</p>';
          echo '<p> Anno: ' . $machine['anno'] . '</p>';
          echo '<p> Prezzo (al giorno): ' . $machine['prezzoGiorno'] . '€</p>';
          echo '</div>';
          echo '<img src="../images/' . $machine['immagine'] . '" alt="immagine del ' . $machine['nome'] . ' ' . $machine['modello'] . '" tabindex="-1"/>';
          echo '</div>';
        }
      } else echo '<p>Nessun grano ora in produzione</p>';
      $connection->closeConnection();
      ?>
    </div>

  </div>
  <div id="go-to-menu">
    <a href="#anchor" tabindex="900" target="_self"><img src="../images/icon/white-arrow-up.png" alt="Torna su"/></a>
  </div>
  <div id="footer">
    <div id="site_info">
      <img id="xhtmlvalid" src="../images/valid-xhtml10.png" lang="en" alt="XHTML valid" />
      <img id="cssvalid" src="../images/vcss-blue.gif" lang="en" alt="CSS3 valid" />
      <a href="admin/adminHome.php" id="admin" tabindex="950" target="_top">Pannello di amministrazione</a>
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
      <li><a href="../html/home.html" lang="en" tabindex="10" target="_top">Home</a></li>
      <li><a href="../html/chi-siamo.html" tabindex="10" target="_top">Chi siamo</a></li>
      <li><a href="../html/prodotti.php" tabindex="10" target="_top">Prodotti</a></li>
      <li class="active"><a href="../html/servizi.php" tabindex="10" target="_top">Servizi</a></li>
      <li><a href="../html/contattaci.html" tabindex="10" target="_top">Contattaci</a></li>
    </ul>
  </div>


</body>


</html>
