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

        require 'db_connection_config.php';  
      
        //* Työntekijan projektit */
        $sql = "SELECT a.projektiID, a.asiakasID, b.nimi, a.henkiloID
        ,concat(c.sukunimi, ' ' ,c.etunimi) as Projektipaalliko
        ,a.projekti, a.alkuPvm, a.loppuPvm 
        FROM projekti a
        inner join asiakas b on (a.asiakasID=b.asiakasID) /* haetaan asiakkaan nimi */
        inner join henkilo c on (a.henkiloID=c.henkiloID) /* Projektipäällikkö */
        WHERE exists(select 1 from projektinTehtava ac 
                    where ac.henkiloID=$henkiloID
                    and a.projektiID=ac.projektiID
                    and a.asiakasID=ac.asiakasID
                    )
        ;"; 
        // tähän henkiloID=1 laitetaan kirjoutumisen yhteydessä tunnistettu henkiloID
        
        $result = mysqli_query($mysqli, $sql) or die ("Bad Query: $sql");
      
          // taulun rakentaminen ja populointi
          echo("<h3>Työntekijan projektit </h3>");
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



        $sql = "SELECT projektinTehtavaID, tehtava, alkuPvm, loppuPvm, tehtavanStatus, hyvaksymisPvm 
        FROM projektinTehtava WHERE henkiloID=$henkiloID /* and projektiID=nn */"; 
        // tähän henkiloID<>1 laitetaan kirjoutumisen yhteydessä tunnistettu henkiloID
        
        $result = mysqli_query($mysqli, $sql) or die ("Bad Query: $sql");
          
              // taulun rakentaminen ja populointi
              echo("<h3>Työntekijan projektien tehtävät </h3>");
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



        //* Työntekijan projektit */
        $sql = "SELECT a.projektiID, a.asiakasID, b.nimi, a.henkiloID
        ,concat(c.sukunimi, ' ' ,c.etunimi) as Projektipaalliko
        ,a.projekti, a.alkuPvm, a.loppuPvm 
        FROM projekti a
        inner join asiakas b on (a.asiakasID=b.asiakasID) /* haetaan asiakkaan nimi */
        inner join henkilo c on (a.henkiloID=c.henkiloID) /* Projektipäällikkö */
        WHERE exists(select 1 from projektinTehtava ac 
                    where ac.henkiloID=$henkiloID
                    and a.projektiID=ac.projektiID
                    and a.asiakasID=ac.asiakasID
                    )
        ;"; 
        // tähän henkiloID=1 laitetaan kirjoutumisen yhteydessä tunnistettu henkiloID
        
        $result = mysqli_query($mysqli, $sql) or die ("Bad Query: $sql");
      
          // taulun rakentaminen ja populointi
          echo("<h3>Työntekijan projektit </h3>");
          // echo("<table border=1>");
          // Get field information for all columns */
          // $finfo = mysqli_fetch_fields($result);
          foreach ($finfo as $val) {echo ('<th>'.$val->name.'</th>');}
          while ($row = mysqli_fetch_assoc($result)) {

            echo("<table border=1>");
            $finfo = mysqli_fetch_fields($result);
            foreach ($finfo as $val) {echo ('<th>'.$val->name.'</th>');}             
              echo ("<tr>");
              foreach ($finfo as $val) {echo ("<td>{$row[$val->name]}</td>");}
                echo ("</tr>");
	            echo("</table>");
	            $projektiID=$row['projektiID']; // otetaan talteen projektiID
	        // sisälooppi
	     	// tähän sisälooppi, tt:n pr. tehtävät
            $sql1 = "SELECT projektinTehtavaID, tehtava, alkuPvm, loppuPvm, tehtavanStatus, hyvaksymisPvm 
            FROM projektinTehtava WHERE henkiloID=$henkiloID and projektiID=$projektiID"; 
            
            $result1 = mysqli_query($mysqli, $sql1) or die ("Bad Query: $sql1");
            
                // taulun rakentaminen ja populointi
                echo("<h3> ... projektien tehtävät </h3>");
                echo("<table border=1>");
                /* Get field information for all columns */
                $finfo1 = mysqli_fetch_fields($result1);
                foreach ($finfo1 as $val) {echo ('<th>'.$val->name.'</th>');}
                while ($row1 = mysqli_fetch_assoc($result1)) {
                    echo ("<tr>");
                    foreach ($finfo1 as $val) {echo ("<td>{$row1[$val->name]}</td>");}
                    echo ("</tr>");
                }
                echo("</table> <br> <br>");
                // end of: taulun rakentaminen ja populointi 
            // end of: sisälooppi
           

          } // ulkolooppi
          // echo("</table> <br> <br>");
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

            // $_SESSION['henkilo_ID']=$row['henkiloID'];

            echo($row['rooli'] . " "  . $row['sukunimi'] . " " . $row['etunimi']);

            ?>        
    
        </strong>

    </h4>

    <button class="accordion"><strong>Oma henkilöstö</strong></button>
<div class="panel">
  <p id="root2">
    <?php 
        // Tähän työntekijät tietokannasta   
        require 'db_connection_config.php';       
        // seuraava looppi
        $sql = "SELECT a.henkiloId, concat(a.sukunimi, ' ', a.etunimi) as Nimi
         FROM henkilo a 
         inner join asiakas b on (a.asiakasID=b.asiakasID)
         inner join henkilonRooli c on (a.henkiloId=c.henkiloId)
         inner join rooli e on (c.rooliId=e.rooliId)
         where b.tyyppi='O' 
         and e.rooli='Projektipäällikkö'      
         ";

        $result = mysqli_query($mysqli, $sql) or die ("Bad Query: $sql");

        // taulun rakentaminen ja populointi
        echo("<h3>Projektipäälliköt </h3>");
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

        // seuraava looppi
        $sql = "SELECT a.henkiloId, concat(a.sukunimi, ' ', a.etunimi) as Nimi
         FROM henkilo a 
         inner join asiakas b on (a.asiakasID=b.asiakasID)
         inner join henkilonRooli c on (a.henkiloId=c.henkiloId)
         inner join rooli e on (c.rooliId=e.rooliId)
         where b.tyyppi='O' 
         and e.rooli='Työntekijä'      
         ";

        $result = mysqli_query($mysqli, $sql) or die ("Bad Query: $sql");

        // taulun rakentaminen ja populointi
        echo("<h3>Työntekijät </h3>");
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
  <button class="open-button" onclick="Form1()">Add User</button>
</div>

<button class="accordion"><strong>Projektit</strong></button>
<div class="panel">
  <p>Esimerkki projekti</p>
  <button class="open-button" onclick="Form1()">Add Project</button>
</div>

<button class="accordion"><strong>Asiakkaat</strong></button>
<div class="panel">
  <p id='plAsiakkaat'>
  <?php 
        // Tähän työntekijät tietokannasta   
        require 'db_connection_config.php';       
        // seuraava looppi
        $sql = "SELECT a.asiakasId, a.nimi
         FROM asiakas a
         where a.tyyppi='T'     
         ";

        $result = mysqli_query($mysqli, $sql) or die ("Bad Query: $sql");

        // taulun rakentaminen ja populointi
        echo("<h3>Asiakkaat </h3>");
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
  <button class="open-button" onclick="Form1()">Add User</button>
</div>



<script src="view.js"></script>


</body>
</html>
