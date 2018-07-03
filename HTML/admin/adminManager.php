<?php require_once __DIR__ . "/../../php/connection.php";
require_once('../../validation/validator.php');

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

if (isAdmin()) { // control if login has been successfull

  $connection = new DBConnection();
  $connection->openConnection();

  if (isset($_POST['submit'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    $email = filter_var($email, FILTER_SANITIZE_EMAIL);

    $error = validateAdminAdd($email, $password);
    switch ($_POST['submit']) {
      default:
        $error = "action not found";
      case "Aggiungi amministratore":
        {
          if ($error == false) {
            $connection->insertAdmin($email, $password);
            $error = null;
          }
        };
    }
  } else if (!isEmpty($_GET['remove'])) {
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
} else {
  $_SESSION['isError'] = true;
  $_SESSION['error'] = $error;
  if (!isEmpty($email)) $_SESSION['email'] = $_POST['email'];
}
header("Location: adminAmministratori.php");
exit();
?>
