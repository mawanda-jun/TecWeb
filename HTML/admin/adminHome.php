<?php require_once __DIR__ . "/../../php/connection.php"; ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<?php
header('Content-type: application/xhtml+xml');
if (session_status() == PHP_SESSION_NONE) { session_start(); }

$wronglogin = false;
$wrongloginmessage = '<div id="wronglogin">Dati errati!</div>';

// $connection = new DBAccess();
// $connection->openConnection();

if(isset($_POST['email']) && isset($_POST['password']))
    // if($connection->adminLogIn( $_POST['email'], $_POST['password'])) //linea dove avviene il controllo dell'accesso
    if(($_POST['email'] == "admin") && ($_POST['password'] == "admin"))
	{
		$_SESSION['login'] = true;
		$_SESSION['email'] = $_POST['email'];
	}
// else
	// $wronglogin = true;

// $connection->closeConnection();

if(isset($_GET['logout']) && $_GET['logout'] == "true")
{
	$_SESSION['login'] = false;
	$_SESSION['email'] = null;
  header("Location: ../home.html");
  session_unset();
  session_destroy();
	die();
}
if(isset($_SESSION['login']) && $_SESSION['login'] == true)
	$title = "Pannello di amministrazione";
else
	$title = "Login";
?>

  <head>
    <title>
      <?php echo $title ?>
    </title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="pannello_amministrazione" content="Pagina di amministrazione per gli amministratori" />
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

        <?php if (isset($_SESSION['login']) && $_SESSION['login'] == true) { ?>

        <ul id="navbar">
          <li class="active"><a href="adminHome.php" lang="en" tabindex="1">Pannello amministrazione</a></li>
          <li><a href="prodotti.php" lang="en" tabindex="1">Prodotti</a></li>
          <li><a href="servizi.php" tabindex="5">Servizi</a></li>
          <li><a href="ordini.php" tabindex="7">Ordini</a></li>
          <li><a href="prenotazioni.php" tabindex="9">Prenotazioni</a></li>
          <li><a href="clienti.php" tabindex="11">Clienti</a></li>
          <li><a href="amministratori.php" tabindex="11">amministratori</a></li>
          <li><a href="adminHome.php?logout=true" xml:lang="en">Logout</a></li>
        </ul>
        <?php 
    } ?>
      </div>

      <div id="breadcrumb">
        <div id="path" tabindex="12"><a href="../">Torna al sito</a></div>
      </div>
    </header>

    <div class="spacer">
      &nbsp;
    </div>

    <!-- <div class="top-img" id="home-top-img">
  </div> -->

    <?php
	if (isset($_SESSION['login']) && $_SESSION['login'] == true) { ?>
      <div class="content">

        <div class="left-section" id="story">
          <h1 tabindex="13">La nostra storia</h1>
          <p tabindex="15">Qui metteremo un breve riassunto di quello che andremo a scrivere nella pagina "chi siamo"Qui
            metteremo un breve riassunto di quello che andremo a scrivere nella pagina "chi siamo"Qui
            metteremo un breve riassunto di quello che andremo a scrivere nella pagina "chi siamo"Qui
            metteremo un breve riassunto di quello che andremo a scrivere nella pagina "chi siamo"Qui
            metteremo un breve riassunto di quello che andremo a scrivere nella pagina "chi siamo"Qui
            metteremo un breve riassunto di quello che andremo a scrivere nella pagina "chi siamo"Qui
            metteremo un breve riassunto di quello che andremo a scrivere nella pagina "chi siamo"
          </p>
          <img src="../images/history-home.png" alt="Vecchia foto di un contadino al lavoro" tabindex="16" />
        </div>
        <div class="right-section" id="products-overview">
          <h1 tabindex="17">I nostri prodotti</h1>
          <p tabindex="19">Qui metteremo un breve riassunto di quello che andremo a scrivere nella pagina "chi siamo"Qui
            metteremo un breve riassunto di quello che andremo a scrivere nella pagina "chi siamo"Qui
            metteremo un breve riassunto di quello che andremo a scrivere nella pagina "chi siamo"Qui
            metteremo un breve riassunto di quello che andremo a scrivere nella pagina "chi siamo"Qui
            metteremo un breve riassunto di quello che andremo a scrivere nella pagina "chi siamo"Qui
            metteremo un breve riassunto di quello che andremo a scrivere nella pagina "chi siamo"Qui
            metteremo un breve riassunto di quello che andremo a scrivere nella pagina "chi siamo"
          </p>
          <img src="../images/grano_misto.jpg" alt="Grano misto" tabindex="21" />
        </div>
      </div>

      <?php

} else { ?>
        <h1>Pagina di <span xml:lang="en">login</span></h1>
        <form action="adminHome.php" method="post" id="loginform">
          <!-- <fieldset id="loginfields"> -->
          <!-- <div id="loginFields"> -->
          <legend> <span xml:lang="en">Login</span></legend>

          <?php 
			if ($wronglogin)
				echo ($wrongloginmessage);
			?>
          <label for="email">Email</label>:
          <input id="email" name="email" type="text" />
          <br/>
          <label for="password"><span xml:lang="en">Password</span></label>:
          <input id="password" name="password" type="password" />
          <br/>
          <input value="Login" type="submit" />
          <input value="Cancella" type="reset" />
          <!-- </fieldset> -->
          <!-- </div> -->
        </form>
        <a href="adminHome.php?logout=true" xml:lang="en">Logout</a>
        <a href="../">Torna al sito</a>
        <?php

} ?>


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
