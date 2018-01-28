<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-2" />
	<!-- Bootstrap -->
        <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
</head>

<?php 
	include('funkcje.php');
	
	if ( is_session_started() === FALSE ) session_start();
	
	//$_SESSION['id'] = 1;
	//$_SESSION['idAnkiety'] = 10;
	
	
	$_SESSION['check'] = 0;
	
	if(isset($_POST["trescZamkniete"]) && isset($_SESSION['idAnkiety']) ){
		$idAnkiety = $_SESSION['idAnkiety'];
		$post = $_POST["trescZamkniete"];
		
		$sql = "INSERT INTO `pytania` (`Tresc`, `Ankiety_idAnkiety`) 
						VALUES ('{$post}', '{$idAnkiety}')";   
		if(wstawDoBazy($sql, $post)){
			$query = "SELECT idPytania from pytania 
								where Tresc = '{$post}' 
								AND Ankiety_idAnkiety = '{$idAnkiety}' Limit 1";
			$RowName = "idPytania";
			$Pytania_idPytania = odczytaj($query, $RowName);
			
			$i = 0;				
		while(isset($_POST["odp"][$i])){
		
			$post2 = $_POST["odp"][$i];
			$sql2 =  "INSERT INTO `odp_zamknieta` (`Tresc`, `Pytania_idPytania`) 
							VALUES ('{$post2}', '{$Pytania_idPytania}')"; 
			wstawDoBazy($sql2, $post2);
			$i++;
			
		}				
			
			
		}
						
		
		
	}
    
?>
</html>