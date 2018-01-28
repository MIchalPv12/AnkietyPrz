<?php

require_once 'mail.php';
include "connect.php";
function select(&$zap) {
	include "connect.php";
    $link = mysqli_connect("$host", "$db_user", "$db_password","$db_name");
    if (!$link) {
        die('Could not connect: ' . mysqli_error($link));
    }
 
    $result = mysqli_query($link,$zap);
	
    $tabela='<table border="1">';
    $tabela=$tabela.'<tr><th>ID</th><th>Login</th><th>Hasło</th><th>Imie</th><th>Nazwisko</th><th>Płeć</th>'
    . '<th>Data urodzenia</th><th>Województwo</th><th>Adres eMail</th><th>Data zał. konta</th><th>Wyp. ankiety</th><th>Zam. ankiety</th>'
    . '<th>Admin</th><th>Zab.</th></tr>';
    while ($row = mysqli_fetch_row($result)) {
        $tabela=$tabela. '<tr>';
        foreach ($row as $value) {
            $tabela=$tabela. '<td>' . $value . '</td>';
        }
        $tabela=$tabela. '</tr>';
    }
    $tabela=$tabela. '</table>';
    mysqli_free_result($result);

    mysqli_close($link);
	return $tabela;
}
$html = file_get_contents("gui.xhtml");
session_start();
if (!isset($_SESSION['zalogowany'])) {
    header('Location: index.php');
    exit();
}

$log = $_SESSION['login'];
$link = mysqli_connect("$host", "$db_user", "$db_password","$db_name");
			if (!$link) {
			die('Could not connect: ' . mysqli_error($link));
			}
			$zapytanie = mysqli_query($link,"Select administrator From uzytkownicy where login='$log'");
			if(mysqli_num_rows($zapytanie)){
			$row = mysqli_fetch_row($zapytanie);
			foreach ($row as $value) {
            $admin=$value;
			}
        }
		if(!$admin){
			exit();
		}
    $menu = file_get_contents("zalogowany.xhtml");
    $search='<!--menu-->';
    $html=str_replace($search,$menu,$html);
    $html2=file_get_contents("sidebar.xhtml");
    $replace='<a href="usuwanie.php"><div class="optionL" style="color: #000000">Administracja</div></a>';
    $replace = $html2.$replace;
    $search = "<!--003-->";
    $html=str_replace($search,$replace,$html);
    $panel_admin=file_get_contents("panel_admin.xhtml");
if (isset($_REQUEST['Wybierz'])) {
    $id = $_POST['id'];
    if($id!=''){
     
    
    $zapytanie = mysqli_query($link,"Select Login From uzytkownicy where idUsers='$id'");
    if(mysqli_num_rows($zapytanie)){
    $row = mysqli_fetch_row($zapytanie);
    foreach ($row as $value) {
            $replace=$value;
        }
    $search=":Login:";
    $panel_admin=str_replace($search,$replace,$panel_admin);
    $zapytanie = mysqli_query($link,"Select Haslo From uzytkownicy where idUsers='$id'");
    $row = mysqli_fetch_row($zapytanie);
    foreach ($row as $value) {
            $replace=$value;
        }
    $search=":Haslo:";
    $panel_admin=str_replace($search,$replace,$panel_admin);
    }
    $replace='name="id" value="'.$id.'"';
    $search='name="id"';
    $panel_admin=str_replace($search,$replace,$panel_admin);
    }
	$search='id="edit" style="visibility:hidden"';
	$replace='id="edit" style="visibility:visible"';
    $panel_admin=str_replace($search,$replace,$panel_admin);
   
}


if (isset($_REQUEST['Edytuj'])) { 
    $id = $_POST['id'];
    $login = $_POST['login'];
    $haslo = $_POST['haslo'];
    mysqli_query($link,"UPDATE uzytkownicy SET Login = '$login' WHERE idUsers='$id'");
    mysqli_query($link,"UPDATE uzytkownicy SET Haslo = '$haslo' WHERE idUsers='$id'");
}
if (isset($_REQUEST['Usun'])) { 
    $id = $_POST['id'];
    mysqli_query($link,"DELETE FROM uzytkownicy WHERE idUsers='$id'") ;
}
if (isset($_REQUEST['Blokuj'])) { 
	
    $id = $_POST['id'];
	$zapytanie = mysqli_query($link,"Select Zablokowany From uzytkownicy where idUsers='$id'");
	if(mysqli_num_rows($zapytanie)){
    $row = mysqli_fetch_row($zapytanie);
    foreach ($row as $value) {
            $zap=$value;
        }
	}
    if($zap) mysqli_query($link,"UPDATE uzytkownicy SET Zablokowany = 0 WHERE idUsers='$id'");
	else mysqli_query($link,"UPDATE uzytkownicy SET Zablokowany = 1 WHERE idUsers='$id'");
}
if (isset($_REQUEST['Wyswietl'])) { //2
    $plec = $_POST['plec'];
    $woj = $_POST['woj'];
    $data = $_POST['Data'];
    $data2 = $_POST['Data2'];
    $wynik = "SELECT * from uzytkownicy where Plec like '$plec%' and Wojewodztwo like '$woj%'";

    if (isset($_POST['Data_od'])) {
        $wynik = $wynik . " and data_urodzenia>=CAST('$data' as DATETIME)";
    }
    if (isset($_POST['Data_do'])) {
        $wynik = $wynik . " and data_urodzenia<=CAST('$data2' as DATETIME)";
    }

    $tabela=select($wynik);
	$search='id="tabela">';
	$replace='id="tabela">'.$tabela;
    $panel_admin=str_replace($search,$replace,$panel_admin);
}
$search='<!--002-->';
    $html=str_replace($search,$panel_admin,$html);
echo $html;
if (isset($_REQUEST['Wyslij'])) { //2
    $temat = $_POST['Temat'];
    $wiad = $_POST['wiad'];
    $zapytanie = mysqli_query($link,"Select adres_email From uzytkownicy");
    while ($row = mysqli_fetch_row($zapytanie)) {
        foreach ($row as $value) {
            smtp_mail($value, $temat, $wiad);
        }
    }
    
}
?>