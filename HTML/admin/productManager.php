<?php require_once __DIR__ . "/../../php/connection.php";
require_once('uploadImage.php');

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (isset($_SESSION['login']) && $_SESSION['login'] === true) { // control if login has been successfull
  // $_SESSION['fileName'] = $_FILES["fileToUpload"]["name"];
  // $_SESSION['file'] = $_FILES["fileToUpload"]["tmp_name"];

  $connection = new DBConnection();
  $connection->openConnection();
  if (isset($_POST['submit'])) {
    // make null variables so I don't use them
    $_SESSION['isError'] = false;
    $_SESSION['errorUploadingImage'] = false;

    $fileName = basename($_FILES["fileToUpload"]["name"]);

    if (!isset($_POST['name']) || empty($_POST['name']))
      $error = 'Il nome non pu&ograve; essere vuoto.';
    else if (!isset($_POST['availability']) || empty($_POST['availability']))
      $error = 'La disponibilit&agrave; non pu&ograve; essere nulla.';
    else if (!filter_var($_POST['availability'], FILTER_VALIDATE_FLOAT))
      $error = 'La disponibilit&agrave; non &egrave; nel formato corretto. Usare il formato: "10.5"';
    else if (!isset($_POST['price']) || empty($_POST['price']))
      $error = 'Il prezzo non pu&ograve; essere nullo.';
    else if (!filter_var($_POST['availability'], FILTER_VALIDATE_FLOAT))
      $error = 'Il prezzo non &egrave; nel formato corretto. Usare il formato: "50.1"';
    else if (strlen($_POST['description']) > 500)
      $error = 'Descrizione troppo lunga. Usare meno di 500 caratteri.';
    switch ($_POST['submit']) {
      default:
        $error = "action not found";
      case "Aggiungi":
        {
          if ($error == null) {
            $fileName = $_FILES["fileToUpload"]["name"];
            $tmpFileName = $_FILES["fileToUpload"]["tmp_name"];
            $fileSize = $_FILES['fileToUpload']['size'];
            $errorOrOk = uploadImage($fileName, $tmpFileName, $fileSize);

            if ($errorOrOk['error'] != null) {
              $_SESSION['isError'] = true;
              $_SESSION['error'] = $errorOrOk['error'];
              $_SESSION['errorUploadingImage'] = $errorOrOk['error'];
              header("Location: adminProdotti.php");
              exit();
            } else
              if (!$connection->insertGrain($_POST['name'], $_POST['description'], $fileName, $_POST['price'], $_POST['availability'])) {
            // if (!$connection->insertGrain('ciao', 'ciao', 'image.img', '123', '123')) {
              $_SESSION['isError'] = true;
              $_SESSION['error'] = "C'&egrave; stato un problema durante il caricamento della <span xml:lang='en'>cultivar</span>";
            }
          }
        };
      case "modify":
        {
            // nothing to do here for now
        };
    }
  } else if (isset($_GET['grainName']) && !empty($_GET['grainName'])) {
    if (isset($_POST['availability']))
      $connection->setGrainAvailability($_GET['grainName'], $_POST['availability']);
    else if (isset($_POST['price']))
      $connection->setGrainPrice($_GET['grainName'], $_POST['price']);
  } else if (isset($_GET['remove']) && !empty($_GET['remove'])) {
    if (!$connection->removeGrain($_GET['remove']))
      $error = "L'eliminazione di una coltivazione non &egrave; andata a buon fine. ";
    else $error = null;
  }
  $connection->closeConnection();

} else {
  $error = "L'utente non &grave; pi&ugrave; loggato. Eseguire nuovamente il login.";
}

if ($error == null) {
  $_SESSION['error'] = null;
  $_SESSION['isError'] = false;
  // $_SESSION['email'] = null;
} else {
  $_SESSION['isError'] = true;
  $_SESSION['error'] = $error;
  // if (isset($_POST['email'])) $_SESSION['email'] = $_POST['email'];
}
header("Location: adminProdotti.php");
exit();
?>
