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
<h2>Your Projects:</h2>
    <div id="projectview"> </div>
      <?php

      require 'db_connection_config.php';  
      
        $sql = "SELECT * FROM projekti where henkiloID=1"; 
        // tähän henkiloID=1 laitetaan kirjoutumisen yhteydessä tunnistettu henkiloID
        
        $result = mysqli_query($mysqli, $sql) or die ("Bad Query: $sql");
      
          // taulun rakentaminen ja populointi
          echo("<h3>Asiakkaan projektit, omassa vastuussa </h3>");
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



        $sql = "SELECT * FROM projekti where henkiloID<>1"; 
        // tähän henkiloID<>1 laitetaan kirjoutumisen yhteydessä tunnistettu henkiloID
        
        $result = mysqli_query($mysqli, $sql) or die ("Bad Query: $sql");
          
              // taulun rakentaminen ja populointi
              echo("<h3>Asiakkaan projektit, muiden vastuussa </h3>");
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
</div>
 

<div class="sidenav">
  
    <h4 style="margin-left:1em;"><strong></strong>Projektipäällikkö Matti Meikäläinen</strong></h4>

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

<script type="text/babel">

class MyComponent extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      users: [
        {
          username: 'Masa',
          online: true
        },
        {
          username: 'Jonne',
          online: false
        },
        {
          username: 'Alpakka',
          online: true
        },
        {
          username: 'Jake',
          online: true
        },
        {
          username: 'Sisko',
          online: true
        },
        {
          username: 'Late',
          online: true
        }
      ]
    }
  }
  render() {
    const usersOnline = this.state.users.filter(i => i.online == true); // kertoo kuka on onlinessä
    const renderOnline = usersOnline.map((i) => <li key={i.username + 1}>{i.username}</li>); // listaa kaikki käyttäjät
  
    return (
       <div>
         <h3>Käytettävissä:</h3>
         <ul>
           {renderOnline}
         </ul>
       </div>
    );
  }
};

ReactDOM.render(<MyComponent />, document.getElementById('root'));

</script>

<script src="view.js"></script>


</body>
</html>
