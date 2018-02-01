

<?php 
	include "funkcje.php";
	
	if ( is_session_started() === FALSE ) session_start();
	//$_SESSION['id'] = null;
	$_SESSION['idAnkiety'] = $_GET['id'];
	//sprawdzenie czy mamy mniej niz 30 pytan
	
	$_SESSION['pytanie'] = 1;
	sprawdzLiczbePytan(30);
        $html = file_get_contents("dodaj_pytanie_zam.xhtml");
        $search='<!--submit-->';
        $replace =  submit();
        $html=str_replace($search,$replace,$html);	
        return $html;
?>






