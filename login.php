<?php
  //ini_set('display_errors', 1);
  //ini_set('display_startup_errors', 1);
  //error_reporting(E_ALL);
   
   include("db_connection_config.php");
   session_start();
   
   if($_SERVER["REQUEST_METHOD"] == "POST") {
      // username and password sent from form 
      
      $myusername = mysqli_real_escape_string($mysqli,$_POST['username']);
      $mypassword = mysqli_real_escape_string($mysqli,$_POST['password']);
      
      $sql = "SELECT kayttajaID FROM kayttaja WHERE kayttajatunnus = '$myusername' and salasana = password('$mypassword')";
      $result = mysqli_query($mysqli,$sql);
      $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
      // $active = $row['active'];
      $count = mysqli_num_rows($result);
      
      // If result matched $myusername and $mypassword, table row must be 1 row
		
      if($count == 1) {
         $_SESSION['login_user'] = $myusername;
         // print $_SESSION['login_user'];
         header("location: kayttajanRoolivalinta.php");
      }else {
         //$error = "Your Login Name or Password is invalid";
         header("location: Login.html");
      }
   }
?>