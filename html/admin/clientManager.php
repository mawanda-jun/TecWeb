<?php require_once __DIR__ . "/../../php/connection.php";

session_start();

if (isAdmin()) { // control if login has been successfull

  $connection = new DBConnection();
  $connection->openConnection();

  if (isset($_POST['submit'])) {

    $nome = filter_var($_POST['nome'], FILTER_SANITIZE_STRING);
    $cognome = filter_var($_POST['cognome'], FILTER_SANITIZE_STRING);
    $telefono = filter_var($_POST['telefono'], FILTER_SANITIZE_NUMBER_INT);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

    $error = validateClientAdd($nome, $cognome, $telefono, $email);
    switch ($_POST['submit']) {
      default:
        $error = "action not found";
      case "Aggiungi":
        {
          if ($error == false) {
            $connection->insertClient($_POST['id'], $_POST['nome'], $_POST['cognome'], $_POST['telefono'], $_POST['email']);
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
  $_SESSION['email'] = null;
} else {
  $_SESSION['isError'] = true;
  $_SESSION['error'] = $error;
  if (isset($_POST['email'])) $_SESSION['email'] = $_POST['email'];
}
header("Location: adminClienti.php");
exit();

?>
