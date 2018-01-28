<?php

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

// Ankieta anonimowa, przekieruj do wypelniania ankiety
if ($row->Anonimowosc == "1") {
    header("Location: ?p=ankietyWypelnij&id=$id");
    exit;
}

// Zapisanie danych o ankietowanym do bazy
if ($_POST) {
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];

    $q = "INSERT INTO ankietowany (idAnkietowany, Imie, Nazwisko, Wypelnione_ankiety) VALUES(NULL, '$imie', '$nazwisko', 0)";
    $mysqli->query($q);

    // Zapisanie w sesji id ankietowanego
    $_SESSION['idAnkietowanego'] = $mysqli->insert_id;

    // Przekierowanie do wypełniania ankiety
    header("Location: ?p=ankietyWypelnij&id=$id");
}

echo 'Ta ankieta nie jest anonimowa, podaj imię i nazwisko. <br/>';
echo '<form action="" method="POST">';
echo 'Imię: <input type="text" name="imie" maxlength="45" /> <br/>';
echo 'Nazwisko: <input type="text" name="nazwisko" maxlength="45" /> <br/>';
echo '<input type="submit" value="wypełnij ankiete" maxlength="45" />';
echo '</form>';

