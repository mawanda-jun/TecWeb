<?php require_once __DIR__ . "/../../php/connection.php"; ?>
<?php require_once('../../validation/validator.php'); ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<?php
header('Content-type: application/xhtml+xml');
if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (!isAdmin()) {
  $_SESSION['error'] = "Sessione invalida";
  header("Location: sessione_scaduta.html");
  session_unset();
  session_destroy();
  exit();
}
?>

  <head>
    <title>Amministratori</title>
    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
    <meta name="descripion" content="Pagina di gestione degli amministratori" />
    <meta name="author" content="Tecwweb&amp;Pastorizia" />
    <meta name="keywords" content="agricoltura, azienda, agricola, grano, duro, biologico, HTML, CSS, JavaScript, MySQL, informatica"/>
    <link rel="icon" type="image/png" href="../images/icon/favicon-32x32.png" sizes="32x32" />
    <link rel="icon" type="image/png" href="../images/icon/favicon-16x16.png" sizes="16x16" />
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
          <li><a href="adminProdotti.php" lang="en" tabindex="1">Prodotti</a></li>
          <li><a href="adminServizi.php" tabindex="5">Servizi</a></li>
          <li><a href="adminOrdini.php" tabindex="7">Ordini</a></li>
          <li><a href="adminPrenotazioni.php" tabindex="9">Prenotazioni</a></li>
          <li><a href="adminClienti.php" tabindex="11">Clienti</a></li>
          <li class="active"><a href="adminAmministratori.php" tabindex="11">Amministratori</a></li>
        </ul>
      </div>

      <div id="breadcrumb">
        <p id="path" tabindex="12">Ti trovi in: Amministrazione > Amministratori</p>
        <a id="logout" href="adminHome.php?logout=true" xml:lang="en">Logout</a>
        <a id="toSite" href="../">Torna al sito</a>
      </div>
    </header>

    <div class="spacer">
      &nbsp;
    </div>


    <div class="admins">
      <div id="description">
        <h1>Benvenuto nella pagina di gestione degli amministratori</h1>
        <p>In questa pagina &egrave; possibile inserire ed eliminare altri amministratori.</p>
      </div>

      <?php if(isset($_SESSION['isError']) && $_SESSION['isError']) {
        echo '<p id="error">' . $_SESSION['error'] . '</p>';
        $_SESSION['isError'] = false;
      }
      $connection = new DBConnection();
      $connection->openConnection();
      $admins = $connection->getListAdmins();
      if ($admins != null) {
        echo '<div class="listAndDelete"><p>Lista degli amministratori:</p><ul>';
        foreach ($admins as $admin)
          echo '<li>' . $admin['email'] . ' <a class="button" title="Rimuovi amministratore ' . $admin['email'] . '"' . ' href="adminManager.php?remove=' . $admin['email'] . '" >Elimina</a></li>';
        echo '</ul></div>';
      } else
        echo '<div id="">Non ci sono altri amministratori.</div>';
      ?>

        <h1>Aggiungi un amministratore</h1>
        <form id="insertAdmin" action="adminManager.php" method="post">
          <!-- onsubmit="return validateFormInsertAdmin()"> da usare quando e se avremo uno script di validazione -->
          <fieldset id="adminFields">
            <legend>Inserisci i seguenti dati:</legend>
            <label for="email"><span xml:lang="en">Email:</span></label>
            <input name="email" type="email" id="email" size="30" maxlength="50" value="<?php echo isset($_SESSION['email']) ? $_SESSION['email'] : '' ?>"
            />
            <label for="password"><span xml:lang="en">Password:</span></label>
            <input name="password" type="password" id="password" size="10" maxlength="12" />
            <input type="submit" value="Aggiungi" name="submit" />
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
