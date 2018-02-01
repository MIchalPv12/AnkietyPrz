<html lang="pl">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
	</head>
	
	<!-- Bootstrap -->
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

<?php
	
	//tworzy  przycisk submit, ktora zawiera dymek z tytulem ankiety do ktorej dodajemy pytanie
	function submit(){
	if ( is_session_started() === FALSE ) session_start();
	
	if(isset($_SESSION["idAnkiety"])){
		$idAnkiety = $_SESSION["idAnkiety"];
	
		$sql = "select Tytul from ankiety where idAnkiety = '{$idAnkiety}' limit 1";
		$tytul = odczytaj($sql, "Tytul");
		return '<a href="#" class="tool" tresc="Do ankiety o tytule '.$tytul.'"><input name="submit" type="submit" class="btn btn-primary bt" value="Prześlij pytania"> </a>';
		}
		else return  '<input name="submit" type="submit" class="btn btn-primary bt" value="Prześlij pytania"> ';
	}
	
    //zapobiega pokazywanie bledow
	//ini_set('error_reporting', 0);
	//ni_set('display_errors', 0);
	
	//Universal function for checking session status.
	function is_session_started()
{
    if ( php_sapi_name() !== 'cli' ) {
        if ( version_compare(phpversion(), '5.4.0', '>=') ) {
            return session_status() === PHP_SESSION_ACTIVE ? TRUE : FALSE;
        } else {
            return session_id() === '' ? FALSE : TRUE;
        }
    }
    return FALSE;
}


	function sprawdzPoleczenie(){
	
		include 'connect.php';
		 $polaczenie = @new mysqli($host, $db_user, $db_password, $db_name); // Ustawienie połączenia z bazą
		if($polaczenie->connect_errno!=0) // jeśli nie uda się połączyć z bazą
		{
			echo "Error: ".$polaczenie->connect_errno;
			exit;
		}
		else
		{
			if ( is_session_started() === FALSE ) session_start();
	
			mysqli_query($polaczenie,'SET NAME utf8');
			mysqli_query($polaczenie,"SET CHARACTER SET 'utf8'");
			if(isset($_SESSION['id'])){
				return $polaczenie;
			}else return null;
		}
		$polaczenie->close();
	}
	
	
	function sprawdzLiczbePytan($maksLiczbaPytan){
	
		
		if(sprawdzPoleczenie()){
			$IdUser = $_SESSION['id'];
			$polaczenie = sprawdzPoleczenie();
			if($_SESSION['pytanie'] == 1 && isset($_SESSION['idAnkiety']) ){
			$IdAnkiety = $_SESSION['idAnkiety'];
			$zapytanie = "SELECT count(idPytania) as liczbaPytan from pytania 
									where Ankiety_idAnkiety = '{$IdAnkiety}' ";
									
									
			}else $zapytanie = "SELECT count(idAnkiety) as liczbaPytan from ankiety
				where Uzytkownicy_idUsers = {$IdUser} ";
			
								
		/*
			if ($wynik = mysqli_query($polaczenie, $zapytanie)  ) {
				$row = mysqli_fetch_assoc($wynik);
				$liczbaPytan = $row["liczbaPytan"] ;
				
				*/
				$nazwa = "liczbaPytan";
				$liczbaPytan = odczytaj($zapytanie, $nazwa);
				if($_SESSION['pytanie'] == 1)
				echo "<input type='hidden' id=liczbaPytan name=liczbaPytan value={$liczbaPytan} />";
									
				if($liczbaPytan > $maksLiczbaPytan){
					if($_SESSION['pytanie'] == 1){
					echo '<center><div class="alert alert-danger" role="alert">Masz już  ',$liczbaPytan,' pytań nie możesz dodać więcej</div><center>';
						header('Refresh: 2;url=index.php');  //po 2 sekundach przekierowuje nas do strony glownej
						exit;
					}else echo '<center><div class="alert alert-danger" role="alert">Masz już  ',$liczbaPytan,' ankiet nie możesz dodać więcej</div><center>';
					
					header('Refresh: 2;url=index.php');  //po 2 sekundach przekierowuje nas do strony glownej
					exit;
				}
								
			
			}else{
				echo '<center><div class="alert alert-danger" role="alert">Nie jesteś zalogowany</div><center>';
				header('Refresh: 2;url=index.php');  //po 2 sekundach przekierowuje nas do strony glownej
				exit;		
				}			
	}
		
	


function wstawDoBazy($sql, $post){
	
	if ( is_session_started() === FALSE ) session_start();
	
	if($_SESSION['check'] == 0){		//zapobiega bledom wieloktornego wywolani
		function filtruj($post){
			if(get_magic_quotes_gpc())
			$post = stripslashes($post); // usuwamy slashe
	 
			// usuwamy spacje, tagi html oraz niebezpieczne znaki
			return mysql_real_escape_string(htmlspecialchars(trim($post)));
		}
	}
	header('Content-Type: text/html; charset=utf-8'); 

	
		if(sprawdzPoleczenie()){  //sprawdza czy jestesmy zalogowani i poleczeni
			$polaczenie = sprawdzPoleczenie();
			
				//sprawdzanie poprawnosci zmiennej
				$post = htmlentities($post, ENT_QUOTES, "UTF-8");
				$post = mysqli_real_escape_string($polaczenie, $post); 
				
						//wlozenie do bazy
			if (!mysqli_query($polaczenie,$sql)) {
				die('Error: ' . mysqli_error($polaczenie));
			}elseif($_SESSION['check']  == 0) {
				echo '<center><div class="alert alert-success" role="alert">Wszystko ok</div><center>';
				$_SESSION['check']  = 1;
				header('Refresh: 2;url=index.php');  //po 2 sekundach przekierowuje nas do strony glownej
				return 1;
				
				
				
				}
					
		}else{
				echo '<center><div class="alert alert-danger" role="alert">Nie jesteś zalogowany</div><center>';
				header('Refresh: 2;url=index.php');  //po 2 sekundach przekierowuje nas do strony glownej
				return null;
				exit;
				} 
	}



function odczytaj($sql, $RowName){

								$polaczenie = sprawdzPoleczenie();
								if ($result = mysqli_query($polaczenie, $sql)) {
									$row = mysqli_fetch_assoc($result);
									return $row[$RowName] ;
									
								}else {
								echo "Cos poszlo nie tak";
								return null;
								header('Refresh: 2;url=index.php');  //po 2 sekundach przekierowuje nas do strony glownej
								exit;
								}
	
}

?>
</html>