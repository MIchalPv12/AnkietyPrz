<?php
function Edycja(){
$id = $_GET['id'];
include "connect.php";
$mysqli = new mysqli($host, $db_user, $db_password, $db_name);
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
 $retu='';
// Sprawdzanie czy napewno właściciel chce edytować ankietę
if ($row->Uzytkownicy_idUsers != $_SESSION['id']) {
    $retu=$retu. 'To nie jest twoja ankieta';
    exit;
}

// Aktualizacja danych
if ($_POST) {
    $tytul = $_POST['tytul'];
    $opis = $_POST['opis'];
    $anonimowosc = $_POST['anonimowosc'];

    // Aktualizacja danych w bazie
    $q = "UPDATE ankiety SET Tytul='$tytul', Opis='$opis', Rodzaj_pytania='$rozdaj', Anonimowosc='$anonimowosc' WHERE idAnkiety=$id";
    $mysqli->query($q);

    // Przekierowanie na tą samą stronę (odświeżenie danych w formularzu)
    header('Location: http://' . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI]);
}

$retu=$retu. '<form acrion="" method="POST">';
$retu=$retu. 'id: ' . $row->idAnkiety . ' <br/>';
$retu=$retu. 'tytuł: <input type="text" name="tytul" value="' . $row->Tytul . '" maxlength="45" /> <br/>';
$retu=$retu. 'opis: <input type="text" name="opis" value="' . $row->Opis . '" maxlength="45" /> <br/>';
$retu=$retu. 'anonimowosc: ';
$retu=$retu. '<select name="anonimowosc">';
$retu=$retu. '<option value="0" ' . ($row->Anonimowosc == 0 ? 'selected="selected"' : '') . ' >nie</option>';
$retu=$retu. '<option value="1" ' . ($row->Anonimowosc == 1 ? 'selected="selected"' : '') . ' >tak</option>';
$retu=$retu. '</select> <br/>';
$retu=$retu. 'właściciel: ' . $row->Uzytkownicy_idUsers . ' <br/>';
$retu=$retu. '<input type="submit" value="zapisz" />';
$retu=$retu. '</form>';
return $retu;
}