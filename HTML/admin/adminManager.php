<?php require_once __DIR__ . "/../../php/connection.php";

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}
// function to write on console
function console($data)
{
  if (is_array($data))
    $output = "<script>console.log( 'Debug Objects: " . implode(',', $data) . "' );</script>";
  else
    $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";
  echo $output;
}

if (isset($_SESSION['login']) && $_SESSION['login'] === true) { // control if login has been successfull

  $connection = new DBConnection();
  $connection->openConnection();

  console($_POST['email']);
  console($_POST['password']);

  if (isset($_POST['submit'])) {

    if (!isset($_POST['email']) || empty($_POST['email']))
      $error = 'L\'<span xml:lang="en">email</span> non pu&ograve; essere vuota.';
    else if (!isset($_POST['password']) || empty($_POST['password']))
      $error = 'La password non pu&ograve; essere vuota';
    else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
      $error = 'L\'<span xml:lang="en">email</span> non &egrave; scritta correttamente. Seguire la prassi: "mario@gmail.com"';
    else if (strlen($_POST['password']) > 8)
      $error = 'La password non deve essere superiore agli 8 caratteri.';
    switch ($_POST['submit']) {
      default:
        $error = "action not found";
      case "add":
        {
          if ($error == null)
            $connection->insertAdmin($_POST['email'], $_POST['password']);
        };
      case "modify":
        {
            // nothing to do here for now
        };
    }
  } else if (isset($_GET['remove']) && !empty($_GET['remove'])) {
    $connection->removeAdmin($_GET['remove']);
    $error = null;
  }
  $connection->closeConnection();

} else {
  $error = "L'utente non &grave; pi&ugrave; loggato. Eseguire nuovamente il login.";
}

if ($error == null) {
  $_SESSION['error'] = null;
  $_SESSION['isError'] = false;
  $_SESSION['email'] = null;
  // header("Location: amministratori.php");
} else {
  $_SESSION['isError'] = true;
  $_SESSION['error'] = $error;
  if (isset($_POST['email'])) $_SESSION['email'] = $_POST['email'];
  // header("Location: sessione_scaduta.php");
}
header("Location: amministratori.php");
exit();
?>
