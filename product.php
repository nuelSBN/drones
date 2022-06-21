<?php
require("./inc/app.php");

$user =  new User();
$edit = false;
$state = null; 
$batteryLevel = null;

if (isset($_SESSION['user'])){
  $user = unserialize($_SESSION['user']);
}

if (isset($_SESSION['serial']) &&  isset($_POST['delete']) && ($user->isUserAuthenticated()))
  {
    Drone::deleteDrone( $_SESSION['serial'] , $user->getId());
    $_SESSION['deleted'] = $_SESSION['serial'];
    header("Location: ./auth/view.php");
die();
}
else if(isset($_SESSION['serial']) && isset($_POST['edit']) && ($user->isUserAuthenticated())){
  
  $drone = Drone::getDroneDetailsFromSerial($_SESSION['serial']);
  $edit = true;
}
else if(isset($_SESSION['serial']) && isset($_POST['editDrone']) && ($user->isUserAuthenticated())){
   if(isset($_POST['state'])){
    $state = $_POST['state'];  
    $drone = Drone::updateDroneState($_SESSION['serial'], $state );

  }
 
  if(isset($_POST['batteryLevel'])){
    $batteryLevel = $_POST['batteryLevel'];
    if ( Drone::isBatteryLevelValid($batteryLevel))
        $drone = Drone::updateDroneBatteryLevel($_SESSION['serial'], $batteryLevel );
    
  }
header("Location: ./auth/view.php");

}
else if (isset($_GET['serial'])){

  $_SESSION['serial'] = $serial=  $_GET['serial'];
  $drone = Drone::getDroneDetailsFromSerial("$serial");

 
}
else{
  header("Location: index.php");
  die();
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./styles/product.css" />
    <script
      src="https://kit.fontawesome.com/541d44dedf.js"
      crossorigin="anonymous"
    ></script>
    <title>Drones - Single product</title>
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

          <?php if($user->isUserAuthenticated()){  ?>
            <li><a href="./auth/logout.php">log out</a></li>
          <li><a class="active" href="./auth/dashboard.php">dashboard</a></li>
            <?php } else {?>
          <li><a href="login.php">sign in</a></li>
          <li><a href="signup.php">sign up</a></li>
            
            <?php } ?>
        </ul>
      </nav>
    </header>
    <main id="product__main">
      <div class="product_main-container">
      <?php if(empty($drone)){ ?>
        <h2>No Drone found</h2>
        <?php }else { ?>
        <div class="product__img-container">
          <img
            src=https://robohash.org/<?= $drone['serialNumber'] ?>
            alt="<?= $drone['model'] ?>"
          />
        </div>
        <div class="product__details">
          <div class="">
            <h1>Drone Model - <?= $drone['model'] ?></h1>
            <p>Drone State -<?= $drone['state'] ?></p>
          </div>
          <div class="">
            <ul>
              <li>Drone Weight Limit - <span><?= $drone['weightLimit'] ?>kg</span> </li>
              <li>Drone Current Load - <span><?= $drone['currentLoad'] ?></span> </li>
              <li>Drone Battery Level - <span><?= $drone['batteryLevel'] ?>% </span></li>
              <li>Drone S/N - <span><?= $drone['serialNumber'] ?></span> </li>
              <li>Date Updated - <span><?= $drone['dateUpdated'] ?></span> </li>
              <li>Date Created - <span><?= $drone['dateCreated'] ?></span> </li>
            </ul>
          </div>
         
          <form class="product_drone-form" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <?php if($user->isUserAuthenticated()){  ?>
           <button name="edit" type="submit">Edit</button>
           <button name="delete" type="submit">Delete</button>
           <?php }?>
          </form>
          
          
        </div>
        <?php }  ?>
      </div>
      <form class="form_edit" method="POST" action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>'>
      <?php if($edit){ ?>
          <div class="upload_container">
            <div class="select__container">
              <select name='state' required>
                <option selected disabled>state</option>
                <option value="idle">idle</option>
                <option value="loading">loading</option>
                <option value="loaded">loaded</option>
                <option value="delivering">delivering</option>
                <option value="delivered">delivered</option>
                <option value="returning">returning</option>
              </select>
            </div>
            <div class="select__container">
              <input
             
                type="number"
                placeholder="Battery Level"
                max="100"
                min="0"
                name="batteryLevel"
              />
              <label>(%)</label>
            </div>
        </div>
          <div class="select__btn">
            <button type="submit" name="editDrone">Update drone</button>
          </div>
          
          <?php }?>   
        </form>
  
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
