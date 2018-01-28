<?php
session_start();
if (isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany'] == true)) {
    $menu = file_get_contents("zalogowany.xhtml");
}else{
    $menu = file_get_contents("niezalogowany.xhtml");
}
$html = file_get_contents("gui.xhtml");
$search='<!--menu-->';
$html=str_replace($search,$menu,$html);
$replace='';
                  
                $search='<!--002-->';
                $replace='Michal Posiewala: adres';
$html=str_replace($search,$replace,$html);
echo $html;
                ?>