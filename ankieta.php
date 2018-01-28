<?php
include "funkcje.php";
if ( is_session_started() === FALSE ) session_start();

	//$_SESSION['id'] = 1;
	//$_SESSION['idAnkiety'] = 10;

	

	$_SESSION['pytanie'] = 0;
	
//sprawdzam tutaj liczbe ankiet, aby nie bylo wiecej niz 10
	sprawdzLiczbePytan(10);  
        echo file_get_contents("nowa_ankieta.xhtml");
?>
	
	