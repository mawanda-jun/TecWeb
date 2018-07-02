<?php
function isAdmin()
{
    return (isset($_SESSION['login']) && ($_SESSION['login'] === true));
}

function isEmpty($var)
{
    return (!isset($var) || empty($var)) ? true : false;
}

function valEmail($email)
{
    return filter_var($email, FILTER_VALIDATE_EMAIL) ? true : false;
}

function valPassword($password)
{
    return (strlen($password) <= 8) ? true : false;
}
function valID($id)
{
    return (strlen($id) <= 9) ? true : false;
}
function valName($name)
{
    return (strlen($name) <= 20) ? true : false;
}

function valPhone($phoneNumber)
{
    $isInt = ctype_digit($phoneNumber);
    // $isInt = filter_val((int)$phoneNumber, FILTER_VALIDATE_INT);
    $isShort = strlen($phoneNumber) <= 14;
    return $isInt && $isShort ? true : false;
    return true;
}

function valFloat($n)
{
    return (filter_val($n, FILTER_VALIDATE_FLOAT)) ? true : false;
}


function validateAdminAdd($email, $password)
{
    if (isEmpty($email) || isEmpty($password))
        return "Nessun campo pu&ograve; essere vuoto";
    else if (!valEmail($email))
        return 'L\'<span xml:lang="en">email</span> non &egrave; scritta correttamente. Seguire la prassi: "mario@gmail.com"';
    else if (!valPassword($password))
        return 'La password non deve essere superiore agli 8 caratteri.';
    else return false;
}

function validateClientAdd($id, $name, $surname, $phone, $email)
{
    if (isEmpty($id) || isEmpty($email) || isEmpty($name) || isEmpty($surname) || isEmpty($phone))
        return "Nessun campo pu&ograve; essere vuoto";
    else if (!valName($name))
        return "Il nome &egrave; troppo lungo";
    else if (!valName($surname))
        return "Il cognome &egrave; troppo lungo";
    else if (!valID($id))
        return "Codice carta d'identit&agrave; troppo lungo";
    else if (!valPhone($phone))
        return "Il numero di telefono &egrave; troppo lungo";
    else if (!valEmail($email))
        return 'L\'<span xml:lang="en">email</span> non &egrave; scritta correttamente. Seguire la prassi: "mario@gmail.com"';
    else return false;
}

function validateGrainAdd($name, $description, $fileName, $price, $availability)
{
    if (isEmpty($name) || isEmpty($description) || isEmpty($fileName) || isEmpty($price) || isEmpty($availability))
        return "Nessun campo pu&ograve; essere vuoto";
    else if (strlen($description) > 500)
        return 'Descrizione troppo lunga. Usare meno di 500 caratteri.';
    else if (!valFloat($price))
        return "Formato prezzo non valido. Ricordarsi di usare: 10.10";
    else if (!valEmail($availability))
        return "Formato disponibilit&agrave; non valido. Ricordarsi di usare: 10.10";
    else return false;
}



?>
