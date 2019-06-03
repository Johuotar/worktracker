<!DOCTYPE html>
<html lang="">
<title>WorkTracker view</title>
<head>
   <link rel="stylesheet" type="text/css" href="view.css">
   <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
   <script src="https://ajax.googleapis.com/ajax/libs/jquery/4.3.1/jquery.min.js"></script>
   <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/reactstrap/8.0.0/reactstrap.min.js"></script>
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
 
<div class="main" id="container"></div>
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
class Products extends React.Component {

constructor(props) {
  super(props);

  //  this.state.products = [];
  this.state = {};
  this.state.filterText = "";
  this.state.products = [
    {
      id: 1,
      Status: '',
      Task: '',
      Date: '',
      name: ''
    }
  ];

}
handleUserInput(filterText) {
  this.setState({filterText: filterText});
};
handleRowDel(product) {
  var index = this.state.products.indexOf(product);
  this.state.products.splice(index, 1);
  this.setState(this.state.products);
};

handleAddEvent(evt) {
  var id = (+ new Date() + Math.floor(Math.random() * 999999)).toString(36);
  var product = {
    id: id,
    name: "",
    Task: "",
    
    Date: ""
  }
  this.state.products.push(product);
  this.setState(this.state.products);

}

handleProductTable(evt) {
  var item = {
    id: evt.target.id,
    name: evt.target.name,
    value: evt.target.value
  };
var products = this.state.products.slice();
var newProducts = products.map(function(product) {

  for (var key in product) {
    if (key == item.name && product.id == item.id) {
      product[key] = item.value;

    }
  }
  return product;
});
  this.setState({products:newProducts});
//  console.log(this.state.products);
};
render() {

  return (
    <div>
      <SearchBar filterText={this.state.filterText} onUserInput={this.handleUserInput.bind(this)}/>
      <ProductTable onProductTableUpdate={this.handleProductTable.bind(this)} onRowAdd={this.handleAddEvent.bind(this)} onRowDel={this.handleRowDel.bind(this)} products={this.state.products} filterText={this.state.filterText}/>
    </div>
  );

}

}
class SearchBar extends React.Component {
handleChange() {
  this.props.onUserInput(this.refs.filterTextInput.value);
}
render() {
  return (
    <div>

      <input type="text" placeholder="Search..." value={this.props.filterText} ref="filterTextInput" onChange={this.handleChange.bind(this)}/>

    </div>

  );
}

}

class ProductTable extends React.Component {

render() {
  var onProductTableUpdate = this.props.onProductTableUpdate;
  var rowDel = this.props.onRowDel;
  var filterText = this.props.filterText;
  var product = this.props.products.map(function(product) {
    if (product.name.indexOf(filterText) === -1) {
      return;
    }
    return (<ProductRow onProductTableUpdate={onProductTableUpdate} product={product} onDelEvent={rowDel.bind(this)} key={product.id}/>)
  });
  return (
    <div>


    <button type="button" onClick={this.props.onRowAdd} className="btn btn-primary m-2">Add</button>
      <table className="table table-bordered">
        <thead>
          <tr>
            <th>Name</th>
            <th>Task</th>
            <th>Date</th>
    
          </tr>
        </thead>

        <tbody>
          {product}

        </tbody>

      </table>
      
    </div>
  );

}

}

class ProductRow extends React.Component {
  constructor(props) {
    super(props);
    this.state =
    {progress: ''}
    this.handleChange = this.handleChange.bind(this);
  }
handleChange(event) {
    this.setState({name: event.target.name});
  }
onDelEvent() {
  this.props.onDelEvent(this.props.product);

}
render() {

  return (
    <tr className="eachRow">
      <EditableCell onProductTableUpdate={this.props.onProductTableUpdate} cellData={{
        "type": "name",
        value: this.props.product.name,
        id: this.props.product.id
      }}/>
      <EditableCell onProductTableUpdate={this.props.onProductTableUpdate} cellData={{
        type: "Task",
        value: this.props.product.Task,
        id: this.props.product.id
      }}/>
      <EditableCell onProductTableUpdate={this.props.onProductTableUpdate} cellData={{
        type: "qty",
        value: this.props.product.qty,
        id: this.props.product.id
      }}/>

      <label>
          Progress:
          <select className="btn btn-primary m-2" progress={this.state.progress} onChange={this.handleChange}>
            <option progress="assigned">Assigned</option>
            <option progress="wip">Wip</option>
            <option progress="stuck">Stuck</option>
            <option progress="done">Done</option>
          </select>
        </label>

      <td className="del-cell">
        <input type="button" onClick={this.onDelEvent.bind(this)} value="X" className="del-btn"/>
      </td>
    </tr>
  );

}

}
class EditableCell extends React.Component {

render() {
  return (
    <td>
      <input type='text' name={this.props.cellData.type} id={this.props.cellData.id} value={this.props.cellData.value} onChange={this.props.onProductTableUpdate}/>
    </td>
  );

}

}
ReactDOM.render( < Products /> , document.getElementById('container'));

/*
(The MIT License)

Permission is hereby granted, free of charge, to any person obtaining a copy of this software and associated documentation files (the 'Software'), to deal in the Software without restriction, including without limitation the rights to use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED 'AS IS', WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
*/

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
