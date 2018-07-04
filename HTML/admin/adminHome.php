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
    <meta name="keywords" content="agricoltura, azienda, agricola, grano, duro, biologico, HTML, CSS, JavaScript, MySQL, informatica"
    />
    <link rel="icon" type="image/png" href="../../images/icon/favicon-32x32.png" />
    <link rel="icon" type="image/png" href="../../images/icon/favicon-16x16.png" />
    <link href="../../css/administrator.css" rel="stylesheet" type="text/css" media="handheld, screen" />
    <!-- <link href="../css/small.css" type="text/css" rel="stylesheet" media="handheld, screen and (max-width:480px),only screen and (max-device-width:480px)" /> -->
    <!-- <link href="../css/print.css" type="text/css" rel="stylesheet" media="print" /> -->
    <!-- <script src="../scripts/script.js" type="text/javascript" charset="utf-8"></script> -->
  </head>

  <body>
    <div id="header">
      <div class="row">
        <img src="../../images/logo.jpg" alt="logo azienda" id="logo-img" />

        <?php if (isset($_SESSION['login']) && $_SESSION['login'] == true) { ?>

        <ul id="navbar">
          <li class="active"><a href="adminHome.php" lang="en">Pannello amministrazione</a></li>
          <li><a href="adminProdotti.php" lang="en">Prodotti</a></li>
          <li><a href="adminServizi.php">Servizi</a></li>
          <li><a href="adminStoricoPrenotazioni.php">Storico prenotazioni</a></li>
        </ul>
        <ul id="navbar2">
          <li><a href="adminPrenotazioni.php">Prenotazioni</a></li>
          <li><a href="adminClienti.php">Clienti</a></li>
          <li><a href="adminAmministratori.php">Amministratori</a></li>
        </ul>
        <?php 
      } ?>
      </div>

      <div id="breadcrumb">
        <p id="path">Ti trovi in: Pannello amministrazione</p>
        <?php if (isset($_SESSION['login']) && $_SESSION['login'] == true) { ?>
        <a id="logout" href="adminHome.php?logout=true" xml:lang="en">Logout</a>
        <?php 
      } ?>
        <a id="toSite" href="../">Torna al sito</a>
      </div>
    </div>

    <div class="spacer">
      &nbsp;
    </div>

    <!-- <div class="top-img" id="home-top-img">
  </div> -->

    <?php
    if (isAdmin()) { ?>
      <div class="content">

        <div class="left-section">
          <h1>Benvenuto nel pannello di amministrazione</h1>
          <p>Qui potrai svolgere tutte le operazioni di amministrazione del sito.</p>
          <p>Le sezioni disponibili sono di seguito presentate:</p>
          <ul>
            <li>
              <h2>Prodotti</h2>
              <p>In questa sezione &egrave; possibile gestire i prodotti offerti dall'azienda. &Egrave; quindi possibile
                vedere le
                <span xml:lang='en'>cultivar</span> e modificarne la disponibilit&agrave; ed il prezzo. Inoltre,
                &egrave; possibile eliminare una
                <span xml:lang='en'>cultivar</span> esistente o inserirne una nuova.</p>
            </li>
            <li>
              <h2>Servizi</h2>
              <p>In questa sezione &egrave; possibile gestire i servizi offerti dall'azienda. &Egrave; quindi possibile
                vedere le macchine disponibilili e modificarne il prezzo. Inoltre, &egrave; possibile eliminare
                una macchina esistente o inserirne una nuova.</p>
            </li>
            <li>
              <h2>Storico prenotazioni</h2>
              <p>In questa sezione &egrave; possibile visualizzare lo storico delle prenotazioni, ossia quelle prenotazioni
                che hanno come data di restituzione una data precedente a quella odierna.</p>
            </li>
            <li>
              <h2>Prenotazioni</h2>
              <p>In questa sezione &egrave; possibile visualizzare le prenotazioni attive, ossia quelle prenotazioni
                che sono in corso o hanno una data di inizio dopo quella odierna. &Egrave; quindi possibile eliminare
                una prenotazione ed inserirne una nuova: &egrave; necessario inserire prima il cliente se questo
                non &egrave; gi&agrave; nel database; quando poi si inseriranno i campi dati relativi alla prenotazione,
                il controllo della disponibilit&agrave; del macchinario nelle date inserite verr&agrave; eseguito
                automaticamente.</p>
            </li>
            <li>
              <h2>Clienti</h2>
              <p>In questa sezione &egrave; possibile visualizzare i clienti inseriti nel database. Un cliente, per
                ragioni di sicurezza, deve essere salvato per prenotare un macchinario. &Egrave; quindi possibile
                modificare il numero di telefono e l'indirizzo <span xml:lang='en'>email</span> del cliente. Inoltre,
                &egrave; possibile inserirne uno nuovo o eliminarne uno esistente, solamente se questo non ha gi&agrave;
                effettuato una prenotazione per non creare disomogeneit&agrave; nel database.</p>
            </li>
            <li>
              <h2>Amministratori</h2>
              <p>In questa sezione &egrave; possibile visualizzare gli amministratori inseriti nel database. Nella
                lista non viene mostrato l'amministratore collegato all'account che ha eseguito l'accesso. &Egrave;
                quindi possibile eliminare un amministratore o inserne uno nuovo.</p>
            </li>
          </ul>
        </div>
      </div>
      <?php

    } else { ?>
        <div class="login-content">
          <h1>Pagina di <span xml:lang="en">login</span></h1>
          <form action="adminHome.php" method="post" id="login-form">
            <fieldset id="loginfields">
              <!-- <div id="loginFields"> -->
              <legend> <span xml:lang="en">Login</span></legend>

              <?php 
            if ($wronglogin)
              echo ($wrongloginmessage);
            ?>
              <ul>
                <li>
                  <label for="emailLogin">Email</label>:
                  <br/>
                  <input id="emailLogin" name="emailLogin" type="email" />
                </li>
                <li>
                  <label for="password"><span xml:lang="en">Password</span></label>:
                  <br/>
                  <input id="password" name="password" type="password" />
                </li>
                <li id="buttons-login">
                  <input value="Login" id="login-button" type="submit" />
                  <input value="Cancella" id="delete-login-button" type="reset" />
                </li>
              </ul>
            </fieldset>
            <!-- </div> -->
          </form>
        </div>
        <?php

      } ?>


          <div id="go-to-menu">
            <a href="#story">Torna su</a>
          </div>
          <div id="footer">
            <div id="site_info">
              <img id="xhtmlvalid" src="../../images/valid-xhtml10.png" lang="en" alt="XHTML valid" />
              <img id="cssvalid" src="../../images/vcss-blue.gif" lang="en" alt="CSS3 valid" />
              <p>Progetto didattico del corso Tecnologie <span xml:lang="en">web</span> prodotto da:</p>
              <ul id="collaborators">
                <li>Manuel Vianello - 1102466</li>
                <li>Stefano Panozzo - 1097068</li>
                <li>Giovanni Cavallin - 1148957</li>
              </ul>
            </div>
          </div>
          <!-- </div> -->



  </body>


</html>
