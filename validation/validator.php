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

function valName($name)
{
    return (strlen($name) <= 20) ? true : false;
}

function valPhone($phoneNumber)
{
    return (strlen($phoneNumber) <= 14) ? true : false;
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

function validateClientAdd($name, $surname, $phone, $email)
{
    if (isEmpty($email) || isEmpty($name) || isEmpty($surname) || isEmpty($phone))
        return "Nessun campo pu&ograve; essere vuoto";
    else if (!valName($name))
        return "Il nome &egrave; troppo lungo";
    else if (!valName($surname))
        return "Il cognome &egrave; troppo lungo";
    else if (!valPhone($phone))
        return "Il numero di telefono &egrave; troppo lungo";
    else if (!valEmail($email))
        return 'L\'<span xml:lang="en">email</span> non &egrave; scritta correttamente. Seguire la prassi: "mario@gmail.com"';
    else return false;
}



?>
