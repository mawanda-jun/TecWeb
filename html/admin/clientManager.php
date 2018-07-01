<?php require_once __DIR__ . "/../../php/connection.php";

session_start();

if (isset($_SESSION['login']) && $_SESSION['login'] === true) { // control if login has been successfull

  $connection = new DBConnection();
  $connection->openConnection();

  if (isset($_POST['submit'])) {
      // manca controllo su valori campi dati immessi
    if (!isset($_POST['nome']) || empty($_POST['nome']))
      $error = 'Il nome non pu&ograve; essere vuoto';
    else if (!isset($_POST['cognome']) || empty($_POST['cognome']))
      $error = 'Il cognome non pu&ograve; essere vuoto';
    else if (!isset($_POST['telefono']) || empty($_POST['telefono']))
      $error = 'Il numero di telefono non pu&ograve; essere vuoto';
    else if (isset($_POST['email']) || !empty($_POST['email']))
      if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
      $error = 'L\'<span xml:lang="en">email</span> non &egrave; scritta correttamente. Seguire la prassi: "mario@gmail.com"';

    switch ($_POST['submit']) {
      default:
        $error = "action not found";
      case "Aggiungi":
        {
          if ($error == null)
            $connection->insertClient($_POST['id'], $_POST['nome'], $_POST['cognome'], $_POST['telefono'], $_POST['email']);
        };
      case "Modifica":
        {

        };
    }
  } else if (isset($_GET['remove']) && !empty($_GET['remove'])) {
    if (!$connection->removeClient($_GET['remove']))
      $error = "Errore durante l'eliminazione del cliente. Ricorda che non è possibile eliminare un cliente associato ad una prenotazione!";
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

