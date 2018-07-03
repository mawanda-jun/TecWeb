<?php require_once('../validation/validator.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="it" lang="it">

<?php 
if(isset($_POST['submit'])){
    $to = "aziendacavallin@gmail.com";
    $from = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
    if(valEmail($from) && ctype_alpha($first_name)) {
        $subject = "Richiesta informazioni Azienda Cavallin";
        $subject2 = "Copia richiesta informazioni Azienda Cavallin";
        $message = "Messaggio da: " . $first_name . "\n\n" . $_POST['message'];
        $message2 = "Copia del messaggio inviato ad Azienda Cavallin" . "\n\n" . $_POST['message'];
        $headers = "From:" . $from;
        $headers2 = "From:" . $to;
        mail($to,$subject,$message,$headers);
        mail($from,$subject2,$message2,$headers2); // copia al sender della mail
    }
}
?>

<head>
  <title>Contattaci</title>
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <meta name="description" content="Pagina dei contatti" />
  <meta name="author" content="Tecwweb&amp;Pastorizia" />
  <meta name="keywords" content="agricoltura, azienda, agricola, grano, duro, biologico, HTML, CSS, JavaScript, MySQL, informatica"
  />
  <link rel="icon" type="image/png" href="../images/icon/favicon-32x32.png" />
  <link rel="icon" type="image/png" href="../images/icon/favicon-16x16.png" />
  <link href="../css/style.css" rel="stylesheet" type="text/css" media="handheld, screen" />
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
        <li><a href="../html/servizi.php" tabindex="10" target="_top">Servizi</a></li>
        <li class="active"><a href="../html/contattaci.php" tabindex="10" target="_top">Contattaci</a></li>
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
      <p id="path">Ti trovi in: Contattaci</p>
      <a id="go-to-content" href="#anchor" tabindex="1" target="_self">Vai al contenuto</a>
    </div>
  </div>

  <div class="spacer" id="contattaci-spacer">
    &nbsp;
  </div>

  <div class="content">
    <div id="anchor"></div>
    <div class="center-section" id="contact-us">
      <h1>Vuoi contattarci?</h1>
      <h2>Richiedi informazione compilando il modulo!<br>Ti contatteremo il prima possibile!</h2>
      <form id="contattaci-form" action="" method="post">
        <ul>
          <li class="name-form">
            <label for="name">Nome:</label>
            <input type="text" name="first_name" class="form-control" id="name" required>
          </li>
          <li class="email-form">
            <label for="email" xml:lang="en">E-mail:</label>
            <input type="email" name="email" class="form-control" id="email" size="35" required>
          </li>
          <li class="message-form">
            <label for="message-text">Messaggio:</label>
            <textarea name="message" class="form-control" id="message-text"></textarea>
          </li>
          <li class="submit-form">
            <input type="submit" name="submit" value="Richiedi informazioni" class="form-control-submit">
          </li>
        </ul>
      </form>
      <p>Se la richiesta è andata a buon fine, riceverai alla casella di posta indicata una copia della mail appena inviata.</p>
      <p>Se riscontri dei problemi, in alternativa, puoi utilizzare il tuo client di posta al seguente <a href="mailto:aziendacavallin@gmail.com?subject=Richiesta informazioni Azienda Cavallin">link</a>.</p>
    </div>
  </div>
  <div id="go-to-menu">
    <a href="#anchor" tabindex="900" target="_self">Torna su</a>
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
    <ul id="navbar">
      <li><a href="../html/home.html" lang="en" tabindex="10" target="_top">Home</a></li>
      <li><a href="../html/chi-siamo.html" tabindex="10" target="_top">Chi siamo</a></li>
      <li><a href="../html/prodotti.php" tabindex="10" target="_top">Prodotti</a></li>
      <li><a href="../html/servizi.php" tabindex="10" target="_top">Servizi</a></li>
      <li class="active"><a href="../html/contattaci.php" tabindex="10" target="_top">Contattaci</a></li>
    </ul>
  </div>
</body>
</html>