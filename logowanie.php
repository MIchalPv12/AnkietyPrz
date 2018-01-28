<?php
session_start();
if ((!isset($_POST['login'])) || (!isset($_POST['haslo']))) {
    header('Location: index.php');
    exit();
}
include "connect.php";
$polaczenie = @new mysqli($host, $db_user, $db_password, $db_name); // ustawienie połączenia z bazą
if ($polaczenie->connect_errno != 0) { // jeśli nie uda się połączyć z bazą
    echo "Error: " . $polaczenie->connect_errno;
} else {
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];
    $login = htmlentities($login, ENT_QUOTES, "UTF-8"); // zabezpieczenia
    $haslo = htmlentities($haslo, ENT_QUOTES, "UTF-8"); // zabezpieczenia
    if ($wynikpolaczania = @$polaczenie->query(
                    sprintf("SELECT * FROM uzytkownicy WHERE Login='%s' AND Haslo='%s' AND Zablokowany!='1'", mysqli_real_escape_string($polaczenie, $login), mysqli_real_escape_string($polaczenie, $haslo)))) { // sprawdzenie czy zapytanie jest dobrze zapisane
        $uzytkownicy = $wynikpolaczania->num_rows; // zwrocenie ile uzytkownikow ma podany login i haslo
        if ($uzytkownicy > 0) { // jezeli udalo sie zalogowac i login i haslo znajduje sie w bazie danych
            $_SESSION['zalogowany'] = true;
            $wiersz = $wynikpolaczania->fetch_assoc();
            $_SESSION['id'] = $wiersz['idUsers'];
            $_SESSION['login'] = $wiersz['Login']; // pobrania wartosci z kolumny login		
            unset($_SESSION['blad']);
            unset($_SESSION['zablokowany']);
            $wynikpolaczania->free_result();
            header('Location: menu.php');
        } else {
            if ($wynikpolaczania = @$polaczenie->query(
                            sprintf("SELECT * FROM uzytkownicy WHERE Login='%s' AND Haslo='%s' AND Zablokowany='1'", mysqli_real_escape_string($polaczenie, $login), mysqli_real_escape_string($polaczenie, $haslo)))) { // sprawdzenie czy zapytanie jest dobrze zapisane
                $uzytkownicy = $wynikpolaczania->num_rows; // zwrocenie ile uzytkownikow ma podany login i haslo
                if ($uzytkownicy > 0) { // jezeli udalo sie zalogowac i login i haslo znajduje sie w bazie danych
                    unset($_SESSION['blad']);
                    $_SESSION['zablokowany'] = '<span style="color:red">Twoje konto jest zablokowane!</span>';
                    header('Location: index.php');
                } else {
                    unset($_SESSION['zablokowany']);
                    $_SESSION['blad'] = '<span style="color:red">Nieprawidłowy login lub hasło!</span>';
                    header('Location: index.php');
                }
            }
        }
    }
    $polaczenie->close();
}
?>