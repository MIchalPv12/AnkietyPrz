<?php
function Wyniki(){
$id = $_GET['id'];
include "connect.php";
$mysqli = new mysqli($host, $db_user, $db_password, $db_name);
// Sprawdzanie czy id jest napewno liczbą.
if (!is_numeric($id)) {
    header('Location: index.php');
}
$retu='';
// Link do eksportu danych do pliku csv
$retu=$retu. '<a href="ankietyCsv.php?id=' . $id . '"> Eksportuj dane do pliku *.csv </a> <br/>';


// Pytania zamknięte
$retu=$retu. '<h3>Odpowiedzi zamkniete:</h3>';

// W tym miejscu komentach jest chyba zbędny ;)
$q = "
SELECT pytania.idPytania, pytania.Tresc as pytanie, odp_zamknieta.Tresc as odpowiedz,
COUNT(odp_zamknieta_has_ankietowany.Ankietowany_idAnkietowany) as odpowiedzi FROM pytania
INNER JOIN odp_zamknieta ON odp_zamknieta.Pytania_idPytania = pytania.idPytania
LEFT JOIN odp_zamknieta_has_ankietowany ON odp_zamknieta.idOdp_zamknieta = odp_zamknieta_has_ankietowany.Odp_zamknieta_idOdp_zamknieta
WHERE pytania.Ankiety_idAnkiety = $id
GROUP BY odp_zamknieta.idOdp_zamknieta
";

$odpowiedzi = $mysqli->query($q);
$idPytania = 0;
while ($odpowiedz = $odpowiedzi->fetch_object()){
    if ($idPytania != $odpowiedz->idPytania) {
        $idPytania = $odpowiedz->idPytania;
        $retu=$retu. '<br/><h4>' . $odpowiedz->pytanie . '</h4><br/>';
    }
    $retu=$retu. '<b>' . $odpowiedz->odpowiedzi . 'x:</b> ' . $odpowiedz->odpowiedz . '<br/>';
}

// Pytania otwarte
$retu=$retu. '<hr/><h3>Odpowiedzi otwarte:</h3>';

$q = "SELECT pytania.idPytania, pytania.Tresc as pytanie, odp_otwarta.Tresc as odpowiedz FROM pytania
INNER JOIN odp_otwarta ON odp_otwarta.Pytania_idPytania = pytania.idPytania WHERE pytania.Ankiety_idAnkiety = $id";

$odpowiedzi = $mysqli->query($q);
$idPytania = 0;
while ($odpowiedz = $odpowiedzi->fetch_object()){
    if ($idPytania != $odpowiedz->idPytania) {
        $idPytania = $odpowiedz->idPytania;
        $retu=$retu. '<br/><h4>' . $odpowiedz->pytanie . '</h4><br/>';
    }
    $retu=$retu. $odpowiedz->odpowiedz . '<br/>';
}
return $retu;
}