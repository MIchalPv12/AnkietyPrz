<?php
session_start();
include "connect.php";
$link=mysqli_connect("$host", "$db_user", "$db_password","$db_name");
$log = $_SESSION['login'];
mysqli_query($link,"DELETE FROM uzytkownicy WHERE login='$log'")
        or die('Błąd zapytania: ' . mysql_error());
session_unset();
header('Location: index.php');
?>