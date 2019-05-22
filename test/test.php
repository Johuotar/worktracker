<!DOCTYPE html>
<html>
<head>
  <link rel="stylesheet" href="style.css">
</head>
<body>
<h1>Hello World</h1>

<?php
require 'db_connection_config.php';  
$sql = "SELECT * FROM kayttaja";

$result = mysqli_query($mysqli, $sql) or die ("Bad Query: $sql");

while ($row = mysqli_fetch_assoc($result)) {
    echo"{$row['kayttajatunnus']}<br>";
}
?>

</body>
</html>