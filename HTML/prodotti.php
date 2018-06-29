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
        <li class="active" tabindex="7"><a href="" >Prodotti</a></li>
        <li><a href="../html/servizi.php" tabindex="9">Servizi</a></li>
        <li><a href="" tabindex="11">Contattaci</a></li>
      </ul>
    </div>
    <div class="row">
      <div id="breadcrumb">
        <div id="path" tabindex="12">Ti trovi in: Prodotti</div>
      </div>
    </div>
    <!-- </div> -->
  </header>
  <div class="top-img" id="prodotti-top-img">
    <!-- <img src="../img/top-img-grain.jpg" alt="" /> da mettere in background 
        da mettere eventualmente informazioni rapide o scritte-->
  </div>
  <div class="content">

    <div class="left-section" id="story">
      <!-- <div class="shrink-center"> -->
      <!-- <a href="" tabindex="6"></a> -->
      <!-- se non funziona usare questo -->
      <h1 tabindex="13">Il grano: vecchio e nuovo</h1>
      <p tabindex="15">Durante gli anni '70 il grano duro ha subito una spinta genetica notevole, che da un lato lo ha
        reso pi&ugrave; basso - quindi pi&ugrave; difficilmente abbattibile e pi&ugrave; facilmente raccoglibile dai macchinari
        moderni -, dall'altro lo ha reso pi&ugrave; produttivo per la produzione di farine e derivati. La nostra
        azienda ha tuttavia deciso di seguire una strada diversa: ricerche importanti hanno visto come
        il grano duro antico offra notevoli vantaggi nutrizionali. Infatti il glutine in esso contenuto
        ha una struttura diversa dagli altri e pi&ugrave; facilmente digeribile, oltre ad avere una composizione
        proteica migliore ed un impatto glicemico inferiore. Non sono poi da trascurare i loro importanti
        contributi alla biodiversit&agrave; e all'ambiente. Va infatti considerato che i grani di antiche variet&agrave;
        hanno meno bisogno di concimazioni, altrimenti si sviluppano anche troppo in altezza; essendo
        belli svettanti, sono pi&ugrave; difficilmente attaccabili dalle infestanti, rendendo superflui i diserbanti.
        Insomma, si prestano ottimamente alla coltivazione biologica.
      </p>
      <img src="../images/logo.jpg" alt="" tabindex="16" />
    </div>
    <div class="grains-list">

    <?php
    $connection = new DBConnection();
    $connection->openConnection();
      
      // $index = 0;         //forse non serve
      // $grainForPage = 10; //grani da mostrare per pagina
    $grains = $connection->getListGrains();

    if ($grains != null) {
      foreach ($grains as $grain) {
        echo '<div class="grain-section">';
        echo '<h1 tabindex="10">' . $grain['nome'] . '</h1>';
        echo '<p tabindex="10">' . $grain['descrizione'] . '</p>';
        echo '<img src="../images/' . $grain['immagine'] . '" alt="immagine del ' . $grain['nome'] . '"/>';
        echo '</div>';
      }
    } else echo '<p>Nessun grano ora in produzione</p>'
    ?>
    </div>




    <!-- <div class="right-section" id="products-overview">
      <h1 tabindex="17">Timilia o grano Marzuolo</h1>
      <p tabindex="19">Grano duro siciliano gi&agrave; citato in epoca greca. &egrave; particolarmente apprezzato per la panificazione
        grazie al gusto dolce e al colore carico della farina. Se ne ricava tra l'altro il celebre pane
        Nero di Castelvetrano.
      </p>
      <img src="../images/logo.jpg" alt="" tabindex="21" />
    </div>
    <div class="left-section" id="story1">
      <h1 tabindex="13">Frassineto</h1>
      <p tabindex="15">Nato nel 1922 nell'Aretino, &egrave; un grano tenero derivato dal Gentil Rosso (vedi). Vanta gusto e
        aroma intensi.
      </p>
      <img src="../images/logo.jpg" alt="" tabindex="16" />
    </div>
    <div class="right-section" id="products-overview1">
      <h1 tabindex="17">Senatore Cappelli</h1>
      <p tabindex="19">Nato con l'intento di aumentare la produzione di frumento per la crescente popolazione, deve il
        nome al senatore abruzzese Raffaele Cappelli, nella cui tenuta il genetista Nazareno Strampelli
        comp`ı gli incroci che lo portarono, dopo un'ibridazione con una cultivar tunisina, a produrre
        un grano di maggiore resa. Non per questo il Cappelli perse sotto il profilo nutrizionale e della
        digeribilit&agrave;.
      </p>
      <img src="../images/logo.jpg" alt="" tabindex="21" />
    </div>
    <div class="left-section" id="story2">
      <h1 tabindex="13">Dicocco o farro medio</h1>
      <p tabindex="15">Proteico e ricco di antiossidanti, appartiene davvero a un'antica cultivar ed era il preferito
        dagli antichi romani.
      </p>
      <img src="../images/logo.jpg" alt="" tabindex="16" />
    </div>
    <div class="right-section" id="products-overview2">
      <h1 tabindex="17">Gentil Rosso</h1>
      <p tabindex="19">Nato in Toscana a met&agrave; '800, questo grano tenero ha spighe rossicce da cui si ricava una farina
        di colore carico. &egrave; ben fornito di minerali e proteine.
      </p>
      <img src="../images/logo.jpg" alt="" tabindex="21" />
    </div>
    <div class="left-section" id="story2">
      <h1 tabindex="13">Rieti</h1>
      <p tabindex="15">Originario dell'omonima citt&agrave; laziale, era gi&agrave; coltivato nel '600, ma ebbe grande diffusione
        in Italia nell'800.
      </p>
      <img src="../images/logo.jpg" alt="" tabindex="16" />
    </div>
    <div class="right-section" id="products-overview2">
      <h1 tabindex="17">Solina</h1>
      <p tabindex="19">Grano tenero diffuso in Abruzzo gi&agrave; nel XVI secolo.
      </p>
      <img src="../images/logo.jpg" alt="" tabindex="21" />
    </div>
    <div class="left-section" id="story2">
      <h1 tabindex="13">Russello</h1>
      <p tabindex="15">Pregiata variet&agrave; di grano duro siciliano, deve il suo nome al colore rosso-dorato delle spighe.
        Ben digeribile, &egrave; molto apprezzato per la panificazione.
      </p>
      <img src="../images/logo.jpg" alt="" tabindex="16" />
    </div>
    <div class="right-section" id="products-overview2">
      <h1 tabindex="17">Verna</h1>
      <p tabindex="19">Grano tenero originario della Toscana. Sottoposta ad analisi dall'universit&agrave; di Bologna, la farina
        ha mostrato un tenore di glutine dello 0,9% contro il 14% della media delle attuali cultivar,
        rispetto alle quali ha pure un miglior contenuto di antiossidanti, proteine totali, minerali.
      </p>
      <img src="../images/logo.jpg" alt="" tabindex="21" />
    </div> -->
  </div>
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


<?php $connection->closeconnection(); ?>
</body>


</html>
