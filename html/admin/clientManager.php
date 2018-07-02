<?php require_once __DIR__ . "/../../php/connection.php";
require_once('../../validation/validator.php');

session_start();

if (isAdmin()) { // control if login has been successfull

  $connection = new DBConnection();
  $connection->openConnection();

  if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);
    $cognome = filter_var($_POST['cognome'], FILTER_SANITIZE_STRING);
    $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_NUMBER_INT);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    $error = validateClientAdd($id, $nome, $cognome, $telefono, $email);
    switch ($_POST['submit']) {
      default:
        $error = "action not found";
      case "Aggiungi":
        {
          if ($error == false) {
            $connection->insertClient($id, $nome, $cognome, $telefono, $email);
            $error = null;
          }
        };
    }
  } else if (isset($_POST['submitNumber'])) {
    if (isset($_POST['number']) && isset($_POST['clientId']))
      if (!$connection->setClientNumber($_POST['clientId'], $_POST['number']))
      $error = "Errore durante la modifica del numero di telefono.";
    else $error = null;

  } else if (isset($_POST['submitEmail'])) {
    if (isset($_POST['email']) && isset($_POST['clientId']))
      if (!$connection->setClientEmail($_POST['clientId'], $_POST['email']))
      $error = "Errore durante la modifica dell'indirizzo mail.";
    else $error = null;

  } else if (isset($_GET['remove']) && !empty($_GET['remove'])) {
    if (!$connection->removeClient($_GET['remove']))
      $error = "Errore durante l'eliminazione del cliente. Ricorda che non è possibile eliminare un cliente associato ad una prenotazione!";
    else $error = null;
  }
  $connection->closeConnection();

} else {
  $error = "L'utente non &grave; pi&ugrave; loggato. Eseguire nuovamente il login.";
}

if ($error == null) {
  $_SESSION['error'] = null;
  $_SESSION['isError'] = false;
} else {
  $_SESSION['isError'] = true;
  $_SESSION['error'] = $error;
}
header("Location: adminClienti.php");
exit();

?>
