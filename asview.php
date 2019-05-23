<!DOCTYPE html>
<html lang="">
<title>WorkTracker view</title>
<head>
   <link rel="stylesheet" type="text/css" href="view.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title></title>

    <script src="https://unpkg.com/react@16/umd/react.development.js"></script>
    <script src="https://unpkg.com/react-dom@16/umd/react-dom.development.js"></script>
    <script src="https://unpkg.com/babel-standalone@6.26.0/babel.js"></script>

</head>

<body>

<!-- logout-toiminnallisuus -->
<a href="logout.php" class="logout">Kirjaudu ulos</a>

<div class="form-popup" id="CreateForm">
  <form action="/action_page.php" class="form-container">
    <h1>Create New Account</h1>

    <label for="useraccount"><b>User Account Name:</b></label>
    <input type="text" placeholder="Enter account name" name="name" required>

    <button type="submit" class="btn">Create new</button>
    <button type="submit" class="btn cancel" onclick="Form1()">Cancel</button>
  </form>
</div>

<div class="main">
<h2>Your Projects and tasks:</h2>
    <div id="projectview"> </div>
      <?php
	
        session_start();

        // print_r($_SESSION);

        $henkiloID=$_SESSION['henkilo_ID'];
        $asiakasID=$_SESSION['asiakas_ID'];

        require 'db_connection_config.php';  
      
        //* asiakashenkilön projektinäkymän haku */
        $sql = "SELECT a.projektiID, a.asiakasID, a.henkiloID
        ,concat(c.sukunimi, ' ',c.etunimi) as ProjektiPaallikko
        ,a.projekti, a.alkuPvm, a.loppuPvm, a.arkistointiPvm
        FROM projekti a
        inner join asiakas b on (a.asiakasID=b.asiakasID)
        inner join henkilo c on (a.henkiloID=c.henkiloID)
        inner join asiakas cc on (c.asiakasID=cc.asiakasID)
        inner join henkilonRooli e on (c.henkiloID=e.henkiloID and cc.asiakasID=e.asiakasID)
        inner join rooli f on (e.rooliID=f.rooliID)
        WHERE a.asiakasID=$asiakasID
        and b.tyyppi='T'
        and cc.tyyppi='O'
        and f.rooli='Projektipäällikkö'
        and exists(select 1 from henkilo ab where a.asiakasID=ab.asiakasID and ab.henkiloID=$henkiloID)
        ;"; 
        
        $result = mysqli_query($mysqli, $sql) or die ("Bad Query: $sql");
      
          // taulun rakentaminen ja populointi
          echo("<h3>Projektit </h3>");
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

        //* asiakashenkilön projektin tehtävän näkymän haku */
        $sql = "SELECT a.projektinTehtavaID, a.asiakasID, a.projektiID
        ,aa.projekti
        ,a.henkiloID, concat(c.sukunimi, ' ',c.etunimi) as Tyontekija, 
        a.tehtava, a.alkuPvm, a.loppuPvm
        ,a.tehtavanStatus, a.hyvaksymisPvm, a.arkistointiPvm
        FROM projektinTehtava a
        inner join projekti aa on (a.projektiID=aa.projektiID and a.asiakasID=aa.asiakasID)
        inner join asiakas b on (a.asiakasID=b.asiakasID)
        inner join henkilo c on (a.henkiloID=c.henkiloID)
        inner join asiakas cc on (c.asiakasID=cc.asiakasID)
        inner join henkilonRooli e on (c.henkiloID=e.henkiloID and cc.asiakasID=e.asiakasID)
        inner join rooli f on (e.rooliID=f.rooliID)
        WHERE a.asiakasID=$asiakasID
        and b.tyyppi='T' /* tilaaja*/
        and cc.tyyppi='O' /* oma yritys */
        and f.rooli='Työntekijä'
        and exists(select 1 from henkilo ab where a.asiakasID=ab.asiakasID and ab.henkiloID=$henkiloID)
        ;"; 
        
        $result = mysqli_query($mysqli, $sql) or die ("Bad Query: $sql");
      
          // taulun rakentaminen ja populointi
          echo("<h3>Projektien tehtävät </h3>");
          echo("<table border=1>");

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
      $result1->free();
      
      /* close connection */
      $mysqli->close();
      ?>   
</div>
 

<div class="sidenav">
  
    <h4 style="margin-left:1em;">
        <strong>

            <?php
              session_start();

                  // $myusername = $_SESSION['login_user'];             

                  // include("db_connection_config.php");
                  
                  // $sql = "SELECT b.henkiloID, b.sukunimi, b.etunimi
                  // ,c.asiakasID, c.nimi, c.tyyppi, f.rooliID, f.rooli
                  // FROM kayttaja a
                  // inner join henkilo b on (a.kayttajatunnus=b.sposti)
                  // inner join asiakas c on (b.asiakasID=c.asiakasID)
                  // inner join henkilonRooli e on (b.henkiloID=e.henkiloID)
                  // inner join rooli f on (e.rooliID=f.rooliID)
                  // WHERE a.kayttajatunnus = '$myusername'";
                  
                  // $result = mysqli_query($mysqli,$sql);
                  // $row = mysqli_fetch_array($result,MYSQLI_ASSOC);

                  // echo($row['rooli'] . " "  . $row['sukunimi'] . " " . $row['etunimi']);

              echo($_SESSION['asiakas_nimi'] . ", "  . $_SESSION['sukunimi'] . " " . $_SESSION['etunimi']);
            ?>        
    
        </strong>

    </h4>

<button class="accordion"><strong>Oma henkilöstö</strong></button>
<div class="panel">
  <p id="root2">
    <?php 

        session_start();
        $henkiloID=$_SESSION['henkilo_ID'];
        $asiakasID=$_SESSION['asiakas_ID'];          

        require 'db_connection_config.php'; 

        $sql = "SELECT a.henkiloID, concat(a.sukunimi, ' ',a.etunimi) as Nimi, a.sposti
        FROM henkilo a
        WHERE a.asiakasID=$asiakasID
        and exists(select 1 from henkilo ab where a.asiakasID=ab.asiakasID and ab.henkiloID=$henkiloID);           
        ";

        $result = mysqli_query($mysqli, $sql) or die ("Bad Query: $sql");

        // echo("<h3>Oma henkilöstö </h3>");
        echo("<table border=0>");
        /* Get field information for all columns */
        $finfo = mysqli_fetch_fields($result);
        foreach ($finfo as $val) {echo ('<th>'.$val->name.'</th>');}
        while ($row = mysqli_fetch_assoc($result)) {
            echo ("<tr>");
            foreach ($finfo as $val) {echo ("<td>{$row[$val->name]}</td>");}
            echo ("</tr>");
        }
        echo("</table> <br> <br>");    

      /* free result set */
      $result->free();
      
      /* close connection */
      $mysqli->close();        
    ?>   

  </p>
  <!-- <button class="open-button" onclick="Form1()">Add User</button> -->
</div>

<button class="accordion"><strong>Projektit - tarvitaanko?</strong></button>
<div class="panel">
  <p></p>
 <!--  <button class="open-button" onclick="Form1()">Add Project</button> -->
</div>

<button class="accordion"><strong>Asiakkaat - tarvitaanko?</strong></button>
<div class="panel">
  <p id='plAsiakkaat'>
  </p>
  <!--  <button class="open-button" onclick="Form1()">Add User</button> -->
</div>



<script src="view.js"></script>


</body>
</html>
