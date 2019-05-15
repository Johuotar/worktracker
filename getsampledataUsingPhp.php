<?php

require 'db_connection_config.php';  
$sql = "SELECT * FROM asiakas";

$result = mysqli_query($mysqli, $sql) or die ("Bad Query: $sql");

$numfields = 1; // mysqli_field_count($result); // mysql_num_fields($result);

echo("<h3>Asiakas </h3>");

echo("<table border=2>");

/* Get field information for all columns */
$finfo = mysqli_fetch_fields($result);

foreach ($finfo as $val) {
    // printf("Name:      %s\n",   $val->name);
    // printf("Table:     %s\n",   $val->table);
    // printf("Max. Len:  %d\n",   $val->max_length);
    // printf("Length:    %d\n",   $val->length);
    // printf("charsetnr: %d\n",   $val->charsetnr);
    // printf("Flags:     %d\n",   $val->flags);
    // printf("Type:      %d\n\n", $val->type);

    echo ('<th>'.$val->name.'</th>');
}

while ($row = mysqli_fetch_assoc($result)) {
    echo ("<tr>");

    foreach ($finfo as $val) {
    echo ("<td>{$row[$val->name]}</td>");
    }

    echo ("</tr>");
}
echo("</table> <br> <br>");


// seuraava looppi
$sql = "SELECT * FROM henkilo";

$result = mysqli_query($mysqli, $sql) or die ("Bad Query: $sql");

    // taulun rakentaminen ja populointi
    echo("<h3>Henkilö </h3>");
    echo("<table border=2>");
    /* Get field information for all columns */
    $finfo = mysqli_fetch_fields($result);
    foreach ($finfo as $val) {echo ('<th>'.$val->name.'</th>');}
    while ($row = mysqli_fetch_assoc($result)) {
        echo ("<tr>");
        foreach ($finfo as $val) {echo ("<td>{$row[$val->name]}</td>");}
        echo ("</tr>");
    }
    echo("</table> <br> <br>");

// seuraava looppi
$sql = "SELECT * FROM rooli";

$result = mysqli_query($mysqli, $sql) or die ("Bad Query: $sql");

    // taulun rakentaminen ja populointi
    echo("<h3>Rooli </h3>");
    echo("<table border=2>");
    /* Get field information for all columns */
    $finfo = mysqli_fetch_fields($result);
    foreach ($finfo as $val) {echo ('<th>'.$val->name.'</th>');}
    while ($row = mysqli_fetch_assoc($result)) {
        echo ("<tr>");
        foreach ($finfo as $val) {echo ("<td>{$row[$val->name]}</td>");}
        echo ("</tr>");
    }
    echo("</table> <br> <br>");
    // end of: taulun rakentaminen ja populointi


// seuraava looppi
$sql = "SELECT * FROM henkilonRooli";

$result = mysqli_query($mysqli, $sql) or die ("Bad Query: $sql");

    // taulun rakentaminen ja populointi
    echo("<h3>Henkilön rooli </h3>");
    echo("<table border=2>");
    /* Get field information for all columns */
    $finfo = mysqli_fetch_fields($result);
    foreach ($finfo as $val) {echo ('<th>'.$val->name.'</th>');}
    while ($row = mysqli_fetch_assoc($result)) {
        echo ("<tr>");
        foreach ($finfo as $val) {echo ("<td>{$row[$val->name]}</td>");}
        echo ("</tr>");
    }
    echo("</table> <br> <br>");


// seuraava looppi
$sql = "SELECT * FROM kayttaja";

$result = mysqli_query($mysqli, $sql) or die ("Bad Query: $sql");

    // taulun rakentaminen ja populointi
    echo("<h3>Käyttäjä </h3>");
    echo("<table border=2>");
    /* Get field information for all columns */
    $finfo = mysqli_fetch_fields($result);
    foreach ($finfo as $val) {echo ('<th>'.$val->name.'</th>');}
    while ($row = mysqli_fetch_assoc($result)) {
        echo ("<tr>");
        foreach ($finfo as $val) {echo ("<td>{$row[$val->name]}</td>");}
        echo ("</tr>");
    }
    echo("</table> <br> <br>");
    // end of: taulun rakentaminen ja populointi

/* free result set */
$result->free();

/* close connection */
$mysqli->close();
?>