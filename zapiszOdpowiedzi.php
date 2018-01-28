<?php

$id = $_GET['id'];

// Sprawdzanie czy id jest napewno liczbą.
if (!is_numeric($id)) {
    header('Location: index.php');
}

// Sprawdzenie czy dostaliśmy odpowiedzi
if(empty($_POST)) {
    header('Location: index.php');
}

// Zapisanie id ankietowanego do zmiennej, jeżeli to była ankieta anonimowa to 0
if (array_key_exists('idAnkietowanego', $_SESSION)) {
    $idAnkietowanego = $_SESSION['idAnkietowanego'];
    unset($_SESSION['idAnkietowanego']);
} else {
    $idAnkietowanego = 0;
}


for ($i = 0; $i < $_POST['iloscPytan']; $i++) {
    $idPytania = $_POST[$i . '_idPytania'];
    $odpowiedz = $_POST[$i . '_odpowiedz'];
    // Odpowiedź otwarta
    if ($_POST[$i . '_otwarte'] == "1") {
        $q = "INSERT INTO odp_otwarta VALUES (NULL, '$odpowiedz', '$idPytania')";
    }
    // odpowiedź zamknięta
    else {
        $q = "INSERT INTO odp_zamknieta_has_ankietowany VALUES ('$idAnkietowanego', '$odpowiedz')";
    }
    $mysqli->query($q);
}

echo 'Dziękujemy za wypełnienie ankiety!';
