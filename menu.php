<?php
include "connect.php";
include "ankietyLista.php";
include "zapiszOdpowiedzi.php";
include "ankietyEdycja.php";
include "ankietyWyniki.php";
session_start();
include "ankietyOdpowiedz.php";
if (!isset($_SESSION['zalogowany'])) {
    header('Location: index.php');
    exit();
}

$log = $_SESSION['login'];
$link = mysqli_connect("$host", "$db_user", "$db_password","$db_name");
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
$zapytanie = mysqli_query($link,"Select administrator From uzytkownicy where login='$log'");
if (mysqli_num_rows($zapytanie)) {
    $row = mysqli_fetch_row($zapytanie);
    foreach ($row as $value) {
        $admin = $value;
    }
}
$html = file_get_contents("gui.xhtml");
$menu = file_get_contents("zalogowany.xhtml");
$search='<!--menu-->';
$html=str_replace($search,$menu,$html);
$html2 = file_get_contents("sidebar.xhtml");
$replace=$html2;
            if ($admin == 1) {
                $replace=$replace.'<a href="administracja.php">';
                $replace=$replace.'<div class="optionL" style="color: #000000">Administracja</div></a>';
            }
$search='<!--003-->';
$html=str_replace($search,$replace,$html);
$replace='';           
        include "connect.php";
        $mysqli = new mysqli($host, $db_user, $db_password, $db_name);
        if (array_key_exists('p', $_GET)) {
            $subPage = $_GET['p'];
        } else {
            $subPage = '';
        }

        switch ($subPage) {
            case 'ankietyEdycja':
                $replace= Edycja();
                break;
            case 'PytaniaOtwarteDodaj':
                $replace= include "PytaniaOtwarteDodaj.php";
                break;
            case 'PytaniaZamknieteDodaj':
                $replace= include "PytaniaZamknieteDodaj.php";
                break;
            case 'ankietyUsun':
                $replace= include "ankietyUsun.php";
                break;
            case 'ankietyOdpowiedz':
                $replace= AnkietyOdp();
                break;
            case 'ankietyWypelnij':
                $replace= include "ankietyWypelnij.php";
                break;
            case 'zapiszOdpowiedzi':
                $replace= zapisz();
                break;
            case 'ankietyWyniki':
                $replace= Wyniki();
                break;
            case 'ankietyLista':
                $replace= ListaAnkiet();
                break;
            default:
                $replace=  '<b> Witaj użytkowniku!</b> </br>Wszystkie opcje dostępne są na panelu z lewej części strony.';
                break;
        }
        $search='<!--002-->';
        $html=str_replace($search,$replace,$html);
        echo $html
        ?>

 