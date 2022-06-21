<?php
require("../inc/app.php");

$user =  new User();

if (isset($_SESSION['user'])){
  $user = unserialize($_SESSION['user']);
}

 if(!$user->isUserAuthenticated()){
        $SESSION['status'] = false;
        header("Location: ../login.php");
       
  }
  try{
     $id = $user->getId();
    $Drones = Drone::getAllDronesByUserId($id);
  }catch(Exception $ex){
    $err = $ex;
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
    <link rel="stylesheet" href="../styles/view.css" />
    <title>Dashboard</title>
  </head>
  <body>
    <header>
      <nav class="container auth-header">
        <div class="logo">
          <a href="../index.php">
            <i class="fa-brands fa-phoenix-squadron"></i>
            <h1>drones</h1>
          </a>
        </div>
        <div id="menu__box">
          <i class="fa-solid fa-bars-staggered"></i>
        </div>
        <ul class="navbar">
          <li><a class="" href="../index.php">home</a></li>
          <li><a href="../alldrones.php">all drones</a></li>
            <li><a href="logout.php">log out</a></li>
          <li><a class="active" href="dashboard.php">dashboard</a></li>
        </ul>
      </nav>
    </header>
    <main id="dashboard__main">
      <section id="dashboard">
        <div class="dashboard_title">
        <h2> Welcome, <?= $user->getfullname()?>, </h2>
        <p>Click <a href="logout.php">here</a> to Log out</p>
      </div>
      <div class="dashboard_sub">
        <p class="dashboard_sub_title">Here you can perform the following </p>
        <ul class="dashboard_sub_list">
          <li><a href="create.php"> Create a Drone </a></li>
          <li><a href="view.php"> View the drones that belongs to you<a> </li>
          <br/>
          <h4> The following are the drones belonging to you. Click on any drone to view the details, edit and delete</h4>
        </ul>
      </div>
    </section>
    <main class="personal_drones">
      <?php if(isset( $_SESSION['deleted']) &&  $_SESSION['deleted']){ ?>
        <h4 class="personal_drones-title">Drone Deleted <?php $_SESSION['deleted']; ?></h2>
        <?php unset($_SESSION['deleted']);        } ?>
      <?php if(isset( $_SESSION['created']) &&  $_SESSION['created']){ ?>
        <h4 class="personal_drones-title">Drone created</h2>
        <?php unset($_SESSION['created']);        } ?>
      <h2 class="personal_drones-title">Your Drones</h2>
      <section id="drones">
        <div class="drones__grid">
          <!-- all the drones will be gotten from the database -->
          <?php foreach($Drones as $drone): ?>
      
      <div
        class="drones__grid-card"       
      >
      <div class="drones__grid-card_img">
            <img
            src=<?= "https://robohash.org/".$drone['serialNumber']; ?>
            onclick="location.href='../product.php?serial=<?= $drone['serialNumber'] ?>'"
            alt=""
            />
      </div>
            <div class="drones__grid-card-text">
                <div class="drones__grid-card-textCard">
                    <h3>drone model: <?= $drone['model'] ?></h3>
                    <p>current state: <?= $drone['state'] ?></p>
                </div>
                <div class="drones__grid-card-box">
                    <button
                    onclick="location.href='../product.php?serial=<?= $drone['serialNumber'] ?>'">show more</button>
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
