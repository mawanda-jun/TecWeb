<?php require_once __DIR__ . "/../../php/connection.php";
require_once('../../validation/validator.php');
require_once('uploadImage.php');
require_once('deleteImage.php');

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (isAdmin()) { // control if login has been successfull
  // $_SESSION['fileName'] = $_FILES["fileToUpload"]["name"];
  // $_SESSION['file'] = $_FILES["fileToUpload"]["tmp_name"];

  $connection = new DBConnection();
  $connection->openConnection();
  if (isset($_POST['submit'])) {
    // make null variables so I don't use them
    $_SESSION['isError'] = false;
    $_SESSION['errorUploadingImage'] = false;

    $fileName = basename($_FILES["fileToUpload"]["name"]);

    $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
    $availability = filter_var($_POST['availability'], FILTER_SANITIZE_NUMBER_FLOAT);
    $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_STRING);


    $error = validateGrainAdd($name, $description, $fileName, $price, $availability);

    switch ($_POST['submit']) {
      default:
        $error = "action not found";
      case "Aggiungi":
        {
          if ($error == null) {
            $fileName = $_FILES["fileToUpload"]["name"];
            $tmpFileName = $_FILES["fileToUpload"]["tmp_name"];
            $fileSize = $_FILES['fileToUpload']['size'];
            $errorOk = uploadImage($fileName, $tmpFileName, $fileSize);

            if ($errorOk['error'] != null) {
              if (!$_SESSION['already'])
                deleteImage($fileName);
              $error = $errorOk['error'];
              $_SESSION['isError'] = true;
              $_SESSION['error'] = $error;
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
  } else if (isset($_POST['submitAvailability'])) {  //&& !empty($_POST['submitAvailability'])) {
    if (isset($_POST['availability']) && isset($_POST['grainName']))
      $connection->setGrainAvailability($_POST['grainName'], $_POST['availability']);
      // $_SESSION['availability'] = $_POST['availability'];
      // $_SESSION['grainName'] = $_POST['grainName'];
  } else if (isset($_POST['submitPrice'])) {
    if (isset($_POST['price']) && isset($_POST['grainName']))
      if ($_POST['price'] > 999.99) $error = "Prezzo troppo alto, il massimo &egrave; di 999.99";
    else
      $connection->setGrainPrice($_POST['grainName'], $_POST['price']);
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
