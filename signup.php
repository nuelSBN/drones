<?php
require("./inc/app.php");
$user =  new User();

if (isset($_SESSION['user'])){
  $user = unserialize($_SESSION['user']);
}

 if($user->isUserAuthenticated()){
      $err = "Please Login";
        header("Location: ./auth/dashboard.php");
        // die();
  }


$err="";

$id = null;
$firstName = null; 
$lastName = null; 
$email = null;
$username = null;
$password = null;

// 
if (!empty($_POST) && (isset($_POST['submit']))){
  if(isset($_POST['firstName'])){
    $firstName = $_POST['firstName'];
  }
  if(isset($_POST['lastName'])){
    $lastName = $_POST['lastName'];
  }
  if(isset($_POST['email'])){
    $email = $_POST['email'];
  }
  if(isset($_POST['username'])){
    $username = $_POST['username'];
  }
  if(isset($_POST['password'])){
    
    $password = $_POST['password'];
  }

  else{
     $err  = $err .  "\nSome fields are submitted";
  }

if(is_null($firstName)|| is_null($lastName)||is_null($username)||is_null($password)||is_null($username)||is_null($email) ){
  $err  = $err . "\nCheck all fields";
  
}
else{
  try{
     if (!preg_match("/^[a-zA-Z-']*$/",$firstName)) {
      $err = $err . "\nFirstName: Only letters and white space allowed";
    }
    if (!preg_match("/^[a-zA-Z-']*$/",$lastName)) {
       $err = $err . "\nLastName: Only letters and white space allowed";
     }
    if (!preg_match("/^[a-zA-Z-']*$/",$username)) {
      $err = $err . "\nUsername: Only letters and white space allowed";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
      $err =$err. "\nEmail: Invalid email format";
    }
    $result = User::addUser($username, $password,$firstName,$lastName,$email);
    $_SESSION['status'] = true;
    header("Location: login.php");
  }
  catch(Exception $ex){
    $err = $err . "\n\t" . $ex->getMessage();
  }


}


 
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/541d44dedf.js"
      crossorigin="anonymous"
    ></script>
    <link rel="stylesheet" href="./styles/auth.css" />
    <title>Drones - Sign Up</title>
  </head>
  <body>
    <header>
      <nav class="container auth-header">
        <div class="logo">
          <a href="index.php">
            <i class="fa-brands fa-phoenix-squadron"></i>
            <h1>drones</h1>
          </a>
        </div>
        <div id="menu__box">
          <i class="fa-solid fa-bars-staggered"></i>
        </div>
        <ul class="navbar">
          <li><a class="" href="index.php">home</a></li>
          <li><a href="alldrones.php">all drones</a></li>
          <li><a href="login.php">sign in</a></li>
          <li><a class="active" href="signup.php">signup</a></li>
           
        </ul>
      </nav>
    </header>

    <main id="auth__main">
      <div class="form__container">
        <div class="form__container-image">
          <img
            src="https://images.pexels.com/photos/1087180/pexels-photo-1087180.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
            alt=""
          />
        </div>
  
        <form class="form" method="POST" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
          <h4 class="error"><?= nl2br($err) ?></h4>
          <div class="input_container-title">
            <h3>please enter your correct details</h3>
          </div>
          <div class="input_container">
            <input name="firstName" type="text" placeholder="First name" />
          </div>
          <div class="input_container">
            <input name="lastName" type="text" placeholder="Last name" />
          </div>
          <div class="input_container">
            <input name="email" type="email" placeholder="Email Address" />
          </div>
          <div class="input_container">
            <input name="username" type="text" placeholder="Username" />
          </div>
          <div class="input_container">
            <input name="password" type="password" placeholder="Password" />
          </div>
          <div class="input_container">
            <button name="submit" type="submit">sign up</button>
          </div>
          <div class="no__account">
            <p>alraedy have an account?</p>
            <a href="login.php">login</a>
          </div>
        </form>
      </div>
    </main>

    <footer id="auth__footer">
      <div class="logo__container">
        <div class="logo">
          <a href="index.php">
            <i class="fa-brands fa-phoenix-squadron"></i>
            <h1>drones</h1>
          </a>
        </div>
      </div>
      <div class="contact">
        <ul class="social__icons">
          <li>
            <a href="#"><i class="fa-brands fa-facebook"></i></a>
          </li>
          <li>
            <a href="#"><i class="fa-brands fa-twitter"></i></a>
          </li>
          <li>
            <a href="#"><i class="fa-brands fa-instagram"></i></a>
          </li>
        </ul>
      </div>
    </footer>

    <script src="./js/index.js"></script>
  </body>
</html>
