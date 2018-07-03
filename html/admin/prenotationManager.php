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

    if($_POST['start'] == null || $_POST['end'] == null)
      $error = "Le date di inizio e fine prenotazione devono essere definite!";
  
    else if($_POST['start'] > $_POST['end'])
      $error = "La data di fine prenotazione non può essere precedente a quella di inizio!";
    
    else if($_POST['start'] < date('Y-m-d'))
      $error = "La data di prenotazione non può essere passata";
    // Controllo sulla disponibilità della prenotazione
    
    $order = $connection->getMachineAvailability($_POST['machineID'], $_POST['start'], $_POST['end']);
    if($order != null)
      $error = "Il macchinario selezionato non è disponibile in queste date. Controlla l'ordine #" . $order . " per maggiori informazioni";
      
    if($error == null)
      $connection->insertPrenotation($_POST['clientID'], $_POST['machineID'], $_POST['start'], $_POST['end']);

  } else if (isset($_GET['remove']) && !empty($_GET['remove'])) {
    if (!$connection->removePrenotation($_GET['remove']))
      $error = "L'eliminazione della prenotazione non &egrave; andata a buon fine. ";
    else 
      $error = null;
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
header("Location: adminPrenotazioni.php");
exit();