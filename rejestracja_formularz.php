<?php
session_start();
include "connect.php";
mysqli_connect("$host", "$db_user", "$db_password","$db_name");
if (isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany'] == true)) {
    header('Location: menu.php');
    exit();
}
$html = file_get_contents("gui.xhtml");
$menu = file_get_contents("niezalogowany.xhtml");
$search='<!--menu-->';
$html=str_replace($search,$menu,$html);
$replace='';


                    if (isset($_SESSION['blad'])) {
                        echo $_SESSION['blad'];
                        unset($_SESSION['blad']);
                    }
                    if (isset($_SESSION['zablokowany'])) {
                        echo $_SESSION['zablokowany'];
                        unset($_SESSION['zablokowany']);
                    }
$search='<!--001-->';
$html=str_replace($search,$replace,$html);
$replace='';
$html2=file_get_contents("form_rej.xhtml");
    //                if (isset($plec) && $plec == "female") ; 
        //            if (isset($plec) && $plec == "male") ; 

                    if (isset($_SESSION['blad_dane'])) {
                        $replace= $_SESSION['blad_dane'];
                        unset($_SESSION['blad_dane']);
                    }
                    if (isset($_SESSION['zlehaslo'])) {
                        $replace= $_SESSION['zlehaslo'];
                        unset($_SESSION['zlehaslo']);
                    }
                    if (isset($_SESSION['zajetylogin'])) {
                        $replace= $_SESSION['zajetylogin'];
                        unset($_SESSION['zajetylogin']);
                    }
$search='<!--003-->';
$html2=str_replace($search,$replace,$html2);
$replace='';   
$search='<!--002-->';
$html=str_replace($search,$html2,$html);
echo $html;
                    ?>