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
  die();
}
?>

  <head>
    <title>Amministratori</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="gestione_amministratori" content="Pagina di gestione degli amministratori" />
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
          <li><a href="prodotti.php" lang="en" tabindex="1">Prodotti</a></li>
          <li><a href="servizi.php" tabindex="5">Servizi</a></li>
          <li><a href="ordini.php" tabindex="7">Ordini</a></li>
          <li><a href="prenotazioni.php" tabindex="9">Prenotazioni</a></li>
          <li><a href="clienti.php" tabindex="11">Clienti</a></li>
          <li class="active"><a href="amministratori.php" tabindex="11">Amministratori</a></li>
        </ul>
      </div>

      <div id="breadcrumb">
        <p id="path" tabindex="12">Ti trovi in: Amministratori</p>
        <a id="logout" href="adminHome.php?logout=true" xml:lang="en">Logout</a>
        <a id="toSite" href="../">Torna al sito</a>
      </div>
    </header>

    <div class="spacer">
      &nbsp;
    </div>

    <?php
    $connection = new DBConnection();
    $connection->openConnection();
    ?>

      <div class="admin">
        <div id="description">
          <h3>Benvenuto nella pagina di gestione degli amministratori.</h3>
          <p>In questa pagina &egrave; possibile inserire ed eliminare altri amministratori.</p>
        </div>


        <?php
        $admins = $connection->getListAdmins();
        if ($admins != null) {
          echo '<div class="listAndDelete"><p>Lista degli amministratori:</p><ul>';
          foreach ($admins as $admin)
            echo '<li>' . htmlspecialchars($admin['email']) . ' <a class="button" title="removing admin ' . htmlspecialchars($admin['email']) . '"' . ' href="adminManager.php?delete=' . htmlspecialchars($admin['email']) . '" >Elimina</a></li>';
          echo '</ul></div>';
        } else
          echo '<div id="">Non ci sono altri amministratori.</div>';
        ?>

          <h3>Aggiungi un amministratore</h3>
          <form id="insertAdmin" action="adminManager.php" method="post">
            <!-- onsubmit="return validateFormInsertAdmin()"> da usare quando e se avremo uno script di validazione -->
            <fieldset id="adminFields">
              <legend>Inserisci i seguenti dati:</legend>
              <label for="email"><span xml:lang="en">Email</span></label>
              <input name="email" type="text" id="email" size="30" maxlength="50" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : ''?>" />
              <label for="password"><span xml:lang="en">Password</span></label>
              <input name="password" type="text" id="password" size="10" maxlength="12" />
              <input type="submit" value="add" name="submit" />
              <div id="errorInput">
                <?php if (isset($_SESSION['isError']) && $_SESSION['isError']) echo $_SESSION['error'] ?>
              </div>
              <!-- <input type="reset" value="Cancella i campi" name="reset"/> -->
            </fieldset>
          </form>
          <?php
          $connection->closeConnection();
          ?>

      </div>


      <div id="go-to-menu">
        <a href="#story">Torna su</a>
      </div>
      <footer>
        <div class="shrink-center">
          <img id="xhtmlvalid" src="../../images/valid-xhtml10.png" lang="en" alt="XHTML valid" />
          <img id="cssvalid" src="../../images/vcss-blue.gif" lang="en" alt="CSS valid" />
          <p>Da pensare a cosa scriverci</p>
        </div>
      </footer>
      <!-- </div> -->



  </body>


</html>
