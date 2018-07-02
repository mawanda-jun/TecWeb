<?php require_once __DIR__ . "/../../php/connection.php";
require_once('../../validation/validator.php');

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
    
  } else if (isset($_GET['remove']) && !empty($_GET['remove'])) {
    if (!$connection->removePrenotation($_GET['remove']))
      $error = "L'eliminazione di una coltivazione non &egrave; andata a buon fine. ";
    else 
      $error = null;
  }
  $connection->closeConnection();

}else {
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
header("Location: adminPrenotazioni.php");
exit();