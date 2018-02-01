<?php
function WypAnk(){
include "connect.php";
$mysqli = new mysqli($host, $db_user, $db_password, $db_name);

$id = $_GET['id'];

// Sprawdzanie czy id jest napewno liczbą.
if (!is_numeric($id)) {
    header('Location: index.php');
}

// Pobieranie danych z bazy
$q = "SELECT * FROM ankiety WHERE idAnkiety=$id";

// Sprawdzanie czy napewno coś dostaliśmy
if (!($result = $mysqli->query($q))) {
    header('Location: index.php');
}

$row = $result->fetch_object();

// Sprawdzanie czy ankietowany podał imię i nazwisko
if ($row->Anonimowosc == "0" && !array_key_exists('idAnkietowanego', $_SESSION)) {
    header("Location: ?p=ankietyOdpowiedz&id=$id");
}

if (array_key_exists('idAnkietowanego', $_SESSION)) {
    $idAnkietowanego = $_SESSION['idAnkietowanego'];
} else {
    $idAnkietowanego = 0;
}


// Pobieranie danych z bazy
$q = "SELECT * FROM pytania WHERE Ankiety_idAnkiety=$id";

// Sprawdzanie czy napewno coś dostaliśmy
if (!($result = $mysqli->query($q))) {
    header('Location: index.php');
}

$i = 0;
$retu='';
$retu=$retu. '<form action="?p=zapiszOdpowiedzi&id=' . $id . '" method="POST">';
while ($row = $result->fetch_object()) {
    $retu=$retu. $row->Tresc . '<br/>';
    $idPytania = $row->idPytania;
    $retu=$retu. '<input type="hidden" name="' . $i . '_idPytania" value="' . $idPytania . '" />';


    $q = "SELECT * FROM odp_zamknieta WHERE Pytania_idPytania=$idPytania";
    $otwarte = true;
    $odpowiedzi = $mysqli->query($q);
    // Jeżeli dostaliśmy odpowiedzi mamy do czynienia z pytaniem otwartym
    while ($odpowiedz = $odpowiedzi->fetch_object()){
        $otwarte = false;
        $retu=$retu. '<input type="radio" name="' . $i . '_odpowiedz" value="' . $odpowiedz->idOdp_zamknieta . '" />' . $odpowiedz->Tresc . '<br/>';
    }

    // Jeżeli zmienna $otwarte nadal ma wartość true znaczy, że mamy do czynienia z pytaniem otwartym
    if ($otwarte) {
        $retu=$retu. '<input type="hidden" name="' . $i . '_otwarte" value="1" />';
        $retu=$retu. '<input type="text" name="' . $i . '_odpowiedz" maxlength="45" />';
    } else {
        // Informacja o tym, że pytanie było zamknięte
        $retu=$retu. '<input type="hidden" name="' . $i . '_otwarte" value="0" />';
    }

    $retu=$retu. '<br/><br/>';
    $i++;
}

$retu=$retu. '<input type="hidden" name="iloscPytan" value="' . $i . '" />';
$retu=$retu. '<input type="submit" value="wyślij" />';
$retu=$retu. '</form>';
return $retu;
}
