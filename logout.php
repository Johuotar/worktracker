<?php
// Initialize the session.
session_start();
// Unset all of the session variables.
unset($_SESSION['login_user']);
// Finally, destroy the session.    
session_destroy();

// Include URL for Login page to login again.
header("Location: Login.html");
exit;
?>