<?php

require 'db_connection_config.php';  
$sql = "SELECT * FROM asiakas";

$result = mysqli_query($mysqli, $sql) or die ("Bad Query: $sql");

while ($row = mysqli_fetch_assoc($result)) {
    echo"{$row['nimi']}<br>";
}

?>