<?php

session_start();
include "connect.php";
$link=mysqli_connect("$host", "$db_user", "$db_password","$db_name");

function filtr($zmienna,$linkk) {
    if (get_magic_quotes_gpc())
        $zmienna = stripslashes($zmienna); // usuwamy slashe
// usuwamy spacje, tagi html oraz niebezpieczne znaki
   return mysqli_real_escape_string($linkk,htmlspecialchars(trim($zmienna)));
}

if (isset($_POST['rejestruj'])) {
    $login = filtr($_POST['login'],$link);
    $haslo1 = filtr($_POST['haslo1'],$link);
    $haslo2 = filtr($_POST['haslo2'],$link);
    $email = filtr($_POST['email'],$link);
    $imie = $_POST['imie'];
    $nazwisko = $_POST['nazwisko'];
    $plec = $_POST['plec'];
    $data_ur = $_POST['data_ur'];
    $wojewodztwo = $_POST['wojewodztwo'];
    $haslo = $_POST['haslo'];
    $log = $_SESSION['login'];
    // sprawdzamy czy login nie jest już w bazie
    if (mysqli_num_rows(mysqli_query($link,"SELECT Login FROM uzytkownicy WHERE Login = '" . $login . "';")) == 0) {
        if ($haslo1 == $haslo2) { // sprawdzamy czy hasła takie same
            if ($imie != null && $nazwisko != null && $plec != null && $data_ur != null && $wojewodztwo != null && $haslo1 != null && $login != null && $email != null && $haslo2 != null) {
                mysqli_query($link,"INSERT INTO `uzytkownicy` (`Login`, `Haslo`, `Adres_email`, `Data_zalozenia_konta`)
                                                    VALUES ('" . $login . "', '" . ($haslo1) . "', '" . $email . "', '" . date("Y-m-d") . "');");
                mysqli_query($link,"UPDATE uzytkownicy SET Imie = '$imie', Nazwisko = '$nazwisko', "
                        . "Plec='$plec', Data_urodzenia='$data_ur', Wojewodztwo='$wojewodztwo' WHERE login='$login'");

                $_SESSION['zarejestrowany'] = '<span style="color:red">Konto zostało utworzone!</span>';
                header('Location: index.php');
            } else {
                $_SESSION['blad_dane'] = '<span style="color:red">Pola nie mogą pozostać puste!</span>'.$haslo2.$nazwisko;
                header('Location: rejestracja_formularz.php');
            }
        } else {
            $_SESSION['zlehaslo'] = '<span style="color:red">Hasła nie są takie same</span>';
            header('Location: rejestracja_formularz.php');
        }
    } else {
        $_SESSION['zajetylogin'] = '<span style="color:red">Podany login jest już zajęty.</span>';
        header('Location: rejestracja_formularz.php');
    }
}
?>