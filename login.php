<?php
require("./inc/app.php");

$user =  new User();


if (isset($_SESSION['user'])){
  $user = unserialize($_SESSION['user']);
}

 if($user->isUserAuthenticated()){
    
        header("Location: ./auth/dashboard.php");
        // die();
  }

$err="";

$username = null;
$password = null;

// 
if (!empty($_POST) && (isset($_POST['submit']))){
  
  if(isset($_POST['username'])){
    $username = $_POST['username'];
  }
  if(isset($_POST['password'])){
    $password = $_POST['password'];
  }

  else{
     $err = $err . "\nSome fields are omitted";
  }

if(is_null($username) || is_null($password)) {
  $err =  $err . "\nCheck all fields";
}
else{
  try{
    if (!preg_match("/^[a-zA-Z-']*$/",$username)) {
      $err = $err . "\nUsername: Only letters and white space allowed";
    }
    $result = $user->login($username, $password);
    if($result){
      $_SESSION['user'] =  serialize($user);
        
      header("Location: ./auth/dashboard.php");
    }
     
    else{
      $err = $err . "\nLogin Error";
      $_SESSION['status']= null;
    }
  }
  catch(Exception $ex){
    $err = $err ."\n". $ex->getMessage();
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
    <title>Drones - Sign in</title>
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
          <li><a class="active" href="login.php">sign in</a></li>
           <li><a href="signup.php">signup</a></li>
        </ul>
      </nav>
    </header>

    <main id="auth__main">
      <div class="form__container">
        <div class="form__container-image">
          <img
            src="https://images.pexels.com/photos/724921/pexels-photo-724921.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
            alt=""
          />
        </div>
        
        <form method="POST" class="form" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
       <h4 class="error"><?= nl2br($err) ?></h4>
       <?php if(isset($_SESSION['status']) && $_SESSION['status']==true){ ?>
            <h3> Registration Successful </h3> <br/>
            <?php } else if(isset($_SESSION['status']) && $_SESSION['status']==false){ ?>
            <h3> You need to login first </h3> <br/>
        <?php } ?>
        <div class="input_container-title">
            
            <h3>please login</h3>
          </div>
          <div class="input_container">
            <input name="username"  type="text" placeholder="username" />
          </div>
          <div class="input_container">
            <input name="password"  type="password" placeholder="Enter password" />
          </div>
          <div class="input_container">
            <button  name="submit" type="submit">login</button>
          </div>
          <div class="no__account">
            <p>don't have an account?</p>
            <a href="signup.php">sign up</a>
          </div>
        </form>
      </div>
    </main>

    <footer id="auth__footer">
      <div class="logo__container">
        <div class="logo">
          <a href="./index.html">
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
