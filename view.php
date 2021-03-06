<!DOCTYPE html>
<html lang="">
<title>WorkTracker view</title>
<head>
   <link rel="stylesheet" type="text/css" href="view.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>
</head>

<body>

<div class="form-popup" id="CreateForm">
  <form class="form-container">
    <h1>Create New Account</h1>

    <label for="useraccount"><b>User Account Name:</b></label>
    <input type="text" placeholder="Enter account name" name="name" required>

    <button type="submit" class="btn">Create new</button>
    <button type="submit" class="btn cancel" onclick="Form1()">Cancel</button>
  </form>
</div>

<div class="form-popup" id="CreateProjectForm">
    <form class="form-container">
      <h1>Create New Project</h1>
  
      <label for="projectname"><b>Project Name:</b></label>
      <input type="text" placeholder="Enter name" name="name" required>
  
      <button type="submit" class="btn">Create new</button>
      <button type="submit" class="btn cancel" onclick="Form2()">Cancel</button>
    </form>
  </div>

<div class="main">
    <h2>Your Projects:</h2>
    <div id="projectview"> </div>
      <?php

      require 'db_connection_config.php';  
      
      $sql = "SELECT * FROM projekti";
      
      $result = mysqli_query($mysqli, $sql) or die ("Bad Query: $sql");
      
          // taulun rakentaminen ja populointi
          echo("<h3>Asiakkaan projektit </h3>");
          echo("<table border=1>");
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


   
    <br>
    <p>----------------------------</p>
    <p>No more Projects!</p>
</div>

<div class="sidenav">

<p style="margin-left:1em;">Projektipäällikkö Matti Meikäläinen</p>

<button class="accordion">Työntekijät</button>
<div class="panel">
  <p>Tähän työntekijät tietokannasta</p>
  <button class="open-button" onclick="Form1()">Add User</button>
</div>

<button class="accordion">Projektit</button>
<div class="panel">
  <p>Esimerkki projekti</p>
  <button class="open-button" onclick="Form2()">Add Project</button>
</div>

<button class="accordion">Asiakkaat</button>
<div class="panel">
  <p>Esimerkki asiakas</p>
  <button class="open-button" onclick="Form1()">Add User</button>
</div>

<!--Load React-->
<!--when deploying, replace "development.js" with "production.min.js". -->
<script src="https://unpkg.com/react@16/umd/react.development.js" crossorigin></script>
<script src="https://unpkg.com/react-dom@16/umd/react-dom.development.js" crossorigin></script>
<script src="view.js"></script>

</body>
</html>