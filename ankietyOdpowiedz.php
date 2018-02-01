<?php
function AnkietyOdp(){
$id = $_GET['id'];
include "connect.php";
include "ankietyWypelnij.php";
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

// Ankieta anonimowa, przekieruj do wypelniania ankiety
if ($row->Anonimowosc == "1") {
    $retu=WypAnk();
    return $retu;
}
$retu ="";
// Zapisanie danych o ankietowanym do bazy
if (!empty($_POST)) {
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];

    $q = "INSERT INTO ankietowany (idAnkietowany, Imie, Nazwisko, Wypelnione_ankiety) VALUES(NULL, '$imie', '$nazwisko', 0)";
    $mysqli->query($q);
    // Zapisanie w sesji id ankietowanego
    $_SESSION['idAnkietowanego'] = $mysqli->insert_id;
    $retu=$retu.'aaa';
    // Przekierowanie do wypełniania ankiety
    $retu=WypAnk();
    return $retu;
}

$retu=$retu.'Ta ankieta nie jest anonimowa, podaj imię i nazwisko. <br/>';
$retu=$retu.'<form action="" method="POST">';
$retu=$retu.'Imię: <input type="text" name="imie" maxlength="45" /> <br/>';
$retu=$retu.'Nazwisko: <input type="text" name="nazwisko" maxlength="45" /> <br/>';
$retu=$retu.'<input type="submit" value="wypełnij ankiete" maxlength="45" />';
$retu=$retu.'</form>';
return $retu;
}
?>