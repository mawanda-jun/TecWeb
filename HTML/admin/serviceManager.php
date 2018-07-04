<?php require_once __DIR__ . "/../../php/connection.php";
require_once('uploadImage.php');
require_once('../../validation/validator.php');
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
    // $_SESSION['isError'] = false;
    // $_SESSION['errorUploadingImage'] = false;

        $fileName = basename($_FILES["fileToUpload"]["name"]);
        $id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
        $type = filter_var($_POST['type'], FILTER_SANITIZE_STRING);
        $name = filter_var($_POST['name'], FILTER_SANITIZE_STRING);
        $model = filter_var($_POST['model'], FILTER_SANITIZE_STRING);
        $power = filter_var($_POST['power'], FILTER_SANITIZE_NUMBER_FLOAT);
        $year = filter_var($_POST['year'], FILTER_SANITIZE_NUMBER_INT);
        $price = filter_var($_POST['price'], FILTER_SANITIZE_NUMBER_FLOAT);

        $error = validateServiceAdd($id, $type, $name, $model, $power, $year, $price);

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
                header("Location: sessione_scaduta.php");

                exit();
            } else
                if (!$connection->insertMachine($id, $type, $name, $model,$power,$year,$fileName,$price)) {
                $_SESSION['isError'] = true;
                $_SESSION['error'] = "C'&egrave; stato un problema l'inserimento del macchinario.";
            }
        }
    } else if (isset($_POST['submitPrice'])) {
        if (isset($_POST['machineID']) && !empty($_POST['machineID'])) {
            if (isset($_POST['price']))
                $connection->setMachinePrice($_POST['machineID'], $_POST['price']);
        }
    } else if (isset($_GET['remove']) && !empty($_GET['remove'])) {
        if (!$connection->removeMachine($_GET['remove'])) {
            $error = "L'eliminazione del macchinario non &egrave; andata a buon fine. Controlla che non sia gi&agrave; presente una prenotazione associata.";
        } else $error = null;
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
header("Location: adminServizi.php");
exit();
?>
