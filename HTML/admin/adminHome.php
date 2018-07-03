<?php require_once __DIR__ . "/../../php/connection.php"; ?>
<?php require_once('../../validation/validator.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<?php
header('Content-type: application/xhtml+xml');
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

$wronglogin = false;
$wrongloginmessage = '<div id="wronglogin">Dati errati!</div>';

$connection = new DBConnection();
$connection->openConnection();

if (isset($_POST['emailLogin']) && isset($_POST['password']))
  if ($connection->adminLogin($_POST['emailLogin'], $_POST['password'])) //linea dove avviene il controllo dell'accesso
    // if(($_POST['emailLogin'] == "admin") && ($_POST['password'] == "admin"))
{
  $_SESSION['login'] = true;
  $_SESSION['emailLogin'] = $_POST['emailLogin'];
} else
  $wronglogin = true;

$connection->closeConnection();

if (isset($_GET['logout']) && $_GET['logout'] == "true") {
  $_SESSION['login'] = false;
  $_SESSION['emailLogin'] = null;
  header("Location: ../home.html");
  session_unset();
  session_destroy();
  exit();
}
if (isset($_SESSION['login']) && $_SESSION['login'] == true)
  $title = "Pannello di amministrazione";
else
  $title = "Login";
?>

  <head>
    <title>
      <?php echo $title ?>
    </title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="description" content="Pagina di amministrazione per gli amministratori" />
    <meta name="author" content="Tecwweb&amp;Pastorizia" />
    <meta name="keywords" content="agricoltura, azienda, agricola, grano, duro, biologico, HTML, CSS, JavaScript, MySQL, informatica"/>
    <link rel="icon" type="image/png" href="../../images/icon/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="../../images/icon/favicon-16x16.png" sizes="16x16" />
    <link href="../../css/administrator.css" rel="stylesheet" type="text/css" media="handheld, screen" />
    <!-- <link href="../css/small.css" type="text/css" rel="stylesheet" media="handheld, screen and (max-width:480px),only screen and (max-device-width:480px)" /> -->
    <!-- <link href="../css/print.css" type="text/css" rel="stylesheet" media="print" /> -->
    <!-- <script src="../scripts/script.js" type="text/javascript" charset="utf-8"></script> -->
  </head>

  <body>
    <header>
      <div class="row">
        <img src="../../images/logo.jpg" alt="logo azienda" id="logo-img" />

        <?php if (isset($_SESSION['login']) && $_SESSION['login'] == true) { ?>

        <ul id="navbar">
          <li class="active"><a href="adminHome.php" lang="en" tabindex="1">Pannello amministrazione</a></li>
          <li><a href="adminProdotti.php" lang="en" tabindex="1">Prodotti</a></li>
          <li><a href="adminServizi.php" tabindex="5">Servizi</a></li>
          <li><a href="adminOrdini.php" tabindex="7">Ordini</a></li>
          <li><a href="adminPrenotazioni.php" tabindex="9">Prenotazioni</a></li>
          <li><a href="adminClienti.php" tabindex="11">Clienti</a></li>
          <li><a href="adminAmministratori.php" tabindex="11">Amministratori</a></li>
        </ul>
        <?php 
      } ?>
      </div>

      <div id="breadcrumb">
        <p id="path" tabindex="12">Ti trovi in: Pannello amministrazione</p>
        <?php if (isset($_SESSION['login']) && $_SESSION['login'] == true) { ?>
        <a id="logout" href="adminHome.php?logout=true" xml:lang="en">Logout</a>
        <?php 
      } ?>
        <a id="toSite" href="../">Torna al sito</a>
      </div>
    </header>

    <div class="spacer">
      &nbsp;
    </div>

    <!-- <div class="top-img" id="home-top-img">
  </div> -->

    <?php
    if (isAdmin()) { ?>
      <div class="content">

        <div class="left-section" id="actions">
          <h2 tabindex="13">Benvenuto nella sezione di amministrazione</h2>
          <p tabindex="15">In questa sezione potrai svolgere tutte le operazioni di amministrazione del sito.</p>
          <h3>Prodotti</h3>
          <p>In questa sezione si possono: </p>
          <ul> </ul>








          <!-- <h2>Benvenuto nell’area di amministrazione</h2>
          <p>In quest’ area potrai gestire, aggiornare e monitorare alcune parti del sito.</p>

          <h3 xml:lang="en">News</h3>
          <p>In questa pagina si ha la possibilità di:</p>
          <ul>
            <li>aggiungere <span xml:lang="en">news</span></li>
            <li>cancellare la <span xml:lang="en">cache</span> delle <span xml:lang="en">news</span> per
              la <span xml:lang="en">sidebar</span></li>
            <li>cancellare le <span xml:lang="en">news</span></li>
            <li>modificare le <span xml:lang="en">news</span></li>
            <li>impostare le <span xml:lang="en">news</span> come bozza o pubblicarle</li>
          </ul>

          <h3>Immagini</h3>
          <p>In questa sezione è possibile fare l’<span lang="en">upload</span> di nuove immagini o rimuoverle
            dal sito.</p>

          <h3>Commenti e utenti bloccati</h3>
          <p>Nella sezione commenti è presente una lista di tutti i commenti presenti nel sito. E’ possibile
            bloccare un utente, specificandone il motivo (se desiderato) e conseguentemente eliminare
            il commento oppure eliminare solo il commento.</p>
          <p>Nella pagina utenti bloccati invece troviamo un elenco di tutti gli utenti ai quali è impedito
            l'inserimento dei commenti e c'è la funzione per sbloccarli.</p>

          <h3>Capitoli</h3>
          <p>Questa sezione elenca tutti i capitoli presenti, permettendo di aggiungerne di nuovi o di eliminarne.</p>

          <h3>Amministratori</h3>
          <p>In questa sezione è possibile aggiungere e rimuovere amministratori, cambiare la propria password
            ed aggiornare la propria <span xml:lang="it">e-mail</span>.</p>

          <p>Infine puoi ritornare al sito rimanendo loggato all’Area amministrativa o fare <span xml:lang="en">Logout</span>.</p> -->
        </div>
      </div>
      <?php

    } else { ?>
        <h1>Pagina di <span xml:lang="en">login</span></h1>
        <form action="adminHome.php" method="post" id="loginform">
          <fieldset id="loginfields">
            <!-- <div id="loginFields"> -->
            <legend> <span xml:lang="en">Login</span></legend>

            <?php 
            if ($wronglogin)
              echo ($wrongloginmessage);
            ?>
            <label for="emailLogin">Email</label>:
            <input id="emailLogin" name="emailLogin" type="text" />
            <br/>
            <label for="password"><span xml:lang="en">Password</span></label>:
            <input id="password" name="password" type="password" />
            <br/>
            <input value="Login" type="submit" />
            <input value="Cancella" type="reset" />
          </fieldset>
          <!-- </div> -->
        </form>
        <a href="../">Torna al sito</a>
        <?php

      } ?>


          <div id="go-to-menu">
            <a href="#story">Torna su</a>
          </div>
          <footer>
            <div id="site_info">
              <img id="xhtmlvalid" src="../../images/valid-xhtml10.png" lang="en" alt="XHTML valid" />
              <img id="cssvalid" src="../../images/vcss-blue.gif" lang="en" alt="CSS3 valid" />
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
