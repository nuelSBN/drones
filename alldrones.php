<?php
require("./inc/app.php");
$user =  new User();

if (isset($_SESSION['user'])){
  $user = unserialize($_SESSION['user']);
}


$infos = array('state','model');

$info=null;
$q = null;

if(isset($_GET['info'] )){
  $info = $_GET['info'];
}
if(isset($_GET['q'] )){
  $q = $_GET['q'];
}

if($info== null || $q == null){
  $Drones = Drone::getAllDrones();
}

else if($info == 'model' && !is_null($q) ){
  $Drones = Drone::getAllDronesByModel($q);

}
else if ($info == 'state' &&  !is_null($q)){

  $Drones = Drone::getAllDronesByState($q);
}
else{
  $Drones = Drone::getAllDrones();
}


?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="./styles/store.css" />
    <script
      src="https://kit.fontawesome.com/541d44dedf.js"
      crossorigin="anonymous"
    ></script>
    <title>Drones - <?= $q ?> category</title>
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
          <li><a class="active" href="alldrones.php">all drones</a></li>
          <?php if($user->isUserAuthenticated()){  ?>
            <li><a href="./auth/logout.php">log out</a></li>
          <li><a href="./auth/dashboard.php">dashboard</a></li>
            <?php } else {?>
          <li><a href="login.php">sign in</a></li>
          <li><a href="signup.php">sign up</a></li>
        <?php } ?>
        </ul>
      </nav>
    </header>
    <main id="all_drones">
      <h2 class="price_rage-box-title"><?= strtoupper($q.' drones') ?></h2>
      <section id="drones_section">
        <div class="drones__grid">
          <!-- all the drones will be gotten from the database -->
          <?php foreach($Drones as $drone): ?>
      
        <div class="drones__grid-card">
          <div class="drones__grid-card_img">
            <img
            src=<?= "https://robohash.org/".$drone['serialNumber']; ?>
            onclick="location.href='product.php?serial=<?= $drone['serialNumber'] ?>'"
            alt=""
            />
          </div>
          <div class="drones__grid-card-text">
                <div class="drones__grid-card-textCard">
                    <h3>drone model - <?= $drone['model'] ?></h3>
                    <p>current state - <?= $drone['state'] ?></p>
                </div>
                <div class="drones__grid-card-box">
                    <button
                    onclick="location.href='product.php?serial=<?= $drone['serialNumber'] ?>'">show more</button>
                </div>
          </div>
      </div>
            <?php endforeach; ?>
        </div>
      </section>
    </main>
    <footer>
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
