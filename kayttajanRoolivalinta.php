<?php

session_start();

// print_r($_SESSION);

$myusername = $_SESSION['login_user'];

include("db_connection_config.php");

$sql = "SELECT b.henkiloID, b.sukunimi, b.etunimi
,c.asiakasID, c.nimi, c.tyyppi, f.rooliID, f.rooli
FROM kayttaja a
inner join henkilo b on (a.kayttajatunnus=b.sposti)
inner join asiakas c on (b.asiakasID=c.asiakasID)
inner join henkilonRooli e on (b.henkiloID=e.henkiloID)
inner join rooli f on (e.rooliID=f.rooliID)
WHERE a.kayttajatunnus = '$myusername'";

$result = mysqli_query($mysqli,$sql);
$row = mysqli_fetch_array($result,MYSQLI_ASSOC);

// $count = mysqli_num_rows($result);
// echo("Rivimäärä: " . $count);

$_SESSION['henkilo_ID']=$row['henkiloID'];
$_SESSION['sukunimi']=$row['sukunimi'];
$_SESSION['etunimi']=$row['etunimi'];
$_SESSION['asiakas_ID']=$row['asiakasID'];
$_SESSION['asiakas_nimi']=$row['nimi'];
$_SESSION['asiakas_tyyppi']=$row['tyyppi'];
$_SESSION['asiakas_nimi']=$row['nimi'];
$_SESSION['rooli_ID']=$row['rooliID'];
$_SESSION['rooli']=$row['rooli'];

if ($row['rooli']=='Projektipaallikko')
{
    header("location: ppview.php");  
}
elseif($row['rooli']=='Tyontekija')
{
    header("location: ttview.php");  
}
elseif($row['rooli']=='Asiakas')
{
    header("location: asview.php");  
}

// echo($row['rooli'] . " "  . $row['sukunimi'] . " " . $row['etunimi']);

?>  