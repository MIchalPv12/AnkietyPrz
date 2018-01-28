	
		
<?php
include "funkcje.php";

	if ( is_session_started() === FALSE ) session_start();
	
	//$_SESSION['id'] = 1;
	$_SESSION['idAnkiety'] =  $_GET['id'];;
	
	$_SESSION['pytanie'] = 1;  //do poprawnego wyswietlania echa, czy chodzi o ankiete czy pytanie
	sprawdzLiczbePytan(30);
$html = file_get_contents("dodaj_pytanie.xhtml");
$search='<!--submit-->';
$replace =  submit();
$html=str_replace($search,$replace,$html);	
return $html;

 ?> 
		
		
		
	





