<?php

function ListaAnkiet(){
include "connect.php";
    $link = mysqli_connect("$host", "$db_user", "$db_password","$db_name");
    if (!$link) {
        die('Could not connect: ' . mysqli_error($link));
    }
 $zap = "SELECT * FROM ankiety";
 $result = mysqli_query($link,$zap);

$tabela="";

$tabela = $tabela.'<table>';
$tabela = $tabela.'<thead>';
$tabela = $tabela.'<th>id</th>';
$tabela = $tabela.'<th>tytuł</th>';
$tabela = $tabela.'<th>opis</th>';
$tabela = $tabela.'<th>rodzaj pytania</th>';
$tabela = $tabela.'<th>anonimowość</th>';
$tabela = $tabela.'<th>właściciel</th>';
$tabela = $tabela.'<th>akcje</th>';
$tabela = $tabela.'</thead>';
$tabela = $tabela.'<tbody>';
$anonim="TAK";
while ($row = $result->fetch_object()) {
    $tabela = $tabela.'<tr>';
    $tabela = $tabela.'<td>' . $row->idAnkiety . '</td>';
    $tabela = $tabela.'<td>' . $row->Tytul . '</td>';
    $tabela = $tabela.'<td>' . $row->Opis . '</td>';
    $tabela = $tabela.'<td>' . $row->Rodzaj_pytania . '</td>';
    if($row->Anonimowosc == 0) $anonim ="NIE";
    else $anonim = "TAK";
    $tabela = $tabela.'<td>' . $anonim . '</td>';
    $tabela = $tabela.'<td>' . $row->Uzytkownicy_idUsers . '</td>';
    $tabela = $tabela.'<td>';
    $tabela = $tabela.'<a href="?p=ankietyOdpowiedz&id=' . $row->idAnkiety . '">wypełnij</a> ';
    if ($row->Uzytkownicy_idUsers == $_SESSION['id']) {
        $tabela = $tabela.'<a href="?p=ankietyEdycja&id=' . $row->idAnkiety . '">edytuj</a> ';
        $tabela = $tabela.'<a href="?p=ankietyUsun&id=' . $row->idAnkiety . '">usuń</a> ';
        $tabela = $tabela.'<a href="?p=ankietyWyniki&id=' . $row->idAnkiety . '">wyniki</a> ';
		$tabela = $tabela.'<a href="?p=PytaniaOtwarteDodaj&id=' . $row->idAnkiety . '">Doda pytanie otwarte</a> ';
		$tabela = $tabela.'<a href="?p=PytaniaZamknieteDodaj&id=' . $row->idAnkiety . '">Doda pytanie zamkniete</a> ';
    }
    $tabela = $tabela.'</td>';
    $tabela = $tabela.'</td>';
    $tabela = $tabela.'</tr>';
}

$tabela = $tabela.'<tbody>';
$tabela = $tabela.'</table>';
return $tabela;
}