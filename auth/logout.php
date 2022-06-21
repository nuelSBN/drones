<?php
require("../inc/app.php");
$user = new User();
if (isset($_SESSION['user'])){
  $user = unserialize($_SESSION['user']);
}


 if($user->isUserAuthenticated()){
     $user->logout();
  }

session_destroy();

header("Location: ../login.php");
?>