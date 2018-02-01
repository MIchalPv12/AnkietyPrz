<?php
session_start();
include "connect.php";
mysqli_connect("$host", "$db_user", "$db_password","$db_name");
if (isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany'] == true)) {
    
} else
    header('Location: index.php');

$html = file_get_contents("gui.xhtml");
$menu = file_get_contents("zalogowany.xhtml");
$search='<!--menu-->';
$html=str_replace($search,$menu,$html);
$replace='';
$search='<!--001-->';
$html=str_replace($search,$replace,$html);
$replace='';
$html2=file_get_contents("edytujdane.xhtml");
$search='<!--002-->';
$html=str_replace($search,$html2,$html);
                    if (isset($_SESSION['blad_dane'])) {
                        $html=$html. $_SESSION['blad_dane'];
                        unset($_SESSION['blad_dane']);
                    }
echo $html
                    ?>
            