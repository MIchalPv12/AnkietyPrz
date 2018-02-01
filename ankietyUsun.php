<?php

$id = $_GET['id'];

// Sprawdzanie czy podane id jest napewno liczbą
if (!is_numeric($id)) {
    header('Location: index.php');
}

$q = "SELECT * FROM ankiety WHERE idAnkiety=$id";

// Sprawdzanie czy dostaliśmy poprawną odpowiedź
if (!($result = $mysqli->query($q))) {
    header('Location: index.php');
}

$row = $result->fetch_object();

// Sprawdzanie czy napewno właściciel chce usunąć ankietę
if ($row->Uzytkownicy_idUsers != $_SESSION['id']) {
    echo 'To nie jest twoja ankieta';
    exit;
}

// Usuwanie wpisu z bazy
$q = "DELETE FROM ankiety WHERE idAnkiety=$id";
$mysqli->query($q);

// Przekierowanie na stronę główną po usunuęciu
header('Location: index.php');
