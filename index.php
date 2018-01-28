<?php
session_start();
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
                        $replace = $_SESSION['blad'];
                        unset($_SESSION['blad']);
                    }
                    if (isset($_SESSION['zablokowany'])) {
                        $replace= $_SESSION['zablokowany'];
                        unset($_SESSION['zablokowany']);
                    }
$search='<!--001-->';
$html=str_replace($search,$replace,$html);
$replace='';
                if (isset($_SESSION['zarejestrowany'])) {
                    $replace= $_SESSION['zarejestrowany'];
                    unset($_SESSION['zarejestrowany']);
                }
                $search='<!--002-->';
                $replace='<center> <img src="obrazki/witaj.png" width="400" height="142"/></center>' 
                          .'<br/>  1. Każdy użytkownik może bezpłatnie stworzyć ankietę.<br/>'
                .'2. Utworzoną ankietę może wysłać do konkretnej osoby lub puli wybranych osób poprzez adres e-mail.<br/>'
                .'3. Ankiety zawierają zarówno pytania otwarte, jak i zamknięte.<br/>'
                .'4. Każdy z uczestików posiada możliwość sprawdzenia i przeglądnięcia wyników swoich ankiet.<br/>'.$replace;
$html=str_replace($search,$replace,$html);
echo $html;
                ?>
           