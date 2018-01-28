

<?php 
	
	include('funkcje.php');
	
	//$_SESSION['id'] = 1;
	//$_SESSION['idAnkiety'] = 10;
	
	if ( is_session_started() === FALSE ) session_start();
	
	$_SESSION['check'] = 0; //zapobiega wielokrotnemu wyswietlaniu sie komunikatow
	
	
	if(isset($_POST["tytulAnkiety"]) && isset($_POST["opisAnkiety"] ) && isset($_POST["Anonimowosc"]) && sprawdzPoleczenie() ){
		$polaczenie = sprawdzPoleczenie();
		$post = $opisAnkiety = $_POST["opisAnkiety"] ;
		 $tytulAnkiety = $_POST["tytulAnkiety"] ;
		$Anonimowosc = $_POST["Anonimowosc"] ;
		$id = $_SESSION['id'];
	
			
			
			
			$tytulAnkiety = htmlentities($tytulAnkiety, ENT_QUOTES, "UTF-8");
			$tytulAnkiety = mysqli_real_escape_string($polaczenie, $tytulAnkiety); 
			
			$Anonimowosc =  htmlentities($tytulAnkiety, ENT_QUOTES, "UTF-8");
			$Anonimowosc = mysqli_real_escape_string($polaczenie, $Anonimowosc); 
			
			
			$sql = "INSERT INTO `Ankiety` (`Tytul`, `Opis`, `Anonimowosc`, `Uzytkownicy_idUsers`) 
								VALUES ('{$tytulAnkiety}', '{$opisAnkiety}','{$Anonimowosc}','{$id}')";  
								
			if(wstawDoBazy($sql, $post)){
				echo '<center><div class="alert alert-success" role="alert">Ankieta dodana poprawnie</div><center>';
				
				$ostatnnioDodanaAnkieta = "select max(idAnkiety) as ostatniaAnkieta from ankiety where Uzytkownicy_idUsers = '{$id}' Limit 1";
				if(odczytaj($ostatnnioDodanaAnkieta, "ostatniaAnkieta")){
				//Jesli wstawimy ankiete poprawnie do bazy, to ustawiam zmienna sesyjna, ktora reprezentuja "aktywna" ankiete na ta ktora wlasnie dodalismy
					 $_SESSION["idAnkiety"] = odczytaj($ostatnnioDodanaAnkieta, "ostatniaAnkieta");
					 
					}

				header('Refresh: 2;url=index.php');  //po 2 sekundach przekierowuje nas do strony glownej
				
			}
			
			
		
	}else {
		echo '<center><div class="alert alert-danger" role="alert">Nie jesteś zalogowany</div><center>';
						header('Refresh: 2;url=index.php');  //po 2 sekundach przekierowuje nas do strony glownej
					}
?>

