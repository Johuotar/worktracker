<!DOCTYPE html>
<html lang="">
<title>WorkTracker view</title>
<head>
   <link rel="stylesheet" type="text/css" href="view.css">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://unpkg.com/react@16/umd/react.development.js"></script>
    <script src="https://unpkg.com/react-dom@16/umd/react-dom.development.js"></script>
    <script src="https://unpkg.com/babel-standalone@6.26.0/babel.js"></script>

</head>

<body>

<!-- logout-toiminnallisuus -->
<a href="logout.php" class="logout">Kirjaudu ulos</a>

<!-- sosiaalisen median linkit -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<a href="https://www.facebook.com" class="fa fa-facebook"></a>
<a href="https://www.twitter.com" class="fa fa-twitter"></a>
<a href="https://www.linkedin.com" class="fa fa-linkedin"></a>

<div class="form-popup" id="AddEmployeeForm">
  <form action="/action_page.php" class="form-container">
    <h1>Add New Employee Account</h1>

    <label for="accesslevel"><b>Account Type:</b></label>
    <br>
    <select name="Access">
      <option value="employee">Employee</option>
      <option value="projectleader">Project Leader</option>
    </select>
    <br><br>

    <label for="firstname"><b>First Name:</b></label>
    <input type="text" placeholder="Enter first name" name="firstname" required>

    <label for="lastname"><b>Last Name:</b></label>
    <input type="text" placeholder="Enter last name" name="lastname" required>

    <button type="submit" class="btn">Create new</button>
    <button type="submit" class="btn cancel" onclick="CloseForm(AddEmployeeForm)">Cancel</button>
  </form>
</div>
<div class="form-popup" id="AddProjectForm">
  <form action="/action_page.php" class="form-container">
    <h1>Create New Project</h1>

    <label for="projectname"><b>Project Name:</b></label>
    <input type="text" placeholder="Enter project name" name="projectname" required>

    <label for="projectowner"><b>Project Owner Company:</b></label>
    <input type="text" placeholder="Enter project owner" name="projectowner" required>

    <button type="submit" class="btn">Create new</button>
    <button type="submit" class="btn cancel" onclick="CloseForm(AddProjectForm)">Cancel</button>
  </form>
</div>
<div class="form-popup" id="AddCustomerForm">
  <form action="/action_page.php" class="form-container">
    <h1>Add New Customer Account</h1>

    <label for="firstname"><b>First Name:</b></label>
    <input type="text" placeholder="Enter first name" name="firstname" required>

    <label for="lastname"><b>Last Name:</b></label>
    <input type="text" placeholder="Enter last name" name="lastname" required>

    <label for="company"><b>Company:</b></label>
    <input type="text" placeholder="Enter company" name="company" required>

    <button type="submit" class="btn">Create new</button>
    <button type="submit" class="btn cancel" onclick="CloseForm(AddCustomerForm)">Cancel</button>
  </form>
</div>

<!--Tähän React renderoi-->
<div id="react" class="main"><p>React element div</p></div>

<div class="main">
<h2>Your Projects:</h2>
    <div id="projectview"> </div>
      <?php

        session_start();

        // print_r($_SESSION);

        $henkiloID=$_SESSION['henkilo_ID'];

        require 'db_connection_config.php';  
      
        $sql = "SELECT * FROM projekti where henkiloID=$henkiloID"; 
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



        $sql = "SELECT * FROM projekti where henkiloID<>$henkiloID"; 
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
  
    <h4 style="margin-left:1em;">
        <strong>

            <?php

            //session_start();

            // print_r($_SESSION);

            $myusername = $_SESSION['login_user'];

            include_once("db_connection_config.php");
            
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
  <button class="open-button" onclick="Form(AddEmployeeForm)">Add Employee</button>
</div>

    <button class="accordion"><strong>Projektit</strong></button>
<div class="panel">
  <p>Esimerkki projekti</p>
  <button class="open-button" onclick="Form(AddProjectForm)">Add Project</button>
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
  <button class="open-button" onclick="Form(AddCustomerForm)">Add Customer</button>
</div>

<script type="text/babel">
//In React, inline styles are not specified as a string
const doneStyle = {
  color: 'green'
};
const problemStyle = {
  color: 'red'
};
const assignedStyle = {
  color: 'gray'
};
//how many rows are made
var numberRows = 4

class Multiple extends React.Component {
  render() {
    let rows = [];
    for (let i=0; i < numberRows; i++) {
      rows.push(<FormComponent key={i} />)
    }
    return <div>{rows}</div>;
  }
}

class FormComponent extends React.Component {
  constructor(props) {
    super(props);
    this.state =
    {name: ''},
    {task: ''},
    {startdate: ''},
    {progress: ''},
    {projectid: ''},
    {approved: ''};
    this.handleSubmit = this.handleSubmit.bind(this);
    this.handleChange = this.handleChange.bind(this);
  }
  handleChange(event) {
    this.setState({name: event.target.name});
  }
  handleSubmit(event) {
    event.preventDefault();
    const data = new FormData(event.target);
    console.log("submit log")

    fetch('/api/form-submit-url', {
      method: 'POST',
      body: data,
    });
  }

  render() {
    return (
      <form onSubmit={this.handleSubmit}>
      <div style={{flex: 1, flexDirection: 'column'}}>
        <label>
          Name:
          <input style={{width: 150, height: 20, backgroundColor: 'skyblue'}} type="text" name={this.state.name} onChange={this.handleChange} />
        </label>
        <label>
          Project Id:
          <input style={{width: 35, height: 20, backgroundColor: 'skyblue'}} type="text" projectid={this.state.projectid} onChange={this.handleChange} />
        </label>
        <label>
          Task:
          <input style={{width: 220, height: 20, backgroundColor: 'skyblue'}} type="text" task={this.state.task} onChange={this.handleChange} />
        </label>
        <label>
          Start Date:
          <input style={{width: 80, height: 20, backgroundColor: 'skyblue'}} type="text" startdate={this.state.startdate} onChange={this.handleChange} />
        </label>
        <label>
          Progress:
          <select progress={this.state.progress} onChange={this.handleChange}>
            <option style={assignedStyle} progress="assigned">Assigned</option>
            <option progress="wip">Wip</option>
            <option style={problemStyle} progress="stuck">Stuck</option>
            <option style={doneStyle} progress="done">Done</option>
          </select>
        </label>
        <label>
          Approval:
          <select progress={this.state.progress} onChange={this.handleChange}>
            <option style={assignedStyle} progress="assigned">Assigned</option>
            <option style={doneStyle} progress="done">Done</option>
          </select>
        </label>
        <button onClick = {this.onSubmit} >submit</button>
      </div>
      </form>
    );
  }
}

ReactDOM.render(<Multiple />, document.getElementById('react'));


</script>

<script src="view.js"></script>

<meta name="viewport" content="width=device-width, initial-scale=1">
<div class="footer">

  <!-- <h3>Copywrite@WorkTracker</h3> -->
  <!-- sosiaalisen median linkit -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<a href="https://www.facebook.com" class="fa fa-facebook"></a>
<a href="https://www.twitter.com" class="fa fa-twitter"></a>
<a href="https://www.linkedin.com" class="fa fa-linkedin"></a>
</div>

</body>
</html>
